<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [

        'order_id',
        'restaurant_id',
        'user_id',
        'payment_method',
        'transaction_id',
        'amount',
        'payment_status',
        'refunded_amount',
        'refund_reason',
        'checkout_data',
        'payment_transaction_id',
        'secondary_transaction_id',
        'payment_type'

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

public function restaurant()
{
    return $this->belongsTo(Restaurant::class);
}
}