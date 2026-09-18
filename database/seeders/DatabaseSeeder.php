<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TicketService;
use App\Models\TourPackage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@airlanggatravel.com'],
            [
                'name' => 'Admin Airlangga',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Site Settings
        $settings = [
            'site_name' => 'Airlangga Travel & Tour Agency',
            'site_tagline' => 'Solusi Perjalanan Wisata, Umrah & Tiket Terpercaya #1',
            'whatsapp_number' => '6281233020117',
            'phone' => '+62 812 33020117',
            'email' => 'tourmice@airlanggatravel.com',
            'address' => 'Jl. Raya Airlangga No. 45, Gubeng, Surabaya, Jawa Timur 60286',
            'years_experience' => '15+',
            'happy_customers' => '25.000+',
            'destinations' => '150+',
            'certified_agency' => 'Izin Resmi Kemenag & ASITA',
            'about_company' => 'Airlangga Travel berdiri sejak tahun 2011 sebagai penyedia layanan tour & travel terkemuka di Indonesia. Kami melayani ribuan wisatawan domestik, mancanegara, serta jamaah ibadah Umrah & Hajj Plus dengan standar pelayanan profesional bintang lima.',
            'vision' => 'Menjadi perusahaan tour, travel, tiket, dan penyelenggara Umrah terpercaya yang memberikan kemudahan, keamanan, dan kebahagiaan bagi setiap pelanggan.',
            'mission' => 'Memberikan layanan perjalanan berkualitas tinggi, jaringan kemitraan maskapai & hotel terbaik, transaksi cepat via WhatsApp, serta pendampingan 24 jam.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // 3. Categories
        $catDomestik = Category::create([
            'name' => 'Wisata Domestik',
            'slug' => 'wisata-domestik',
            'type' => 'tour',
            'icon' => 'compass',
        ]);

        $catInternasional = Category::create([
            'name' => 'Wisata Internasional',
            'slug' => 'wisata-internasional',
            'type' => 'tour',
            'icon' => 'globe',
        ]);

        $catUmrah = Category::create([
            'name' => 'Umrah & Hajj Plus',
            'slug' => 'umrah-hajj',
            'type' => 'umrah',
            'icon' => 'moon',
        ]);

        $catTransport = Category::create([
            'name' => 'Sewa Transportasi',
            'slug' => 'sewa-transport',
            'type' => 'transport',
            'icon' => 'car',
        ]);

        // 4. Tour Packages
        TourPackage::create([
            'category_id' => $catDomestik->id,
            'title' => 'Exotic Bali & Island Hopping Nusa Penida',
            'slug' => Str::slug('Exotic Bali & Island Hopping Nusa Penida'),
            'destination' => 'Bali, Indonesia',
            'price' => 3850000,
            'discount_price' => 3250000,
            'duration_days' => 4,
            'duration_nights' => 3,
            'description' => 'Jelajahi keindahan pulau dewata Bali dan surga tersembunyi Nusa Penida (Kelingking Beach, Broken Beach, Diamond Beach) lengkap dengan hotel bintang 4 dan makan malam di Jimbaran Beach.',
            'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1200',
            'gallery' => [
                'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1200',
                'https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=1200',
                'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
            ],
            'itinerary' => [
                ['day' => 1, 'title' => 'Penjemputan Bandara & Pantai Pandawa', 'description' => 'Tiba di Bandara Ngurah Rai, disambut Tour Guide. Mengunjungi Pantai Pandawa & Sunset Uluwatu.'],
                ['day' => 2, 'title' => 'Full Day Tour Nusa Penida West & East', 'description' => 'Menyeberang ke Nusa Penida dengan Speedboat. Mengunjungi Kelingking Beach, Angel Billabong, & Diamond Beach.'],
                ['day' => 3, 'title' => 'Ubud Cultural Village & Kintamani Volcano', 'description' => 'Melihat pemandangan Gunung Bromo, persawahan Tegalalang Ubud, & belanja souvenir Krisna.'],
                ['day' => 4, 'title' => 'Tanah Lot & Transfer Bandara', 'description' => 'Kunjungan ke Pura Tanah Lot lalu diantar kembali ke Bandara.'],
            ],
            'inclusions' => [
                'Tiket Pesawat Pulang Pergi (Opsional)',
                'Hotel Bintang 4 (3 Malam)',
                'Makan Pagi, Siang, & Malam sesuai Itinerary',
                'Transportasi AC Private & Supir Ramah',
                'Tiket Speedboat PP Nusa Penida',
                'Tiket Masuk Seluruh Objek Wisata',
            ],
            'exclusions' => [
                'Pengeluaran Pribadi & Tipping Guide',
                'Asuransi Tambahan (Opsional)',
            ],
            'badge' => 'Best Seller',
            'is_featured' => true,
            'is_active' => true,
        ]);

        TourPackage::create([
            'category_id' => $catDomestik->id,
            'title' => 'Labuan Bajo Sailing Liveaboard & Komodo Dragon',
            'slug' => Str::slug('Labuan Bajo Sailing Liveaboard & Komodo Dragon'),
            'destination' => 'Nusa Tenggara Timur',
            'price' => 6500000,
            'discount_price' => 5900000,
            'duration_days' => 3,
            'duration_nights' => 2,
            'description' => 'Pengalaman tak terlupakan menginap di atas kapal Phinisi Mewah (Liveaboard 3D2N), trekking di Pulau Padar, bertemu Komodo di Pulau Rinca, & renang bersama Manta Ray.',
            'cover_image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
            'gallery' => [
                'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
                'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1200',
            ],
            'itinerary' => [
                ['day' => 1, 'title' => 'Boarding Phinisi - Pulau Kelor & Kalong', 'description' => 'Naik kapal Phinisi, trekking Pulau Kelor & menikmati sunset ribuan kelelawar di Pulau Kalong.'],
                ['day' => 2, 'title' => 'Sunrise Pulau Padar, Pink Beach & Komodo', 'description' => 'Sunrise trekking Pulau Padar, bersantai di Pink Beach, & bertemu Komodo ditemani Ranger.'],
                ['day' => 3, 'title' => 'Manta Point & Taka Makassar', 'description' => 'Snorkeling bersama Manta Ray di Manta Point, foto di Taka Makassar, & kembali ke Labuan Bajo.'],
            ],
            'inclusions' => [
                'Menginap 2 Malam di Kapal Phinisi AC',
                'Makan 7x Selama di Kapal (Chef Onboard)',
                'Alat Snorkeling & Pelampung Lengkap',
                'Dokumentasi Drone & Kamera Mirrorless',
                'Air Mineral & Kopi/Teh Sepuasnya',
            ],
            'exclusions' => [
                'Tiket Masuk Taman Nasional Komodo (Ranger Fee)',
                'Tiket Pesawat ke/dari Labuan Bajo',
            ],
            'badge' => 'Diskon 10%',
            'is_featured' => true,
            'is_active' => true,
        ]);

        TourPackage::create([
            'category_id' => $catUmrah->id,
            'title' => 'Paket Umrah Executive Bintang 5 - 9 Hari (Direct Flight)',
            'slug' => Str::slug('Paket Umrah Executive Bintang 5 - 9 Hari Direct Flight'),
            'destination' => 'Makkah & Madinah, Arab Saudi',
            'price' => 32500000,
            'discount_price' => 29900000,
            'duration_days' => 9,
            'duration_nights' => 8,
            'description' => 'Ibadah Umrah khusyuk dengan fasilitas Hotel Bintang 5 persis di depan Pelataran Masjidil Haram (Pullman Zamzam / Hilton) & Masjid Nabawi (Frontel Al Harithia). Penerbangan Langsung Saudia Airlines.',
            'cover_image' => 'https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=1200',
            'gallery' => [
                'https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=1200',
                'https://images.unsplash.com/photo-1591604466107-ec97de577aff?q=80&w=1200',
            ],
            'itinerary' => [
                ['day' => 1, 'title' => 'Keberangkatan Surabaya/Jakarta - Madinah', 'description' => 'Berkumpul di Bandara, pengarahan pembimbing & penerbangan langsung ke Madinah.'],
                ['day' => 2, 'title' => 'Ziarah Masjid Nabawi & Raudhah', 'description' => 'Ibadah di Masjid Nabawi, ziarah ke Raudhah (Taman Surga) & Makam Rasulullah SAW.'],
                ['day' => 3, 'title' => 'Ziarah Kota Madinah (Masjid Quba & Uhud)', 'description' => 'Mengunjungi Masjid Quba, Kebun Kurma, & Jabal Uhud.'],
                ['day' => 4, 'title' => 'Menuju Makkah & Pelaksanaan Umrah Pertama', 'description' => 'Mengambil Miqat di Bir Ali, perjalanan Kereta Cepat Haramain ke Makkah, & Tawaf/Sai Umrah.'],
                ['day' => 5, 'title' => 'Perbanyak Ibadah di Masjidil Haram', 'description' => 'Ibadah mandiri di Masjidil Haram & iktikaf.'],
                ['day' => 6, 'title' => 'Ziarah Kota Makkah (Jabal Tsur & Arafah)', 'description' => 'Ziarah ke Jabal Tsur, Padang Arafah, Jabal Rahmah, Muzdalifah, & Mina.'],
                ['day' => 7, 'title' => 'Umrah Kedua & City Tour', 'description' => 'Mengambil Miqat di Ji\'ranah untuk Umrah kedua.'],
                ['day' => 8, 'title' => 'Tawaf Wada & Kepulangan ke Indonesia', 'description' => 'Pelaksanaan Tawaf Wada lalu transfer ke Bandara Jeddah.'],
                ['day' => 9, 'title' => 'Tiba di Tanah Air', 'description' => 'Tiba di Surabaya/Jakarta dengan selamat & semoga menjadi Umrah Maqbullah.'],
            ],
            'inclusions' => [
                'Tiket Pesawat Saudia Airlines PP Direct Flight',
                'Visa Umrah Resmi & Asuransi Kesehatan',
                'Hotel Makkah & Madinah Bintang 5 (Depan Pelataran)',
                'Makan 3x Sehari Fullboard Buffet Indonesia',
                'Pembimbing Ibadah (Muthawwif) Berpengalaman',
                'Perlengkapan Umrah Lengkap (Koper, Ihram/Mukena, Batik)',
                'Air Zamzam 5 Liter',
            ],
            'exclusions' => [
                'Pembuatan Paspor',
                'Pengeluaran Pribadi & Laundry Hotel',
            ],
            'badge' => 'Hot Promo',
            'is_featured' => true,
            'is_active' => true,
        ]);

        TourPackage::create([
            'category_id' => $catInternasional->id,
            'title' => 'Japan Sakura Festival & Mt. Fuji Golden Route',
            'slug' => Str::slug('Japan Sakura Festival & Mt. Fuji Golden Route'),
            'destination' => 'Tokyo, Mt. Fuji, Kyoto, Osaka',
            'price' => 22000000,
            'discount_price' => 19500000,
            'duration_days' => 7,
            'duration_nights' => 6,
            'description' => 'Nikmati indahnya bunga Sakura di Ueno Park Tokyo, keagungan Gunung Fuji di Iyashi no Sato, kuil bersejarah Fushimi Inari Kyoto, & pusat kuliner Dotonbori Osaka.',
            'cover_image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=1200',
            'gallery' => [
                'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=1200',
                'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?q=80&w=1200',
            ],
            'itinerary' => [
                ['day' => 1, 'title' => 'Tiba di Tokyo Narita & Shibuya Crossing', 'description' => 'Penjemputan di Narita, check-in hotel Tokyo, & jalan-jalan di Shibuya Hachiko.'],
                ['day' => 2, 'title' => 'Asakusa Sensoji & Ueno Sakura Park', 'description' => 'Kunjungan Kuil Asakusa, Tokyo Skytree, & piknik Sakura di Ueno Park.'],
                ['day' => 3, 'title' => 'Mt. Fuji & Kawaguchiko Lake', 'description' => 'Mengunjungi Danau Kawaguchiko & desa tradisional Iyashi no Sato di kaki Mt. Fuji.'],
                ['day' => 4, 'title' => 'Shinkansen Bullet Train ke Kyoto', 'description' => 'Pengalaman naik Kereta Cepat Shinkansen menuju Kyoto & Fushimi Inari Shrine.'],
                ['day' => 5, 'title' => 'Arashiyama Bamboo Forest & Osaka Castle', 'description' => 'Jalan-jalan di hutan bambu Arashiyama & benteng Osaka Castle.'],
                ['day' => 6, 'title' => 'Universal Studios Japan (Opsional) & Dotonbori', 'description' => 'Bebas acara di USJ atau berbelanja kuliner Takoyaki di Dotonbori.'],
                ['day' => 7, 'title' => 'Kansai Airport & Kembali ke Indonesia', 'description' => 'Pengantaran ke Kansai Airport untuk penerbangan pulang.'],
            ],
            'inclusions' => [
                'Tiket Pesawat PP All-in',
                'Hotel Bintang 3/4 Strategis Dekat Stasiun',
                'Tiket Shinkansen Tokyo-Kyoto',
                'Tour Guide Berbahasa Indonesia',
                'Visa Jepang (Paspor Biasa/E-Passport)',
            ],
            'exclusions' => [
                'Tiket Universal Studios Japan (Opsional)',
                'Makan Yang Tidak Disebutkan',
            ],
            'badge' => 'Favorit Musim Semi',
            'is_featured' => true,
            'is_active' => true,
        ]);

        TourPackage::create([
            'category_id' => $catTransport->id,
            'title' => 'Sewa HiAce Commuter VIP / Premio Driver Profesional',
            'slug' => Str::slug('Sewa HiAce Commuter VIP Premio Driver Profesional'),
            'destination' => 'Surabaya, Malang, Bromo, Bali',
            'price' => 1300000,
            'discount_price' => null,
            'duration_days' => 1,
            'duration_nights' => 0,
            'description' => 'Sewa armada bus/microbus Toyota HiAce Premio & Commuter kapasitas 14-16 seat dengan interior mewah, AC dingin, Reclining Seat, USB Charger, & Supir ramah berpengalaman.',
            'cover_image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1200',
            'gallery' => [
                'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1200',
            ],
            'itinerary' => [
                ['day' => 1, 'title' => 'Layanan Sewa Harian / Drop Off', 'description' => 'Penjemputan sesuai tempat lokasi yang diminta (Bandara, Rumah, Kantor) & siap antar seluruh rute Jawa-Bali.'],
            ],
            'inclusions' => [
                'Armada HiAce Clean & Disinfected',
                'Layanan Supir Berpengalaman',
                'Kapasitas Hingga 14 Penumpang',
                'AC Dual Blower & Reclining Seat',
            ],
            'exclusions' => [
                'Bahan Bakar (BBM), Tol, & Parkir',
                'Uang Makan Supir (Jika Menginap)',
            ],
            'badge' => 'Armada Terbaru',
            'is_featured' => false,
            'is_active' => true,
        ]);

        // 5. Ticket Services
        TicketService::create([
            'type' => 'pesawat',
            'title' => 'Tiket Pesawat Domestik & Internasional',
            'description' => 'Pesan tiket pesawat Garuda Indonesia, Lion Air, Citilink, Batik Air, AirAsia, Saudia, Singapore Airlines dengan harga promo agen & bantuan issued cepat 24 jam.',
            'icon' => 'plane',
            'wa_template_message' => 'Halo Airlangga Travel, saya ingin beli Tiket Pesawat:',
        ]);

        TicketService::create([
            'type' => 'kereta',
            'title' => 'Tiket Kereta Api KAI (Eksekutif & Luxury)',
            'description' => 'Layanan pemesanan tiket kereta api antar kota seluruh Jawa & Sumatra (Eksekutif, Luxury Sleeper, Panoramic) tanpa perlu antre.',
            'icon' => 'train',
            'wa_template_message' => 'Halo Airlangga Travel, saya ingin reservasi Tiket Kereta Api:',
        ]);

        TicketService::create([
            'type' => 'bus',
            'title' => 'Sewa Bus Pariwisata & Shuttle Travel',
            'description' => 'Armada Bus Pariwisata Medium (31 seat) & Big Bus (50 seat) karoseri Jetbus/Adiputro terbaru untuk keperluas karya wisata, rombongan kantor, & keluarga.',
            'icon' => 'bus',
            'wa_template_message' => 'Halo Airlangga Travel, saya ingin tanya ketersediaan Bus Pariwisata:',
        ]);

        // 6. Testimonials
        Testimonial::create([
            'client_name' => 'Bpk. H. Rahmat Santoso',
            'client_title' => 'Jamaah Umrah Executive 2025',
            'rating' => 5,
            'comment' => 'Alhamdulillah ibadah Umrah bersama Airlangga Travel sangat memuaskan. Hotelnya benar-benar di depan masjidil haram, makanannya selera Indonesia, dan Muthawwifnya sabar mendampingi jamaah sepuh.',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200',
            'package_name' => 'Umrah Executive Bintang 5',
        ]);

        Testimonial::create([
            'client_name' => 'Ibu Dr. Ratna Sari',
            'client_title' => 'Gathering Perusahaan PT Petrokimia',
            'rating' => 5,
            'comment' => 'Tour Bali & Nusa Penida untuk 45 orang staf kami berjalan lancar luar biasa! Pelayanan guide ramah, bus AC dingin, dan booking via WhatsApp sangat responsif.',
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200',
            'package_name' => 'Exotic Bali Tour',
        ]);

        Testimonial::create([
            'client_name' => 'Kevin & Amanda',
            'client_title' => 'Honeymoon Trip Labuan Bajo',
            'rating' => 5,
            'comment' => 'Sailing 3D2N naik Phinisi dengan Airlangga Travel adalah keputusan terbaik untuk honeymoon kami. Dokumentasi dronenya keren banget dan kapal bersih berkelas!',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
            'package_name' => 'Labuan Bajo Phinisi Tour',
        ]);

        // 7. Articles
        Article::create([
            'title' => '7 Tips Utama Memilih Paket Umrah Berizin Resmi Agar Ibadah Tenang',
            'slug' => Str::slug('7 Tips Utama Memilih Paket Umrah Berizin Resmi Agar Ibadah Tenang'),
            'category' => 'Panduan Umrah',
            'excerpt' => 'Sebelum mendaftar Umrah, pastikan travel yang Anda pilih memiliki izin PPIU resmi dari Kementerian Agama dan menawarkan kepastian jadwal penerbangan.',
            'content' => '<p>Menjalankan ibadah Umrah ke tanah suci merupakan impian setiap umat muslim. Namun, maraknya penipuan agen travel abal-abal menuntut kita untuk ekstra waspada.</p><p>Berikut adalah 5 syarat penting yang wajib Anda cek (5 PASTI Umrah):</p><ul><li><strong>Pasti Travelnya Berizin:</strong> Cek nomor izin PPIU resmi Kemenag.</li><li><strong>Pasti Jadwalnya:</strong> Memiliki tiket penerbangan pergi-pulang yang jelas.</li><li><strong>Pasti Terbangnya:</strong> Menggunakan maskapai ternama tanpa transit berlebihan.</li><li><strong>Pasti Hotelnya:</strong> Lokasi hotel terverifikasi dan jelas bintangnya.</li><li><strong>Pasti Visanya:</strong> Visa terbit sebelum tanggal keberangkatan.</li></ul><p>Airlangga Travel menjamin seluruh paket Umrah kami memenuhi standar 5 PASTI Kementerian Agama RI.</p>',
            'cover_image' => 'https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=1200',
            'author' => 'Ustadz H. Ahmad (Pembimbing Ibadah)',
            'views' => 1420,
            'is_published' => true,
        ]);

        Article::create([
            'title' => 'Panduan Lengkap Liburan ke Labuan Bajo: Waktu Terbaik & Destinasi Wajib',
            'slug' => Str::slug('Panduan Lengkap Liburan ke Labuan Bajo Waktu Terbaik Destinasi Wajib'),
            'category' => 'Tips Wisata',
            'excerpt' => 'Ingin liburan ke surga Nusa Tenggara Timur? Simak rekomendasi bulan terbaik untuk trekking Pulau Padar & laut tenang untuk snorkeling bersama Manta Ray.',
            'content' => '<p>Labuan Bajo di Flores Barat telah menjadi destinasi impian dunia. Keindahan bukit savana dan perairan beningnya menyajikan pemandangan spektakuler.</p><p>Bulan April hingga November adalah waktu ideal untuk sailing karena ombak laut cenderung tenang dan cuaca cerah untuk trekking fotografi.</p>',
            'cover_image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
            'author' => 'Tim Destinasi Airlangga',
            'views' => 890,
            'is_published' => true,
        ]);

        // 8. Documentation Photo Gallery
        Gallery::create([
            'title' => 'Keberangkatan Jamaah Umrah Executive Makkah',
            'image_url' => 'https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=1200',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Gathering Perusahaan Tour Bali & Nusa Penida',
            'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1200',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Sailing Phinisi Trip Labuan Bajo Komodo',
            'image_url' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Dokumentasi Tour Musim Semi Japan Sakura Golden Route',
            'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=1200',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Ziarah Masjid Nabawi Madinah Munawwarah',
            'image_url' => 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?q=80&w=1200',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // 9. Trusted Partners & Corporate Clients
        $partners = [
            ['name' => 'PT Petrokimia Gresik', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
            ['name' => 'PT Telkomsel Indonesia', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
            ['name' => 'Bank Jatim', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
            ['name' => 'Garuda Indonesia', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
            ['name' => 'Saudia Airlines', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
            ['name' => 'ASITA Indonesia', 'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=300'],
        ];

        foreach ($partners as $idx => $p) {
            Partner::create([
                'name' => $p['name'],
                'logo_url' => $p['logo_url'],
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        $this->call(ServicesSeeder::class);
    }
}
