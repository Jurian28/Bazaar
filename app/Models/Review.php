<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'user_sender_id',
        'advertisement_id',
        'rating',
        'comment'
    ];

    public function advertisement(){
        return $this->belongsTo(Advertisement::class);
    }


    public function sender(){
        return $this->belongsTo(User::class, 'user_sender_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
