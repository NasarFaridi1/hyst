<?php

namespace App\Services\Platforms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeliverooService
{
    /**
     * Fetch Live Active Orders from Deliveroo API (Live Proxy Mode)
     */
    public function fetchActiveOrders($credentials)
    {
        if (empty($credentials) || !$credentials->is_enabled || empty($credentials->client_secret)) {
            return [];
        }

        $url = "https://api.deliveroo.com/order/v1/sites/{$credentials->store_id}/orders";
        $response = Http::withToken($credentials->client_secret)->get($url);

        if ($response->successful()) {
            return $response->json('orders', []);
        }

        return [];
    }
    /**
     * Confirm / Accept Deliveroo Order
     */
    public function acceptOrder($order, $prepTimeMinutes, $credentials)
    {
        $siteId = $credentials->store_id;
        $token  = $credentials->client_secret;

        if (empty($token) || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.deliveroo.com/order/v1/orders/{$order->platform_order_id}/confirm";
        $response = Http::withToken($token)->post($url, [
            'prep_time' => (int) ($prepTimeMinutes ?: $credentials->prep_time_minutes ?: 15)
        ]);

        Log::info('Deliveroo Accept Order Response', ['status' => $response->status(), 'body' => $response->json()]);

        return $response->successful();
    }

    /**
     * Mark Order Prepared (Deliveroo)
     */
    public function markPrepared($order, $credentials)
    {
        $token = $credentials->client_secret;
        if (empty($token) || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.deliveroo.com/order/v1/orders/{$order->platform_order_id}/mark_prepared";
        $response = Http::withToken($token)->post($url);

        return $response->successful();
    }

    /**
     * Reject Deliveroo Order
     */
    public function rejectOrder($order, $reason, $credentials)
    {
        $token = $credentials->client_secret;
        if (empty($token) || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.deliveroo.com/order/v1/orders/{$order->platform_order_id}/reject";
        $response = Http::withToken($token)->post($url, [
            'reason' => $reason ?: 'KITCHEN_TOO_BUSY'
        ]);

        return $response->successful();
    }

    /**
     * Update Site Open/Pause Status (Deliveroo Site API)
     */
    public function updateSiteStatus($siteId, $status, $credentials)
    {
        $token = $credentials->client_secret;
        if (empty($token) || empty($siteId)) {
            return false;
        }

        $url = "https://api.deliveroo.com/site/v1/sites/{$siteId}/status";
        $response = Http::withToken($token)->post($url, [
            'status' => strtoupper($status) === 'PAUSED' ? 'PAUSED' : 'OPEN'
        ]);

        return $response->successful();
    }
}
