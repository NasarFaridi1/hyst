<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\WorldpayPaymentLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WorldpayService
{
    /**
     * Get Authentication URL based on environment config
     */
    protected function getAuthUrl(): string
    {
        return config('services.worldpay.auth_url', 'https://sandbox.auth.paymentsapi.io');
    }

    /**
     * Get REST API URL based on environment config
     */
    protected function getApiUrl(): string
    {
        return config('services.worldpay.api_url', 'https://sandbox.rest.paymentsapi.io');
    }

    /**
     * Record API Call Log into Database for Audit Trail
     */
    public function recordLog(array $data): void
    {
        try {
            $requestPayload = $data['request_payload'] ?? null;
            if (is_array($requestPayload)) {
                if (isset($requestPayload['Password'])) {
                    $requestPayload['Password'] = '******';
                }
                if (isset($requestPayload['Username'])) {
                    $requestPayload['Username'] = substr($requestPayload['Username'], 0, 3) . '***';
                }
            }

            $headers = $data['request_headers'] ?? [];
            $sanitizedHeaders = [];
            foreach ($headers as $header) {
                if (is_string($header) && str_contains(strtolower($header), 'authorization')) {
                    $sanitizedHeaders[] = 'Authorization: Bearer ***MASKED***';
                } else {
                    $sanitizedHeaders[] = $header;
                }
            }

            $responsePayload = $data['response_payload'] ?? null;
            if (is_string($responsePayload)) {
                $decoded = json_decode($responsePayload, true);
                $responsePayload = ($decoded !== null) ? $decoded : ['raw' => $responsePayload];
            }

            WorldpayPaymentLog::create([
                'restaurant_id'     => $data['restaurant_id'] ?? null,
                'payment_id'        => $data['payment_id'] ?? null,
                'order_id'          => $data['order_id'] ?? null,
                'reference'         => $data['reference'] ?? null,
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
            Log::error('Worldpay Audit Log Save Error: ' . $e->getMessage());
        }
    }

    /**
     * Login to Worldpay & cache token for 3500 seconds (~1 hour)
     */
    public function login(Restaurant $restaurant): string
    {
        $cacheKey = 'worldpay_token_' . $restaurant->id;

        return Cache::remember($cacheKey, 3500, function () use ($restaurant) {
            $authUrl = $this->getAuthUrl() . '/login';
            $startTime = microtime(true);

            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
            ];

            $payload = [
                'Username' => $restaurant->worldpay_username,
                'Password' => $restaurant->worldpay_password,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $authUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => $headers,
            ]);

            $response = curl_exec($curl);
            $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                curl_close($curl);

                $this->recordLog([
                    'restaurant_id'     => $restaurant->id,
                    'action'            => 'LOGIN',
                    'endpoint_url'      => $authUrl,
                    'http_method'       => 'POST',
                    'http_status_code'  => 0,
                    'request_headers'   => $headers,
                    'request_payload'   => $payload,
                    'response_payload'  => null,
                    'error_message'     => 'cURL Error: ' . $error,
                    'execution_time_ms' => $executionTimeMs,
                ]);

                throw new \Exception("Worldpay Auth Connection Error: " . $error);
            }

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'action'            => 'LOGIN',
                'endpoint_url'      => $authUrl,
                'http_method'       => 'POST',
                'http_status_code'  => $status,
                'request_headers'   => $headers,
                'request_payload'   => $payload,
                'response_payload'  => $response,
                'error_message'     => ($status !== 200) ? "Authentication Failed (Status {$status})" : null,
                'execution_time_ms' => $executionTimeMs,
            ]);

            if ($status !== 200) {
                Log::error('Worldpay Login Failed', ['status' => $status, 'response' => $response]);
                throw new \Exception("Worldpay Authentication Failed (Status {$status}): " . $response);
            }

            $data = json_decode($response, true);

            if (empty($data['access_token'])) {
                throw new \Exception("Worldpay Auth Token Missing in Response.");
            }

            return $data['access_token'];
        });
    }

    /**
     * Generate Hosted Payment Page Token
     */
    public function generateHostedPayment(
        Restaurant $restaurant,
        string $accessToken,
        array $data
    ): array {

        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/services/tokens/hpp/";
        $startTime = microtime(true);

        $country = !empty($data['country']) ? $data['country'] : 'GB';
        $postcode = !empty($data['postcode']) ? $data['postcode'] : 'SW1A 1AA';
        $suburb = !empty($data['suburb']) ? $data['suburb'] : (!empty($data['city']) ? $data['city'] : 'London');
        $state = !empty($data['state']) ? $data['state'] : 'Greater London';

        // Prepare Disbursements for extra charges (delivery charge, platform fee, service fee, etc.)
        if (!empty($data['disbursements']) && is_array($data['disbursements'])) {
            $disbursements = $data['disbursements'];
        } else {
            $isDineIn   = ($data['order_type'] ?? '') === 'dine_in';
            $isTakeaway = ($data['order_type'] ?? '') === 'takeaway';
            $isDelivery = ($data['order_type'] ?? '') === 'delivery';
            $deliveryCharge = ($isDineIn || $isTakeaway) ? 0.0 : (float) ($data['delivery_charge'] ?? 0);
            $platformCharge = (float) ($data['platform_charge'] ?? 0);
            $serviceCharge  = (float) ($data['service_charge'] ?? 0);
            $hystCharge     = $isDineIn ? 0.0 : (float) ($data['hyst_charge'] ?? 0);
            $productCharge  = (float) ($data['product_charge'] ?? 0);
            $extraCharge    = (float) ($data['extra_charge'] ?? 0);
            $miscFee        = ($isDineIn || $isTakeaway || $isDelivery) ? 0.20 : 0.0;

            $calculatedExtraAmount = $deliveryCharge + $platformCharge + $serviceCharge + $hystCharge + $productCharge + $extraCharge + $miscFee;

            if (isset($data['disbursement_amount'])) {
                $disbursementAmount = (float) $data['disbursement_amount'];
            } elseif ($calculatedExtraAmount > 0) {
                $disbursementAmount = $calculatedExtraAmount;
            } else {
                $disbursementAmount = (float) ($data['default_disbursement_amount'] ?? 2.25);
            }

            $businessId = $data['disbursement_business_id'] ?? $data['business_id'] ?? 24785;
            $type = $data['disbursement_type'] ?? 'MISC_FEE';

            $disbursements = [
                [
                    "BusinessId" => (int) $businessId,
                    "Type"       => $type,
                    "Amount"     => (float) $disbursementAmount,
                ]
            ];
        }

        $payload = [
            "ReturnUrl" => route('payment.callback'),
            "CardAuthorizationType" => "RECURRING",
            "Template" => "Basic",
            "Transaction" => [
                "ProcessType" => "COMPLETE",
                "Reference" => $data['reference'],
                "Description" => $data['description'] ?? 'Online Order',
                "Amount" => (float) $data['amount'],
                "ServiceDate" => now()->toIso8601String(),
                "Disbursements" => $disbursements,
            ],
            "Payer" => [
                "SavePayer" => true,
                "UniqueReference" => "USER-" . $data['user_id'],
                "GroupReference" => "USER-" . $data['user_id'],
                "FamilyOrBusinessName" => $data['name'],
                "GivenName" => $data['name'],
                "Email" => $data['email'],
                "Phone" => $data['phone'] ?? '',
                "Mobile" => $data['phone'] ?? '',
                "Address" => [
                    "Line1" => $data['address'] ?? '1 Main Street',
                    "Line2" => null,
                    "Suburb" => $suburb,
                    "State" => $state,
                    "PostCode" => $postcode,
                    "Country" => $country,
                ],
            ],
            "Audit" => [
                "Username" => $data['name'],
                "UserIP" => request()->ip(),
            ],
        ];

        Log::info('Worldpay HPP Payload', $payload);

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'payment_id'        => $data['payment_id'] ?? null,
                'order_id'          => $data['order_id'] ?? null,
                'reference'         => $data['reference'],
                'action'            => 'GENERATE_HPP',
                'endpoint_url'      => $apiUrl,
                'http_method'       => 'POST',
                'http_status_code'  => 0,
                'request_headers'   => $headers,
                'request_payload'   => $payload,
                'response_payload'  => null,
                'error_message'     => 'cURL Error: ' . $error,
                'execution_time_ms' => $executionTimeMs,
            ]);

            throw new \Exception("Worldpay HPP Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->recordLog([
            'restaurant_id'     => $restaurant->id,
            'payment_id'        => $data['payment_id'] ?? null,
            'order_id'          => $data['order_id'] ?? null,
            'reference'         => $data['reference'],
            'action'            => 'GENERATE_HPP',
            'endpoint_url'      => $apiUrl,
            'http_method'       => 'POST',
            'http_status_code'  => $status,
            'request_headers'   => $headers,
            'request_payload'   => $payload,
            'response_payload'  => $response,
            'error_message'     => ($status < 200 || $status >= 300) ? "HPP Generation Failed (Status {$status})" : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay HPP Generation Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay HPP Generation Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }

    /**
     * Retrieve Hosted Payment Status
     */
    public function getHostedPaymentStatus(
        Restaurant $restaurant,
        string $accessToken,
        string $webPageToken,
        ?int $paymentId = null,
        ?int $orderId = null
    ): array {
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/services/tokens/{$webPageToken}";
        $startTime = microtime(true);

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json',
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'payment_id'        => $paymentId,
                'order_id'          => $orderId,
                'reference'         => $webPageToken,
                'action'            => 'GET_HPP_STATUS',
                'endpoint_url'      => $apiUrl,
                'http_method'       => 'GET',
                'http_status_code'  => 0,
                'request_headers'   => $headers,
                'request_payload'   => null,
                'response_payload'  => null,
                'error_message'     => 'cURL Error: ' . $error,
                'execution_time_ms' => $executionTimeMs,
            ]);

            throw new \Exception("Worldpay Status Check Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->recordLog([
            'restaurant_id'     => $restaurant->id,
            'payment_id'        => $paymentId,
            'order_id'          => $orderId,
            'reference'         => $webPageToken,
            'action'            => 'GET_HPP_STATUS',
            'endpoint_url'      => $apiUrl,
            'http_method'       => 'GET',
            'http_status_code'  => $status,
            'request_headers'   => $headers,
            'request_payload'   => null,
            'response_payload'  => $response,
            'error_message'     => ($status < 200 || $status >= 300) ? "Status Check Failed (Status {$status})" : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay Status Check Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay Status Check Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }

    /**
     * Charge Saved Card for Payer (CIT)
     */
    public function chargeSavedCard(
        Restaurant $restaurant,
        string $accessToken,
        string $payerReference,
        array $data
    ): array {

        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/payers/{$payerReference}/transactions/card";
        $startTime = microtime(true);

        $payload = [
            "ProcessType" => "COMPLETE",
            "Reference" => $data['reference'],
            "Amount" => (float) $data['amount'],
            "Description" => $data['description'] ?? 'Online Order',
            "CardStorageType" => "CIT_PAYFAC_STORED",
            "ServiceDate" => now()->toIso8601String(),
            "Audit" => [
                "Username" => $data['name'],
                "UserIP" => request()->ip(),
            ],
        ];

        Log::info('Worldpay Saved Card Payload', [
            'payer_reference' => $payerReference,
            'payload' => $payload,
        ]);

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'payment_id'        => $data['payment_id'] ?? null,
                'order_id'          => $data['order_id'] ?? null,
                'reference'         => $data['reference'],
                'action'            => 'CHARGE_SAVED_CARD',
                'endpoint_url'      => $apiUrl,
                'http_method'       => 'POST',
                'request_headers'   => $headers,
                'request_payload'   => $payload,
                'response_payload'  => null,
                'error_message'     => 'cURL Error: ' . $error,
                'execution_time_ms' => $executionTimeMs,
            ]);

            throw new \Exception("Worldpay Saved Card Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->recordLog([
            'restaurant_id'     => $restaurant->id,
            'payment_id'        => $data['payment_id'] ?? null,
            'order_id'          => $data['order_id'] ?? null,
            'reference'         => $data['reference'],
            'action'            => 'CHARGE_SAVED_CARD',
            'endpoint_url'      => $apiUrl,
            'http_method'       => 'POST',
            'http_status_code'  => $status,
            'request_headers'   => $headers,
            'request_payload'   => $payload,
            'response_payload'  => $response,
            'error_message'     => ($status < 200 || $status >= 300) ? "Saved Card Charge Failed (Status {$status})" : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay Saved Card Charge Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay Charge Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }

    /**
     * Finalize 3D Secure Saved Card Payment
     */
    public function finalize3DSavedCardPayment(
        Restaurant $restaurant,
        string $accessToken,
        string $redirectId,
        ?int $paymentId = null,
        ?int $orderId = null
    ): array {
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/transactions/saved-card-payments/finalize/{$redirectId}";
        $startTime = microtime(true);

        $payload = [
            "Audit" => [
                "Username" => auth()->check() ? auth()->user()->name : "System",
                "UserIP" => request()->ip(),
            ],
        ];

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'payment_id'        => $paymentId,
                'order_id'          => $orderId,
                'reference'         => $redirectId,
                'action'            => 'FINALIZE_3D_SECURE',
                'endpoint_url'      => $apiUrl,
                'http_method'       => 'POST',
                'http_status_code'  => 0,
                'request_headers'   => $headers,
                'request_payload'   => $payload,
                'response_payload'  => null,
                'error_message'     => 'cURL Error: ' . $error,
                'execution_time_ms' => $executionTimeMs,
            ]);

            throw new \Exception("Worldpay 3DS Finalize Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->recordLog([
            'restaurant_id'     => $restaurant->id,
            'payment_id'        => $paymentId,
            'order_id'          => $orderId,
            'reference'         => $redirectId,
            'action'            => 'FINALIZE_3D_SECURE',
            'endpoint_url'      => $apiUrl,
            'http_method'       => 'POST',
            'http_status_code'  => $status,
            'request_headers'   => $headers,
            'request_payload'   => $payload,
            'response_payload'  => $response,
            'error_message'     => ($status < 200 || $status >= 300) ? "3DS Finalize Failed (Status {$status})" : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay 3DS Finalize Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay 3DS Finalize Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }

    /**
     * Refund Payment
     */
    public function refundPayment(
        Restaurant $restaurant,
        string $accessToken,
        string $transactionId,
        float $amount,
        string $paymentType,
        string $description = 'Order Refund',
        ?int $paymentId = null,
        ?int $orderId = null
    ): array {

        $endpoint = strtolower($paymentType) === 'card' ? 'card-payments' : 'bank-payments';
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/transactions/{$endpoint}/{$transactionId}/refunds";
        $startTime = microtime(true);

        $refundRef = "REFUND-" . strtoupper(Str::random(10));

        $payload = [
            "Reference" => $refundRef,
            "Description" => $description,
            "Amount" => (float) $amount,
            "Audit" => [
                "Username" => auth()->check() ? auth()->user()->name : "Restaurant",
                "UserIP" => request()->ip(),
            ],
        ];

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            $this->recordLog([
                'restaurant_id'     => $restaurant->id,
                'payment_id'        => $paymentId,
                'order_id'          => $orderId,
                'reference'         => $refundRef,
                'action'            => 'REFUND_PAYMENT',
                'endpoint_url'      => $apiUrl,
                'http_method'       => 'POST',
                'http_status_code'  => 0,
                'request_headers'   => $headers,
                'request_payload'   => $payload,
                'response_payload'  => null,
                'error_message'     => 'cURL Error: ' . $error,
                'execution_time_ms' => $executionTimeMs,
            ]);

            throw new \Exception("Worldpay Refund Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->recordLog([
            'restaurant_id'     => $restaurant->id,
            'payment_id'        => $paymentId,
            'order_id'          => $orderId,
            'reference'         => $refundRef,
            'action'            => 'REFUND_PAYMENT',
            'endpoint_url'      => $apiUrl,
            'http_method'       => 'POST',
            'http_status_code'  => $status,
            'request_headers'   => $headers,
            'request_payload'   => $payload,
            'response_payload'  => $response,
            'error_message'     => ($status < 200 || $status >= 300) ? "Refund Failed (Status {$status})" : null,
            'execution_time_ms' => $executionTimeMs,
        ]);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay Refund Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay Refund Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }
}