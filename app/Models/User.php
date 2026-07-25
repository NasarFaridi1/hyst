<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'restaurant_id',
        'phone',
        'image',
        'fcm_token',
        'api_token',
        'phone_hash',
        'email_hash',
        'email_verified',
        'email_verified_at',
        'email_otp',
        'otp_expire_at',
        'email_verify_token',
        'address',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'postcode',
        'provider',      
        'provider_id',   

        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email' => 'encrypted',
        'phone' => 'encrypted',
		    'email_verified_at' => 'datetime',

    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function ambassadorRestaurants()
    {
        return $this->hasMany(Restaurant::class,'ambassador_id');
    }

    public function ambassadorCategories()
    {
        return $this->hasMany(Category::class,'ambassador_id');
    }

    public function ambassadorProducts()
    {
        return $this->hasMany(Product::class,'ambassador_id');
    }

    protected static function booted()
    {
        static::saving(function ($user) {

            if (!empty($user->email)) {

                $user->email_hash = hash(
                    'sha256',
                    strtolower(trim($user->email))
                );
            }

            if (!empty($user->phone)) {

                $user->phone_hash = hash(
                    'sha256',
                    trim($user->phone)
                );
            }
        });
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)
            ->latest();
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function giftCardTransactions()
    {
        return $this->hasMany(GiftCardTransaction::class);
    }
    
}