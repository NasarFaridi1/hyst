<?php

use App\Models\PageVisit;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

if (!function_exists('savePageVisit')) {

    function savePageVisit($request, $page, $restaurantId = null, $restaurantName = null, $orderId = null, $productId = null)
    {
        try {
            $ip = $request->ip();
            $data = [];

            if ($ip && $ip !== '127.0.0.1' && $ip !== '::1' && !str_starts_with($ip, '192.168.')) {
                $response = Http::timeout(1)->get("http://ip-api.com/json/" . $ip);
                if ($response->successful()) {
                    $data = $response->json() ?? [];
                }
            }

            $agent = new Agent();

            PageVisit::create([
                'user_id'       => Auth::id(),
                'restaurant_id' => $restaurantId,
                'restaurant_name' => $restaurantName,
                'order_id'      => $orderId,
                'product_id'    => $productId,
                'page_name'     => $page,
                'page_url'      => $request->fullUrl(),
                'ip_address'    => $ip,
                'city'          => $data['city'] ?? '',
                'state'         => $data['regionName'] ?? '',
                'country'       => $data['country'] ?? '',
                'latitude'      => $data['lat'] ?? null,
                'longitude'     => $data['lon'] ?? null,
                'browser'       => $agent->browser(),
                'platform'      => $agent->platform(),
                'user_agent'    => $request->userAgent(),
                'session_id'    => session()->getId(),
            ]);
        } catch (\Throwable $e) {
            \Log::warning('savePageVisit error: ' . $e->getMessage());
        }
    }
}