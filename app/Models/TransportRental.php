<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'inclusions',
        'fleet_items',
        'cover_image',
        'detail_images',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'inclusions' => 'array',
        'fleet_items' => 'array',
        'detail_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
