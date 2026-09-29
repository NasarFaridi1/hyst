<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorldpayPaymentLog extends Model
{
    protected $table = 'worldpay_payment_logs';

    protected $fillable = [
        'restaurant_id',
        'payment_id',
        'order_id',
        'reference',
        'action',
        'endpoint_url',
        'http_method',
        'http_status_code',
        'request_headers',
        'request_payload',
        'response_payload',
        'error_message',
        'ip_address',
        'execution_time_ms',
    ];

    protected $casts = [
        'request_headers'  => 'array',
        'request_payload'  => 'array',
        'response_payload' => 'array',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
