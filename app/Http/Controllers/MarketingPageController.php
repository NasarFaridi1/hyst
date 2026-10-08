<?php

namespace App\Http\Controllers;

use App\Services\SEOService;
use Illuminate\Http\Request;

class MarketingPageController extends Controller
{
    protected SEOService $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function hystVsDeliveroo(Request $request)
    {
        savePageVisit($request, 'HYST vs Deliveroo');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'HYST vs Deliveroo | Zero Commission Food Delivery',
            'description' => 'Compare HYST vs Deliveroo. Discover why ordering directly through HYST saves money for customers and local restaurants in Hounslow & UK.',
            'path' => 'hyst-vs-deliveroo',
        ]);
        return view('marketing_pages.hyst-vs-deliveroo', compact('seo'));
    }

    public function hystVsJustEat(Request $request)
    {
        savePageVisit($request, 'HYST vs Just Eat');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'HYST vs Just Eat | Transparent Menu Prices in Hounslow',
            'description' => 'Compare HYST vs Just Eat. HYST offers zero commission restaurant ordering with genuine menu prices and direct delivery in Hounslow.',
            'path' => 'hyst-vs-just-eat',
        ]);
        return view('marketing_pages.hyst-vs-just-eat', compact('seo'));
    }

    public function whyFoodIsMoreExpensive(Request $request)
    {
        savePageVisit($request, 'Why Food Is More Expensive');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Why Food Is More Expensive on Food Apps | HYST',
            'description' => 'Learn why food delivery apps mark up menu prices and how HYST protects honest restaurant pricing with zero commission ordering.',
            'path' => 'why-food-is-more-expensive-on-marketplaces',
        ]);
        return view('marketing_pages.why-food-is-more-expensive-on-marketplaces', compact('seo'));
    }

    public function commissionFreeRestaurantOrdering(Request $request)
    {
        savePageVisit($request, 'Commission Free Ordering');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Commission-Free Restaurant Ordering | HYST',
            'description' => 'Commission-free restaurant online ordering platform for UK local restaurants. Keep 100% of your earnings with HYST.',
            'path' => 'commission-free-restaurant-ordering',
        ]);
        return view('marketing_pages.commission-free-restaurant-ordering', compact('seo'));
    }

    public function restaurantOrderingPlatformUk(Request $request)
    {
        savePageVisit($request, 'Restaurant Platform UK');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Direct Restaurant Ordering Platform UK | HYST',
            'description' => 'The leading direct online ordering platform for UK restaurants. Power your restaurant website & delivery without commission.',
            'path' => 'restaurant-ordering-platform-uk',
        ]);
        return view('marketing_pages.restaurant-ordering-platform-uk', compact('seo'));
    }

    public function restaurantMarketingGuide(Request $request)
    {
        savePageVisit($request, 'Restaurant Marketing Guide');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Restaurant Marketing & Direct Ordering Guide | HYST',
            'description' => 'Complete marketing guide for local UK restaurants to boost direct online takeaway orders and customer loyalty.',
            'path' => 'restaurant-marketing-guide',
        ]);
        return view('marketing_pages.restaurant-marketing-guide', compact('seo'));
    }

    public function restaurantLoyaltyProgramme(Request $request)
    {
        savePageVisit($request, 'Restaurant Loyalty');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Restaurant Loyalty Programme & Rewards | HYST',
            'description' => 'Reward repeat customers with built-in restaurant loyalty programs and automated customer offers on HYST.',
            'path' => 'restaurant-loyalty-programme',
        ]);
        return view('marketing_pages.restaurant-loyalty-programme', compact('seo'));
    }

    public function restaurantQrOrdering(Request $request)
    {
        savePageVisit($request, 'QR Ordering');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'QR Code Ordering for Restaurants | HYST',
            'description' => 'Contactless QR code menu ordering for dine-in & takeaway restaurants in Hounslow & London.',
            'path' => 'restaurant-qr-ordering',
        ]);
        return view('marketing_pages.restaurant-qr-ordering', compact('seo'));
    }

    public function directOnlineOrderingForRestaurants(Request $request)
    {
        savePageVisit($request, 'Direct Online Ordering');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Direct Online Ordering for Restaurants | HYST',
            'description' => 'Enable direct customer ordering for your restaurant with zero marketplace commission fees.',
            'path' => 'direct-online-ordering-for-restaurants',
        ]);
        return view('marketing_pages.direct-online-ordering-for-restaurants', compact('seo'));
    }

    public function restaurantPosIntegration(Request $request)
    {
        savePageVisit($request, 'POS Integration');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Restaurant POS & Verifone Integration | HYST',
            'description' => 'Seamless POS system and Verifone terminal integration for UK restaurants using HYST.',
            'path' => 'restaurant-pos-integration',
        ]);
        return view('marketing_pages.restaurant-pos-integration', compact('seo'));
    }

    public function foodOrderingPlatformHounslow(Request $request)
    {
        savePageVisit($request, 'Food Platform Hounslow');
        $seo = $this->seoService->generate('marketing', [
            'title' => 'Food Ordering Platform in Hounslow | HYST',
            'description' => 'Discover local food, takeaways & restaurants in Hounslow TW3. Order directly from local restaurants at true menu prices.',
            'path' => 'food-ordering-platform-hounslow',
        ]);
        return view('marketing_pages.food-ordering-platform-hounslow', compact('seo'));
    }
}