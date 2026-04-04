<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

//    public function bids()
//    {
//        return $this->hasMany(Bid::class);
//    }
}
