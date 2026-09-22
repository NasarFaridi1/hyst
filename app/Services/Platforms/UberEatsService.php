<?php

namespace App\Services\Platforms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UberEatsService
{
    /**
     * Get OAuth token for Uber Eats Marketplace API
     */
    public function token($credentials)
    {
        $clientId = $credentials->client_id ?? config('services.uber.client_id');
        $clientSecret = $credentials->client_secret ?? config('services.uber.client_secret');

        $response = Http::asForm()->post('https://auth.uber.com/oauth/v2/token', [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'grant_type'    => 'client_credentials',
            'scope'         => 'eats.order eats.store eats.store.status',
        ]);

        if ($response->failed()) {
            Log::error('Uber Eats Token Failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json('access_token');
    }

    /**
     * Fetch Live Active Orders from Uber Eats API (Live Proxy Mode)
     */
    public function fetchActiveOrders($credentials)
    {
        if (empty($credentials) || !$credentials->is_enabled || empty($credentials->store_id)) {
            return [];
        }

        $token = $this->token($credentials);
        if (!$token) {
            return [];
        }

        $url = "https://api.uber.com/v1/eats/stores/{$credentials->store_id}/created-orders";
        $response = Http::withToken($token)->get($url);

        if ($response->successful()) {
            return $response->json('orders', []);
        }

        return [];
    }

    /**
     * Accept POS Order (Uber Eats)
     */
    public function acceptOrder($order, $credentials)
    {
        $token = $this->token($credentials);
        if (!$token || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$order->platform_order_id}/accept_pos_order";
        $response = Http::withToken($token)->post($url, [
            'reason' => 'ACCEPTED_BY_RESTAURANT'
        ]);

        Log::info('Uber Eats Accept Order Response', ['status' => $response->status(), 'body' => $response->json()]);

        return $response->successful();
    }

    /**
     * Deny / Reject POS Order (Uber Eats)
     */
    public function denyOrder($order, $reason, $credentials)
    {
        $token = $this->token($credentials);
        if (!$token || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$order->platform_order_id}/deny_pos_order";
        $response = Http::withToken($token)->post($url, [
            'reason' => [
                'explanation' => $reason ?: 'ITEM_OUT_OF_STOCK'
            ]
        ]);

        return $response->successful();
    }

    /**
     * Mark Order Ready for Pickup (Uber Eats)
     */
    public function markReadyForPickup($order, $credentials)
    {
        $token = $this->token($credentials);
        if (!$token || empty($order->platform_order_id)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$order->platform_order_id}/ready_for_pickup";
        $response = Http::withToken($token)->post($url);

        return $response->successful();
    }

    /**
     * Toggle Store Status (Open / Paused) (Uber Eats)
     */
    public function updateStoreStatus($storeId, $status, $credentials)
    {
        $token = $this->token($credentials);
        if (!$token || empty($storeId)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/stores/{$storeId}/status";
        $response = Http::withToken($token)->post($url, [
            'status' => strtoupper($status) === 'PAUSED' ? 'PAUSED' : 'ONLINE'
        ]);

        return $response->successful();
    }
}
