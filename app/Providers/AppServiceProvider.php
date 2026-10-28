<?php

namespace App\Providers;

use Database\Seeders\HeroImageSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $syncVersionFile = storage_path('public_sync/version.txt');

        if (is_file($syncVersionFile)) {
            $appliedFile = storage_path('public_sync/applied.txt');
            $version = trim((string) @file_get_contents($syncVersionFile));
            $applied = is_file($appliedFile) ? trim((string) @file_get_contents($appliedFile)) : '';

            if ($version !== '' && $version !== $applied) {
                $targets = array_unique(array_filter([
                    public_path(),
                    $_SERVER['DOCUMENT_ROOT'] ?? null,
                    dirname(base_path()).'/public_html',
                ]));

                foreach ($targets as $targetRoot) {
                    if (is_dir($targetRoot) && is_writable($targetRoot)) {
                        if (is_dir(storage_path('public_sync/build'))) {
                            File::copyDirectory(storage_path('public_sync/build'), $targetRoot.'/build');
                        }
                        if (is_dir(storage_path('public_sync/assets'))) {
                            File::copyDirectory(storage_path('public_sync/assets'), $targetRoot.'/assets');
                        }
                    }
                }

                if (is_dir(storage_path('framework/views'))) {
                    foreach (glob(storage_path('framework/views/*.php')) ?: [] as $compiledView) {
                        @unlink($compiledView);
                    }
                }

                @file_put_contents($appliedFile, $version);
            }
        }

        $this->ensureDatabaseAutoIncrement();
        $this->ensureHeroImagesTable();
    }

    /**
     * Ensure hero_images table exists and has seed data for shared hosting deployments.
     */
    protected function ensureHeroImagesTable(): void
    {
        // Seeder version bump: increment this string whenever the seeder adds new records.
        // AppServiceProvider will re-run the seeder once on the next request after deploy.
        $seederVersion = 'v4-2026-10-27-sync';
        $seederFlag = storage_path('framework/hero_seeder_'.$seederVersion.'.flag');

        try {
            if (! Schema::hasTable('hero_images')) {
                Schema::create('hero_images', function ($table) {
                    $table->id();
                    $table->string('title')->nullable();
                    $table->string('subtitle')->nullable();
                    $table->string('badge')->nullable();
                    $table->string('image_url');
                    $table->integer('sort_order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }

            // Run seeder once per version to sync new records (updateOrCreate is idempotent)
            if (! is_file($seederFlag) && class_exists(HeroImageSeeder::class)) {
                (new HeroImageSeeder)->run();
                @file_put_contents($seederFlag, date('c'));
            }
        } catch (\Throwable $e) {
            // Ignore DB errors when database is not yet configured or reachable
        }
    }

    /**
     * Repair tables imported from partial SQL dumps that are missing PRIMARY KEY / AUTO_INCREMENT on `id`.
     */
    protected function ensureDatabaseAutoIncrement(): void
    {
        $flagFile = storage_path('framework/db_autoincrement_v1_'.md5((string) config('database.connections.mysql.database')).'.flag');
        if (is_file($flagFile)) {
            return;
        }

        try {
            if (DB::getDriverName() !== 'mysql') {
                return;
            }

            $tables = [
                'articles',
                'categories',
                'galleries',
                'inquiry_logs',
                'partners',
                'passport_visa_services',
                'site_settings',
                'testimonials',
                'ticket_services',
                'tour_packages',
                'transport_rentals',
                'unair_store_items',
                'users',
            ];

            $allSucceeded = true;

            foreach ($tables as $table) {
                try {
                    $cols = DB::select("SHOW COLUMNS FROM `{$table}` WHERE Field = 'id'");
                    if (empty($cols)) {
                        continue;
                    }

                    $col = $cols[0];
                    $hasPrimary = strtoupper((string) $col->Key) === 'PRI';
                    $hasAutoIncrement = stripos((string) $col->Extra, 'auto_increment') !== false;

                    if (! $hasPrimary) {
                        DB::statement("ALTER TABLE `{$table}` ADD PRIMARY KEY (`id`), MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
                    } elseif (! $hasAutoIncrement) {
                        DB::statement("ALTER TABLE `{$table}` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
                    }
                } catch (\Throwable $tableError) {
                    $allSucceeded = false;
                }
            }

            if ($allSucceeded) {
                @file_put_contents($flagFile, date('c'));
            }
        } catch (\Throwable $e) {
            // Ignore when DB is not yet reachable
        }
    }
}
