<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerCopy extends Model
{
    use HasFactory;

    protected $table = 'player_copies';

    protected $fillable = [
        'card_uuid',
        'catalogue_id',
        'original_owner_id',
        'current_owner_id',
        'source_order_id',
        'source_entitlement_id',
        'acquisition_type',
        'is_locked',
        'status',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public function catalogue()
    {
        return $this->belongsTo(PlayerCatalogue::class, 'catalogue_id');
    }

    public function currentOwner()
    {
        return $this->belongsTo(User::class, 'current_owner_id');
    }

    public function originalOwner()
    {
        return $this->belongsTo(User::class, 'original_owner_id');
    }

    public function sourceOrder()
    {
        return $this->belongsTo(Order::class, 'source_order_id');
    }

    public function transfers()
    {
        return $this->hasMany(PlayerTransfer::class, 'player_copy_id');
    }

    public function activeShares()
    {
        return $this->hasMany(PlayerAccessShare::class, 'player_copy_id')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function teamSelections()
    {
        return $this->hasMany(TeamPlayerSelection::class, 'player_copy_id');
    }
}
