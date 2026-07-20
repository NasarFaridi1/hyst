<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyRewardLog extends Model
{
    use HasFactory;

    protected $fillable = [

        'restaurant_id',

        'user_id',

        'reward_type',

        'festival_name',

        'subject',

        'message',

        'offers',

        'status',

        'error_message',

        'sent_at',

    ];


    protected $casts = [

        'offers' => 'array',

        'sent_at' => 'datetime',

    ];


    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    public function restaurant()
    {
        return $this->belongsTo(
            Restaurant::class
        );
    }
}