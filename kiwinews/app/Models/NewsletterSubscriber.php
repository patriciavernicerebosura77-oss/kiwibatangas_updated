<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // Siguraduhing naka-import din ito para sa email notification

class NewsletterSubscriber extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
    ];
}