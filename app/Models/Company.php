<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'primary_color',
        'secondary_color',
        'logo_url',
        'font_family',
    ];

    public function components() {
        return $this->hasMany(CompanyComponent::class);
    }


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public static function getBySlug($slug) {
        if (!$slug) {
            return self::getDefaultCompany();
        }
        return Company::where('slug', $slug)->firstOrFail();
    }

    public static function getDefaultCompany() {
        return Company::find(1);
    }
}
