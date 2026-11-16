<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchdayCampaign extends Model
{
    use HasFactory;

    protected $table = 'matchday_campaigns';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'min_order_amount',
        'choices_per_order',
        'entitlement_expiry_days',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'min_order_amount' => 'decimal:2',
        'choices_per_order' => 'integer',
        'entitlement_expiry_days' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function entitlements()
    {
        return $this->hasMany(OrderUnlockEntitlement::class, 'campaign_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}
