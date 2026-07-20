<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StuartService
{
    /*
    |--------------------------------------------------------------------------
    | GET TOKEN
    |--------------------------------------------------------------------------
    */

    public function getToken()
    {
        $response = Http::withoutVerifying()
            ->asForm()
            ->post(
                config('services.stuart.base_url') . '/oauth/token',
                [
                    'client_id' =>
                        config('services.stuart.client_id'),

                    'client_secret' =>
                        config('services.stuart.client_secret'),

                    'grant_type' => 'client_credentials',
                ]
            );

        Log::info('STUART TOKEN RESPONSE', [
            'body' => $response->body()
        ]);

        return $response->json()['access_token'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | DELIVERY PAYLOAD
    |--------------------------------------------------------------------------
    */

    public function deliveryPayload($order, $restaurant)
    {
        return [

            'job' => [

                'pickup_at' => now()
                    ->addMinutes(10)
                    ->toIso8601String(),

                'pickups' => [

                    [

                        'address' => $restaurant->location,

                        'comment' => 'Restaurant Pickup',

                        'contact' => [

                            'firstname' => $restaurant->name,

                            'lastname' => 'Restaurant',

                            'phone' => '+919876543210',

                        ],
                    ]
                ],

                'dropoffs' => [

                    [

                        'package_type' => 'small',

                        'package_description' =>
                            'Food Delivery',

                        'client_reference' =>
                            'ORDER-' . $order->id,

                        'address' => $order->address,

                        'comment' =>
                            'Customer Delivery Address',

                        'contact' => [

                            'firstname' =>
                                $order->user->name,

                            'lastname' => 'Customer',

                            'phone' => $order->phone,
                        ],
                    ]
                ]
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATE DELIVERY
    |--------------------------------------------------------------------------
    */

    public function validateDelivery($order, $restaurant)
    {
        $token = $this->getToken();

        if (!$token) {
            return false;
        }

        $payload =
            $this->deliveryPayload(
                $order,
                $restaurant
            );

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->post(
                config('services.stuart.base_url')
                . '/v2/jobs/validate',
                $payload
            );

        Log::info('VALIDATE DELIVERY', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return $response->json();
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE DELIVERY
    |--------------------------------------------------------------------------
    */

    public function createDelivery($order, $restaurant)
    {
        Log::info('CREATE DELIVERY START');

        $token = $this->getToken();

        if (!$token) {

            Log::info('TOKEN FAILED');

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE FIRST
        |--------------------------------------------------------------------------
        */

        $validation =
            $this->validateDelivery(
                $order,
                $restaurant
            );

        if (
            !$validation ||
            ($validation['valid'] ?? false) == false
        ) {

            Log::info('VALIDATION FAILED', [
                'validation' => $validation
            ]);

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE JOB
        |--------------------------------------------------------------------------
        */

        $payload =
            $this->deliveryPayload(
                $order,
                $restaurant
            );

        Log::info('DELIVERY PAYLOAD', $payload);

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(
                config('services.stuart.base_url')
                . '/v2/jobs',
                $payload
            );

        Log::info('CREATE DELIVERY RESPONSE', [

            'status' => $response->status(),

            'body' => $response->body()

        ]);

        return $response->json();
    }
}
