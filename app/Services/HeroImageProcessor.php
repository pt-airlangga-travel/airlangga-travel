<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

/**
 * Processes hero images by cropping and resizing them to the target
 * hero aspect ratio (16:9 landscape) before storage.
 *
 * Uses PHP GD — no additional packages required.
 */
class HeroImageProcessor
{
    /** Target width in pixels. */
    private const TARGET_WIDTH = 1920;

    /** Target height in pixels (16:9 ratio). */
    private const TARGET_HEIGHT = 810;

    /** JPEG output quality (0-100). */
    private const JPEG_QUALITY = 92;

    /** PNG output compression (0-9, lower = bigger file but faster). */
    private const PNG_COMPRESSION = 6;

    /**
     * Crop-center and resize the uploaded image to the hero target dimensions.
     *
     * Saves the processed image into `storage/app/public/hero_images/`
     * and returns the web-accessible path string (e.g. `/storage/hero_images/abc.jpg`).
     *
     * @param  UploadedFile  $file  The raw uploaded file from Livewire.
     * @return string The `/storage/...` URL path for DB storage.
     *
     * @throws \RuntimeException If GD cannot load or process the image.
     */
    public function process(UploadedFile $file): string
    {
        $sourcePath = $file->getRealPath();
        $mimeType = $file->getMimeType() ?? 'image/jpeg';

        /** @var \GdImage $source */
        $source = match (true) {
            str_contains($mimeType, 'png') => imagecreatefrompng($sourcePath),
            str_contains($mimeType, 'gif') => imagecreatefromgif($sourcePath),
            str_contains($mimeType, 'webp') => imagecreatefromwebp($sourcePath),
            default => imagecreatefromjpeg($sourcePath),
        };

        if ($source === false) {
            throw new \RuntimeException('GD could not load the uploaded image.');
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);

        // ── Smart center-crop to target ratio ──────────────────────────────
        // Scale the source so the shortest side exactly fits the target,
        // then crop any overhang from the center.
        $targetRatio = self::TARGET_WIDTH / self::TARGET_HEIGHT;
        $srcRatio = $srcW / $srcH;

        if ($srcRatio > $targetRatio) {
            // Source is wider than target → crop sides
            $cropH = $srcH;
            $cropW = (int) round($srcH * $targetRatio);
            $cropX = (int) round(($srcW - $cropW) / 2);
            $cropY = 0;
        } else {
            // Source is taller than target → crop top/bottom
            $cropW = $srcW;
            $cropH = (int) round($srcW / $targetRatio);
            $cropX = 0;
            $cropY = (int) round(($srcH - $cropH) / 2);
        }

        /** @var \GdImage $canvas */
        $canvas = imagecreatetruecolor(self::TARGET_WIDTH, self::TARGET_HEIGHT);

        // Preserve transparency for PNG/GIF sources
        if (in_array($mimeType, ['image/png', 'image/gif', 'image/webp'])) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefill($canvas, 0, 0, $transparent);
        }

        imagecopyresampled(
            $canvas, $source,
            0, 0,                          // dest x, y
            $cropX, $cropY,                // src  x, y
            self::TARGET_WIDTH, self::TARGET_HEIGHT,
            $cropW, $cropH,
        );

        imagedestroy($source);

        // ── Save to storage ────────────────────────────────────────────────
        $storageDisk = storage_path('app/public/hero_images');
        if (! is_dir($storageDisk)) {
            mkdir($storageDisk, 0755, true);
        }

        $extension = $this->resolveOutputExtension($mimeType);
        $filename = uniqid('hero_', more_entropy: true).'.'.$extension;
        $outputPath = $storageDisk.'/'.$filename;

        $saved = match ($extension) {
            'png' => imagepng($canvas, $outputPath, self::PNG_COMPRESSION),
            'webp' => imagewebp($canvas, $outputPath, self::JPEG_QUALITY),
            default => imagejpeg($canvas, $outputPath, self::JPEG_QUALITY),
        };

        imagedestroy($canvas);

        if (! $saved) {
            throw new \RuntimeException('GD could not save the processed image.');
        }

        return '/storage/hero_images/'.$filename;
    }

    /**
     * Determine file extension for the saved output.
     *
     * @return string 'jpg' | 'png' | 'webp'
     */
    private function resolveOutputExtension(string $mimeType): string
    {
        return match (true) {
            str_contains($mimeType, 'png') => 'png',
            str_contains($mimeType, 'webp') => 'webp',
            default => 'jpg',
        };
    }
}
