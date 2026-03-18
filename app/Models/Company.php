<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'primary_color',
        'secondary_color',
        'logo_url',
        'font_family',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function getBySlug($slug) {
        if (!$slug) {
            return Company::find(1); // default company
        }
        return Company::where('slug', $slug)->firstOrFail();
    }
}
