<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price_per_day',
        'location',
        'photo_path',
        'expires_at'
    ];
}
