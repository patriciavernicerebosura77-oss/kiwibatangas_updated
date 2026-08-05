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

    /**
     * I-link ang Article sa Category model gamit ang category name o string.
     * Pinapayagan nito ang dynamic fetching ng updated na pangalan mula sa Category table.
     */
public function categoryRecord()
{
    // Hahanapin nito sa Category table kung saan ang 'name' ay kapareho ng $this->category
    return $this->belongsTo(Category::class, 'category', 'name');
}
}