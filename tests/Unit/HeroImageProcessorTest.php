<?php

namespace Tests\Unit;

use App\Services\HeroImageProcessor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroImageProcessorTest extends TestCase
{
    private HeroImageProcessor $processor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->processor = new HeroImageProcessor;
        Storage::fake('public');
    }

    public function test_process_landscape_jpeg_returns_storage_path(): void
    {
        $file = $this->makeFakeJpeg(1920, 1080);
        $result = $this->processor->process($file);

        $this->assertStringStartsWith('/storage/hero_images/hero_', $result);
        $this->assertStringEndsWith('.jpg', $result);
    }

    public function test_process_portrait_jpeg_is_cropped_to_landscape(): void
    {
        // Portrait 1080×1920 → should be cropped/resized to 1920×810
        $file = $this->makeFakeJpeg(1080, 1920);
        $result = $this->processor->process($file);

        $this->assertStringStartsWith('/storage/hero_images/', $result);

        // Verify the saved file dimensions are the target dimensions
        $savedPath = storage_path('app/public/hero_images/'.basename($result));
        [$width, $height] = getimagesize($savedPath);

        $this->assertSame(1920, $width);
        $this->assertSame(810, $height);
    }

    public function test_process_square_image_is_cropped_to_landscape(): void
    {
        $file = $this->makeFakeJpeg(800, 800);
        $result = $this->processor->process($file);

        $savedPath = storage_path('app/public/hero_images/'.basename($result));
        [$width, $height] = getimagesize($savedPath);

        $this->assertSame(1920, $width);
        $this->assertSame(810, $height);
    }

    public function test_process_wide_image_is_cropped_horizontally(): void
    {
        // Ultra-wide 3840×810 — wider than 16:9 target, sides should be cropped
        $file = $this->makeFakeJpeg(3840, 810);
        $result = $this->processor->process($file);

        $savedPath = storage_path('app/public/hero_images/'.basename($result));
        [$width, $height] = getimagesize($savedPath);

        $this->assertSame(1920, $width);
        $this->assertSame(810, $height);
    }

    public function test_process_png_preserves_png_extension(): void
    {
        $file = $this->makeFakePng(800, 600);
        $result = $this->processor->process($file);

        $this->assertStringEndsWith('.png', $result);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Create a real (GD-generated) JPEG temp file wrapped as UploadedFile.
     */
    private function makeFakeJpeg(int $width, int $height): UploadedFile
    {
        $tmpPath = tempnam(sys_get_temp_dir(), 'hero_test_').'.jpg';
        $img = imagecreatetruecolor($width, $height);
        $blue = imagecolorallocate($img, 30, 144, 255);
        imagefill($img, 0, 0, $blue);
        imagejpeg($img, $tmpPath, 85);
        imagedestroy($img);

        return new UploadedFile($tmpPath, 'test.jpg', 'image/jpeg', null, true);
    }

    /**
     * Create a real (GD-generated) PNG temp file wrapped as UploadedFile.
     */
    private function makeFakePng(int $width, int $height): UploadedFile
    {
        $tmpPath = tempnam(sys_get_temp_dir(), 'hero_test_').'.png';
        $img = imagecreatetruecolor($width, $height);
        $green = imagecolorallocate($img, 34, 197, 94);
        imagefill($img, 0, 0, $green);
        imagepng($img, $tmpPath, 6);
        imagedestroy($img);

        return new UploadedFile($tmpPath, 'test.png', 'image/png', null, true);
    }
}
