<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdInquiry extends Model
{
    protected $fillable = ['name', 'company', 'phone', 'email', 'message', 'status'];
}