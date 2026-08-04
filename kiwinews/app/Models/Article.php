<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'excerpt',
        'body',
        'image_url',
        'video_url',
        'images',
        'slug',
        'published_at',
        'is_featured',
        'is_breaking',
        'daily_views',
        'weekly_views',
        'monthly_views',
        'yearly_views'
    ];

    protected $casts = [
        'images' => 'array',
    ];
}