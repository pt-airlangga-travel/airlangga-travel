<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
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

                @file_put_contents($appliedFile, $version);
            }
        }
    }
}
