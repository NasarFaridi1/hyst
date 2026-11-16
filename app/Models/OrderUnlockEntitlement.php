<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUnlockEntitlement extends Model
{
    use HasFactory;

    protected $table = 'order_unlock_entitlements';

    protected $fillable = [
        'order_id',
        'user_id',
        'campaign_id',
        'total_choices',
        'choices_remaining',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'total_choices' => 'integer',
        'choices_remaining' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function campaign()
    {
        return $this->belongsTo(MatchdayCampaign::class, 'campaign_id');
    }

    public function history()
    {
        return $this->hasMany(PlayerUnlockHistory::class, 'entitlement_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'pending')
            ->where('choices_remaining', '>', 0)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }
}
