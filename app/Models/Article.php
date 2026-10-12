<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'cover_image',
        'author',
        'views',
        'is_published',
        'created_at',
    ];

    protected $casts = [
        'views' => 'integer',
        'is_published' => 'boolean',
    ];

    public static function getCategories(): array
    {
        $defaultCategories = [
            'Tips Wisata',
            'Panduan Umrah',
            'Berita Travel',
            'UNAIR Store',
            'Paket Tour & Wisata',
            'Tiket Wisata',
            'Sewa Transportasi',
            'E-Paspor & Visa',
            'Promosi & Event',
        ];

        try {
            $raw = SiteSetting::get('article_categories');
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
        SiteSetting::set('article_categories', json_encode($cleaned));
    }
}
