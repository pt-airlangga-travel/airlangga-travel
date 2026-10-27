<?php

namespace App\Console\Commands;

use App\Models\HeroImage;
use App\Services\HeroImageProcessor;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReprocessHeroImages extends Command
{
    protected $signature = 'hero-images:reprocess {--dry-run : Show what would be processed without making changes}';

    protected $description = 'Crop and resize all existing hero images to the target 1920×810 landscape ratio';

    public function handle(): int
    {
        $heroImages = HeroImage::all();

        if ($heroImages->isEmpty()) {
            $this->info('No hero images found.');

            return self::SUCCESS;
        }

        $this->info("Found {$heroImages->count()} hero image(s) to reprocess.");

        if ($this->option('dry-run')) {
            $this->warn('[DRY RUN] No files will be modified.');
        }

        $processor = new HeroImageProcessor;
        $processed = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($heroImages as $hero) {
            $this->line("  → #{$hero->sort_order} [{$hero->id}] {$hero->title}");

            // Only reprocess images stored in /storage/hero_images/
            // (skip seeded public/assets images — those are static files)
            if (! str_contains((string) $hero->image_url, '/storage/hero_images/')) {
                $this->line('     <fg=yellow>SKIP</> (not a storage-backed image)');
                $skipped++;

                continue;
            }

            $storagePath = 'hero_images/'.basename($hero->image_url);

            if (! Storage::disk('public')->exists($storagePath)) {
                $this->line('     <fg=yellow>SKIP</> (file not found on disk)');
                $skipped++;

                continue;
            }

            if ($this->option('dry-run')) {
                $this->line('     <fg=green>WOULD REPROCESS</>');
                $processed++;

                continue;
            }

            try {
                // Copy the existing stored file into a temp UploadedFile-like object
                $realPath = Storage::disk('public')->path($storagePath);
                $mimeType = mime_content_type($realPath) ?: 'image/jpeg';

                // Create a temp copy so UploadedFile can read it
                $tmpPath = tempnam(sys_get_temp_dir(), 'hero_reprocess_');
                copy($realPath, $tmpPath);

                $uploadedFile = new UploadedFile(
                    $tmpPath,
                    basename($storagePath),
                    $mimeType,
                    null,
                    true,
                );

                $newUrl = $processor->process($uploadedFile);

                // Delete the old file
                Storage::disk('public')->delete($storagePath);

                // Remove temp file
                @unlink($tmpPath);

                // Update DB record
                $hero->update(['image_url' => $newUrl]);

                $this->line('     <fg=green>DONE</> → '.$newUrl);
                $processed++;
            } catch (\Throwable $e) {
                $this->line('     <fg=red>FAILED</> '.$e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Done. Processed: {$processed} | Skipped: {$skipped} | Failed: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
