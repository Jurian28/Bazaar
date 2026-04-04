<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const TYPE_USER = 'user';
    const TYPE_SELLER = 'seller';
    const TYPE_COMPANY = 'company';
    const TYPE_ADMIN = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function Company()
    {
        return $this->belongsTo(Company::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }


    public function SaleBids()
    {
        return $this->hasMany(SaleBid::class);
    }


    public function RentalBids()
    {
        return $this->hasMany(RentalBid::class);
    }

    public function OfferBids()
    {
        return $this->hasMany(OfferBid::class);
    }

    public function favorites() {
        return $this->belongsToMany(Advertisement::class, 'favorites');
    }
}
