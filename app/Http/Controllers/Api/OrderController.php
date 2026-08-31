<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Complaint;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderCompletionEvidence;
use App\Models\OrderItem;
use App\Models\OrderOffer;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseNotificationService;
use App\Services\StuartService;
use App\Services\UberService;



class OrderController extends Controller
{
    //
    public function checkout()
    {
        $cart = Cart::with([
            'restaurant',
            'items.product.offers',
            'items.variant'
        ])
        ->where('user_id', auth()->id())
        ->first();

        if (!$cart || $cart->items->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty.'
            ], 400);
        }

        $restaurant = $cart->restaurant;

        $cartItems = $cart->items;

        $cartProductIds = $cartItems->pluck('product_id')->toArray();

        $originalTotal = 0;
        $discount = 0;
        $orderOfferDiscount = 0;
        $finalTotal = 0;

        $cartItemOffer = [];

        foreach ($cartItems as $item) {

            $originalTotal +=
                $item->price *
                $item->quantity;
        }

        $offers = Offer::with('products')
        ->where('restaurant_id', $restaurant->id)
        ->where('is_active', 1)
        ->where(function ($q) {

            $q->whereNull('start_date')
                ->orWhereDate('start_date', '<=', now());

        })
        ->where(function ($q) {

            $q->whereNull('end_date')
                ->orWhereDate('end_date', '>=', now());

        })
        ->get();

        foreach ($offers as $offer) {

            $offerProductIds =
                $offer->products->pluck('id')->toArray();

            $allMatched =
                !array_diff($offerProductIds, $cartProductIds);

            if ($allMatched) {

                $offerProductsTotal = 0;

                foreach ($cartItems as $item) {

                    if (in_array($item->product_id, $offerProductIds)) {

                        $offerProductsTotal +=
                            $item->price *
                            $item->quantity;

                        $cartItemOffer[$item->id] = $offer;
                    }
                }

                if ($offer->value_type == 'percent') {

                    $discount +=
                        ($offerProductsTotal * $offer->value) / 100;

                } else {

                    $discount += $offer->value;
                }
            }
        }

        $finalTotal = $originalTotal - $discount;

        $orderOffer = null;

        $completedOrder = Order::where('user_id', auth()->id())
        ->where('restaurant_id', $restaurant->id)
        ->whereIn('status', ['completed', 'delivered'])
        ->exists();

        if ($completedOrder) {

            $orderOffer = OrderOffer::where('restaurant_id', $restaurant->id)
                ->where('status', 'active')
                ->where('min_order_value', '<=', $finalTotal)
                ->first();

            if ($orderOffer) {

                if ($orderOffer->value_type == 'percentage') {

                    $orderOfferDiscount =
                        ($finalTotal * $orderOffer->value) / 100;

                } else {

                    $orderOfferDiscount =
                        $orderOffer->value;
                }

                $discount += $orderOfferDiscount;

                $finalTotal -= $orderOfferDiscount;
            }
        }

        $loyaltyService = app(\App\Services\LoyaltyRewardService::class);
        $activeLoyaltyReward = $loyaltyService->getAvailableReward(auth()->id(), $restaurant->id);
        $loyaltyDiscount = 0;

        if ($activeLoyaltyReward) {
            $loyaltyDiscount = $activeLoyaltyReward->calculateDiscount(max(0, $finalTotal));
            $finalTotal = max(0, $finalTotal - $loyaltyDiscount);
        }

        $serviceCharge = 0.12;
        $deliveryCharge = 0.12;
        $hystCharge = 0.25;

        $finalTotal +=
        $serviceCharge +
        $deliveryCharge +
        $hystCharge;

        return response()->json([

            'status' => true,

            'restaurant' => $restaurant,

            'items' => $cartItems,

            'subtotal' => $originalTotal,

            'discount' => $discount,

            'loyalty_discount' => $loyaltyDiscount,

            'active_loyalty_reward' => $activeLoyaltyReward,

            'service_charge' => $serviceCharge,

            'delivery_charge' => $deliveryCharge,

            'hyst_charge' => $hystCharge,

            'grand_total' => $finalTotal,

            'payment_enabled' =>
                !empty($restaurant->transactworld_member_id) &&
                !empty($restaurant->transactworld_checksum_key),

            'order_offer' => $orderOffer

        ]);
    }

    public function placeOrder(Request $request)
    {
        Log::info('PLACE ORDER START');

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'order_type'     => 'required',
            'payment_method' => 'required',
            'phone'          => 'required_if:payment_method,Cash On Delivery',
            'address'        => 'nullable|required_if:order_type,delivery',
            'pincode'        => 'nullable|required_if:order_type,delivery',
            'booking_date'   => 'nullable|required_if:order_type,table_book|date',
            'booking_time'   => 'nullable|required_if:order_type,table_book',
            'number_of_people' => 'nullable|required_if:order_type,table_book|numeric|min:1',
            'occasion'       => 'nullable|required_if:order_type,table_book',
        ]);

        Log::info('VALIDATION SUCCESS');

        /*
        |--------------------------------------------------------------------------
        | CART
        |--------------------------------------------------------------------------
        */
        $cart = Cart::with([
            'restaurant',
            'items.product.offers',
            'items.variant'
        ])
        ->where('user_id', auth()->id())
        ->first();

        if (!$cart || $cart->items->isEmpty()) {

            return response()->json([
                'status'  => false,
                'message' => 'Your cart is empty.'
            ], 400);
        }

        $restaurant   = $cart->restaurant;
        $restaurantId = $restaurant->id;
        $cartItems    = $cart->items;

        $cartProductIds = $cartItems->pluck('product_id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | TOTALS (same logic as checkout())
        |--------------------------------------------------------------------------
        */
        $originalTotal      = 0;
        $discount           = 0;
        $orderOfferDiscount = 0;

        foreach ($cartItems as $item) {
            $originalTotal += $item->price * $item->quantity;
        }

        $offers = Offer::with('products')
            ->where('restaurant_id', $restaurantId)
            ->where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now());
            })
            ->get();

        $cartItemOffer = [];

        foreach ($offers as $offer) {

            $offerProductIds = $offer->products->pluck('id')->toArray();
            $allMatched = !array_diff($offerProductIds, $cartProductIds);

            if ($allMatched) {

                $offerProductsTotal = 0;

                foreach ($cartItems as $item) {
                    if (in_array($item->product_id, $offerProductIds)) {
                        $offerProductsTotal += $item->price * $item->quantity;
                        $cartItemOffer[$item->id] = $offer;
                    }
                }

                if ($offer->value_type == 'percent') {
                    $discount += ($offerProductsTotal * $offer->value) / 100;
                } else {
                    $discount += $offer->value;
                }
            }
        }

        $finalTotal = $originalTotal - $discount;

        /*
        |--------------------------------------------------------------------------
        | ORDER OFFER (repeat-order discount)
        |--------------------------------------------------------------------------
        */
        $orderOffer = null;

        $completedOrder = Order::where('user_id', auth()->id())
            ->where('restaurant_id', $restaurantId)
            ->whereIn('status', ['completed', 'delivered'])
            ->exists();

        if ($completedOrder) {

            $orderOffer = OrderOffer::where('restaurant_id', $restaurantId)
                ->where('status', 'active')
                ->where('min_order_value', '<=', $finalTotal)
                ->first();

            if ($orderOffer) {

                if ($orderOffer->value_type == 'percentage') {
                    $orderOfferDiscount = ($finalTotal * $orderOffer->value) / 100;
                } else {
                    $orderOfferDiscount = $orderOffer->value;
                }

                $discount   += $orderOfferDiscount;
                $finalTotal -= $orderOfferDiscount;
            }
        }

        $loyaltyService = app(\App\Services\LoyaltyRewardService::class);
        $appliedLoyaltyReward = null;
        $loyaltyRewardDiscount = 0;

        if (auth()->check()) {
            $rewardId = $request->input('loyalty_reward_id');
            if (!$rewardId) {
                $availReward = $loyaltyService->getAvailableReward(auth()->id(), $restaurantId);
                $rewardId = $availReward?->id;
            }

            if ($rewardId) {
                $appliedLoyaltyReward = \App\Models\LoyaltyReward::where('id', $rewardId)
                    ->where('user_id', auth()->id())
                    ->where('restaurant_id', $restaurantId)
                    ->available()
                    ->first();

                if ($appliedLoyaltyReward) {
                    $loyaltyRewardDiscount = $appliedLoyaltyReward->calculateDiscount(max(0, $finalTotal));
                    $discount   += $loyaltyRewardDiscount;
                    $finalTotal  = max(0, $finalTotal - $loyaltyRewardDiscount);
                }
            }
        }

        $serviceCharge  = 0.12;
        $deliveryCharge = 0.12;
        $hystCharge     = 0.25;

        $finalTotal += $serviceCharge + $deliveryCharge + $hystCharge;

        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */
        $addressVal = $request->address;
        $postcodeVal = $request->pincode;

        if ($request->filled('address_id')) {
            $userAddr = UserAddress::find($request->address_id);
            if ($userAddr) {
                $addressVal = $addressVal ?: ($userAddr->address . ($userAddr->city ? ', ' . $userAddr->city : ''));
                $postcodeVal = $postcodeVal ?: $userAddr->postcode;
            }
        }

        if (empty($addressVal) && $request->order_type === 'delivery' && auth()->check()) {
            $defaultAddr = UserAddress::where('user_id', auth()->id())->where('is_default', 1)->first()
                ?? UserAddress::where('user_id', auth()->id())->latest()->first();
            if ($defaultAddr) {
                $addressVal = $defaultAddr->address;
                $postcodeVal = $defaultAddr->postcode;
            }
        }

        $order = Order::create([
            'user_id'           => auth()->id(),
            'restaurant_id'     => $restaurantId,
            'total_amount'      => $finalTotal,
            'service_charge'    => $serviceCharge,
            'delivery_charge'   => $deliveryCharge,
            'hyst_charge'       => $hystCharge,
            'order_type'        => $request->order_type,
            'phone'             => $request->phone,
            'address'           => $addressVal,
            'pincode'           => $postcodeVal,
            'payment_method'    => $request->payment_method,
            'status'            => 'pending',
            'offer_discount'    => $discount,
            'offer_title'       => $orderOffer?->title ?? ($discount > 0 ? 'Offer Discount' : null),
            'loyalty_reward_id' => $appliedLoyaltyReward?->id,
            'loyalty_discount'  => $loyaltyRewardDiscount,
            'delivery_provider' => $restaurant->self_delivery ? 'self' : 'uber',
            'booking_date'      => $request->order_type === 'table_book' ? $request->booking_date : null,
            'booking_time'      => $request->order_type === 'table_book' ? $request->booking_time : null,
            'number_of_people'  => $request->order_type === 'table_book' ? $request->number_of_people : null,
            'occasion'          => $request->order_type === 'table_book' ? $request->occasion : null,
        ]);

        if ($appliedLoyaltyReward && $loyaltyRewardDiscount > 0) {
            $loyaltyService->processRedemption($order, $appliedLoyaltyReward->id, max(0, $originalTotal - $discount + $loyaltyRewardDiscount));
        }

        if (auth()->check()) {
            $loyaltyService->evaluateAndIssueReward($order, $originalTotal);
        }

        Log::info('ORDER CREATED', ['order_id' => $order->id]);

        sendNotification(
            auth()->id(),
            'order_placed',
            'Order Placed Successfully',
            'Your order #' . $order->id . ' has been placed successfully.',
            'order',
            $order->id
        );

        /*
        |--------------------------------------------------------------------------
        | ORDER ITEMS
        |--------------------------------------------------------------------------
        */
        foreach ($cartItems as $item) {

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'variant_id'   => $item->variant_id ?? null,
                'variant_name' => $item->variant->name ?? null,
                'quantity'     => $item->quantity,
                'price'        => $item->price,
                'total'        => $item->price * $item->quantity,
            ]);
        }

        Log::info('ORDER ITEMS SAVED');

        Log::info('FINAL TOTAL', [
            'original_total' => $originalTotal,
            'discount'        => $discount,
            'final_total'     => $order->total_amount,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ENTRY
        |--------------------------------------------------------------------------
        */
        $payment = Payment::create([
            'order_id'       => $order->id,
            'restaurant_id'  => $restaurantId,
            'user_id'        => auth()->id(),
            'payment_method' => $request->payment_method,
            'amount'         => $order->total_amount,
            'payment_status' => $request->payment_method == 'Cash On Delivery'
                ? 'pending'
                : 'paid',
        ]);

        /*
        |--------------------------------------------------------------------------
        | INVOICE
        |--------------------------------------------------------------------------
        */
        $invoice = Invoice::create([
            'order_id'        => $order->id,
            'invoice_number'  => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'restaurant_id'   => $order->restaurant_id,
            'user_id'         => $order->user_id,
            'subtotal'        => $originalTotal,
            'discount'        => $discount,
            'service_charge'  => $serviceCharge,
            'delivery_charge' => $deliveryCharge,
            'hyst_charge'     => $hystCharge,
            'total'           => $finalTotal,
            'invoice_date'    => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFY RESTAURANT ADMIN
        |--------------------------------------------------------------------------
        */
        $restaurantAdmin = User::where('restaurant_id', $order->restaurant_id)
            ->where('role', 'restaurant_admin')
            ->first();

        if ($restaurantAdmin) {

            sendNotification(
                $restaurantAdmin->id,
                'new_order',
                'New Order Received',
                auth()->user()->name . ' placed order #' . $order->id,
                'order',
                $order->id
            );

            $firebase = new FirebaseNotificationService();

            $orderRestaurant = \App\Models\Restaurant::find($order->restaurant_id);
            $restSoundFile = $orderRestaurant?->notification_sound ?? 'hyst_notification.mp3';
            $restSoundUrl = asset('sounds/' . $restSoundFile);

            $restaurantAdmins = User::where('restaurant_id', $order->restaurant_id)
                ->whereNotNull('fcm_token')
                ->where('fcm_token', '!=', '')
                ->get();

            $sentTokenMap = [];
            foreach ($restaurantAdmins as $admin) {
                $sentTokenMap[$admin->fcm_token] = true;
                $firebase->send(
                    $admin->fcm_token,
                    'New Order Received! 🛍️',
                    'You received a new order #' . $order->id . ' for £' . number_format($order->total_amount ?? $order->amount ?? 0, 2) . '.',
                    '/restaurant/orders',
                    $restSoundUrl
                );
            }

            if (!empty($restaurantAdmin->fcm_token) && empty($sentTokenMap[$restaurantAdmin->fcm_token])) {
                $firebase->send(
                    $restaurantAdmin->fcm_token,
                    'New Order Received! 🛍️',
                    'You received a new order #' . $order->id . ' for £' . number_format($order->total_amount ?? $order->amount ?? 0, 2) . '.',
                    '/restaurant/orders',
                    $restSoundUrl
                );
            }
        }

        Log::info('PAYMENT CREATED');

        /*
        |--------------------------------------------------------------------------
        | STUART DELIVERY
        |--------------------------------------------------------------------------
        */
        if ($request->order_type == 'delivery') {

            $stuart = new StuartService();

            $order->load('user');

            $delivery = $stuart->createDelivery($order, $restaurant);

            Log::info('DELIVERY RESPONSE', ['delivery' => $delivery]);

            if ($delivery) {

                $order->update([
                    'stuart_job_id'   => $delivery['id'] ?? null,
                    'tracking_url'    => $delivery['deliveries'][0]['tracking_url'] ?? null,
                    'delivery_status' => $delivery['status'] ?? 'searching',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR CART
        |--------------------------------------------------------------------------
        */
        $cart->items()->delete();
        $cart->delete();

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */
        return response()->json([
            'status'  => true,
            'message' => 'Order Placed Successfully',
            'order'   => $order->load('items'),
            'invoice' => $invoice,
            'payment' => $payment,
        ]);
    }


    public function driverWebhook(Request $request)
    {
        try {

            Log::info('STUART WEBHOOK RECEIVED', $request->all());

            $data = $request->input('data');

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'No data found.'
                ], 400);
            }

            $clientReference = $data['clientReference'] ?? null;

            if (!$clientReference) {
                return response()->json([
                    'status' => false,
                    'message' => 'Client reference missing.'
                ], 400);
            }

            // Example: ORDER-123
            $orderId = str_replace('ORDER-', '', $clientReference);

            $order = Order::find($orderId);

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found.'
                ], 404);
            }

            $driver = $data['driver'] ?? [];

            $status = $data['status'] ?? $order->delivery_status;

            $order->update([
                'delivery_status' => $status,

                'tracking_url' => $data['trackingUrl'] ?? $order->tracking_url,

                'driver_name' => $driver['name'] ?? $order->driver_name,

                'driver_phone' => $driver['phone'] ?? $order->driver_phone,

                'driver_id' => $driver['id'] ?? $order->driver_id,

                'picked_at' => in_array($status, ['picking', 'in_transit'])
                    ? now()
                    : $order->picked_at,

                'delivered_at' => $status === 'delivered'
                    ? now()
                    : $order->delivered_at,
            ]);

            Log::info('ORDER DELIVERY UPDATED', [
                'order_id' => $order->id,
                'delivery_status' => $status,
                'driver_name' => $driver['name'] ?? null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Webhook processed successfully.',
                'order_id' => $order->id,
                'delivery_status' => $status
            ]);

        } catch (\Exception $e) {

            Log::error('STUART WEBHOOK ERROR', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ], 500);
        }
    }

    public function myOrders()
    {
        $orders = Order::with([
            'restaurant',
            'payment'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully.',
            'data' => $orders
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with([
            'items.product',
            'items.variant',
            'payment',
            'restaurant',
            'review',
            'invoice'
        ])
        ->where('user_id', auth()->id())
        ->find($id);

        if (!$order) {

            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $messages = Message::where('order_id', $order->id)
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->latest()
            ->get();

        $complaints = Complaint::where('order_id', $order->id)
            ->latest()
            ->get();

        $customerEvidence = OrderCompletionEvidence::where('order_id', $order->id)
            ->where('uploader_type', 'customer')
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'Order details fetched successfully.',
            'data' => [
                'order' => $order,
                'messages' => $messages,
                'complaints' => $complaints,
                'customer_evidence' => $customerEvidence
            ]
        ]);
    }

    public function orderStatus($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order status fetched successfully.',
            'data' => [
                'order_id' => $order->id,
                'status' => $order->status,
                'delivery_status' => $order->delivery_status,
            ]
        ]);
    }

    public function transactions()
    {
        $payments = Payment::with([
            'restaurant',
            'order'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Transactions fetched successfully.',
            'data' => $payments
        ]);
    }
    public function submitReview(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $already = Review::where('order_id', $order->id)->exists();

        if ($already) {
            return response()->json([
                'status' => false,
                'message' => 'Review already submitted.'
            ], 400);
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $order->restaurant_id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'pending'
        ]);

        $restaurantAdmin = User::where('restaurant_id', $order->restaurant_id)
            ->where('role', 'restaurant_admin')
            ->first();

        if ($restaurantAdmin) {

            sendNotification(
                $restaurantAdmin->id,
                'review_pending',
                'New Review Received',
                auth()->user()->name . ' submitted a ' . $request->rating . '★ review.',
                'review',
                $review->id
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Review submitted successfully.',
            'data' => $review
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::with('payment')
            ->where('user_id', auth()->id())
            ->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $blockedStatuses = [
            'waiting_at_pickup',
            'picking',
            'in_transit',
            'delivered'
        ];

        if (in_array($order->delivery_status, $blockedStatuses)) {

            return response()->json([
                'status' => false,
                'message' => 'Order cannot be cancelled after pickup has started.'
            ], 400);
        }

        if ($order->delivery_status == 'canceled') {

            return response()->json([
                'status' => false,
                'message' => 'Order already cancelled.'
            ], 400);
        }

        if (!empty($order->uber_delivery_id) && $order->uber_delivery_status !== 'canceled') {
            try {
                $uber = new UberService();
                $uber->cancelDelivery($order->uber_delivery_id, 'Customer cancelled order via API');
            } catch (\Throwable $e) {
                Log::error('Uber Cancel Delivery Failed in Api OrderController', [
                    'order_id' => $order->id,
                    'uber_delivery_id' => $order->uber_delivery_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $order->update([
            'delivery_status' => 'canceled',
            'uber_delivery_status' => 'canceled',
            'status' => 'cancelled'
        ]);

        sendNotification(
            auth()->id(),
            'order_cancelled',
            'Order Cancelled',
            'Your order #' . $order->id . ' has been cancelled.',
            'order',
            $order->id
        );

        $restaurantAdmin = User::where('restaurant_id', $order->restaurant_id)
            ->where('role', 'restaurant_admin')
            ->first();

        if ($restaurantAdmin) {

            sendNotification(
                $restaurantAdmin->id,
                'order_cancelled',
                'Order Cancelled',
                auth()->user()->name . ' cancelled order #' . $order->id,
                'order',
                $order->id
            );
        }

        if ($order->payment) {

            $order->payment->update([
                'payment_status' => 'cancelled'
            ]);

            if ($order->payment->payment_method != 'Cash On Delivery') {

                sendNotification(
                    auth()->id(),
                    'refund_pending',
                    'Refund Pending',
                    'Your refund for order #' . $order->id . ' is pending.',
                    'order',
                    $order->id
                );
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }

    public function customerLoyaltyRewards()
    {
        $rewards = \App\Models\LoyaltyReward::with(['restaurant', 'earnedFromOrder'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $rewards,
        ]);
    }

    public function uploadCustomerEvidence(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::where('user_id', auth()->id())
            ->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $exists = OrderCompletionEvidence::where('order_id', $order->id)
            ->where('uploader_type', 'customer')
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Evidence already uploaded.'
            ], 400);
        }

        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();

        $request->file('photo')->move(
            public_path('order-evidence'),
            $photoName
        );

        $evidence = OrderCompletionEvidence::create([
            'order_id' => $order->id,
            'uploader_type' => 'customer',
            'photo' => 'order-evidence/' . $photoName,
            'description' => $request->description,
        ]);

        sendNotification(
            auth()->id(),
            'evidence_uploaded',
            'Evidence Submitted',
            'Evidence uploaded successfully.',
            'order',
            $order->id
        );

        $restaurantAdmin = User::where('restaurant_id', $order->restaurant_id)
            ->where('role', 'restaurant_admin')
            ->first();

        if ($restaurantAdmin) {

            sendNotification(
                $restaurantAdmin->id,
                'customer_evidence',
                'Customer Uploaded Evidence',
                auth()->user()->name . ' uploaded evidence for order #' . $order->id,
                'order',
                $order->id
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Evidence uploaded successfully.',
            'data' => $evidence
        ]);
    }
}