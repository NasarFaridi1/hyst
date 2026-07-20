<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingBanner extends Model
{
    use HasFactory;

    protected $table = 'marketing_banners';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'banner_image',
        'status',
        'category_id',
        'email',
        'phone'
    ];

    

    public function category()
    {
        return $this->belongsTo(
            MarketingBannerCategory::class,
            'category_id'
        );
    }
}