<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    const MAXIMUM = 4;

    protected $fillable = [
        'company_id',
        'user_id',
        'title',
        'description',
        'type',
    ];

    public function sale() {
        return $this->hasOne(Sale::class);
    }
    public function rental() {
        return $this->hasOne(Rental::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function saleBids() {
        return $this->hasMany(SaleBid::class);
    }

    public function rentalBids() {
        return $this->hasMany(RentalBid::class);
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }


    public function isRental() {
        return $this->type == 'rental';
    }
    public function isSale() {
        return $this->type == 'sale';
    }
}
