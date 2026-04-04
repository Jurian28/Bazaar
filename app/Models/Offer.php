<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'start_price',
        'end_date',
    ];

    protected $casts = [
        'start_price' => 'decimal:2',
        'end_time' => 'datetime',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
