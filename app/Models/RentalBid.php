<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBid extends Model
{
    use HasFactory;

    public static $WEAR_PER_DAY = 1;

    protected $table = 'rental_bids';

    protected $fillable = [
        'advertisement_id',
        'user_id',
        'start_date',
        'end_date',
        'photo_returned',
        'accepted',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
