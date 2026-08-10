<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UberService
{

    public function token()
    {
        if (Cache::has('uber_token')) {
            return Cache::get('uber_token');
        }

        $response = Http::asForm()->post(
            'https://auth.uber.com/oauth/v2/token',
            [
                'client_id'     => config('services.uber.client_id'),
                'client_secret' => config('services.uber.client_secret'),
                'grant_type'    => 'client_credentials',
                'scope'         => 'eats.deliveries direct.organizations',
            ]
        );

        Log::info('Uber Token Status', [
            'status' => $response->status(),
        ]);

        Log::info('Uber Token Response', [
            'body' => $response->json(),
        ]);

        if ($response->failed()) {
            throw new \Exception(
                'Uber token generation failed: ' . $response->body()
            );
        }

        $token = $response->json('access_token');

        // Cache until shortly before expiry
        Cache::put(
            'uber_token',
            $token,
            now()->addDays(29)
        );

        return $token;
    }

    public function quoteFromCheckout($restaurant, $user, $checkout)
    {
        $times = $this->getDeliveryTimes();

        $payload = [

            "pickup_address" => json_encode([
                "street_address" => [$restaurant->address],
                "city" => $restaurant->city,
                "state" => $restaurant->state,
                "zip_code" => $restaurant->postcode,
                "country" => $restaurant->country,
            ]),

            "dropoff_address" => json_encode([
                "street_address" => [$checkout['address']],
                "city" => $checkout['city'],
                "state" => $checkout['state'],
                "zip_code" => $checkout['postcode'],
                "country" => $checkout['country'],
            ]),

            "pickup_latitude" => (float)$restaurant->latitude,
            "pickup_longitude" => (float)$restaurant->longitude,

            "dropoff_latitude" => (float)$checkout['latitude'],
            "dropoff_longitude" => (float)$checkout['longitude'],

            "pickup_ready_dt" => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt" => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt" => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "pickup_phone_number" => $restaurant->phone,
            "dropoff_phone_number" => !empty($user?->phone) ? $user->phone : ($checkout['phone'] ?? session('guest_checkout.phone') ?? ''),

            "manifest_total_value" => (int) round($checkout['amount'] * 100),

            "external_store_id" => (string)$restaurant->id,
        ];

        Log::info('Uber Quote Payload', $payload);

            $response = Http::withToken($this->token())
                ->acceptJson()
                ->post(
                    'https://api.uber.com/v1/customers/' .
                    config('services.uber.customer_id') .
                    '/delivery_quotes',
                    $payload
                );

            Log::info('Uber Quote Response', [
                'status' => $response->status(),
                'body'   => $response->json(),
            ]);

            return $response->json();
        
    }

    public function quote($restaurant, $order)
    {
        
        $isGuest = $order->is_guest;

        $name = $isGuest
            ? $order->guest_name
            : optional($order->user)->name;

        $address = $isGuest
            ? $order->guest_address
            : optional($order->user)->address;

        $city = $isGuest
            ? $order->guest_city
            : optional($order->user)->city;

        $country = $isGuest
            ? $order->guest_country
            : optional($order->user)->country;
        $state = $isGuest
            ? $order->guest_state
            : optional($order->user)->state;
            
        $postcode = $isGuest
            ? $order->guest_postcode
            : optional($order->user)->postcode;
        
        $phone = $isGuest
            ? $order->guest_phone
            : optional($order->user)->phone;
        
        $latitude = $isGuest
            ? $order->guest_latitude
            : optional($order->user)->latitude;
            
        $longitude = $isGuest
            ? $order->guest_longitude
            : optional($order->user)->longitude;


         $times = $this->getDeliveryTimes();

        $payload = [

            "pickup_address" => json_encode([
                "street_address" => [$restaurant->address],
                "city"           => $restaurant->city,
                "state"          => $restaurant->state,
                "zip_code"       => $restaurant->postcode,
                "country"        => $restaurant->country,
            ]),

            "dropoff_address" => json_encode([
                "street_address" => [$order->address ?? $address],
                "city"           => $city,
                "state"          => $state,
                "zip_code"       => $postcode,
                "country"        => $country,
            ]),

            "pickup_latitude"  => (float) $restaurant->latitude,
            "pickup_longitude" => (float) $restaurant->longitude,

            "dropoff_latitude"  => (float) $latitude,
            "dropoff_longitude" => (float) $longitude,

           

            "pickup_ready_dt"     => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt"  => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt"    => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "pickup_phone_number" => $restaurant->phone,
            "dropoff_phone_number" => $order->phone ?? $phone,

            // Amount in the smallest currency unit (pence for GBP)
            "manifest_total_value" => (int) round($order->total_amount * 100),

            "external_store_id" => (string) $restaurant->id,

        ];

        Log::info('Uber Quote Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                'https://api.uber.com/v1/customers/' .
                config('services.uber.customer_id') .
                '/delivery_quotes',
                $payload
            );

        Log::info('Uber Quote Response', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        return $response->json();
    }
    

    public function createDelivery($order, $restaurant, $request)
    {
       
        $items = [];

        $isGuest = $order->is_guest;

        $name = $isGuest
            ? $order->guest_name
            : optional($order->user)->name;

        $address = $isGuest
            ? $order->guest_address
            : optional($order->user)->address;

        $city = $isGuest
            ? $order->guest_city
            : optional($order->user)->city;

        $country = $isGuest
            ? $order->guest_country
            : optional($order->user)->country;
        $state = $isGuest
            ? $order->guest_state
            : optional($order->user)->state;
            
        $postcode = $isGuest
            ? $order->guest_postcode
            : optional($order->user)->postcode;
        
        $phone = $isGuest
            ? $order->guest_phone
            : optional($order->user)->phone;
        
        $latitude = $isGuest
            ? $order->guest_latitude
            : optional($order->user)->latitude;
            
        $longitude = $isGuest
            ? $order->guest_longitude
            : optional($order->user)->longitude;

        $times = $this->getDeliveryTimes();
        foreach ($order->items as $item) {

            $items[] = [

                "name" => $item->product->name,

                "quantity" => $item->quantity,

                "price" => (int) round($item->total * 100), // pence

            ];
        }


        $payload = [

            "quote_id" => $request->uber_quote_id,

            "pickup_name" => $restaurant->name,

            "pickup_business_name" => $restaurant->name,

            "pickup_address" => json_encode([
                "street_address" => [$restaurant->address],
                "city" => $restaurant->city,
                "state" => $restaurant->state,
                "zip_code" => $restaurant->postcode,
                "country" => $restaurant->country,
            ]),

            "pickup_phone_number" => $restaurant->phone,

            "pickup_latitude" => (float) $restaurant->latitude,

            "pickup_longitude" => (float) $restaurant->longitude,

            "dropoff_name" => $name,

            "dropoff_address" => json_encode([
                "street_address" => [$order->address ?? $request->address],
                "city" => $request->city ?? $city,
                "state" => $request->state ?? $state,
                "zip_code" => $request->postcode ?? $postcode,
                "country" => $request->country ?? $country,
            ]),

            "dropoff_phone_number" => $order->phone ?? $request->phone ?? $phone,

            "dropoff_latitude" => (float) $request->latitude ?? $latitude,

            "dropoff_longitude" => (float) $request->longitude ?? $longitude,

            "manifest_items" => $items,

            "manifest_reference" => "ORDER-" . $order->id,

            "manifest_total_value" => (int) round($order->total_amount * 100),

            "pickup_ready_dt"     => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt"  => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt"    => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "idempotency_key" => (string) Str::uuid(),

            "external_store_id" => (string) $restaurant->id,

        ];

        Log::info('Uber Delivery Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                "https://api.uber.com/v1/customers/"
                . config('services.uber.customer_id')
                . "/deliveries",
                $payload
            );

          

        Log::info('Uber Delivery Response', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        return $response->json();
    }


    private function getDeliveryTimes()
    {
        $pickupReady = Carbon::now()->addMinutes(5);

        $pickupDeadline = $pickupReady->copy()->addMinutes(20);

        $dropoffReady = $pickupReady->copy();

        $dropoffDeadline = $pickupDeadline->copy()->addMinutes(60);

        return compact(
            'pickupReady',
            'pickupDeadline',
            'dropoffReady',
            'dropoffDeadline'
        );
    }
}