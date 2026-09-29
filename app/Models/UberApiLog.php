<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UberApiLog extends Model
{
    protected $table = 'uber_api_logs';

    protected $fillable = [
        'restaurant_id',
        'order_id',
        'delivery_id',
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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
