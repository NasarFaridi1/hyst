<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketingPageController extends Controller
{
    public function hystVsDeliveroo()
    {
        return view('marketing_pages.hyst-vs-deliveroo');
    }

    public function hystVsJustEat()
    {
        return view('marketing_pages.hyst-vs-just-eat');
    }

    public function whyFoodIsMoreExpensive()
    {
        return view('marketing_pages.why-food-is-more-expensive-on-marketplaces');
    }

    public function commissionFreeRestaurantOrdering()
    {
        return view('marketing_pages.commission-free-restaurant-ordering');
    }

    public function restaurantOrderingPlatformUk()
    {
        return view('marketing_pages.restaurant-ordering-platform-uk');
    }

    public function restaurantMarketingGuide()
    {
        return view('marketing_pages.restaurant-marketing-guide');
    }

    public function restaurantLoyaltyProgramme()
    {
        return view('marketing_pages.restaurant-loyalty-programme');
    }

    public function restaurantQrOrdering()
    {
        return view('marketing_pages.restaurant-qr-ordering');
    }

    public function directOnlineOrderingForRestaurants()
    {
        return view('marketing_pages.direct-online-ordering-for-restaurants');
    }

    public function restaurantPosIntegration()
    {
        return view('marketing_pages.restaurant-pos-integration');
    }
}