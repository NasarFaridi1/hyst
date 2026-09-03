<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UberWebhookLog extends Model
{
    use HasFactory;

    protected $table = 'uber_webhook_logs';

    protected $fillable = [
        'order_id',
        'delivery_id',
        'external_order_id',
        'event_type',
        'status',
        'payload',
        'headers',
        'signature_valid',
        'ip_address',
        'received_at'
    ];

    protected $casts = [
        'payload'         => 'array',
        'headers'         => 'array',
        'signature_valid' => 'boolean',
        'received_at'      => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
