<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UberWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Uber Webhook Received', $request->all());

        $payload = $request->all();

        $deliveryId = $payload['delivery_id']
            ?? $payload['data']['id']
            ?? $payload['id']
            ?? null;

        if (!$deliveryId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing delivery ID in webhook'
            ], 400);
        }

        $order = Order::where('uber_delivery_id', $deliveryId)->first();

        if (!$order) {
            Log::warning('Uber Webhook: Order not found', ['delivery_id' => $deliveryId]);
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 444);
        }

        $data = $payload['data'] ?? $payload;
        $status = $payload['status'] ?? $data['status'] ?? $payload['event_type'] ?? null;

        $updateData = [
            'uber_delivery_status' => $status ?? $order->uber_delivery_status,
            'courier_imminent'     => $data['courier_imminent'] ?? false,
            'uber_tracking_url'    => $data['tracking_url'] ?? $order->uber_tracking_url,
            'uber_driver_name'     => $data['courier']['name'] ?? $order->uber_driver_name,
            'uber_driver_phone'    => $data['courier']['phone_number'] ?? $order->uber_driver_phone,
            'uber_driver_id'       => $data['courier']['public_phone_info']['pin_code'] ?? $order->uber_driver_id,
            'uber_picked_at'       => $data['pickup']['status_timestamp'] ?? $order->uber_picked_at,
            'uber_delivered_at'    => $data['dropoff']['status_timestamp'] ?? $order->uber_delivered_at,
            'uber_vehicle_type'    => $data['courier']['vehicle_type'] ?? $order->uber_vehicle_type,
            'uber_vehicle_make'    => $data['courier']['vehicle_make'] ?? $order->uber_vehicle_make,
            'uber_vehicle_model'   => $data['courier']['vehicle_model'] ?? $order->uber_vehicle_model,
            'uber_vehicle_plate'   => $data['courier']['vehicle_license_plate'] ?? $order->uber_vehicle_plate,
            'uber_driver_lat'      => $data['courier']['location']['lat'] ?? $order->uber_driver_lat,
            'uber_driver_lng'      => $data['courier']['location']['lng'] ?? $order->uber_driver_lng,
        ];

        if ($status === 'canceled' || $status === 'cancelled') {
            $updateData['delivery_status'] = 'canceled';
        } elseif ($status === 'delivered' || $status === 'dropoff_complete') {
            $updateData['delivery_status'] = 'delivered';
        } elseif ($status === 'pickup_complete' || $status === 'in_transit') {
            $updateData['delivery_status'] = 'in_transit';
        }

        $order->update(array_filter($updateData, fn($val) => !is_null($val)));

        return response()->json([
            'success' => true
        ]);
    }
}