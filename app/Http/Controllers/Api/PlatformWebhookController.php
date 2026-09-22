<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlatformWebhookController extends Controller
{
    /**
     * Handle Uber Eats Order Webhooks
     */
    public function handleUberEats(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Uber Eats Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderId     = $payload['order_id'] ?? $payload['event_id'] ?? null;
        $displayCode = $payload['display_id'] ?? ('UE-' . substr($orderId ?? '', -4));
        $status      = $payload['current_state'] ?? 'CREATED';

        if (empty($orderId)) {
            return response()->json(['status' => 'acknowledged_missing_id'], 200);
        }

        $order = Order::where('platform_order_id', $orderId)->first();

        if (!$order) {
            $eatsData = $payload['order'] ?? $payload;
            $items    = $eatsData['cart']['items'] ?? [];
            $total    = ($eatsData['payment']['total'] ?? 0) / 100;

            $order = Order::create([
                'restaurant_id'          => $restaurantId,
                'user_id'                => 1, // System default customer profile for marketplace
                'platform_source'        => 'ubereats',
                'platform_order_id'      => $orderId,
                'platform_display_code'  => $displayCode,
                'platform_order_status'  => $status,
                'platform_raw_payload'    => json_encode($payload),
                'order_type'             => 'takeaway',
                'total_amount'           => $total ?: 10.00,
                'address'                => $eatsData['delivery']['location']['address'] ?? 'Uber Eats Marketplace Customer',
                'phone'                  => $eatsData['eater']['phone'] ?? 'N/A',
                'payment_method'         => 'UberEats Marketplace Pay',
                'status'                 => 'pending',
                'delivery_status'        => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => null,
                    'quantity'   => $item['quantity'] ?? 1,
                    'price'      => ($item['price']['unit_price']['amount'] ?? 0) / 100,
                    'total'      => ($item['price']['total_price']['amount'] ?? 0) / 100,
                ]);
            }
        } else {
            $order->update([
                'platform_order_status' => $status,
                'platform_raw_payload'   => json_encode($payload),
                'status'                 => in_array(strtolower($status), ['denied', 'canceled']) ? 'cancelled' : $order->status,
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle Deliveroo Order Webhooks
     */
    public function handleDeliveroo(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Deliveroo Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderData   = $payload['order'] ?? $payload;
        $orderId     = $orderData['id'] ?? null;
        $displayCode = $orderData['display_id'] ?? ('DEL-' . substr($orderId ?? '', -4));
        $status      = $orderData['status'] ?? 'NEW';

        if (empty($orderId)) {
            return response()->json(['status' => 'acknowledged_missing_id'], 200);
        }

        $order = Order::where('platform_order_id', $orderId)->first();

        if (!$order) {
            $items = $orderData['items'] ?? [];
            $total = ($orderData['total_price'] ?? 0) / 100;

            $order = Order::create([
                'restaurant_id'          => $restaurantId,
                'user_id'                => 1,
                'platform_source'        => 'deliveroo',
                'platform_order_id'      => $orderId,
                'platform_display_code'  => $displayCode,
                'platform_order_status'  => $status,
                'platform_raw_payload'    => json_encode($payload),
                'order_type'             => 'takeaway',
                'total_amount'           => $total ?: 12.00,
                'address'                => 'Deliveroo Customer',
                'phone'                  => 'N/A',
                'payment_method'         => 'Deliveroo Pay',
                'status'                 => 'pending',
                'delivery_status'        => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => null,
                    'quantity'   => $item['quantity'] ?? 1,
                    'price'      => ($item['unit_price'] ?? 0) / 100,
                    'total'      => ($item['total_price'] ?? 0) / 100,
                ]);
            }
        } else {
            $order->update([
                'platform_order_status' => $status,
                'platform_raw_payload'   => json_encode($payload),
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle Just Eat Order Webhooks
     */
    public function handleJustEat(Request $request, $restaurantId)
    {
        $payload = $request->all();
        Log::info("Just Eat Webhook Received for Restaurant #{$restaurantId}", ['body' => $payload]);

        $orderId     = $payload['OrderId'] ?? $payload['id'] ?? null;
        $displayCode = 'JE-' . substr($orderId ?? '', -4);
        $status      = $payload['Status'] ?? 'PLACED';

        if (empty($orderId)) {
            return response()->json(['status' => 'acknowledged_missing_id'], 200);
        }

        $order = Order::where('platform_order_id', $orderId)->first();

        if (!$order) {
            $items = $payload['Lines'] ?? $payload['items'] ?? [];
            $total = $payload['TotalAmount'] ?? 15.00;

            $order = Order::create([
                'restaurant_id'          => $restaurantId,
                'user_id'                => 1,
                'platform_source'        => 'justeat',
                'platform_order_id'      => $orderId,
                'platform_display_code'  => $displayCode,
                'platform_order_status'  => $status,
                'platform_raw_payload'    => json_encode($payload),
                'order_type'             => 'takeaway',
                'total_amount'           => $total,
                'address'                => $payload['Customer']['Address']['Line1'] ?? 'Just Eat Customer',
                'phone'                  => $payload['Customer']['PhoneNumber'] ?? 'N/A',
                'payment_method'         => 'Just Eat Pay',
                'status'                 => 'pending',
                'delivery_status'        => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => null,
                    'quantity'   => $item['Quantity'] ?? 1,
                    'price'      => $item['UnitPrice'] ?? 0,
                    'total'      => ($item['UnitPrice'] ?? 0) * ($item['Quantity'] ?? 1),
                ]);
            }
        } else {
            $order->update([
                'platform_order_status' => $status,
                'platform_raw_payload'   => json_encode($payload),
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
