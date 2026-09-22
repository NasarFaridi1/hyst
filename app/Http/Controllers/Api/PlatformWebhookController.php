<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlatformWebhookController extends Controller
{
    /**
     * Handle Uber Eats Order Webhooks (Live API Proxy Mode)
     * Webhooks acknowledge status updates and log events without DB storage.
     */
    public function handleUberEats(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Uber Eats Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderId = $payload['order_id'] ?? $payload['event_id'] ?? null;
        $status  = $payload['current_state'] ?? 'CREATED';

        return response()->json([
            'status'  => 'success',
            'message' => 'Uber Eats webhook acknowledged in Live API Proxy mode',
            'event'   => [
                'order_id' => $orderId,
                'status'   => $status
            ]
        ], 200);
    }

    /**
     * Handle Deliveroo Order Webhooks (Live API Proxy Mode)
     * Webhooks acknowledge status updates and log events without DB storage.
     */
    public function handleDeliveroo(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Deliveroo Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderData = $payload['order'] ?? $payload;
        $orderId   = $orderData['id'] ?? null;
        $status    = $orderData['status'] ?? 'NEW';

        return response()->json([
            'status'  => 'success',
            'message' => 'Deliveroo webhook acknowledged in Live API Proxy mode',
            'event'   => [
                'order_id' => $orderId,
                'status'   => $status
            ]
        ], 200);
    }

    /**
     * Handle Just Eat Order Webhooks (Live API Proxy Mode)
     * Webhooks acknowledge status updates and log events without DB storage.
     */
    public function handleJustEat(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Just Eat Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderId = $payload['OrderId'] ?? $payload['id'] ?? null;
        $status  = $payload['Status'] ?? 'PLACED';

        return response()->json([
            'status'  => 'success',
            'message' => 'Just Eat webhook acknowledged in Live API Proxy mode',
            'event'   => [
                'order_id' => $orderId,
                'status'   => $status
            ]
        ], 200);
    }
}

