<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UnairStoreItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'price',
        'discount_price',
        'stock_status',
        'badge',
        'description',
        'cover_image',
        'detail_images',
        'wa_template_message',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'detail_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->price === null || (float) $this->price <= 0) {
            return null;
        }

        return 'Rp '.number_format((float) $this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPriceAttribute(): ?string
    {
        if ($this->discount_price === null || (float) $this->discount_price <= 0) {
            return null;
        }

        return 'Rp '.number_format((float) $this->discount_price, 0, ',', '.');
    }

    public function getResolvedWaMessage(?string $prefix = null): string
    {
        $defaultOld = 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk: '.$this->title;
        if (! empty($this->wa_template_message) && $this->wa_template_message !== $defaultOld) {
            return $this->wa_template_message;
        }

        $effectivePrefix = trim((string) ($prefix ?: 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk:'));

        return $effectivePrefix.' '.$this->title;
    }

    public static function getCategories(): array
    {
        $defaultCategories = [
            'Apparel & Fashion',
            'Tumbler & Drinkware',
            'Souvenir & Aksesoris',
            'Perlengkapan Travel',
        ];

        try {
            $raw = SiteSetting::get('unair_store_categories');
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded) && ! empty($decoded)) {
                    return array_values(array_unique(array_filter($decoded)));
                }
            }
        } catch (\Throwable $e) {
            // Fallback to default
        }

        return $defaultCategories;
    }

    public static function saveCategories(array $categories): void
    {
        $cleaned = array_values(array_unique(array_filter(array_map('trim', $categories))));
        SiteSetting::set('unair_store_categories', json_encode($cleaned));
    }

    /**
     * @return array<string, string>
     */
    public static function getPageSettings(): array
    {
        $defaults = [
            'store_whatsapp_number' => '6281233020117',
            'store_whatsapp_order_prefix' => 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk:',
            'store_whatsapp_custom_message' => 'Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:',
            'store_hero_badge' => '🛍️ Official Merchandise & Travel Store',
            'store_hero_title' => 'UNAIR Store',
            'store_hero_highlight' => '& Official Merch',
            'store_hero_description' => 'Koleksi merchandise resmi Universitas Airlangga, apparel eksklusif Ksatria Airlangga, souvenir kampus, serta perlengkapan traveling pilihan Airlangga Travel dengan pemesanan cepat via WhatsApp.',
            'store_search_placeholder' => 'Cari produk UNAIR Store...',
            'store_banner_enabled' => '1',
            'store_banner_badge' => '✨ Custom Order & Souvenir Kampus / Instansi',
            'store_banner_title' => 'Butuh Souvenir Seminar, Wisuda, atau Gathering Fakultas?',
            'store_banner_description' => 'UNAIR Store bersama Airlangga Travel melayani pemesanan partai besar (bulk order) seminar kit, jaket angkatan, tumbler custom logo fakultas, hingga paket merchandise eksklusif dengan harga khusus.',
            'store_banner_button_text' => 'Konsultasi Custom Order via WA',
        ];

        try {
            $raw = SiteSetting::get('unair_store_page_settings');
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    return array_merge($defaults, $decoded);
                }
            }
        } catch (\Throwable $e) {
            // Fallback to defaults
        }

        return $defaults;
    }

    /**
     * @param  array<string, mixed>  $settings
     */
    public static function savePageSettings(array $settings): void
    {
        $merged = array_merge(self::getPageSettings(), $settings);
        SiteSetting::set('unair_store_page_settings', json_encode($merged));
    }

    public static function ensureReady(): void
    {
        if (! Schema::hasTable('unair_store_items')) {
            Schema::create('unair_store_items', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('category')->default('Apparel & Fashion');
                $table->decimal('price', 14, 2)->nullable();
                $table->decimal('discount_price', 14, 2)->nullable();
                $table->string('stock_status')->default('Tersedia');
                $table->string('badge')->nullable();
                $table->text('description')->nullable();
                $table->string('cover_image')->nullable();
                $table->json('detail_images')->nullable();
                $table->string('wa_template_message')->nullable();
                $table->boolean('is_featured')->default(true);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            try {
                DB::statement('ALTER TABLE unair_store_items MODIFY price DECIMAL(14, 2) NULL DEFAULT NULL');
            } catch (\Throwable $e) {
                // Ignore if already nullable or SQLite in tests
            }
        }

        if (self::count() === 0) {
            $defaults = [
                [
                    'title' => 'Varsity Jacket Exclusive Ksatria Airlangga',
                    'category' => 'Apparel & Fashion',
                    'price' => 325000,
                    'discount_price' => 285000,
                    'stock_status' => 'Tersedia',
                    'badge' => 'Best Seller',
                    'description' => 'Jaket Varsity premium edisi resmi Universitas Airlangga berbahan Cotton Fleece tebal dengan bordir logo Garuda Mukti presisi. Nyaman dipakai kuliah maupun traveling.',
                    'cover_image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=1000&q=80',
                        'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
                [
                    'title' => 'Hoodie Official Universitas Airlangga Navy Edition',
                    'category' => 'Apparel & Fashion',
                    'price' => 260000,
                    'discount_price' => 225000,
                    'stock_status' => 'Tersedia',
                    'badge' => 'Official Merch',
                    'description' => 'Hoodie pullover warna Navy khas Airlangga dengan bahan lembut, hangat, dan sablon plastisol high-density. Tersedia ukuran S, M, L, XL, hingga XXL.',
                    'cover_image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
                [
                    'title' => 'Tumbler Stainless Vacuum Flask LED UNAIR',
                    'category' => 'Tumbler & Drinkware',
                    'price' => 135000,
                    'discount_price' => 110000,
                    'stock_status' => 'Tersedia',
                    'badge' => 'Favorit',
                    'description' => 'Tumbler stainless steel SUS 304 tahan panas & dingin hingga 12 jam dengan indikator suhu LED sentuh dan grafir laser logo resmi Universitas Airlangga.',
                    'cover_image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
                [
                    'title' => 'Totebag Canvas Premium & Lanyard ID Card UNAIR',
                    'category' => 'Souvenir & Aksesoris',
                    'price' => 95000,
                    'discount_price' => 79000,
                    'stock_status' => 'Tersedia',
                    'badge' => 'Paket Hemat',
                    'description' => 'Paket bundling Totebag kanvas tebal ber-resleting muat laptop 15 inch dilengkapi Lanyard printing dua sisi + card holder kulit sintetis eksklusif UNAIR.',
                    'cover_image' => 'https://images.unsplash.com/photo-1597484661643-2f5fef640dd1?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1597484661643-2f5fef640dd1?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
                [
                    'title' => 'Travel Kit & Neck Pillow Memory Foam Airlangga',
                    'category' => 'Perlengkapan Travel',
                    'price' => 175000,
                    'discount_price' => 149000,
                    'stock_status' => 'Tersedia',
                    'badge' => 'Travel Series',
                    'description' => 'Bantal leher memory foam empuk dilengkapi penutup mata, pouch organizer tahan air, dan luggage tag eksklusif kolaborasi UNAIR Store x Airlangga Travel.',
                    'cover_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
                [
                    'title' => 'Paket Souvenir Wisuda & Seminar Kit Eksklusif UNAIR',
                    'category' => 'Souvenir & Aksesoris',
                    'price' => 195000,
                    'discount_price' => 165000,
                    'stock_status' => 'Pre-Order',
                    'badge' => 'Custom Order',
                    'description' => 'Gift box eksklusif berisi boneka maskot wisuda/agenda kulit, pulpen metal grafir, pin kuningan Garuda Mukti, dan goodie bag resmi untuk acara fakultas & seminar.',
                    'cover_image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=1000&q=80',
                    'detail_images' => [
                        'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=1000&q=80',
                    ],
                ],
            ];

            foreach ($defaults as $item) {
                self::create([
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'category' => $item['category'],
                    'price' => $item['price'],
                    'discount_price' => $item['discount_price'],
                    'stock_status' => $item['stock_status'],
                    'badge' => $item['badge'],
                    'description' => $item['description'],
                    'cover_image' => $item['cover_image'],
                    'detail_images' => $item['detail_images'],
                    'wa_template_message' => 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk: '.$item['title'],
                    'is_featured' => true,
                    'is_active' => true,
                ]);
            }
        }
    }
}
