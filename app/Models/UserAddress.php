<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'label',
        'building_type',
        'address',
        'landmark',
        'city',
        'state',
        'country',
        'postcode',
        'latitude',
        'longitude',
        'flat_number',
        'floor',
        'building_name',
        'entrance',
        'instructions',
        'is_default',
    ];

    protected $casts = [
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',
        'is_default' => 'boolean',
    ];

    /**
     * Address belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}