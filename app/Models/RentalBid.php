<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBid extends Model
{
    use HasFactory;

    protected $table = 'rental_bids';

    protected $fillable = [
        'advertisement_id',
        'user_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
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
