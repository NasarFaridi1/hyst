<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\RestaurantDeliveryCharge;

class SelfDeliveryService
{
    /**
     * Calculate distance between restaurant and customer
     * using the Haversine formula.
     *
     * Returns distance in miles.
     */
    public function distanceKm(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371; // KM

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return round($earthRadius * $c, 2);
    }

    /**
     * Calculate distance between restaurant and customer
     * using the Haversine formula.
     *
     * Returns distance in miles.
     */
    public function distance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        return round($this->distanceKm($lat1, $lon1, $lat2, $lon2) * 0.621371, 2);
    }

    /**
     * Find delivery slab.
     */
    public function getDeliverySlab(
        Restaurant $restaurant,
        float $distance
    ): ?RestaurantDeliveryCharge {

        return RestaurantDeliveryCharge::where(
                'restaurant_id',
                $restaurant->id
            )
            ->where(
                'from_distance',
                '<=',
                $distance
            )
            ->where(
                'to_distance',
                '>=',
                $distance
            )
            ->first();
    }

    /**
     * Calculate self delivery.
     */
    public function calculate(
        Restaurant $restaurant,
        float $customerLatitude,
        float $customerLongitude,
        float $subtotal
    ): array {

        if (
            empty($restaurant->latitude) ||
            empty($restaurant->longitude)
        ) {

            return [
                'success' => false,
                'message' => 'Restaurant location is missing.',
            ];
        }

        $distanceKm = $this->distanceKm(
            (float) $restaurant->latitude,
            (float) $restaurant->longitude,
            $customerLatitude,
            $customerLongitude
        );

        $distanceMiles = round($distanceKm * 0.621371, 2);
        $maxRadiusKm = 10.0;

        if ($distanceKm > $maxRadiusKm) {
            return [
                'success' => false,
                'distance' => $distanceMiles,
                'distance_km' => $distanceKm,
                'distance_miles' => $distanceMiles,
                'max_radius_km' => $maxRadiusKm,
                'message' => "Delivery Unavailable: Your address is {$distanceKm} KM away from the restaurant. Orders in the United Kingdom can only be booked within a 10 KM radius.",
            ];
        }

        $distance = $distanceMiles;

        /*
        |--------------------------------------------------------------------------
        | Find Slab
        |--------------------------------------------------------------------------
        */

        $slab = $this->getDeliverySlab(
            $restaurant,
            $distance
        );

        if (!$slab) {

            return [

                'success' => false,

                'message' =>
                    'Delivery is not available for your address.',

                'distance' =>
                    $distance,

                'delivery_charge' =>
                    0,

                'free_delivery' =>
                    false,

                'slab' =>
                    null,

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Delivery Charge
        |--------------------------------------------------------------------------
        */

        $deliveryCharge = (float) $slab->delivery_charge;

        $freeDelivery = false;

        if (

            !is_null($slab->free_delivery_min_order)

            &&

            $subtotal >= $slab->free_delivery_min_order

        ) {

            $deliveryCharge = 0;

            $freeDelivery = true;

        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return [

            'success' => true,

            'distance' => round($distance, 2),

            'distance_km' => $distanceKm,

            'distance_miles' => $distanceMiles,

            'max_radius_km' => 10.0,

            'delivery_charge' => round($deliveryCharge, 2),

            'free_delivery' => $freeDelivery,

            'minimum_order' => $slab->free_delivery_min_order,

            'slab' => [

                'id' => $slab->id,

                'from_distance' => $slab->from_distance,

                'to_distance' => $slab->to_distance,

                'delivery_charge' => $slab->delivery_charge,

                'free_delivery_min_order' => $slab->free_delivery_min_order,

            ],

        ];
    }
}