<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use App\Models\ProductVariant;
use App\Models\ProductAddon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\Http;
use App\Models\OrderCompletionEvidence;
use App\Services\WorldpayService;
use App\Services\UberService;
use App\Services\VerifonePosService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected WorldpayService $worldpay;
    protected VerifonePosService $verifone;

    public function __construct(WorldpayService $worldpay, VerifonePosService $verifone)
    {
        $this->worldpay = $worldpay;
        $this->verifone = $verifone;
    }
    /*
    |--------------------------------------------------------------------------
    | ORDER LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->latest()
            ->get();

        return view(
            'restaurant.orders.index',
            compact('orders')
        );
    }

    // public function allOrders()
    // {
    //     $orders = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //         ->latest()
    //         ->get();

    //     return view(
    //         'restaurant.orders.create',
    //         compact('orders')
    //     );
    // }

    public function allOrders(Request $request)
    {
        $search = $request->search;

        $orders = Order::with('user')
            ->where('restaurant_id', auth()->user()->restaurant_id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'restaurant.orders.create',
            compact('orders', 'search')
        );
    }




    public function uploadEvidence(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp',
            'description' => 'required|string|max:1000',
        ]);

        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->findOrFail($id);

        // allow only one upload
        $exists = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'restaurant'
        )->exists();

        if ($exists) {
            return back()->with(
                'error',
                'Evidence already uploaded.'
            );
        }

        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();

        $request->file('photo')->move(
            public_path('order-evidence'),
            $photoName
        );

        $photo = 'order-evidence/' . $photoName;

        OrderCompletionEvidence::create([
            'order_id'      => $order->id,
            'uploader_type' => 'restaurant',
            'photo'         => $photo,
            'description'   => $request->description,
        ]);

        sendNotification(
            $order->user_id,
            'restaurant_evidence',
            'Restaurant Uploaded Evidence',
            'Restaurant uploaded delivery evidence for order #' . $order->id,
            'order',
            $order->id,
            $order->id
        );

        sendNotification(
            auth()->id(),
            'evidence_uploaded',
            'Evidence Uploaded',
            'Evidence uploaded successfully for order #' . $order->id,
            'order',
            $order->id,
            $order->id
        );
        return back()->with(
            'success',
            'Evidence uploaded successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */

    // public function show($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //         ->with([
    //             'user',
    //             'items.product',
    //             'payment'
    //         ])
    //         ->findOrFail($id);

    //     return view(
    //         'restaurant.orders.show',
    //         compact('order')
    //     );
    // }

    public function show($id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
        ->with([
            'user',
            'restaurant',
            'items.product',
            'items.addons',
            'payment',
            'review',
            'invoice',
            'loyaltyReward',
            'earnedLoyaltyReward'
        ])
        ->findOrFail($id);

        $complaints = Complaint::where('order_id', $order->id)
        ->latest()
        ->get();

        $restaurantEvidence = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'restaurant'
        )->first();
		
		$customerEvidence = OrderCompletionEvidence::where(
			'order_id',
			$order->id
		)->where(
			'uploader_type',
			'customer'
		)->first();

        return view(
            'restaurant.orders.show',
            compact('order','complaints','restaurantEvidence' , 'customerEvidence')
        );
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([

            'message' => 'required'

        ]);

        $order = Order::findOrFail($id);

        $message = Message::create([

            'sender_id' => auth()->id(),

            'receiver_id' => $order->user_id,

            'order_id' => $order->id,

            'message' => $request->message,

            'is_read' => 0

        ]);

        sendNotification(

            $order->user_id,

            'new_message',

            'New Message From Restaurant',

            'You received a new message regarding order #' .
            $order->id,

            'order',

            $order->id,

            $order->id
        );

        return back()->with(
            'success',
            'Message Sent Successfully'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    // public function updateStatus(Request $request, $id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //     ->findOrFail($id);

    //     $order->update([

    //         'status' => $request->status

    //     ]);

    //     return back()->with(
    //         'success',
    //         'Order Status Updated'
    //     );
    // }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER STATUS
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'status' => 'required',
            'cancel_reason' => 'required_if:status,cancelled|max:500',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'cancelled') {
            $data['cancel_reason'] = $request->cancel_reason;
            $data['cancelled_by'] = 'restaurant';
            $data['delivery_status'] = 'canceled';
            $data['uber_delivery_status'] = 'canceled';

            if (!empty($order->uber_delivery_id) && $order->uber_delivery_status !== 'canceled') {
                try {
                    $uber = new UberService();
                    $uber->cancelDelivery($order->uber_delivery_id, $request->cancel_reason ?? 'Restaurant cancelled order');
                } catch (\Throwable $e) {
                    Log::error('Uber Cancel Delivery Failed in RestaurantAdmin OrderController', [
                        'order_id' => $order->id,
                        'uber_delivery_id' => $order->uber_delivery_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $order->update($data);

        $referralService = app(\App\Services\ReferralService::class);
        if ($request->status === 'completed') {
            $referralService->processOrderCompletion($order);
            if ($order->user) {
                $referralService->getOrCreateCodeForUser($order->user, $order->restaurant_id);
            }
        } elseif ($request->status === 'cancelled') {
            $referralService->processOrderCancellation($order);
        }

        if ($request->status === 'accepted') {
            if ($order->restaurant && $order->restaurant->verifone_enabled) {
                try {
                    $this->verifone->printReceipt($order, 'CUSTOMERRECEIPT');
                } catch (\Throwable $e) {
                    Log::error('Verifone POS Receipt Printing Failed on Order Acceptance', [
                        'order_id' => $order->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }



        // $order->update([

        //     'status' => $request->status,

        // ]);

        $statusMessages = [

            'pending' => 'Your order has been placed.',

            'accepted' => 'Restaurant accepted your order.',

            'completed' => 'Your order has been completed.',

            'cancelled' => 'Your order has been cancelled.',
        ];

        sendNotification(

            $order->user_id,

            'order_status',

            'Order Update',

            $statusMessages[$request->status]
                ?? ('Order status changed to ' . $request->status),

            'order',

            $order->id,

            $order->id
        );

        if ($order->user && !empty($order->user->fcm_token)) {
            Log::info('SEND ORDER STATUS FCM TO USER', ['user_id' => $order->user_id, 'status' => $request->status]);

            $title = 'Order Status Update';
            $body = 'Your order #' . $order->id . ' status is now ' . strtoupper($request->status) . '.';

            if (in_array(strtolower($request->status), ['accepted', 'preparing'])) {
                $title = 'Order Accepted! 🍳';
                $body = 'Your order #' . $order->id . ' has been accepted by the restaurant and is now being prepared!';
            } elseif (in_array(strtolower($request->status), ['completed', 'delivered'])) {
                $title = 'Order Received! 🍽️';
                $body = 'Your order #' . $order->id . ' has been delivered. Enjoy your meal!';
            } elseif (strtolower($request->status) == 'cancelled') {
                $title = 'Order Cancelled';
                $body = 'Your order #' . $order->id . ' was cancelled by the restaurant.';
            }

            $firebase = new FirebaseNotificationService();
            $firebase->send($order->user->fcm_token, $title, $body, '/my-orders');
        }
       


        /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDER
        |--------------------------------------------------------------------------
        */

                /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDER
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'cancelled') {

            $payment = $order->payment;

            if (
                $payment &&
                !empty($payment->payment_transaction_id) &&
                !in_array($payment->payment_status, ['refunded'])
            ) {
                try {

                    $restaurant = $order->restaurant;

                    $token = $this->worldpay->login($restaurant);

                    // Refund FULL amount
                    $this->worldpay->refundPayment(
                        $restaurant,
                        $token,
                        $payment->payment_transaction_id,
                        $payment->amount, // Full payment amount
                        $payment->payment_type,
                        "Full refund for cancelled Order #{$order->id}"
                    );

                    DB::transaction(function () use ($payment) {

                        $payment->refunded_amount = $payment->amount;

                        $payment->payment_status = 'refunded';

                        $payment->save();

                    });

                } catch (\Exception $e) {

                    Log::error('Refund Failed', [
                        'order_id' => $order->id,
                        'message' => $e->getMessage()
                    ]);

                    return back()->with(
                        'error',
                        'Order was cancelled but refund failed: ' . $e->getMessage()
                    );
                }
            }
        }



        return back()->with(
            'success',
            'Order Status Updated Successfully'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE DIRECT / OFFLINE ORDER (RESTAURANT POS)
    |--------------------------------------------------------------------------
    */
    public function createOrder(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $categories = Category::where(function ($q) use ($restaurantId) {
            $q->where('restaurant_id', $restaurantId)->orWhereNull('restaurant_id');
        })
        ->where('status', 1)
        ->orderBy('name')
        ->get();

        $products = Product::with(['category', 'variants', 'addons'])
            ->where('restaurant_id', $restaurantId)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $customers = User::whereHas('orders', function ($q) use ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        })
        ->select('id', 'name', 'email', 'phone')
        ->limit(20)
        ->get();

        return view('restaurant.orders.create_order', compact('categories', 'products', 'customers'));
    }

    public function storeOfflineOrder(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $request->validate([
            'order_type' => 'required|in:dine_in',
            'payment_method' => 'required|string',
            'payment_status' => 'required|in:pending,paid',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'table_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'pincode' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer',
            'items.*.addons' => 'nullable|array',
            'notes' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request, $restaurantId) {
            $totalAmount = 0;
            $itemsData = [];

            foreach ($request->items as $itemInput) {
                $product = Product::where('restaurant_id', $restaurantId)->findOrFail($itemInput['product_id']);

                $unitPrice = (float) $product->price;
                $variantName = null;
                $variantId = null;

                if (!empty($itemInput['variant_id'])) {
                    $variant = ProductVariant::where('product_id', $product->id)->find($itemInput['variant_id']);
                    if ($variant) {
                        $unitPrice = (float) $variant->price;
                        $variantName = $variant->name;
                        $variantId = $variant->id;
                    }
                }

                $addonTotal = 0;
                $addonsList = [];
                if (!empty($itemInput['addons']) && is_array($itemInput['addons'])) {
                    $addons = ProductAddon::where(function($q) use ($product) {
                            $q->where('restaurant_id', $product->restaurant_id)
                              ->orWhere('product_id', $product->id);
                        })
                        ->whereIn('id', $itemInput['addons'])
                        ->get();
                    foreach ($addons as $ad) {
                        $addonTotal += (float) $ad->price;
                        $addonsList[] = [
                            'addon_id' => $ad->id,
                            'category_name' => $ad->category_name ?? 'Addon',
                            'addon_name' => $ad->addon_name,
                            'price' => (float) $ad->price,
                        ];
                    }
                }

                $itemUnitPrice = $unitPrice + $addonTotal;
                $qty = (int) $itemInput['quantity'];
                $itemSubtotal = $itemUnitPrice * $qty;
                $totalAmount += $itemSubtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'variant_id' => $variantId,
                    'variant_name' => $variantName,
                    'quantity' => $qty,
                    'price' => $itemUnitPrice,
                    'total' => $itemSubtotal,
                    'addons' => $addonsList,
                ];
            }

            $user = null;
            if ($request->filled('user_id')) {
                $user = User::find($request->user_id);
            } elseif ($request->filled('customer_email')) {
                $user = User::where('email', $request->customer_email)->first();
            }

            $addressVal = $request->address;
            if ($request->order_type === 'dine_in' && $request->filled('table_number')) {
                $addressVal = 'Table ' . $request->table_number;
            } elseif (empty($addressVal)) {
                $restaurant = \App\Models\Restaurant::find($restaurantId);
                $addressVal = $restaurant ? $restaurant->address : 'Counter / In-House';
            }

            $isVerifone = ($request->payment_method === 'verifone_pos');
            $initialOrderStatus = ($request->payment_status === 'paid' && !$isVerifone) ? 'completed' : 'pending';

            $order = Order::create([
                'user_id' => $user?->id,
                'is_guest' => !$user,
                'guest_name' => $request->customer_name,
                'guest_email' => $request->customer_email,
                'guest_phone' => $request->customer_phone,
                'guest_address' => $request->address,
                'guest_postcode' => $request->pincode,
                'restaurant_id' => $restaurantId,
                'total_amount' => $totalAmount,
                'service_charge' => 0,
                'delivery_charge' => 0,
                'hyst_charge' => 0,
                'product_charge' => 0,
                'order_type' => $request->order_type,
                'phone' => $request->customer_phone,
                'address' => $addressVal,
                'pincode' => $request->pincode,
                'payment_method' => $request->payment_method,
                'status' => $initialOrderStatus,
                'order_from' => 'restaurant_pos',
                'description' => $request->notes,
            ]);

            foreach ($itemsData as $itemData) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'variant_id' => $itemData['variant_id'],
                    'variant_name' => $itemData['variant_name'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemData['total'],
                ]);

                foreach ($itemData['addons'] as $addonInfo) {
                    OrderItemAddon::create([
                        'order_item_id' => $orderItem->id,
                        'addon_id' => $addonInfo['addon_id'],
                        'category_name' => $addonInfo['category_name'],
                        'addon_name' => $addonInfo['addon_name'],
                        'price' => $addonInfo['price'],
                    ]);
                }
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'restaurant_id' => $restaurantId,
                'user_id' => $user?->id,
                'payment_method' => $request->payment_method,
                'payment_type' => 'Offline',
                'amount' => $totalAmount,
                'payment_status' => ($isVerifone && $request->payment_status === 'paid') ? 'pending' : $request->payment_status,
            ]);

            // Handle Verifone POS Machine Terminal Payment (ONLY when Paid Now)
            if ($isVerifone && $request->payment_status === 'paid') {
                $order->load(['restaurant', 'items.product', 'items.addons', 'user']);
                $verifoneRes = $this->verifone->processSalePayment($order, $totalAmount);

                if ($verifoneRes['success']) {
                    $payment->update([
                        'payment_status'     => 'paid',
                        'poi_transaction_id' => $verifoneRes['poi_transaction_id'] ?? null,
                        'poi_timestamp'      => $verifoneRes['poi_timestamp'] ?? null,
                        'masked_pan'         => $verifoneRes['masked_pan'] ?? null,
                        'card_brand'         => $verifoneRes['card_brand'] ?? null,
                        'auth_code'          => $verifoneRes['auth_code'] ?? null,
                        'nexo_service_id'    => $verifoneRes['service_id'] ?? null,
                    ]);

                    $order->update(['status' => 'completed']);

                    // Print receipt on terminal
                    try {
                        $this->verifone->printReceipt($order, 'CUSTOMERRECEIPT');
                    } catch (\Throwable $e) {
                        Log::error('Verifone POS Print Failed after storeOfflineOrder', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }

                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success'      => true,
                            'message'      => 'Payment approved on Verifone terminal!',
                            'order_id'     => $order->id,
                            'redirect_url' => route('restaurant.orders.show', $order->id),
                        ]);
                    }

                    return redirect()->route('restaurant.orders.show', $order->id)
                        ->with('success', 'Order #' . $order->id . ' paid & created via Verifone POS.');
                } else {
                    $payment->update(['payment_status' => 'failed']);
                    $order->update(['status' => 'cancelled', 'cancel_reason' => 'Verifone payment failed: ' . ($verifoneRes['error'] ?? 'Declined')]);

                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Transaction declined.'),
                        ], 400);
                    }

                    return back()->with('error', 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Declined on terminal.'))->withInput();
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'Order created successfully.',
                    'order_id'     => $order->id,
                    'redirect_url' => route('restaurant.orders.show', $order->id),
                ]);
            }

            return redirect()->route('restaurant.orders.show', $order->id)
                ->with('success', 'Manual Direct Order #' . $order->id . ' created successfully.');
        });
    }

    public function storeMiscellaneousOrder(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:999999',
            'description'    => 'nullable|string|max:500',
            'payment_method' => 'required|string',
            'payment_status' => 'required|in:pending,paid',
            'customer_name'  => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'table_number'   => 'nullable|string|max:50',
        ]);

        return DB::transaction(function () use ($request, $restaurantId) {
            $amount = (float) $request->amount;
            $customerName = $request->filled('customer_name') ? $request->customer_name : 'Walk-in Guest';
            $orderDesc = $request->filled('description') 
                ? '[Misc Charge] ' . $request->description 
                : 'Miscellaneous / Custom POS Charge';

            $table = $request->filled('table_number') ? 'Table ' . $request->table_number : 'Counter / Direct Charge';

            $isVerifone = ($request->payment_method === 'verifone_pos');
            $initialOrderStatus = ($request->payment_status === 'paid' && !$isVerifone) ? 'completed' : 'pending';

            // Ensure a designated Misc Product exists for this restaurant to guarantee DB foreign key & order view integrity
            $category = Category::where(function ($q) use ($restaurantId) {
                $q->where('restaurant_id', $restaurantId)->orWhereNull('restaurant_id');
            })->where('status', 1)->first();

            $miscProduct = Product::firstOrCreate(
                [
                    'restaurant_id' => $restaurantId,
                    'name'          => 'Miscellaneous / Custom Charge',
                ],
                [
                    'category_id'   => $category?->id ?? 1,
                    'slug'          => 'misc-charge-' . $restaurantId . '-' . time(),
                    'description'   => 'Direct miscellaneous / custom offline order charge',
                    'price'         => 0.00,
                    'currency'      => 'GBP',
                    'status'        => 0, // Hidden from online storefront menus
                    'product_type'  => 'veg',
                ]
            );

            // Create Order with dummy data
            $order = Order::create([
                'user_id'        => null,
                'is_guest'       => true,
                'guest_name'     => $customerName,
                'guest_email'    => null,
                'guest_phone'    => $request->customer_phone,
                'restaurant_id'  => $restaurantId,
                'total_amount'   => $amount,
                'service_charge' => 0,
                'delivery_charge'=> 0,
                'hyst_charge'    => 0,
                'product_charge' => 0,
                'order_type'     => 'dine_in',
                'phone'          => $request->customer_phone,
                'address'        => $table,
                'payment_method' => $request->payment_method,
                'status'         => $initialOrderStatus,
                'order_from'     => 'restaurant_pos',
                'description'    => $orderDesc,
            ]);

            // Create OrderItem
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $miscProduct->id,
                'variant_name' => $request->description ? substr($request->description, 0, 100) : 'Custom Charge',
                'quantity'     => 1,
                'price'        => $amount,
                'total'        => $amount,
            ]);

            // Create Payment
            $payment = Payment::create([
                'order_id'       => $order->id,
                'restaurant_id'  => $restaurantId,
                'user_id'        => null,
                'payment_method' => $request->payment_method,
                'payment_type'   => 'Offline',
                'amount'         => $amount,
                'payment_status' => $isVerifone ? 'pending' : $request->payment_status,
            ]);

            // Verifone POS Machine Terminal Payment
            if ($isVerifone) {
                $order->load(['restaurant', 'items.product', 'items.addons']);
                $verifoneRes = $this->verifone->processSalePayment($order, $amount);

                if ($verifoneRes['success']) {
                    $payment->update([
                        'payment_status'     => 'paid',
                        'poi_transaction_id' => $verifoneRes['poi_transaction_id'] ?? null,
                        'poi_timestamp'      => $verifoneRes['poi_timestamp'] ?? null,
                        'masked_pan'         => $verifoneRes['masked_pan'] ?? null,
                        'card_brand'         => $verifoneRes['card_brand'] ?? null,
                        'auth_code'          => $verifoneRes['auth_code'] ?? null,
                        'nexo_service_id'    => $verifoneRes['service_id'] ?? null,
                    ]);

                    $order->update(['status' => 'completed']);

                    // Print receipt on terminal
                    try {
                        $this->verifone->printReceipt($order, 'CUSTOMERRECEIPT');
                    } catch (\Throwable $e) {
                        Log::error('Verifone POS Print Failed after storeMiscellaneousOrder', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }

                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success'      => true,
                            'message'      => 'Payment approved on Verifone terminal!',
                            'order_id'     => $order->id,
                            'redirect_url' => route('restaurant.orders.show', $order->id),
                        ]);
                    }

                    return redirect()->route('restaurant.orders.show', $order->id)
                        ->with('success', 'Order #' . $order->id . ' paid & created via Verifone POS.');
                } else {
                    $payment->update(['payment_status' => 'failed']);
                    $order->update(['status' => 'cancelled', 'cancel_reason' => 'Verifone payment failed: ' . ($verifoneRes['error'] ?? 'Declined')]);

                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Transaction declined.'),
                        ], 400);
                    }

                    return back()->with('error', 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Declined on terminal.'))->withInput();
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'Miscellaneous Order #' . $order->id . ' created successfully.',
                    'order_id'     => $order->id,
                    'redirect_url' => route('restaurant.orders.show', $order->id),
                ]);
            }

            return redirect()->route('restaurant.orders.show', $order->id)
                ->with('success', 'Miscellaneous Order #' . $order->id . ' created successfully.');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | DIRECT DELIVERY VIA UBER DIRECT & WORLDPAY (RESTAURANT PORTAL)
    |--------------------------------------------------------------------------
    */

    public function createDirectDelivery(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant = \App\Models\Restaurant::findOrFail($restaurantId);

        $categories = Category::where(function ($q) use ($restaurantId) {
            $q->where('restaurant_id', $restaurantId)->orWhereNull('restaurant_id');
        })
        ->where('status', 1)
        ->orderBy('name')
        ->get();

        $products = Product::where('restaurant_id', $restaurantId)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('restaurant.orders.create_direct_delivery', compact('restaurant', 'categories', 'products'));
    }

    public function getDirectDeliveryQuote(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant = \App\Models\Restaurant::findOrFail($restaurantId);

        $request->validate([
            'dropoff_name'     => 'required|string|max:255',
            'dropoff_phone'    => 'required|string|max:50',
            'dropoff_address'  => 'required|string|max:500',
            'dropoff_city'     => 'required|string|max:100',
            'dropoff_postcode' => 'required|string|max:20',
            'order_value'      => 'nullable|numeric|min:0',
        ]);

        if (empty($restaurant->address) || empty($restaurant->postcode)) {
            return response()->json([
                'success' => false,
                'message' => 'Your restaurant address or postcode is missing in profile. Please update restaurant address first.',
            ], 422);
        }

        try {
            $uber = new UberService();

            $checkout = [
                'address'   => $request->dropoff_address,
                'city'      => $request->dropoff_city,
                'state'     => $request->dropoff_state ?? '',
                'country'   => $request->dropoff_country ?? 'GB',
                'postcode'  => $request->dropoff_postcode,
                'latitude'  => (float) ($request->dropoff_latitude ?? 0),
                'longitude' => (float) ($request->dropoff_longitude ?? 0),
                'amount'    => (float) ($request->order_value ?? 10.00),
            ];

            $quote = $uber->quoteFromCheckout($restaurant, null, $checkout);

            Log::info('Direct Delivery Uber Quote Response', [
                'restaurant_id' => $restaurantId,
                'quote'         => $quote,
            ]);

            if (empty($quote) || (isset($quote['kind']) && $quote['kind'] === 'error') || !empty($quote['code'])) {
                $errMessage = $quote['message'] ?? 'Unable to obtain Uber delivery quote. Please verify the destination address and postcode.';
                return response()->json([
                    'success' => false,
                    'message' => $errMessage,
                    'data'    => $quote,
                ], 400);
            }

            $rawFee = $quote['fee'] ?? 0;
            // Uber returns fee in minor currency unit (pence)
            $uberFee = ($rawFee > 50 && is_numeric($rawFee)) ? round($rawFee / 100, 2) : (float) $rawFee;
            $markupFee = round($uberFee * 0.20, 2); // 20% platform markup
            $totalFee = round($uberFee + $markupFee, 2);

            return response()->json([
                'success'      => true,
                'quote_id'     => $quote['id'] ?? null,
                'uber_fee'     => number_format($uberFee, 2, '.', ''),
                'markup_fee'   => number_format($markupFee, 2, '.', ''),
                'total_fee'    => number_format($totalFee, 2, '.', ''),
                'expires_at'   => $quote['expires'] ?? null,
                'duration_min' => $quote['duration'] ?? null,
                'eta'          => isset($quote['dropoff_eta']) ? date('H:i', strtotime($quote['dropoff_eta'])) : null,
            ]);

        } catch (\Throwable $e) {
            Log::error('Direct Delivery Quote Exception', [
                'restaurant_id' => $restaurantId,
                'message'       => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error connecting to Uber Direct: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeDirectDelivery(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant = \App\Models\Restaurant::findOrFail($restaurantId);

        $request->validate([
            'items_text'            => 'required|string|max:2000',
            'order_value'           => 'nullable|numeric|min:0',
            'customer_name'         => 'required|string|max:255',
            'customer_phone'        => 'required|string|max:50',
            'address'               => 'required|string|max:500',
            'city'                  => 'required|string|max:100',
            'postcode'              => 'required|string|max:20',
            'uber_quote_id'         => 'required|string',
            'uber_base_fee'         => 'required|numeric|min:0',
            'total_delivery_charge' => 'required|numeric|min:0.01',
            'notes'                 => 'nullable|string|max:500',
            'deliverable_action'    => 'nullable|string',
            'undeliverable_action'  => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request, $restaurant) {
            $totalAmount = (float) $request->total_delivery_charge;
            $uberBaseFee = (float) $request->uber_base_fee;
            $markupFee = round($totalAmount - $uberBaseFee, 2);

            $order = Order::create([
                'restaurant_id'        => $restaurant->id,
                'user_id'              => auth()->id(),
                'is_guest'             => true,
                'guest_name'           => $request->customer_name,
                'guest_phone'          => $request->customer_phone,
                'guest_address'        => $request->address,
                'guest_city'           => $request->city,
                'guest_postcode'       => $request->postcode,
                'guest_country'        => $request->country ?? 'GB',
                'address'              => $request->address . ', ' . $request->city . ' ' . $request->postcode,
                'phone'                => $request->customer_phone,
                'pincode'              => $request->postcode,
                'order_type'           => 'direct_delivery',
                'total_amount'         => $totalAmount,
                'delivery_charge'      => $totalAmount,
                'uber_base_fee'        => $uberBaseFee,
                'uber_markup_fee'      => $markupFee,
                'items_text'           => $request->items_text,
                'status'               => 'pending',
                'delivery_provider'    => 'uber',
                'payment_method'       => 'worldpay',
                'uber_quote_id'        => $request->uber_quote_id,
                'deliverable_action'   => $request->deliverable_action ?? 'deliverable_action_meet_at_door',
                'undeliverable_action' => $request->undeliverable_action ?? 'leave_at_door',
                'dropoff_notes'        => $request->notes ?? 'Direct Delivery via Restaurant',
            ]);

            $reference = 'DD-ORDER-' . $order->id . '-' . time();

            $payment = Payment::create([
                'order_id'       => $order->id,
                'restaurant_id'  => $restaurant->id,
                'user_id'        => auth()->id(),
                'payment_method' => 'worldpay',
                'transaction_id' => $reference,
                'amount'         => $totalAmount,
                'payment_status' => 'pending',
                'checkout_data'  => json_encode([
                    'order_type'            => 'direct_delivery',
                    'order_id'              => $order->id,
                    'uber_quote_id'         => $request->uber_quote_id,
                    'items_text'            => $request->items_text,
                    'customer_name'         => $request->customer_name,
                    'customer_phone'        => $request->customer_phone,
                    'address'               => $request->address,
                    'city'                  => $request->city,
                    'postcode'              => $request->postcode,
                    'order_value'           => $request->order_value,
                    'notes'                 => $request->notes,
                    'deliverable_action'    => $request->deliverable_action ?? 'deliverable_action_meet_at_door',
                    'undeliverable_action'  => $request->undeliverable_action ?? 'leave_at_door',
                    'total_delivery_charge' => $totalAmount,
                ]),
            ]);

            try {
                $accessToken = $this->worldpay->login($restaurant);
                $hppData = [
                    'order_id'      => $order->id,
                    'reference'     => $reference,
                    'amount'        => $totalAmount,
                    'name'          => $restaurant->name ?? auth()->user()->name,
                    'email'         => $restaurant->email ?? auth()->user()->email,
                    'phone'         => $restaurant->phone ?? auth()->user()->phone ?? '',
                    'address'       => $restaurant->address ?? 'Main Street',
                    'city'          => $restaurant->city ?? 'London',
                    'postcode'      => $restaurant->postcode ?? 'SW1A 1AA',
                    'country'       => 'GB',
                    'user_id'       => auth()->id(),
                    'description'   => 'Direct Delivery Courier Fee for Order #' . $order->id,
                    'return_url'    => route('restaurant.orders.direct_delivery_callback'),
                    'disbursements' => [
                        [
                            "BusinessId" => 24785, // HYST Platform
                            "Type"       => 'MISC_FEE',
                            "Amount"     => $totalAmount,
                        ]
                    ],
                ];

                $hpp = $this->worldpay->generateHostedPayment($restaurant, $accessToken, $hppData);

                $paymentUrl = $hpp['redirectUrl'] ?? $hpp['url'] ?? null;
                $webPageToken = $hpp['webPageToken'] ?? null;

                if ($webPageToken) {
                    $payment->update(['transaction_id' => $webPageToken]);
                }

                if (!$paymentUrl) {
                    throw new \Exception('Worldpay did not return a valid hosted payment page URL.');
                }

                return response()->json([
                    'success'      => true,
                    'order_id'     => $order->id,
                    'redirect_url' => $paymentUrl,
                ]);

            } catch (\Throwable $e) {
                Log::error('Direct Delivery Worldpay Initiation Failed', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Worldpay initialization error: ' . $e->getMessage(),
                ], 500);
            }
        });
    }

    public function directDeliveryPaymentCallback(Request $request)
    {
        $webPageToken = $request->webPageToken;

        if (!$webPageToken) {
            Log::error('Direct Delivery Worldpay Callback missing webPageToken', $request->all());
            return redirect()->route('restaurant.orders.create_direct_delivery')
                ->with('error', 'Payment authorization session not found.');
        }

        $payment = Payment::where('transaction_id', $webPageToken)->firstOrFail();
        $restaurant = \App\Models\Restaurant::findOrFail($payment->restaurant_id);

        try {
            $accessToken = $this->worldpay->login($restaurant);
            $result = $this->worldpay->getHostedPaymentStatus(
                $restaurant,
                $accessToken,
                $webPageToken,
                $payment->id,
                $payment->order_id
            );

            if (($result['status'] ?? null) === 'PROCESSED_SUCCESSFUL') {
                $payment->update([
                    'payment_status'           => 'paid',
                    'payment_transaction_id'   => $result['transaction']['transactionId'] ?? null,
                    'secondary_transaction_id' => $result['transaction']['secondaryTransactionId'] ?? null,
                    'payment_method'           => $result['transaction']['paymentMethod'] ?? 'worldpay',
                ]);

                $this->fulfillDirectDeliveryAfterPayment($payment);

                return redirect()->route('restaurant.orders.direct_delivery_track', $payment->order_id)
                    ->with('success', 'Payment successful! Uber Direct courier has been requested.');
            }

            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('restaurant.orders.create_direct_delivery')
                ->with('error', 'Payment was not successful. Status: ' . ($result['status'] ?? 'declined'));

        } catch (\Throwable $e) {
            Log::error('Direct Delivery Callback Exception', ['message' => $e->getMessage()]);
            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('restaurant.orders.create_direct_delivery')
                ->with('error', 'Payment verification error: ' . $e->getMessage());
        }
    }

    public function fulfillDirectDeliveryAfterPayment(Payment $payment)
    {
        $order = $payment->order;
        if (!$order) {
            $order = Order::find($payment->order_id);
        }

        if (!$order) {
            Log::error('Direct Delivery fulfillment failed: Order not found for payment', ['payment_id' => $payment->id]);
            return;
        }

        if (!empty($order->uber_delivery_id)) {
            Log::info('Direct Delivery already has Uber delivery dispatched', ['order_id' => $order->id, 'uber_id' => $order->uber_delivery_id]);
            return;
        }

        $restaurant = $order->restaurant;
        $uber = new UberService();

        $deliveryReq = new Request([
            'name'                 => $order->guest_name,
            'phone'                => $order->guest_phone,
            'address'              => $order->guest_address,
            'city'                 => $order->guest_city,
            'postcode'             => $order->guest_postcode,
            'uber_quote_id'        => $order->uber_quote_id,
            'deliverable_action'   => $order->deliverable_action ?? 'deliverable_action_meet_at_door',
            'undeliverable_action' => $order->undeliverable_action ?? 'leave_at_door',
            'dropoff_notes'        => $order->dropoff_notes,
        ]);

        try {
            $uberdelivery = $uber->createDelivery($order, $restaurant, $deliveryReq);

            Log::info('Direct Delivery Uber courier dispatched successfully', [
                'order_id' => $order->id,
                'response' => $uberdelivery,
            ]);

            if (!empty($uberdelivery) && isset($uberdelivery['id'])) {
                $order->update([
                    'status'               => 'processing',
                    'delivery_status'      => 'pending',
                    'delivery_provider'    => 'uber',
                    'uber_delivery_id'     => $uberdelivery['id'],
                    'uber_tracking_url'    => $uberdelivery['tracking_url'] ?? null,
                    'uber_delivery_status' => $uberdelivery['status'] ?? 'pending',
                    'driver_name'          => $uberdelivery['courier']['name'] ?? null,
                    'driver_phone'         => $uberdelivery['courier']['phone_number'] ?? null,
                ]);
            } else {
                Log::warning('Uber delivery response missing id', ['order_id' => $order->id, 'response' => $uberdelivery]);
                $order->update([
                    'status'               => 'processing',
                    'delivery_status'      => 'failed',
                    'cancel_reason'        => $uberdelivery['message'] ?? 'Uber courier dispatch failed.',
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Direct Delivery Uber dispatch exception', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    public function trackDirectDelivery($id)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $order = Order::where('restaurant_id', $restaurantId)->findOrFail($id);
        $restaurant = \App\Models\Restaurant::findOrFail($restaurantId);

        // Refresh live delivery status from Uber if active delivery id exists
        if (!empty($order->uber_delivery_id) && !in_array($order->uber_delivery_status, ['delivered', 'canceled'])) {
            try {
                $uber = new UberService();
                $uberData = $uber->getDelivery($order->uber_delivery_id, $restaurant);
                if (!empty($uberData) && isset($uberData['status'])) {
                    $order->update([
                        'uber_delivery_status' => $uberData['status'],
                        'uber_tracking_url'    => $uberData['tracking_url'] ?? $order->uber_tracking_url,
                        'driver_name'          => $uberData['courier']['name'] ?? $order->driver_name,
                        'driver_phone'         => $uberData['courier']['phone_number'] ?? $order->driver_phone,
                    ]);
                    $order->refresh();
                }
            } catch (\Throwable $e) {
                Log::warning('Unable to refresh Uber Direct status', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            }
        }

        return view('restaurant.orders.direct_delivery_track', compact('order', 'restaurant'));
    }

    public function checkVerifoneStatus(Request $request)
    {
        $restaurant = \App\Models\Restaurant::find(auth()->user()->restaurant_id);
        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restaurant not found'], 404);
        }

        $res = $this->verifone->checkStatus($restaurant);
        return response()->json($res);
    }

    public function abortVerifonePayment(Request $request)
    {
        $serviceId = $request->input('service_id');
        $restaurant = \App\Models\Restaurant::find(auth()->user()->restaurant_id);

        if (!$restaurant || !$serviceId) {
            return response()->json(['success' => false, 'message' => 'Invalid parameters'], 400);
        }

        $res = $this->verifone->abortTransaction($restaurant, $serviceId);
        return response()->json($res);
    }

    public function printVerifoneReceipt(Request $request, $id)
    {
        $order = Order::where('restaurant_id', auth()->user()->restaurant_id)
            ->with(['restaurant', 'items.product', 'items.addons', 'user', 'payment'])
            ->findOrFail($id);

        $res = $this->verifone->printReceipt($order, 'CUSTOMERRECEIPT');

        if ($res['success']) {
            return back()->with('success', 'Receipt sent to Verifone POS terminal printer.');
        }

        return back()->with('error', 'Failed to print receipt on Verifone terminal: ' . ($res['error'] ?? 'Unknown error'));
    }

    public function refundVerifonePayment(Request $request, $id)
    {
        $order = Order::where('restaurant_id', auth()->user()->restaurant_id)
            ->with(['restaurant', 'payment'])
            ->findOrFail($id);

        $amount = (float) ($request->input('amount') ?: $order->total_amount);

        $res = $this->verifone->processRefund($order, $amount, $request->input('reason', 'Refund requested by restaurant'));

        if ($res['success']) {
            if ($order->payment) {
                $order->payment->update([
                    'payment_status'  => 'refunded',
                    'refunded_amount' => $amount,
                    'refund_reason'   => $request->input('reason', 'Verifone POS refund'),
                ]);
            }
            $order->update([
                'status'        => 'cancelled',
                'cancel_reason' => 'Refunded via Verifone POS',
            ]);

            return back()->with('success', 'Verifone POS Refund of £' . number_format($amount, 2) . ' processed successfully.');
        }

        return back()->with('error', 'Verifone POS Refund Failed: ' . ($res['error'] ?? 'Declined on terminal.'));
    }

    public function reversalVerifonePayment(Request $request, $id)
    {
        $order = Order::where('restaurant_id', auth()->user()->restaurant_id)
            ->with(['restaurant', 'payment'])
            ->findOrFail($id);

        $res = $this->verifone->processReversal($order, $request->input('reason', 'CustCancel'));

        if ($res['success']) {
            if ($order->payment) {
                $order->payment->update([
                    'payment_status' => 'voided',
                    'refund_reason'  => 'Pre-settlement Void/Reversal via Verifone POS',
                ]);
            }
            $order->update([
                'status'        => 'cancelled',
                'cancel_reason' => 'Voided / Reversed via Verifone POS before settlement',
            ]);

            return back()->with('success', 'Verifone POS Transaction Voided / Reversed successfully before settlement.');
        }

        return back()->with('error', 'Verifone POS Reversal Failed: ' . ($res['error'] ?? 'Declined on terminal.'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->findOrFail($id);

        $request->validate([
            'payment_status' => 'required|string',
            'payment_method' => 'nullable|string'
        ]);

        $targetMethod = $request->payment_method ?? $order->payment_method ?? 'Cash';

        // Verifone Cloud POS terminal payment processing
        if ($targetMethod === 'verifone_pos' && $request->payment_status === 'paid') {
            $order->load(['restaurant', 'items.product', 'items.addons', 'user']);
            $verifoneRes = $this->verifone->processSalePayment($order, (float) $order->total_amount);

            if ($verifoneRes['success']) {
                $payment = Payment::where('order_id', $order->id)->first();
                $paymentData = [
                    'payment_method'     => 'verifone_pos',
                    'payment_type'       => 'Offline',
                    'amount'             => $order->total_amount,
                    'payment_status'     => 'paid',
                    'poi_transaction_id' => $verifoneRes['poi_transaction_id'] ?? null,
                    'poi_timestamp'      => $verifoneRes['poi_timestamp'] ?? null,
                    'masked_pan'         => $verifoneRes['masked_pan'] ?? null,
                    'card_brand'         => $verifoneRes['card_brand'] ?? null,
                    'auth_code'          => $verifoneRes['auth_code'] ?? null,
                    'nexo_service_id'    => $verifoneRes['service_id'] ?? null,
                ];

                if (!$payment) {
                    $paymentData['order_id'] = $order->id;
                    $paymentData['restaurant_id'] = $order->restaurant_id;
                    $paymentData['user_id'] = $order->user_id;
                    $payment = Payment::create($paymentData);
                } else {
                    $payment->update($paymentData);
                }

                $order->update([
                    'payment_method' => 'verifone_pos',
                    'status'         => 'completed',
                ]);

                // Print receipt on terminal
                try {
                    $this->verifone->printReceipt($order, 'CUSTOMERRECEIPT');
                } catch (\Throwable $e) {
                    Log::error('Verifone POS Print Failed on order updatePaymentStatus', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                }

                if ($order->user_id) {
                    sendNotification(
                        $order->user_id,
                        'payment_status',
                        'Payment Completed',
                        'Payment of £' . number_format($order->total_amount, 2) . ' for order #' . $order->id . ' was completed via Verifone POS.',
                        'order',
                        $order->id,
                        $order->id
                    );
                }

                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success'      => true,
                        'message'      => 'Payment approved on Verifone terminal!',
                        'order_id'     => $order->id,
                        'redirect_url' => route('restaurant.orders.show', $order->id),
                    ]);
                }

                return redirect()->route('restaurant.orders.show', $order->id)
                    ->with('success', 'Order #' . $order->id . ' paid & completed via Verifone POS.');
            } else {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Transaction declined.'),
                    ], 400);
                }

                return back()->with('error', 'Verifone POS Payment Failed: ' . ($verifoneRes['error'] ?? 'Declined on terminal.'));
            }
        }

        $payment = Payment::where('order_id', $order->id)->first();

        if (!$payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'restaurant_id' => $order->restaurant_id,
                'user_id' => $order->user_id,
                'payment_method' => $request->payment_method ?? $order->payment_method ?? 'Cash',
                'payment_type' => 'Offline',
                'amount' => $order->total_amount,
                'payment_status' => $request->payment_status
            ]);
        } else {
            $updateData = ['payment_status' => $request->payment_status];
            if ($request->filled('payment_method')) {
                $updateData['payment_method'] = $request->payment_method;
            }
            $payment->update($updateData);
        }

        $orderUpdate = [];
        if ($request->filled('payment_method')) {
            $orderUpdate['payment_method'] = $request->payment_method;
        }
        if ($request->payment_status === 'paid') {
            $orderUpdate['status'] = 'completed';
        }
        if (!empty($orderUpdate)) {
            $order->update($orderUpdate);
        }

        if ($order->user_id) {
            sendNotification(
                $order->user_id,
                'payment_status',
                'Payment Status Updated',
                'Payment status for order #' . $order->id . ' changed to ' . ucfirst($request->payment_status),
                'order',
                $order->id,
                $order->id
            );
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'      => true,
                'message'      => 'Payment Status Updated Successfully',
                'order_id'     => $order->id,
                'redirect_url' => route('restaurant.orders.show', $order->id),
            ]);
        }

        return back()->with(
            'success',
            'Payment Status Updated Successfully'
        );
    }

    // public function refundPayment($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )->with('payment')->findOrFail($id);

    //     if ($order->status !== 'cancelled') {

    //         return back()->with(
    //             'error',
    //             'Only cancelled orders can be refunded.'
    //         );
    //     }

    //     if (!$order->payment) {

    //         return back()->with(
    //             'error',
    //             'Payment record not found.'
    //         );
    //     }

    //     if ($order->payment->payment_status !== 'paid') {

    //         return back()->with(
    //             'error',
    //             'Only paid orders can be refunded.'
    //         );
    //     }

    //     $order->payment->update([
    //         'payment_status' => 'refunded'
    //     ]);

    //     return back()->with(
    //         'success',
    //         'Payment Refunded Successfully.'
    //     );
    // }

    public function refundPayment(Request $request, $id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
        ->with('payment')
        ->findOrFail($id);

        if ($order->status !== 'cancelled') {
            return back()->with(
                'error',
                'Only cancelled orders can be refunded.'
            );
        }

        if (!$order->payment) {
            return back()->with(
                'error',
                'Payment record not found.'
            );
        }

        $payment = $order->payment;

        $request->validate([
            'refund_amount' => 'required|numeric|min:0.01'
        ]);

        $alreadyRefunded = $payment->refunded_amount ?? 0;

        $remainingAmount =
            $order->total_amount - $alreadyRefunded;

        if ($request->refund_amount > $remainingAmount) {

            return back()->with(
                'error',
                'Refund amount exceeds remaining balance.'
            );
        }

        $newRefundedAmount =
            $alreadyRefunded + $request->refund_amount;

        $status = 'partially_refunded';

        if ($newRefundedAmount >= $order->total_amount) {
            $status = 'refunded';
        }

        $payment->update([
            'refunded_amount' => $newRefundedAmount,
            'payment_status'  => $status,
        ]);

        sendNotification(

            $order->user_id,

            'refund_processed',

            $status == 'refunded'
                ? 'Full Refund Processed'
                : 'Partial Refund Processed',

            $status == 'refunded'

                ? 'A full refund of £' .
                    number_format($newRefundedAmount, 2) .
                    ' has been processed for order #' .
                    $order->id

                : 'A partial refund of £' .
                    number_format($request->refund_amount, 2) .
                    ' has been processed for order #' .
                    $order->id .
                    '. Total refunded: £' .
                    number_format($newRefundedAmount, 2),

            'order',

            $order->id,

            $order->id
        );

        sendNotification(

            auth()->id(),

            'refund_processed',

            'Refund Processed',

            'Refund of £' .
            number_format($request->refund_amount, 2) .
            ' processed for order #' .
            $order->id,

            'order',

            $order->id,

            $order->id
        );

        return back()->with(
            'success',
            'Refund processed successfully.'
        );
    }
  
    // public function refundPayment($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //     ->with([
    //         'payment',
    //         'restaurant'
    //     ])
    //     ->findOrFail($id);

    //     if ($order->status !== 'cancelled') {

    //         return back()->with(
    //             'error',
    //             'Only cancelled orders can be refunded.'
    //         );
    //     }

    //     if (!$order->payment) {

    //         return back()->with(
    //             'error',
    //             'Payment record not found.'
    //         );
    //     }

    //     if ($order->payment->payment_status !== 'paid') {

    //         return back()->with(
    //             'error',
    //             'Only paid payments can be refunded.'
    //         );
    //     }

    //     $restaurant = $order->restaurant;

    //     $memberId =
    //         $restaurant->transactworld_member_id;

    //     $secureKey =
    //         $restaurant->transactworld_checksum_key;

    //     $paymentId =
    //         $order->payment->payment_id;

    //     $amount = number_format(
    //         $order->payment->amount,
    //         2,
    //         '.',
    //         ''
    //     );

    //     $checksum = md5(
    //         $memberId .
    //         '|' .
    //         $secureKey .
    //         '|' .
    //         $paymentId .
    //         '|' .
    //         $amount
    //     );

    //     $endpoint =
    //         'https://preprod.transactworld.com/transactionServices/REST/v1/payments/' .
    //         $paymentId;

    //     $response = Http::withHeaders([

    //         'Content-Type' => 'application/json',

    //         // Add auth token here
    //         'authentication' =>
    //             'YOUR_AUTH_TOKEN'

    //     ])->post($endpoint, [

    //         'memberId' =>
    //             $memberId,

    //         'paymentType' =>
    //             'RF',

    //         'amount' =>
    //             $amount,

    //         'checksum' =>
    //             $checksum
    //     ]);

    //     $result = $response->json();

    //     \Log::info('Refund Response', $result);

    //     if (
    //         isset($result['responseCode']) &&
    //         $result['responseCode'] == '000'
    //     ) {

    //         $order->payment->update([

    //             'payment_status' =>
    //                 'refunded'
    //         ]);

    //         return back()->with(
    //             'success',
    //             'Payment Refunded Successfully.'
    //         );
    //     }

    //     return back()->with(
    //         'error',
    //         $result['responseMessage']
    //             ?? 'Refund Failed'
    //     );
    // }

    public function reviews()
    {
        $reviews = Review::with([

            'user',
            'order'

        ])

            ->where(

                'restaurant_id',

                auth()->user()->restaurant_id

            )

            ->latest()

            ->get();

        return view(

            'restaurant.reviews.index',

            compact('reviews')

        );
    }
    public function approveReview($id)
    {
        $review = Review::findOrFail($id);

        $review->update([

            'status' => 'approved'

        ]);

        return back()->with(

            'success',

            'Review approved successfully.'

        );
    }
    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);

        $review->update([

            'status' => 'rejected'

        ]);

        return back()->with(

            'success',

            'Review rejected successfully.'

        );
    }
}