<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'start_price',
        'end_time',
        'max_bids',
    ];

    protected $casts = [
        'start_price' => 'decimal:2',
        'end_time' => 'datetime',
        'max_bids' => 'integer',
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
