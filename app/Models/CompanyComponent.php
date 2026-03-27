<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyComponent extends Model
{
    protected $fillable = [
        'company_id',
        'type',
        'data',
        'order'
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
