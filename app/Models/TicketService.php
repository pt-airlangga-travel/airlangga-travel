<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketService extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'icon',
        'wa_template_message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
