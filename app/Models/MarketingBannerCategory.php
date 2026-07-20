<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingBannerCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function banners()
    {
        return $this->hasMany(MarketingBanner::class, 'category_id');
    }
}