<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassportVisaService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'benefits',
        'pricing_options',
        'cover_image',
        'detail_images',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'pricing_options' => 'array',
        'detail_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
