<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'restaurant_id',
        'total_amount',
        'order_type',

        'address',
        'phone',
        'pincode',

        'payment_method',
        'status',
        'stuart_job_id',
        'tracking_url',
        'delivery_status',
        'driver_name',
        'driver_phone',
        'driver_id',
        'picked_at',
        'delivered_at',
        'service_charge',
        'delivery_charge',
        'hyst_charge',
        'cancel_reason',
        'cancelled_by',

        'delivery_provider',


        'uber_delivery_id',
        'uber_quote_id',
        'uber_tracking_url',
        'uber_delivery_status',
        'uber_driver_name',
        'uber_driver_phone',
        'uber_driver_id',
        'uber_picked_at',
        'uber_delivered_at',
        'uber_vehicle_type',
        'uber_vehicle_make',
        'uber_vehicle_model',
        'uber_vehicle_plate',
        'uber_driver_lat',
        'uber_driver_lng',
        'courier_imminent',

        // Guest Order
        'is_guest',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
        'guest_postcode',
        'guest_city',
        'guest_country',
        'guest_state',
        'guest_latitude',
        'guest_longitude',
        'coupon_id',
        'coupon_discount',
        'gift_card_id',
        'gift_card_code',
        'gift_card_amount',

        'is_scheduled',
        'scheduled_for',
        'preparation_minutes',
        'description'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function review()
    {
        return $this->hasOne(\App\Models\Review::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class);
    }
    // Order.php
public function complaints()
{
    return $this->hasMany(Complaint::class);
}
}