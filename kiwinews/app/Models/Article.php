<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'category', 
        'image_url', 'is_breaking', 'is_featured', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}