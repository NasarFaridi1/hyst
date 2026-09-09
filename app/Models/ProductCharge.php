<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCharge extends Model
{
    use HasFactory;

    protected $table = 'product_charges';

    protected $fillable = [
        'title',
        'percentage',
        'is_active',
    ];

    protected $casts = [
        'percentage' => 'float',
        'is_active'  => 'boolean',
    ];

    /**
     * Get the currently active additional charge percentage.
     */
    public static function getActivePercentage(): float
    {
        $activeCharge = static::where('is_active', 1)->first();

        return $activeCharge ? (float) $activeCharge->percentage : 0.0;
    }
}
