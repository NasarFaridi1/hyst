<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\UberWebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\FirebaseNotificationService;

class UberWebhookController extends Controller
{
    /**
     * Handle incoming Uber Direct / DaaS Webhooks (delivery.status_changed, event.delivery_status)
     * Reference: https://developer.uber.com/docs/deliveries/daas/references/api/webhooks/delivery-status-webhook
     */
    public function handle(Request $request)
    {
        $rawContent = $request->getContent();
        Log::info('Uber Webhook Received', [
            'headers' => $request->headers->all(),
            'body'    => $request->all()
        ]);

        // 1. Signature Verification (HMAC-SHA256 via X-Uber-Signature header)
        $signatureHeader = $request->header('X-Uber-Signature') ?? $request->header('x-uber-signature');
        $signingKey = config('services.uber.signing_key');
        $signatureValid = true;

        if ($signatureHeader && $signingKey) {
            $expectedSignature = hash_hmac('sha256', $rawContent, $signingKey);
            if (!hash_equals($expectedSignature, $signatureHeader)) {
                $signatureValid = false;
                Log::warning('Uber Webhook Signature Mismatch', [
                    'received' => $signatureHeader,
                    'expected' => $expectedSignature
                ]);
            }
        }

        $payload = $request->all();
        $meta    = $payload['meta'] ?? [];
        $data    = $payload['data'] ?? $payload;

        // 2. Extract Delivery Identifier & External Order ID
        $deliveryId = $payload['delivery_id']
            ?? $meta['order_id']
            ?? $meta['delivery_id']
            ?? $data['id']
            ?? $payload['id']
            ?? null;

        $externalOrderId = $payload['external_order_id']
            ?? $meta['external_order_id']
            ?? $data['manifest_reference']
            ?? $payload['manifest_reference']
            ?? null;

        $status = $meta['status']
            ?? $payload['status']
            ?? $data['status']
            ?? $payload['event_type']
            ?? null;

        $eventType = $payload['event_type'] ?? $payload['kind'] ?? 'delivery.status_changed';

        // 3. Find Order in Database
        $order = null;
        if ($deliveryId) {
            $order = Order::where('uber_delivery_id', $deliveryId)->first();
        }

        if (!$order && $externalOrderId) {
            $cleanId = preg_replace('/[^\d]/', '', (string) $externalOrderId);
            if ($cleanId) {
                $order = Order::find($cleanId);
            }
        }

        // 4. Log Webhook Response to Database with Date & Time
        try {
            UberWebhookLog::create([
                'order_id'          => $order?->id,
                'delivery_id'       => $deliveryId,
                'external_order_id' => $externalOrderId,
                'event_type'        => $eventType,
                'status'            => $status,
                'payload'           => $payload,
                'headers'           => $request->headers->all(),
                'signature_valid'   => $signatureValid,
                'ip_address'        => $request->ip(),
                'received_at'       => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to store Uber Webhook in database log table', [
                'error' => $e->getMessage()
            ]);
        }

        if (!$signatureValid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature'
            ], 401);
        }

        if (!$deliveryId && !$externalOrderId) {
            Log::warning('Uber Webhook: Missing delivery_id and external_order_id', $payload);
            return response()->json([
                'success' => false,
                'message' => 'Missing delivery ID or external order ID in payload'
            ], 400);
        }

        if (!$order) {
            Log::warning('Uber Webhook: Order not found in database', [
                'delivery_id'       => $deliveryId,
                'external_order_id' => $externalOrderId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Order not found, webhook logged and acknowledged'
            ], 200);
        }

        // 5. Parse Courier Info & Build Order Update Data
        $courier = $data['courier'] ?? $payload['courier'] ?? $meta['courier'] ?? [];
        $pickup  = $data['pickup'] ?? $payload['pickup'] ?? [];
        $dropoff = $data['dropoff'] ?? $payload['dropoff'] ?? [];

        $trackingUrl = $data['tracking_url'] ?? $payload['tracking_url'] ?? $order->uber_tracking_url;

        $updateData = [
            'uber_delivery_id'     => $order->uber_delivery_id ?: $deliveryId,
            'uber_delivery_status' => $status ?: $order->uber_delivery_status,
            'courier_imminent'     => $data['courier_imminent'] ?? $meta['courier_imminent'] ?? false,
            'uber_tracking_url'    => $trackingUrl,
            'uber_driver_name'     => $courier['name'] ?? $order->uber_driver_name,
            'uber_driver_phone'    => $courier['phone_number'] ?? $order->uber_driver_phone,
            'uber_driver_id'       => $courier['public_phone_info']['pin_code'] ?? $courier['id'] ?? $order->uber_driver_id,
            'uber_picked_at'       => $pickup['status_timestamp'] ?? $order->uber_picked_at,
            'uber_delivered_at'    => $dropoff['status_timestamp'] ?? $order->uber_delivered_at,
            'uber_vehicle_type'    => $courier['vehicle_type'] ?? $order->uber_vehicle_type,
            'uber_vehicle_make'    => $courier['vehicle_make'] ?? $order->uber_vehicle_make,
            'uber_vehicle_model'   => $courier['vehicle_model'] ?? $order->uber_vehicle_model,
            'uber_vehicle_plate'   => $courier['vehicle_license_plate'] ?? $order->uber_vehicle_plate,
            'uber_driver_lat'      => $courier['location']['lat'] ?? $order->uber_driver_lat,
            'uber_driver_lng'      => $courier['location']['lng'] ?? $order->uber_driver_lng,
        ];

        // Status mapping to internal order delivery_status & status
        if ($status) {
            $normalizedStatus = strtolower($status);

            if (in_array($normalizedStatus, ['canceled', 'cancelled', 'returned'])) {
                $updateData['delivery_status'] = 'canceled';
            } elseif (in_array($normalizedStatus, ['delivered', 'dropoff_complete', 'completed'])) {
                $updateData['delivery_status'] = 'delivered';
                $updateData['status']          = 'completed';
            } elseif (in_array($normalizedStatus, ['pickup_complete', 'in_transit', 'dropoff', 'en_route'])) {
                $updateData['delivery_status'] = 'in_transit';
            }
        }

        $order->update(array_filter($updateData, fn($val) => !is_null($val)));

        // 6. Send Push Notification to Customer if status updated
        try {
            if ($order->user && !empty($order->user->fcm_token) && $status) {
                $firebase = new FirebaseNotificationService();
                $norm = strtolower($status);

                if (in_array($norm, ['pickup_complete', 'in_transit', 'en_route'])) {
                    $firebase->send(
                        $order->user->fcm_token,
                        'Order On The Way! 🚀',
                        'Your Uber courier has picked up Order #' . $order->id . ' and is on the way to your door.',
                        '/my-orders'
                    );
                } elseif (in_array($norm, ['delivered', 'dropoff_complete', 'completed'])) {
                    $firebase->send(
                        $order->user->fcm_token,
                        'Order Delivered! 🍽️',
                        'Your order #' . $order->id . ' has been delivered by Uber Direct.',
                        '/my-orders'
                    );
                } elseif (in_array($norm, ['canceled', 'cancelled'])) {
                    $firebase->send(
                        $order->user->fcm_token,
                        'Delivery Canceled',
                        'Your Uber delivery for order #' . $order->id . ' was canceled.',
                        '/my-orders'
                    );
                }
            }
        } catch (\Throwable $e) {
            Log::error('Uber Webhook FCM Notification Error', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Webhook processed and stored in database successfully'
        ], 200);
    }
}