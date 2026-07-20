<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [

        'user_id',
        'type',
        'title',
        'message',
        'reference_type',
        'reference_id',
        'is_read',
        'order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}