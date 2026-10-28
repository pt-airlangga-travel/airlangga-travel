<?php

namespace Database\Seeders;

use App\Models\HeroImage;
use Illuminate\Database\Seeder;

class HeroImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae03589a22a10.14028135.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae035ac611305.78200403.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae035bbd74e25.11008676.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae0360f8ae400.23197465.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae0361e738963.55904389.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'image_url' => '/storage/hero_images/hero_6ae03646cde712.46666637.jpg',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        $keepUrls = array_column($items, 'image_url');
        HeroImage::whereNotIn('image_url', $keepUrls)->delete();

        foreach ($items as $data) {
            HeroImage::updateOrCreate(
                ['image_url' => $data['image_url']],
                $data
            );
        }
    }
}
