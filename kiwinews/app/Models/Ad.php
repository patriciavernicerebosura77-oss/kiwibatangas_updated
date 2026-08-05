<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'promo_code',
        'badge_text',
        'button_text',
        'button_link',
        'is_active',
        'expires_at', // Idinagdag para suportahan ang expiration date at time remaining
    ];
}