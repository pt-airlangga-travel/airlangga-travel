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
                'title' => 'Penguatan Kesehatan Mental Pusat Asrama Mahasiswa',
                'subtitle' => 'Universitas Airlangga • Yogyakarta',
                'badge' => 'Gathering UNAIR 2026',
                'image_url' => '/storage/hero_images/hero-asrama-unair-pantai-jogja.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Majelis Senat Akademik PTN-BH',
                'subtitle' => 'Universitas Airlangga • Tour & Kunjungan Resmi',
                'badge' => 'Official Delegation',
                'image_url' => '/storage/hero_images/hero-ptnbh-universitas-airlangga.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Penguatan Kesehatan Mental Sekretariat UNAIR',
                'subtitle' => 'Malang • Jeep Adventure & Outbound',
                'badge' => 'Gathering & Outbound',
                'image_url' => '/storage/hero_images/hero-sekretariat-unair-malang.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Penguatan Kesehatan Mental Fakultas Kedokteran UNAIR',
                'subtitle' => 'Bandung • Family & Team Gathering',
                'badge' => 'FK UNAIR Tour',
                'image_url' => '/storage/hero_images/hero-fakultas-kedokteran-unair-bandung.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Penguatan Kesehatan Mental RSGM UNAIR',
                'subtitle' => 'Rumah Sakit Gigi & Mulut • Yogyakarta',
                'badge' => 'RSGM Gathering',
                'image_url' => '/storage/hero_images/hero-rsgm-universitas-airlangga-jogja.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($items as $data) {
            HeroImage::updateOrCreate(
                ['image_url' => $data['image_url']],
                $data
            );
        }
    }
}
