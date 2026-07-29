<?php

namespace App\Http\Controllers;

class MarketingPageController extends Controller
{
    public function show($slug)
    {
        $pages = [
            'commission-free-restaurant-ordering'      => 'commission-free-restaurant-ordering',
            'direct-online-ordering-for-restaurants'   => 'direct-online-ordering-for-restaurants',
            'hyst-vs-deliveroo'                        => 'hyst-vs-deliveroo',
            'hyst-vs-just-eat'                         => 'hyst-vs-just-eat',
            'restaurant-loyalty-programme'             => 'restaurant-loyalty-programme',
            'restaurant-marketing-guide'               => 'restaurant-marketing-guide',
            'restaurant-ordering-platform-uk'          => 'restaurant-ordering-platform-uk',
            'restaurant-pos-integration'               => 'restaurant-pos-integration',
            'restaurant-qr-ordering'                   => 'restaurant-qr-ordering',
            'why-food-is-more-expensive-on-marketplaces' => 'why-food-is-more-expensive-on-marketplaces',
        ];

        if (!isset($pages[$slug])) {
            abort(404);
        }

        return view('marketing_pages.' . $pages[$slug] . '.dc');
    }
}