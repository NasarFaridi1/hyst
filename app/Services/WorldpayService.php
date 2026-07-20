<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WorldpayService
{
    protected string $baseUrl = 'https://sandbox.auth.paymentsapi.io';

    /**
     * Login to Worldpay
     */
    public function login(Restaurant $restaurant): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://sandbox.auth.paymentsapi.io/login',
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
            throw new \Exception(curl_error($curl));
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($status !== 200) {
            throw new \Exception($response);
        }

        $data = json_decode($response, true);

        return $data['access_token'];
    }
    /**
     * Generate Hosted Payment Page Token
     */
    public function generateHostedPayment(
        Restaurant $restaurant,
        string $accessToken,
        array $data
    ): array {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://sandbox.auth.paymentsapi.io/businesses/{$restaurant->worldpay_business_id}/services/tokens/hpp/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                "ReturnUrl" => route('payment.callback'),
                "Template" => "Basic",
                "CardAuthorizationType" => "RECURRING",
                "Transaction" => [
                    "ProcessType" => "COMPLETE",
                    "Reference" => $data['reference'],
                    "Description" => $data['description'],
                    "Amount" => (float) $data['amount'],
                    "ServiceDate" => now()->toIso8601String(),
                ],
                "Payer" => [
                    "SavePayer" => true,
                    "UniqueReference" => $data['user_id'],
                    "GroupReference" => $data['user_id'],
                    "FamilyOrBusinessName" => $data['name'],
                    "GivenName" => $data['name'],
                    "Email" => $data['email'],
                    "Phone" => $data['phone'],
                    "Mobile" => $data['phone'],
                    "Address" => [
                        "Line1" => $data['address'],
                        "Line2" => null,
                        "Suburb" => "Testville",
                        "State" => 'QLD',
                        "PostCode" => '4001',
                        "Country" => $data['country'],
                    ],
                ],
                "Audit" => [
                    "Username" => $data['name'],
                    "UserIP" => request()->ip(),
                ],
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception(curl_error($curl));
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($status < 200 || $status >= 300) {
            throw new \Exception($response);
        }

        return json_decode($response, true);
    }


    public function getHostedPaymentStatus(
        Restaurant $restaurant,
        string $accessToken,
        string $webPageToken
    ): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [

            CURLOPT_URL =>
            "https://sandbox.auth.paymentsapi.io/businesses/{$restaurant->worldpay_business_id}/services/tokens/{$webPageToken}",

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_CUSTOMREQUEST => 'GET',

            CURLOPT_HTTPHEADER => [

                'Authorization: Bearer '.$accessToken,

                'Accept: application/json',
            ],

        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {

            throw new \Exception(curl_error($curl));
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($status < 200 || $status >= 300) {

            throw new \Exception($response);
        }

        return json_decode($response, true);
    }
}