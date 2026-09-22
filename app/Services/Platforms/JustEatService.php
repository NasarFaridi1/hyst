<?php

namespace App\Services\Platforms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JustEatService
{
    /**
     * Fetch Live Active Orders from Just Eat API (Live Proxy Mode)
     */
    public function fetchActiveOrders($credentials)
    {
        if (empty($credentials) || !$credentials->is_enabled || empty($credentials->client_secret)) {
            return [];
        }

        $url = "https://connect.just-eat.com/restaurants/{$credentials->store_id}/orders";
        $response = Http::withToken($credentials->client_secret)->get($url);

        if ($response->successful()) {
            return $response->json('orders', []);
        }

        return [];
    }
    /**
     * Helper to extract order ID from string, object, or array
     */
    protected function getOrderId($order)
    {
        if (is_string($order)) return $order;
        if (is_object($order)) return $order->platform_order_id ?? $order->id ?? null;
        if (is_array($order)) return $order['id'] ?? $order['platform_order_id'] ?? null;
        return null;
    }

    /**
     * Accept Just Eat Order
     */
    public function acceptOrder($order, $prepTimeMinutes, $credentials)
    {
        $token   = $credentials->client_secret ?? null;
        $orderId = $this->getOrderId($order);

        if (empty($token) || empty($orderId)) {
            return false;
        }

        $url = "https://connect.just-eat.com/orders/{$orderId}/accept";
        $response = Http::withToken($token)->post($url, [
            'estimated_prep_time' => (int) ($prepTimeMinutes ?: 15)
        ]);

        Log::info('Just Eat Accept Order Response', ['status' => $response->status(), 'body' => $response->json()]);

        return $response->successful();
    }

    /**
     * Mark Order Ready for Collection (Just Eat)
     */
    public function markReady($order, $credentials)
    {
        $token   = $credentials->client_secret ?? null;
        $orderId = $this->getOrderId($order);

        if (empty($token) || empty($orderId)) {
            return false;
        }

        $url = "https://connect.just-eat.com/orders/{$orderId}/ready";
        $response = Http::withToken($token)->post($url);

        return $response->successful();
    }

    /**
     * Reject Just Eat Order
     */
    public function rejectOrder($order, $reason, $credentials)
    {
        $token   = $credentials->client_secret ?? null;
        $orderId = $this->getOrderId($order);

        if (empty($token) || empty($orderId)) {
            return false;
        }

        $url = "https://connect.just-eat.com/orders/{$orderId}/reject";
        $response = Http::withToken($token)->post($url, [
            'reason' => $reason ?: 'RESTAURANT_BUSY'
        ]);

        return $response->successful();
    }

    /**
     * Update Store Status (Just Eat)
     */
    public function updateStoreStatus($storeId, $status, $credentials)
    {
        $token = $credentials->client_secret;
        if (empty($token) || empty($storeId)) {
            return false;
        }

        $url = "https://connect.just-eat.com/restaurants/{$storeId}/status";
        $response = Http::withToken($token)->post($url, [
            'status' => strtoupper($status) === 'PAUSED' ? 'PAUSED' : 'OPEN'
        ]);

        return $response->successful();
    }
}
