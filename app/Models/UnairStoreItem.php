<?php

namespace App\Models;

use Database\Seeders\UnairStoreOfficialCatalogSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UnairStoreItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'available_sizes',
        'available_colors',
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
        'available_sizes' => 'array',
        'available_colors' => 'array',
        'detail_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static bool $isBootstrapping = false;

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

    /**
     * @return array<int, string>
     */
    public function getSizesListAttribute(): array
    {
        if (empty($this->available_sizes)) {
            return [];
        }

        if (is_array($this->available_sizes)) {
            return array_values(array_filter(array_map('trim', $this->available_sizes)));
        }

        return array_values(array_filter(array_map('trim', explode(',', (string) $this->available_sizes))));
    }

    /**
     * @return array<int, string>
     */
    public function getColorsListAttribute(): array
    {
        if (empty($this->available_colors)) {
            return [];
        }

        if (is_array($this->available_colors)) {
            return array_values(array_filter(array_map('trim', $this->available_colors)));
        }

        return array_values(array_filter(array_map('trim', explode(',', (string) $this->available_colors))));
    }

    public function getResolvedWaMessage(?string $prefix = null): string
    {
        $defaultOld = 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk: '.$this->title;
        if (! empty($this->wa_template_message) && $this->wa_template_message !== $defaultOld) {
            return $this->wa_template_message;
        }

        $effectivePrefix = trim((string) ($prefix ?: 'Halo Admin UNAIR Store, saya ingin menanyakan ketersediaan produk:'));

        return $effectivePrefix.' '.$this->title;
    }

    public static function getCategories(): array
    {
        $defaultCategories = [
            'Apparel & Fashion',
            'Tumbler & Drinkware',
            'Tas & Totebag',
            'Souvenir & Aksesoris',
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
            'store_whatsapp_number' => '6285157715414',
            'store_whatsapp_order_prefix' => 'Halo Admin UNAIR Store, saya ingin menanyakan ketersediaan produk:',
            'store_whatsapp_custom_message' => 'Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:',
            'store_hero_badge' => '',
            'store_hero_title' => 'Merchandise Universitas Airlangga',
            'store_hero_highlight' => '',
            'store_hero_description' => 'Koleksi merchandise Universitas Airlangga, apparel eksklusif Ksatria Airlangga, serta aneka souvenir kampus.',
            'store_hero_logo_size' => 'large',
            'store_search_placeholder' => 'Cari merchandise Universitas Airlangga...',
            'store_banner_enabled' => '1',
            'store_banner_badge' => '✨ Custom Order & Souvenir Kampus / Instansi',
            'store_banner_title' => 'Butuh Custom Merchandise untuk Event, Unit Universitas, atau Corporate?',
            'store_banner_description' => 'Airlangga Travel melayani pemesanan partai besar (bulk order) seminar kit, jaket angkatan, tumbler custom logo fakultas, hingga paket merchandise eksklusif dengan harga khusus.',
            'store_banner_button_text' => 'Konsultasi Custom Order via WA',
        ];

        try {
            $raw = SiteSetting::get('unair_store_page_settings');
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    if (($decoded['store_whatsapp_number'] ?? '') === '6281233020117') {
                        $decoded['store_whatsapp_number'] = '6285157715414';
                        SiteSetting::set('unair_store_page_settings', json_encode(array_merge($defaults, $decoded)));
                    }

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
        if (self::$isBootstrapping) {
            return;
        }

        self::$isBootstrapping = true;

        try {
            if (! Schema::hasTable('unair_store_items')) {
                Schema::create('unair_store_items', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->string('slug')->unique();
                    $table->string('category')->default('Apparel & Fashion');
                    $table->json('available_sizes')->nullable();
                    $table->json('available_colors')->nullable();
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
                if (! Schema::hasColumn('unair_store_items', 'available_sizes')) {
                    try {
                        Schema::table('unair_store_items', function (Blueprint $table) {
                            $table->json('available_sizes')->nullable()->after('category');
                        });
                    } catch (\Throwable $e) {
                        // Ignore if already added
                    }
                }
                if (! Schema::hasColumn('unair_store_items', 'available_colors')) {
                    try {
                        Schema::table('unair_store_items', function (Blueprint $table) {
                            $table->json('available_colors')->nullable()->after('available_sizes');
                        });
                    } catch (\Throwable $e) {
                        // Ignore if already added
                    }
                }
                try {
                    DB::statement('ALTER TABLE unair_store_items MODIFY price DECIMAL(14, 2) NULL DEFAULT NULL');
                } catch (\Throwable $e) {
                    // Ignore if already nullable or SQLite in tests
                }
            }

            if (self::count() < 20) {
                if (class_exists(UnairStoreOfficialCatalogSeeder::class)) {
                    (new UnairStoreOfficialCatalogSeeder)->run();

                    return;
                }
            }
        } finally {
            self::$isBootstrapping = false;
        }
    }
}
