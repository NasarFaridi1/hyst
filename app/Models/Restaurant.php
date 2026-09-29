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
        'opening_hours',

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
        'opening_hours' => 'array',
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

        $now = \Carbon\Carbon::now('Europe/London');
        $today = $now->format('l');

        // Check per-day opening_hours JSON if present and non-empty
        if (!empty($this->opening_hours) && is_array($this->opening_hours)) {
            $todayConfig = $this->opening_hours[$today] ?? null;
            if (!$todayConfig || empty($todayConfig['enabled'])) {
                return false;
            }

            $openTime = $todayConfig['open'] ?? null;
            $closeTime = $todayConfig['close'] ?? null;

            if (empty($openTime) || empty($closeTime)) {
                return false;
            }

            try {
                $open = \Carbon\Carbon::parse($openTime, 'Europe/London');
                $close = \Carbon\Carbon::parse($closeTime, 'Europe/London');

                if ($close->lessThan($open)) {
                    $close->addDay();
                }

                return $now->between($open, $close);
            } catch (\Exception $e) {
                return true;
            }
        }

        // Fallback to legacy single schedule fields
        if (empty($this->working_days) || empty($this->opening_time) || empty($this->closing_time)) {
            return true;
        }

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

    public function getTodayOpeningTimeAttribute()
    {
        $today = \Carbon\Carbon::now('Europe/London')->format('l');
        if (!empty($this->opening_hours) && is_array($this->opening_hours)) {
            $todayConfig = $this->opening_hours[$today] ?? null;
            if ($todayConfig && !empty($todayConfig['enabled']) && !empty($todayConfig['open'])) {
                return \Carbon\Carbon::parse($todayConfig['open'])->format('h:i A');
            }
            return null;
        }
        return $this->opening_time ? \Carbon\Carbon::parse($this->opening_time)->format('h:i A') : null;
    }

    public function getTodayClosingTimeAttribute()
    {
        $today = \Carbon\Carbon::now('Europe/London')->format('l');
        if (!empty($this->opening_hours) && is_array($this->opening_hours)) {
            $todayConfig = $this->opening_hours[$today] ?? null;
            if ($todayConfig && !empty($todayConfig['enabled']) && !empty($todayConfig['close'])) {
                return \Carbon\Carbon::parse($todayConfig['close'])->format('h:i A');
            }
            return null;
        }
        return $this->closing_time ? \Carbon\Carbon::parse($this->closing_time)->format('h:i A') : null;
    }

    public function getTodayHoursTextAttribute()
    {
        $today = \Carbon\Carbon::now('Europe/London')->format('l');
        if (!empty($this->opening_hours) && is_array($this->opening_hours)) {
            $todayConfig = $this->opening_hours[$today] ?? null;
            if (!$todayConfig || empty($todayConfig['enabled'])) {
                return 'Closed Today';
            }
            $open = !empty($todayConfig['open']) ? \Carbon\Carbon::parse($todayConfig['open'])->format('h:i A') : '--';
            $close = !empty($todayConfig['close']) ? \Carbon\Carbon::parse($todayConfig['close'])->format('h:i A') : '--';
            return $open . ' - ' . $close;
        }

        $workingDays = $this->working_days ? array_map('trim', explode(',', $this->working_days)) : [];
        if (!in_array($today, $workingDays)) {
            return 'Closed Today';
        }
        $open = $this->opening_time ? \Carbon\Carbon::parse($this->opening_time)->format('h:i A') : '--';
        $close = $this->closing_time ? \Carbon\Carbon::parse($this->closing_time)->format('h:i A') : '--';
        return $open . ' - ' . $close;
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

    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }
}