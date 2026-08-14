<?php

use App\Models\PageVisit;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

if (!function_exists('isValidPublicIp')) {
    function isValidPublicIp($ip)
    {
        if (!$ip || !is_string($ip)) {
            return false;
        }

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }
}

if (!function_exists('savePageVisit')) {

    function savePageVisit($request, $page, $restaurantId = null, $restaurantName = null, $orderId = null, $productId = null)
    {
        try {
            $ip = $request->ip();
            $data = [];

            if (isValidPublicIp($ip)) {
                $sessionGeoKey = 'ip_geo_' . md5($ip);
                if (session()->has($sessionGeoKey)) {
                    $data = session()->get($sessionGeoKey, []);
                } else {
                    try {
                        $response = Http::timeout(0.3)->get("http://ip-api.com/json/" . $ip);
                        if ($response->successful()) {
                            $data = $response->json() ?? [];
                            session()->put($sessionGeoKey, $data);
                        }
                    } catch (\Throwable $e) {
                        // ignore API timeout so user request never hangs!
                    }
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