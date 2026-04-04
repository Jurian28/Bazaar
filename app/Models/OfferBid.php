<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'user_id',
        'price',
        'accepted'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
