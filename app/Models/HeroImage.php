<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'badge',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(?string $value): string
    {
        if (empty($value)) {
            return asset('assets/agt.png');
        }

        if (str_starts_with($value, '/storage/hero_images/')) {
            $filename = basename($value);
            if (file_exists(public_path('assets/hero-images/'.$filename))) {
                return asset('assets/hero-images/'.$filename);
            }
        }

        return $value;
    }
}
