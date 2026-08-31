<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UberService
{
    private function getBaseUrl()
    {
        return config('services.uber.base_url', 'https://api.uber.com/v1');
    }

    private function getCustomerId($restaurant = null)
    {
        if ($restaurant && !empty($restaurant->uber_organization_id)) {
            return $restaurant->uber_organization_id;
        }
        return config('services.uber.customer_id');
    }

    /**
     * Create New Org (Uber Direct Organizations API)
     * Endpoint: POST /v1/direct/organizations
     */
    public function createOrganization($restaurant, $billingType = 'CENTRALIZED')
    {
        $payload = [
            "name"         => $restaurant->name,
            "billing_type" => $billingType,
            "address"      => [
                "street_address" => [(string) $restaurant->address],
                "city"           => (string) $restaurant->city,
                "state"          => (string) $restaurant->state,
                "zip_code"       => (string) $restaurant->postcode,
                "country"        => (string) ($restaurant->country ?: 'GB'),
            ],
        ];

        Log::info('Uber Create Organization Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                $this->getBaseUrl() . '/direct/organizations',
                $payload
            );

        Log::info('Uber Create Organization Response', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        $data = $response->json();
        if ($response->successful() && !empty($data['organization_id'])) {
            $restaurant->update([
                'uber_organization_id' => $data['organization_id']
            ]);
        }

        return $data;
    }

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
        $expiresIn = $response->json('expires_in', 2592000); // Default to 30 days if not present

        $cacheSeconds = max(60, $expiresIn - 300);

        Cache::put(
            'uber_token',
            $token,
            now()->addSeconds($cacheSeconds)
        );

        return $token;
    }

    public function quoteFromCheckout($restaurant, $user, $checkout)
    {
        $times = $this->getDeliveryTimes();

        $payload = [
            "pickup_address" => $this->formatAddress(
                $restaurant->address,
                $restaurant->city,
                $restaurant->state,
                $restaurant->postcode,
                $restaurant->country
            ),

            "dropoff_address" => $this->formatAddress(
                $checkout['address'] ?? '',
                $checkout['city'] ?? '',
                $checkout['state'] ?? '',
                $checkout['postcode'] ?? '',
                $checkout['country'] ?? ''
            ),

            "pickup_latitude"  => (float) $restaurant->latitude,
            "pickup_longitude" => (float) $restaurant->longitude,

            "dropoff_latitude"  => (float) ($checkout['latitude'] ?? 0),
            "dropoff_longitude" => (float) ($checkout['longitude'] ?? 0),

            "pickup_ready_dt"     => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt"  => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt"    => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "pickup_phone_number"  => $this->formatPhone($restaurant->phone),
            "dropoff_phone_number" => $this->formatPhone($user->phone ?? ''),

            "manifest_total_value" => (int) round(($checkout['amount'] ?? 0) * 100),

            "external_store_id" => (string) $restaurant->id,
        ];

        Log::info('Uber Quote Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                $this->getBaseUrl() . '/customers/' . $this->getCustomerId($restaurant) . '/delivery_quotes',
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
        $address  = optional($order->user)->address;
        $city     = optional($order->user)->city;
        $country  = optional($order->user)->country;
        $state    = optional($order->user)->state;
        $postcode = optional($order->user)->postcode;
        $phone    = optional($order->user)->phone;
        $latitude = optional($order->user)->latitude;
        $longitude= optional($order->user)->longitude;

        $times = $this->getDeliveryTimes();

        $payload = [
            "pickup_address" => $this->formatAddress(
                $restaurant->address,
                $restaurant->city,
                $restaurant->state,
                $restaurant->postcode,
                $restaurant->country
            ),

            "dropoff_address" => $this->formatAddress(
                $order->address ?? $address,
                $city,
                $state,
                $postcode,
                $country
            ),

            "pickup_latitude"  => (float) $restaurant->latitude,
            "pickup_longitude" => (float) $restaurant->longitude,

            "dropoff_latitude"  => (float) ($latitude ?? 0),
            "dropoff_longitude" => (float) ($longitude ?? 0),

            "pickup_ready_dt"     => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt"  => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt"    => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "pickup_phone_number"  => $this->formatPhone($restaurant->phone),
            "dropoff_phone_number" => $this->formatPhone($order->phone ?? $phone ?? ''),

            "manifest_total_value" => (int) round($order->total_amount * 100),

            "external_store_id" => (string) $restaurant->id,
        ];

        Log::info('Uber Quote Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                $this->getBaseUrl() . '/customers/' . $this->getCustomerId($restaurant) . '/delivery_quotes',
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

        $name      = optional($order->user)->name ?? $request->name ?? 'Customer';
        $address   = optional($order->user)->address;
        $city      = optional($order->user)->city;
        $country   = optional($order->user)->country;
        $state     = optional($order->user)->state;
        $postcode  = optional($order->user)->postcode;
        $phone     = optional($order->user)->phone;
        $latitude  = optional($order->user)->latitude;
        $longitude = optional($order->user)->longitude;

        $times = $this->getDeliveryTimes();

        if ($order->items && count($order->items) > 0) {
            foreach ($order->items as $item) {
                $items[] = [
                    "name"     => $item->product->name ?? 'Item',
                    "quantity" => (int) $item->quantity,
                    "price"    => (int) round(($item->total ?? 0) * 100), // pence
                    "size"     => "small",
                    "weight"   => 0,
                    "dimensions" => [
                        "length" => 20,
                        "height" => 20,
                        "depth"  => 20
                    ],
                ];
            }
        }

        if (empty($items)) {
            $items[] = [
                "name"     => "Food Order #" . $order->id,
                "quantity" => 1,
                "price"    => (int) round($order->total_amount * 100),
                "size"     => "small",
                "weight"   => 0,
            ];
        }

        // Action options specification
        $deliverableAction = $request->deliverable_action
            ?? $order->deliverable_action
            ?? 'deliverable_action_meet_at_door';

        $undeliverableAction = $request->undeliverable_action
            ?? $order->undeliverable_action
            ?? 'leave_at_door';

        $dropoffNotes = $request->dropoff_notes
            ?? $order->dropoff_notes
            ?? $order->description
            ?? 'Please ring door bell upon arrival.';

        $pickupNotes = $restaurant->pickup_notes
            ?? 'Please pick up at restaurant main counter.';

        $payload = [
            "quote_id" => $request->uber_quote_id ?? $order->uber_quote_id,

            "pickup_name" => $restaurant->name,
            "pickup_address" => $this->formatAddress(
                $restaurant->address,
                $restaurant->city,
                $restaurant->state,
                $restaurant->postcode,
                $restaurant->country
            ),
            "pickup_phone_number" => $this->formatPhone($restaurant->phone),

            "dropoff_name" => $name,
            "dropoff_address" => $this->formatAddress(
                $order->address ?? $request->address ?? $address,
                $request->city ?? $city,
                $request->state ?? $state,
                $request->postcode ?? $postcode,
                $request->country ?? $country
            ),
            "dropoff_phone_number" => $this->formatPhone($order->phone ?? $request->phone ?? $phone ?? ''),

            "manifest_items" => $items,

            "pickup_business_name" => $restaurant->name,
            "pickup_latitude"     => (float) $restaurant->latitude,
            "pickup_longitude"    => (float) $restaurant->longitude,
            "pickup_notes"        => $pickupNotes,

            "dropoff_latitude"  => (float) ($request->latitude ?? $latitude ?? 0),
            "dropoff_longitude" => (float) ($request->longitude ?? $longitude ?? 0),
            "dropoff_notes"     => $dropoffNotes,

            "deliverable_action"   => $deliverableAction,
            "undeliverable_action" => $undeliverableAction,

            "manifest_reference"  => "ORDER-" . $order->id,
            "manifest_total_value"=> (int) round($order->total_amount * 100),

            "pickup_ready_dt"     => $times['pickupReady']->toISOString(),
            "pickup_deadline_dt"  => $times['pickupDeadline']->toISOString(),
            "dropoff_ready_dt"    => $times['dropoffReady']->toISOString(),
            "dropoff_deadline_dt" => $times['dropoffDeadline']->toISOString(),

            "idempotency_key"   => (string) Str::uuid(),
            "external_store_id" => (string) $restaurant->id,
        ];

        Log::info('Uber Delivery Payload', $payload);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                $this->getBaseUrl() . "/customers/" . $this->getCustomerId($restaurant) . "/deliveries",
                $payload
            );

        Log::info('Uber Delivery Response', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        return $response->json();
    }

    /**
     * Get Delivery Details / Real-time Status
     */
    public function getDelivery($deliveryId, $restaurant = null)
    {
        if (empty($deliveryId)) {
            return null;
        }

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->get(
                $this->getBaseUrl() . "/customers/" . $this->getCustomerId($restaurant) . "/deliveries/" . $deliveryId
            );

        Log::info('Uber Get Delivery Response', [
            'delivery_id' => $deliveryId,
            'status'      => $response->status(),
            'body'        => $response->json(),
        ]);

        return $response->json();
    }

    /**
     * Cancel Delivery API
     */
    public function cancelDelivery($deliveryId, $reason = null, $restaurant = null)
    {
        if (empty($deliveryId)) {
            return [
                'success' => false,
                'message' => 'No delivery ID provided'
            ];
        }

        $payload = array_filter([
            'cancel_reason' => $reason
        ]);

        Log::info('Uber Cancel Delivery Payload', [
            'delivery_id' => $deliveryId,
            'reason'      => $reason,
        ]);

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->post(
                $this->getBaseUrl() . "/customers/" . $this->getCustomerId($restaurant) . "/deliveries/" . $deliveryId . "/cancel",
                $payload
            );

        Log::info('Uber Cancel Delivery Response', [
            'delivery_id' => $deliveryId,
            'status'      => $response->status(),
            'body'        => $response->json(),
        ]);

        return $response->json();
    }

    private function getDeliveryTimes()
    {
        $pickupReady    = Carbon::now()->addMinutes(5);
        $pickupDeadline = $pickupReady->copy()->addMinutes(20);
        $dropoffReady   = $pickupReady->copy();
        $dropoffDeadline= $pickupDeadline->copy()->addMinutes(60);

        return compact(
            'pickupReady',
            'pickupDeadline',
            'dropoffReady',
            'dropoffDeadline'
        );
    }

    private function formatAddress($street, $city, $state, $zipCode, $country)
    {
        return json_encode([
            "street_address" => [(string) $street],
            "city"           => (string) $city,
            "state"          => (string) $state,
            "zip_code"       => (string) $zipCode,
            "country"        => (string) ($country ?: 'GB'),
        ]);
    }

    private function formatPhone($phone)
    {
        if (empty($phone)) {
            return '';
        }
        $phone = preg_replace('/[^\d+]/', '', (string) $phone);
        return $phone;
    }
}