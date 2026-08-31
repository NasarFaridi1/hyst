<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
  'ambassador_id',
        'name',
        'email',
        'slug',
        'phone',
        'location',
        'latitude',
        'longitude',
        'description',
        'image',
        'category_ids',
        'status',
        'dine_in',
        'table_book',
        'notification_sound',
        'home_delivery',
        'transactworld_member_id',
        'transactworld_account_id',
        'transactworld_terminal_id',
        'transactworld_checksum_key',
        'transactworld_mode',
        'favorite_count',

        // Hygiene fields
        'hygiene_rating',
        'hygiene_certificate',

        'working_days',
        'opening_time',
        'closing_time',

        'restaurant_status',

        'takeaway',
        'display_order',

        'address',
        'city',
        'state',
        'country',
        'postcode',

        'worldpay_business_id',

        'worldpay_username',

        'worldpay_password',
        'uber_organization_id',
        'self_delivery',
        'allow_asap',
        'allow_schedule',
        'dietary_categories',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'dietary_categories' => 'array',
        'allow_asap' => 'boolean',
        'allow_schedule' => 'boolean',
    ];

    protected $appends = [
        'is_open',
    ];

    public function getIsOpenAttribute()
    {
        // 1. If Super Admin disabled the restaurant (status == 0), it is closed
        if (isset($this->status) && (int)$this->status === 0) {
            return false;
        }

        // 2. If Restaurant Admin explicitly set store status to 'Closed'
        if ($this->restaurant_status === 'Closed') {
            return false;
        }

        if ($this->restaurant_status === 'Open') {
            return true;
        }

        if (empty($this->working_days) || empty($this->opening_time) || empty($this->closing_time)) {
            return true;
        }

        $now = \Carbon\Carbon::now('Europe/London');
        $today = $now->format('l');

        $workingDays = array_map('trim', explode(',', $this->working_days));

        if (!in_array($today, $workingDays)) {
            return false;
        }

        try {
            $open = \Carbon\Carbon::parse($this->opening_time, 'Europe/London');
            $close = \Carbon\Carbon::parse($this->closing_time, 'Europe/London');

            if ($close->lessThan($open)) {
                $close->addDay();
            }

            return $now->between($open, $close);
        } catch (\Exception $e) {
            return true;
        }
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function banners()
    {
        return $this->hasMany(RestaurantBanner::class, 'restaurant_id', 'id');
    }

    public function ambassador()
    {
        return $this->belongsTo(User::class,'ambassador_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getQrUrlAttribute()
    {
        return route('restaurant.products', $this->slug);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function featuredOffer()
    {
        return $this->hasOne(Offer::class)
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->latest();
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function deliveryCharges()
    {
        return $this->hasMany(RestaurantDeliveryCharge::class)
                    ->orderBy('from_distance');
    }

    public function loyaltyRule()
    {
        return $this->hasOne(LoyaltyRule::class);
    }

    public function loyaltyRewards()
    {
        return $this->hasMany(LoyaltyReward::class);
    }
}