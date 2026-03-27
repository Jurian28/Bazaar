<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleBid extends Model
{
    use HasFactory;

    protected $table = 'sale_bids';

    protected $fillable = [
        'advertisement_id',
        'user_id',
        'price',
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
