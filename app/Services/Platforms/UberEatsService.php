<?php

namespace App\Services\Platforms;

use App\Models\UberApiLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UberEatsService
{
    /**
     * Recursively sanitize sensitive keys in array payload for security
     */
    protected function sanitizeData($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $sensitiveKeys = [
            'client_secret',
            'access_token',
            'refresh_token',
            'signing_key',
            'password',
            'secret',
            'token',
            'api_key',
        ];

        foreach ($data as $key => $value) {
            $keyLower = strtolower((string) $key);

            if (in_array($keyLower, $sensitiveKeys)) {
                $data[$key] = '***MASKED***';
            } elseif (is_array($value)) {
                $data[$key] = $this->sanitizeData($value);
            }
        }

        return $data;
    }

    /**
     * Log Uber Eats API calls to Database safely with sensitive data masking
     */
    public function recordLog(array $data): void
    {
        try {
            $requestPayload = isset($data['request_payload']) ? $this->sanitizeData($data['request_payload']) : null;
            $responsePayload = isset($data['response_payload']) ? $this->sanitizeData($data['response_payload']) : null;

            $headers = $data['request_headers'] ?? [];
            $sanitizedHeaders = [];
            foreach ($headers as $key => $value) {
                $headerStr = is_numeric($key) ? $value : "{$key}: {$value}";
                if (str_contains(strtolower($headerStr), 'authorization')) {
                    $sanitizedHeaders[] = 'Authorization: Bearer ***MASKED***';
                } else {
                    $sanitizedHeaders[] = $headerStr;
                }
            }

            if (is_string($responsePayload)) {
                $decoded = json_decode($responsePayload, true);
                $responsePayload = ($decoded !== null) ? $this->sanitizeData($decoded) : ['raw' => $responsePayload];
            }

            UberApiLog::create([
                'restaurant_id'     => $data['restaurant_id'] ?? null,
                'order_id'          => $data['order_id'] ?? null,
                'delivery_id'       => $data['delivery_id'] ?? null,
                'action'            => $data['action'],
                'endpoint_url'      => $data['endpoint_url'],
                'http_method'       => $data['http_method'] ?? 'POST',
                'http_status_code'  => $data['http_status_code'] ?? null,
                'request_headers'   => $sanitizedHeaders,
                'request_payload'   => $requestPayload,
                'response_payload'  => $responsePayload,
                'error_message'     => $data['error_message'] ?? null,
                'ip_address'        => request()->ip(),
                'execution_time_ms' => $data['execution_time_ms'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Uber Eats Audit Log Save Error: ' . $e->getMessage());
        }
    }

    /**
     * Get OAuth token for Uber Eats Marketplace API
     */
    public function token($credentials)
    {
        $clientId = $credentials->client_id ?? config('services.uber.client_id');
        $clientSecret = $credentials->client_secret ?? config('services.uber.client_secret');
        $url = 'https://auth.uber.com/oauth/v2/token';
        $startTime = microtime(true);

        $payload = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'grant_type'    => 'client_credentials',
            'scope'         => 'eats.order eats.store eats.store.status',
        ];

        $response = Http::asForm()->post($url, $payload);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'action'            => 'EATS_OAUTH_TOKEN',
            'endpoint_url'      => $url,
            'http_method'       => 'POST',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Content-Type: application/x-www-form-urlencoded'],
            'request_payload'   => $payload,
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('Uber Eats Token Failed: ' . $response->body()) : null,
            'execution_time_ms' => $executionTimeMs,
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
        $startTime = microtime(true);

        $response = Http::withToken($token)->get($url);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'action'            => 'FETCH_ACTIVE_ORDERS',
            'endpoint_url'      => $url,
            'http_method'       => 'GET',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Authorization: Bearer ' . $token],
            'request_payload'   => ['store_id' => $credentials->store_id],
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('HTTP ' . $response->status()) : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

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
     * Accept POS Order (Uber Eats)
     */
    public function acceptOrder($order, $credentials)
    {
        $token   = $this->token($credentials);
        $orderId = $this->getOrderId($order);

        if (!$token || empty($orderId)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$orderId}/accept_pos_order";
        $startTime = microtime(true);
        $payload = ['reason' => 'ACCEPTED_BY_RESTAURANT'];

        $response = Http::withToken($token)->post($url, $payload);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'order_id'          => is_numeric($orderId) ? (int) $orderId : null,
            'action'            => 'ACCEPT_POS_ORDER',
            'endpoint_url'      => $url,
            'http_method'       => 'POST',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Authorization: Bearer ' . $token],
            'request_payload'   => $payload,
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('HTTP ' . $response->status()) : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        Log::info('Uber Eats Accept Order Response', ['status' => $response->status(), 'body' => $responseData]);

        return $response->successful();
    }

    /**
     * Deny / Reject POS Order (Uber Eats)
     */
    public function denyOrder($order, $reason, $credentials)
    {
        $token   = $this->token($credentials);
        $orderId = $this->getOrderId($order);

        if (!$token || empty($orderId)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$orderId}/deny_pos_order";
        $startTime = microtime(true);
        $payload = [
            'reason' => [
                'explanation' => $reason ?: 'ITEM_OUT_OF_STOCK'
            ]
        ];

        $response = Http::withToken($token)->post($url, $payload);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'order_id'          => is_numeric($orderId) ? (int) $orderId : null,
            'action'            => 'DENY_POS_ORDER',
            'endpoint_url'      => $url,
            'http_method'       => 'POST',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Authorization: Bearer ' . $token],
            'request_payload'   => $payload,
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('HTTP ' . $response->status()) : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        return $response->successful();
    }

    /**
     * Mark Order Ready for Pickup (Uber Eats)
     */
    public function markReadyForPickup($order, $credentials)
    {
        $token   = $this->token($credentials);
        $orderId = $this->getOrderId($order);

        if (!$token || empty($orderId)) {
            return false;
        }

        $url = "https://api.uber.com/v1/eats/orders/{$orderId}/ready_for_pickup";
        $startTime = microtime(true);

        $response = Http::withToken($token)->post($url);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'order_id'          => is_numeric($orderId) ? (int) $orderId : null,
            'action'            => 'READY_FOR_PICKUP',
            'endpoint_url'      => $url,
            'http_method'       => 'POST',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Authorization: Bearer ' . $token],
            'request_payload'   => [],
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('HTTP ' . $response->status()) : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

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
        $startTime = microtime(true);
        $payload = [
            'status' => strtoupper($status) === 'PAUSED' ? 'PAUSED' : 'ONLINE'
        ];

        $response = Http::withToken($token)->post($url, $payload);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $responseData = $response->json();

        $this->recordLog([
            'restaurant_id'     => $credentials->restaurant_id ?? null,
            'action'            => 'UPDATE_STORE_STATUS',
            'endpoint_url'      => $url,
            'http_method'       => 'POST',
            'http_status_code'  => $response->status(),
            'request_headers'   => ['Authorization: Bearer ' . $token],
            'request_payload'   => $payload,
            'response_payload'  => $responseData,
            'error_message'     => $response->failed() ? ('HTTP ' . $response->status()) : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        return $response->successful();
    }
}
