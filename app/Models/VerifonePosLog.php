<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifonePosLog extends Model
{
    protected $table = 'verifone_pos_logs';

    protected $fillable = [
        'restaurant_id',
        'order_id',
        'payment_id',
        'action',
        'service_id',
        'poi_transaction_id',
        'endpoint_url',
        'http_method',
        'http_status_code',
        'request_headers',
        'request_payload',
        'response_payload',
        'status',
        'error_message',
        'execution_time_ms',
        'ip_address',
    ];

    protected $casts = [
        'request_headers'  => 'array',
        'request_payload'  => 'array',
        'response_payload' => 'array',
        'execution_time_ms'=> 'float',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
