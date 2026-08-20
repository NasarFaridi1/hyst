<?php

namespace App\Services;

use App\Models\Restaurant;
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
     * Login to Worldpay & cache token for 3500 seconds (~1 hour)
     */
    public function login(Restaurant $restaurant): string
    {
        $cacheKey = 'worldpay_token_' . $restaurant->id;

        return Cache::remember($cacheKey, 3500, function () use ($restaurant) {
            $authUrl = $this->getAuthUrl() . '/login';

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $authUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode([
                    'Username' => $restaurant->worldpay_username,
                    'Password' => $restaurant->worldpay_password,
                ]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                curl_close($curl);
                throw new \Exception("Worldpay Auth Connection Error: " . $error);
            }

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

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

        $country = !empty($data['country']) ? $data['country'] : 'GB';
        $postcode = !empty($data['postcode']) ? $data['postcode'] : 'SW1A 1AA';
        $suburb = !empty($data['suburb']) ? $data['suburb'] : (!empty($data['city']) ? $data['city'] : 'London');
        $state = !empty($data['state']) ? $data['state'] : 'Greater London';

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

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Worldpay HPP Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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
        string $webPageToken
    ): array {
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/services/tokens/{$webPageToken}";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Worldpay Status Check Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Worldpay Saved Card Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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
        string $redirectId
    ): array {
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/transactions/saved-card-payments/finalize/{$redirectId}";

        $payload = [
            "Audit" => [
                "Username" => auth()->check() ? auth()->user()->name : "System",
                "UserIP" => request()->ip(),
            ],
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Worldpay 3DS Finalize Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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
        string $description = 'Order Refund'
    ): array {

        $endpoint = strtolower($paymentType) === 'card' ? 'card-payments' : 'bank-payments';
        $apiUrl = $this->getApiUrl() . "/businesses/{$restaurant->worldpay_business_id}/transactions/{$endpoint}/{$transactionId}/refunds";

        $payload = [
            "Reference" => "REFUND-" . strtoupper(Str::random(10)),
            "Description" => $description,
            "Amount" => (float) $amount,
            "Audit" => [
                "Username" => auth()->check() ? auth()->user()->name : "Restaurant",
                "UserIP" => request()->ip(),
            ],
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Worldpay Refund Error: " . $error);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($status < 200 || $status >= 300) {
            Log::error('Worldpay Refund Failed', ['status' => $status, 'response' => $response]);
            throw new \Exception("Worldpay Refund Failed (Status {$status}): " . $response);
        }

        return json_decode($response, true);
    }
}