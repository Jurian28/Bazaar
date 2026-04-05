<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'company_id',
        'path',
        'signed_at'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
