<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id',
        'invoice_number',
        'restaurant_id',
        'user_id',
        'subtotal',
        'discount',
        'total',
        'invoice_date',
        'service_charge',
        'delivery_charge',
        'hyst_charge'
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}