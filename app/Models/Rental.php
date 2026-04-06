<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'start_date',
        'end_date',
        'price_per_day',
        'wear_level',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price_per_day' => 'decimal:2',
        'wear_level' => 'integer',
    ];

    public function advertisement() {
        return $this->belongsTo(Advertisement::class);
    }

    public function user() {
        return $this->belongsTo(User::class); // renter
    }
}
