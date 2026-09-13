<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\TourPackage;
use App\Models\TransportRental;
use App\Models\PassportVisaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourCat = Category::firstOrCreate(['slug' => 'tour-wisata'], ['name' => 'Paket Tour & Wisata', 'type' => 'tour', 'icon' => '✈️']);
        $umrahCat = Category::firstOrCreate(['slug' => 'umrah-hajj'], ['name' => 'Umrah & Hajj', 'type' => 'umrah', 'icon' => '🕋']);
        $ticketCat = Category::firstOrCreate(['slug' => 'tiket-wisata'], ['name' => 'Tiket Wisata', 'type' => 'ticket', 'icon' => '🎟️']);

        // 1. Lombok Package (From Screenshot 1)
        TourPackage::updateOrCreate(
            ['slug' => 'liburan-tanpa-batas-lombok'],
            [
                'category_id' => $tourCat->id,
                'title' => 'Liburan Tanpa Batas di Lombok!',
                'destination' => 'Lombok, West Nusa Tenggara',
                'price' => 1555000,
                'duration_days' => 3,
                'duration_nights' => 2,
                'description' => 'Nikmati sensasi wisata jelajah keindahan pulau Lombok, Sirkuit Mandalika, desa adat Sasak, dan eksotisme gili.',
                'cover_image' => 'https://images.unsplash.com/photo-1570784428784-2840de469335?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1570784428784-2840de469335?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80'
                ],
                'sub_destinations' => [
                    [
                        'name' => 'Sasak Ende',
                        'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Gili Trawangan',
                        'image' => 'https://images.unsplash.com/photo-1570784428784-2840de469335?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Bukit Seger',
                        'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                'inclusions' => [
                    'Transportasi Lokal',
                    'Hotel *3 selama 2 malam',
                    'Snack & Air Mineral',
                    'Tiket Wisata (Bukit Merese, Pantai Kuta Mandalika, Desa Sukarare)',
                    'Makan sesuai program',
                    'Guide profesional',
                    'Boat penyeberangan Gili'
                ],
                'badge' => 'Terpopuler Lombok',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 2. Bali Package (From Screenshot 1)
        TourPackage::updateOrCreate(
            ['slug' => 'liburan-tanpa-batas-bali'],
            [
                'category_id' => $tourCat->id,
                'title' => 'Liburan Tanpa Batas di Bali!',
                'destination' => 'Bali & Nusa Penida',
                'price' => 1599000,
                'duration_days' => 3,
                'duration_nights' => 2,
                'description' => 'Jelajahi keindahan panorama pulau Dewata Bali, wisata kebudayaan Panglipuran, wahana water sport, dan pemandangan Gunung Kintamani.',
                'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80'
                ],
                'sub_destinations' => [
                    [
                        'name' => 'Panglipuran',
                        'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Water Sport',
                        'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Kintamani',
                        'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                'inclusions' => [
                    'Transportasi Lokal',
                    'Hotel bintang 3 selama 2 malam',
                    'Snack & Air Mineral',
                    'Wisata (Kintamani, GWK, Banana boat, Panglipuran, Melasti)',
                    'Makan & Snack',
                    'Banner rombongan'
                ],
                'badge' => 'Best Seller Bali',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 3. Ziarah Wali Jatim Package (From Screenshot 2)
        TourPackage::updateOrCreate(
            ['slug' => 'ziarah-wali-jatim'],
            [
                'category_id' => $tourCat->id,
                'title' => 'Ziarah Wali Jatim',
                'destination' => 'Jawa Timur (Surabaya, Gresik, Tuban)',
                'meeting_point' => 'Surabaya, Sidoarjo',
                'price' => 265000,
                'duration_days' => 1,
                'duration_nights' => 0,
                'description' => 'Paket ziarah wali sanga Jawa Timur mengungjungi makam Sunan Ampel, Sunan Malik Ibrahim, Sunan Giri, Sunan Asmorokondi, dan Sunan Bonang.',
                'cover_image' => 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1591604466107-ec97de577aff?auto=format&fit=crop&w=1200&q=80'
                ],
                'pricing_tiers' => [
                    ['pax' => '40 Pax', 'price' => 345000, 'note' => '2x Makan'],
                    ['pax' => '50 Pax', 'price' => 295000, 'note' => '2x Makan'],
                    ['pax' => '59 Pax', 'price' => 265000, 'note' => '2x Makan'],
                    ['pax' => '40 Pax', 'price' => 375000, 'note' => '3x Makan'],
                    ['pax' => '50 Pax', 'price' => 320000, 'note' => '3x Makan'],
                    ['pax' => '59 Pax', 'price' => 295000, 'note' => '3x Makan'],
                ],
                'inclusions' => [
                    'Transportasi BigBus (Tol, Parkir, Tip Crew)',
                    'Ustadz pembimbing ziarah',
                    'Infaq lokasi',
                    'Snack & Air Mineral',
                    'Makan sesuai paket',
                    'Tour Leader berpengalaman',
                    'Banner & Dokumentasi',
                    'Asuransi Perjalanan'
                ],
                'badge' => 'Paket Ziarah Rombongan',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 4. Sewa Transportasi (From Screenshot 3)
        TransportRental::updateOrCreate(
            ['slug' => 'pricelist-sewa-armada-surabaya-antar-kota'],
            [
                'title' => 'Pricelist Sewa Armada Surabaya - Antar Kota',
                'category' => 'Surabaya Area & Antar Kota',
                'inclusions' => ['BBM', 'Unit Armada Clean', 'Driver Profesional'],
                'fleet_items' => [
                    ['unit' => 'Innova Reborn', 'seat' => '7 pax', 'price_per_day' => 916000],
                    ['unit' => 'All New Avanza', 'seat' => '7 pax', 'price_per_day' => 855000],
                    ['unit' => 'Zenix', 'seat' => '7 pax', 'price_per_day' => 1588000],
                    ['unit' => 'HiAce Premio / Commuter', 'seat' => '10-12 pax', 'price_per_day' => 1465000],
                    ['unit' => 'Medium Bus', 'seat' => '30-35 pax', 'price_per_day' => 2442000],
                    ['unit' => 'Big Bus VIP', 'seat' => '50-59 pax', 'price_per_day' => 3358000],
                ],
                'cover_image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80',
                'detail_images' => [
                    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1559297434-fae8a1916a79?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80'
                ],
                'description' => 'Layanan sewa armada kendaraan paling lengkap di Surabaya untuk keperluan perjalanan dinas, wisata keluarga, ziarah, dan city tour antar kota.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 5. E-Passport & Visa (From Screenshot 4)
        PassportVisaService::updateOrCreate(
            ['slug' => 'pembuatan-epaspor-dan-layanan-visa'],
            [
                'title' => 'Pembuatan E-Paspor & Layanan Visa',
                'type' => 'passport',
                'benefits' => [
                    'Tanpa antri kuota foto imigrasi',
                    'Datang langsung tinggal foto',
                    'Paspor jadi 3 hari kerja setelah foto (sabtu, minggu & tanggal merah tidak terhitung)'
                ],
                'pricing_options' => [
                    ['item' => 'Epaspor 5 tahun', 'price' => 1400000, 'note' => 'Berlaku 5 Tahun'],
                    ['item' => 'Epaspor 10 tahun', 'price' => 1800000, 'note' => 'Berlaku 10 Tahun'],
                    ['item' => 'Visa Jepang Waiver (epaspor)', 'price' => 550000, 'note' => 'Khusus Pemegang Epaspor'],
                    ['item' => 'Visa Jepang Reguler (paspor biasa)', 'price' => 1150000, 'note' => 'Paspor Biasa Non-Epaspor'],
                    ['item' => 'Visa Korea single entry', 'price' => 1650000, 'note' => 'Single Entry Visa'],
                    ['item' => 'Visa Korea multiple entry', 'price' => 2600000, 'note' => 'Multiple Entry Visa'],
                    ['item' => 'Visa Australia', 'price' => 2850000, 'note' => 'Tourist & Business Visa'],
                ],
                'cover_image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80',
                'detail_images' => [
                    'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1200&q=80'
                ],
                'description' => 'Jasa pengurusan E-Paspor resmi kilat 3 hari serta pengajuan dokumen Visa turis/bisnis ke berbagai negara tujuan favorit dunia.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );
    }
}
