<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Invoice;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderCompletionEvidence;
use App\Models\OrderItem;
use App\Models\OrderOffer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Services\StuartService;
use App\Services\UberService;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;
use App\Services\FirebaseNotificationService;
use App\Models\ActivityLog;
use App\Models\Coupon;
use App\Models\OrderItemAddon;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function storeGuestInfo(Request $request)
    {
        $request->validate([
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required',
            'address'     => 'required',
            'city'        => 'required',
            'state'       => 'required',
            'postcode'    => 'required',
            'country'     => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
        ]);

        session([
            'guest_checkout' => [
                'name'      => $request->guest_name,
                'email'     => $request->guest_email,
                'phone'     => $request->guest_phone,
                'address'   => $request->address,
                'city'      => $request->city,
                'state'     => $request->state,
                'postcode'  => $request->postcode,
                'country'   => $request->country,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude
            ]
        ]);

        return redirect()->route('checkout');
    }
    public function checkout(Request $request)
    {
        savePageVisit($request, 'Checkout');
       
        $cart = session()->get('cart', []);

        // dd($cart);

        if (empty($cart)) {

            return redirect('/cart')
                ->with(
                    'error',
                    'Your cart is empty'
                );
        }


        // $restaurantId = Product::find(
        //     array_key_first($cart)
        // )->restaurant_id;

        $firstItem = reset($cart);

        $restaurantId = Product::find(
            $firstItem['id']
        )->restaurant_id;

        $restaurant = Restaurant::find(
            $restaurantId
        );



        $cartProductIds = collect($cart)
            ->pluck('id')
            ->toArray();



        $originalTotal = 0;

        $discount = 0;

        $finalTotal = 0;



        foreach ($cart as $item) {

            // $originalTotal +=
            //     $item['price']
            //     * $item['quantity'];

            $itemPrice =
                $item['base_price']
                + ($item['addon_total'] ?? 0);

            $originalTotal +=
                $itemPrice
                * $item['quantity'];
        }


        $offers = \App\Models\Offer::with('products')

            ->where('is_active', 1)

            ->where(function ($q) {

                $q->whereNull('start_date')
                    ->orWhereDate(
                        'start_date',
                        '<=',
                        now()
                    );

            })

            ->where(function ($q) {

                $q->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()
                    );

            })

            ->get();

        /*
        |--------------------------------------------------------------------------
        | APPLY OFFER ONLY IF
        | ALL PRODUCTS MATCH
        |--------------------------------------------------------------------------
        */

        foreach ($offers as $offer) {

            $offerProductIds =
                $offer->products
                    ->pluck('id')
                    ->toArray();



            $allMatched = !array_diff(

                $offerProductIds,

                $cartProductIds
            );


            if ($allMatched) {


                $offerProductsTotal = 0;

                foreach ($cart as $item) {

                    if (
                        in_array(
                            $item['id'],
                            $offerProductIds
                        )
                    ) {

                        // $offerProductsTotal +=
                        //     $item['price']
                        //     * $item['quantity'];

                        $itemPrice =
                            $item['base_price']
                            + ($item['addon_total'] ?? 0);

                        $offerProductsTotal +=
                            $itemPrice
                            * $item['quantity'];


                        $cartItemOffer[
                            $item['id']
                        ] = $offer;
                    }
                }



                if (
                    $offer->value_type
                    == 'percent'
                ) {

                    $discount +=
                        (
                            $offerProductsTotal
                            * $offer->value
                        ) / 100;
                } else {

                    $discount +=
                        $offer->value;
                }
            }
        }



        $finalTotal =
            max(
                $originalTotal - $discount,
                0
            );


        $orderOfferDiscount = 0;
        $orderOffer = null;

        if(auth()->check()) {

            $completedOrder = Order::where('user_id', auth()->id())
                ->where('restaurant_id', $restaurantId)
                ->whereIn('status', ['completed', 'delivered'])
                ->exists();

            if($completedOrder) {

                $orderOffer = OrderOffer::where('restaurant_id', $restaurantId)
                    ->where('status', 'active')
                    ->where('min_order_value', '<=', $finalTotal)
                    ->first();

                if($orderOffer) {

                    if($orderOffer->value_type == 'percentage') {

                        $orderOfferDiscount =
                            ($finalTotal * $orderOffer->value) / 100;

                    } else {

                        $orderOfferDiscount =
                            $orderOffer->value;
                    }

                    $finalTotal -= $orderOfferDiscount;

                    $discount += $orderOfferDiscount;
                }
            }
        }   


        foreach ($cart as $key => $item) {

            $cart[$key]['offer'] =
                $cartItemOffer[$item['id']]
                ?? null;

            // $cart[$key]['final_price'] =
            //     $item['price'];

            // $cart[$key]['subtotal'] =
            //     $item['price']
            //     * $item['quantity'];

            $itemPrice =
                $item['base_price']
                + ($item['addon_total'] ?? 0);

            $cart[$key]['final_price'] = $itemPrice;

            $cart[$key]['subtotal'] =
                $itemPrice * $item['quantity'];
        }

        $paymentEnabled =
        !empty($restaurant->worldpay_business_id) &&
        !empty($restaurant->worldpay_username) &&
        !empty($restaurant->worldpay_password);

        $serviceCharge = 0.12;
        $deliveryCharge = 0.12;
        $hystCharge = 0.25;

        $finalTotal +=
            // $serviceCharge +
            $deliveryCharge +
            $hystCharge;

        $addresses = UserAddress::where('user_id', Auth::id())
        ->orderByDesc('is_default')
        ->latest()
        ->get();



        $couponDiscount = 0;

        if(session()->has('coupon')){

            $couponDiscount=session('coupon.discount');

            $finalTotal -= $couponDiscount;

        }

        return view(

            'front.checkout',

            compact(

                'cart',
                'restaurant',
                'originalTotal',
                'discount',
                'finalTotal',
                'paymentEnabled',
                'orderOffer',
                'orderOfferDiscount',
                'serviceCharge',
                'deliveryCharge',
                'hystCharge',
                'addresses',
                'couponDiscount'
                
            )
        );
    }

    public function placeOrder(Request $request, Payment $payment = null)
    {
        

       
        
            Log::info('PLACE ORDER START');

            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */
            $guest = session('guest_checkout');

            

            $userId = auth()->check() ? auth()->id() : null;

           

            $request->validate([

                'order_type' =>
                    'required',

                'payment_method' =>
                    'required',

                'phone' =>
                    'required_if:payment_method,Cash On Delivery',

                // 'address' =>
                //     'required_if:order_type,delivery|required_if:payment_method,Cash On Delivery',

                // 'pincode' =>
                //     'required_if:order_type,delivery|required_if:payment_method,Cash On Delivery',
                'address' => 'nullable|required_if:order_type,delivery',

                'pincode' => 'nullable',

            ]);

            


           

            Log::info('VALIDATION SUCCESS');

            /*
            |--------------------------------------------------------------------------
            | CART
            |--------------------------------------------------------------------------
            */

            $cart = session()->get('cart', []);
           

            if (empty($cart)) {

                return back();
            }


            
            


            /*
            |--------------------------------------------------------------------------
            | RESTAURANT
            |--------------------------------------------------------------------------
            */

            // $restaurantId = Product::find(
            //     array_key_first($cart)
            // )->restaurant_id;

            $firstItem = reset($cart);

            $restaurantId = Product::find($firstItem['id'])->restaurant_id;

            
            

            /*
            |--------------------------------------------------------------------------
            | CART PRODUCT IDS
            |--------------------------------------------------------------------------
            */

            $cartProductIds = collect($cart)
                ->pluck('id')
                ->toArray();

                

            /*
            |--------------------------------------------------------------------------
            | TOTALS
            |--------------------------------------------------------------------------
            */

            $originalTotal = 0;

            $discount = 0;

            /*
            |--------------------------------------------------------------------------
            | ORIGINAL TOTAL
            |--------------------------------------------------------------------------
            */

            foreach ($cart as $item) {

                // $originalTotal +=
                //     $item['price']
                //     * $item['quantity'];
                $itemPrice =
                    $item['base_price']
                    + ($item['addon_total'] ?? 0);

                $originalTotal +=
                    $itemPrice
                    * $item['quantity'];
            }

            /*
            |--------------------------------------------------------------------------
            | ACTIVE OFFERS
            |--------------------------------------------------------------------------
            */


            

            $offers = \App\Models\Offer::with('products')

                ->where('is_active', 1)

                ->where(function ($q) {

                    $q->whereNull('start_date')

                        ->orWhereDate(
                            'start_date',
                            '<=',
                            now()
                        );

                })

                ->where(function ($q) {

                    $q->whereNull('end_date')

                        ->orWhereDate(
                            'end_date',
                            '>=',
                            now()
                        );

                })

                ->get();

            /*
            |--------------------------------------------------------------------------
            | APPLY COMBO OFFERS
            |--------------------------------------------------------------------------
            */

            foreach ($offers as $offer) {

                $offerProductIds =
                    $offer->products
                        ->pluck('id')
                        ->toArray();

                $allMatched =
                    !array_diff(
                        $offerProductIds,
                        $cartProductIds
                    );

                if ($allMatched) {

                    if (

                        $offer->value_type
                        == 'percent'

                    ) {

                        $discount +=
                            (
                                $originalTotal
                                *
                                $offer->value
                            )
                            /
                            100;

                    } else {

                        /*
                        FLAT DISCOUNT
                        SIRF EK BAR
                        */

                        $discount +=
                            $offer->value;

                    }

                    break;
                }

            }

            /*
            |--------------------------------------------------------------------------
            | FINAL TOTAL
            |--------------------------------------------------------------------------
            */

            $finalTotal = max(

                $originalTotal - $discount,

                0
            );

            

            $orderOffer = null;
            $completedOrder = false;


           

            if ($userId) {
                $completedOrder = Order::where('user_id', auth()->id())
                    ->where('restaurant_id', $restaurantId)
                    ->whereIn('status', ['completed', 'delivered'])
                    ->exists();
            }   
            
            

            if($completedOrder) {

                $orderOffer = OrderOffer::where('restaurant_id', $restaurantId)
                    ->where('status', 'active')
                    ->where('min_order_value', '<=', $finalTotal)
                    ->first();

                if($orderOffer) {

                    if($orderOffer->value_type == 'percentage') {

                        $discount +=
                            ($finalTotal * $orderOffer->value) / 100;

                    } else {

                        $discount +=
                            $orderOffer->value;
                    }
                }
            }

            $serviceCharge = (float) $request->service_charge;
            $deliveryCharge = (float) $request->delivery_charge;
            $hystCharge = (float) $request->hyst_charge;

            $finalTotal =
                ($originalTotal - $discount)
                + $deliveryCharge
                + $hystCharge;

            $finalTotal = max($finalTotal, 0);


                
            

            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER
            |--------------------------------------------------------------------------
            */

            // 1. Fetch coupon details from session
            $couponId = session('coupon.id');
            $discountAmount = session('coupon.discount', 0);

            $order = Order::create([

                'user_id' =>
                    $userId,


                    

                'is_guest' => !$userId,

                'guest_name' => $guest['name'] ?? null,
                'guest_email' => $guest['email'] ?? null,
                'guest_phone' => $guest['phone'] ?? null,
                'guest_address' => $guest['address'] ?? null,
                'guest_postcode' => $guest['postcode'] ?? null,
                'guest_city' => $guest['city'] ?? null,
                'guest_country' => $guest['country'] ?? null,
                'guest_state' => $guest['state'] ?? null,
                'guest_latitude' => $guest['latitude'] ?? null,
                'guest_longitude' => $guest['longitude'] ?? null,

                'restaurant_id' =>
                    $restaurantId,

                'total_amount' =>
                    $finalTotal,

                'service_charge' => 0,

                'delivery_charge' => $deliveryCharge,

                'hyst_charge' => $hystCharge,

                'order_type' =>
                    $request->order_type,

                'phone' =>
                    $request->phone,

                'address' =>
                    $request->address,

                'pincode' =>
                    $request->postcode,

                'payment_method' =>
                    $request->payment_method,



                'status' =>
                    'pending',

                'coupon_id' => $couponId,
                'coupon_discount' => $discountAmount   
            ]);

            if(session()->has('coupon')){

                Coupon::where(
                    'id',
                    session('coupon.id')
                )->increment('used_count');

                session()->forget('coupon');

            }
            savePageVisit(
                $request,
                'Place Order',
                $restaurantId,
                Restaurant::find($restaurantId)?->name,
                $order->id
            );

            

            Log::info('ORDER CREATED', [

                'order_id' =>
                    $order->id
            ]);

            if ($userId) {
                sendNotification(

                    $userId,

                    'order_placed',

                    'Order Placed Successfully',

                    'Your order #' . $order->id . ' has been placed successfully.',

                    'order',

                    $order->id,
                    $order->id
                );
            }

            


            /*
            |--------------------------------------------------------------------------
            | ORDER ITEMS
            |--------------------------------------------------------------------------
            |
            | PRODUCT PRICE SAME RAHEGA
            | OFFER SIRF ORDER TOTAL PAR LAGEGA
            |
            */

            // foreach ($cart as $item) {

            //     OrderItem::create([

            //         'order_id' =>
            //             $order->id,

            //         'product_id' =>
            //             $item['id'],

            //         'variant_id' => $item['variant_id'] ?? null,
            //         'variant_name' => $item['variant_name'] ?? null,

            //         'quantity' =>
            //             $item['quantity'],

            //         'price' =>
            //             $item['price'],

            //         'total' =>

            //             $item['price']
            //             *
            //             $item['quantity']

            //     ]);

            // }


            foreach ($cart as $item) {

                $itemPrice =
                    $item['base_price']
                    + ($item['addon_total'] ?? 0);

                $orderItem = OrderItem::create([

                    'order_id'     => $order->id,

                    'product_id'   => $item['id'],

                    'variant_id'   => $item['variant_id'] ?? null,

                    'variant_name' => $item['variant_name'] ?? null,

                    'quantity'     => $item['quantity'],

                    'price'        => $itemPrice,

                    'total'        => $itemPrice * $item['quantity']

                ]);

                /*
                |--------------------------------------------------------------------------
                | SAVE ORDER ITEM ADDONS
                |--------------------------------------------------------------------------
                */

                if (!empty($item['addons'])) {

                    foreach ($item['addons'] as $addon) {

                        OrderItemAddon::create([

                            'order_item_id' => $orderItem->id,

                            'addon_id'      => $addon['id'],

                            'category_name' => $addon['category_name'],

                            'addon_name'    => $addon['addon_name'],

                            'price'         => $addon['price'],

                        ]);

                    }

                }

            }


            

            Log::info('ORDER ITEMS SAVED');


            /*
            |--------------------------------------------------------------------------
            | UPDATE FINAL ORDER TOTAL
            |--------------------------------------------------------------------------
            */

            

            $order->update([

                'total_amount' =>$finalTotal

                    // max(

                    //     $originalTotal
                    //     -
                    //     $discount,

                    //     0

                    // )

            ]);


            Log::info('FINAL TOTAL UPDATED', [

                'original_total' =>
                    $originalTotal,

                'discount' =>
                    $discount,

                'final_total' =>
                    $order->total_amount

            ]);


            /*
            |--------------------------------------------------------------------------
            | PAYMENT ENTRY
            |--------------------------------------------------------------------------
            */

            // $payment = Payment::create([

            //     'order_id' =>
            //         $order->id,

            //     'restaurant_id' =>
            //         $restaurantId,

            //     'user_id' =>
            //         auth()->id(),

            //     'payment_method' =>
            //         $request->payment_method,

            //     'amount' =>
            //         $order->total_amount,

            //     'payment_status' =>

            //         $request->payment_method
            //         == 'Cash On Delivery'

            //         ? 'pending'

            //         : 'paid'

            // ]);

            if($payment){

                $payment->update([

                    'order_id'=>$order->id,

                    'payment_status'=>'paid'

                ]);

            }else{

                Payment::create([

                    'order_id'=>$order->id,

                    'restaurant_id'=>$restaurantId,

                    'user_id'=>$userId,

                    'payment_method'=>'Cash On Delivery',

                    'amount'=>$order->total_amount,

                    'payment_status'=>'pending'

                ]);

            }

           


            $invoice = Invoice::create([

                'order_id'        => $order->id,

                'invoice_number'  =>
                    'INV-' .
                    str_pad($order->id, 6, '0', STR_PAD_LEFT),

                'restaurant_id'   => $order->restaurant_id,

                'user_id'         => $order->user_id,

                'subtotal'        => $originalTotal,

                'discount'        => $discount ?? 0,

                'service_charge'  => 0,

                'delivery_charge' => $request->delivery_charge ?? 0,

                'hyst_charge'     => $request->hyst_charge ?? 0,

                'total'           => $finalTotal,

                'invoice_date'    => now()

            ]);

           


            $restaurantAdmin =
                User::where(

                    'restaurant_id',
                    $order->restaurant_id

                )

                    ->where(
                        'role',
                        'restaurant_admin'
                    )

                    ->first();


            Log::info(

                'RESTAURANT FOUND',

                [

                    'id' =>
                        $restaurantAdmin->id ?? null,

                    'token' =>
                        !empty(
                        $restaurantAdmin->fcm_token
                    )

                ]

            );



            if($restaurantAdmin){

                sendNotification(

                    $restaurantAdmin->id,

                    'new_order',

                    'New Order Received',

                    // auth()->user()->name .
                    // ' placed order #' .
                    // $order->id,
                    ($userId
                        ? auth()->user()->name
                        : $guest['name']
                    ) . ' placed order #' . $order->id,

                    'order',

                    $order->id,
                    $order->id
                );
            }

            if (

                $restaurantAdmin

                &&

                !empty(
                $restaurantAdmin->fcm_token
            )

            ) {

                $firebase =
                    new FirebaseNotificationService();

                $firebase->send(

                    $restaurantAdmin->fcm_token,

                    'New Order',

                    'You received a new order.'

                );

            }
            Log::info('PAYMENT CREATED');

            /*
            |--------------------------------------------------------------------------
            | STUART DELIVERY
            |--------------------------------------------------------------------------
            */

            Log::info('UBER DELIVERY START');

            if (
                $request->order_type
                == 'delivery'
            ) {

                $restaurant = Restaurant::find(
                    $restaurantId
                );

                // $stuart = new StuartService();

                // $order->load('user');
                if ($userId) {
                    $order->load('user');
                }

                // $delivery = $stuart->createDelivery(
                //     $order,
                //     $restaurant
                // );

                

                try {

                    Log::info('Uber delivery process started', [
                        'order_id' => $order->id,
                    ]);

                    $uber = new UberService();

                    // Log::info('Generating Uber quote...');

                    

                    // $quote = $uber->quote(
                    //     $restaurant,
                    //     $order
                    // );

                    // Log::info('Uber quote generated', [
                    //     'quote' => $quote,
                    // ]);


                    Log::info('Creating Uber delivery...');

                    Log::info('Uber quote generated',[
                        'quote'=>$request->uber_quote_id,
                        'longitude'=>(float) $restaurant->longitude,
                    ]);

                    // if(!isset($quote['id'])){

                    //     throw new \Exception(
                    //         'Uber Quote Failed : '.json_encode($quote)
                    //     );

                    // }

                    

                    // $uberdelivery = $uber->createDelivery(
                    //     $order,
                    //     $restaurant,
                    //     $request
                    // );

                    // Log::info('Uber delivery created successfully', [
                    //     'delivery' => $uberdelivery,
                    // ]);

                } catch (\Throwable $e) {

                    Log::error('Uber delivery process failed', [
                        'order_id' => $order->id ?? null,
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ]);

                    // throw $e; // Remove this if you don't want the exception to propagate
                }

                // Log::info('DELIVERY RESPONSE', [

                //     'delivery' =>
                //         $delivery
                // ]);

                // if ($delivery) {

                //     $order->update([

                //         'delivery_provider' => 'stuart',

                //         'stuart_job_id' =>

                //             $delivery['id']
                //             ?? null,

                //         'tracking_url' =>

                //             $delivery['deliveries'][0]['tracking_url']
                //             ?? null,

                //         'delivery_status' =>

                //             $delivery['status']
                //             ?? 'searching',
                //     ]);
                // }

                // if($uberdelivery){
                if($quote = $request->uber_quote_id){

                    $order->update([
                        'delivery_provider' => 'uber',

                        // 'uber_delivery_id'=>$uberdelivery['id'],

                        // 'uber_tracking_url'=>$uberdelivery['tracking_url'],

                        // 'uber_delivery_status'=>$uberdelivery['status'],

                        'uber_quote_id'=>$request->uber_quote_id,

                    ]);
                }
            }

            Log::info('UBER DELIVERY END');

            /*
            |--------------------------------------------------------------------------
            | CLEAR CART
            |--------------------------------------------------------------------------
            */

            
            session()->forget('cart');

            /*
            |--------------------------------------------------------------------------
            | REDIRECT
            |--------------------------------------------------------------------------
            */

            if($userId){
                return redirect('/my-orders')

                ->with(

                    'success',

                    'Order Placed Successfully'
                );
            }

            return redirect('/')

            ->with(

                'success',

                'Order Placed Successfully'
            );
            
         
               
    }

    public function driverwebhook(Request $request)
    {
        Log::info('STUART WEBHOOK', $request->all());

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = $request->data;

        if (!$data) {

            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CLIENT REFERENCE
        |--------------------------------------------------------------------------
        */

        $clientReference =
            $data['clientReference'] ?? null;

        if (!$clientReference) {

            return response()->json([
                'success' => false,
                'message' => 'No client reference'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER ID
        |--------------------------------------------------------------------------
        */

        $orderId = str_replace(
            'ORDER-',
            '',
            $clientReference
        );

        $order = Order::find($orderId);

        if (!$order) {

            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DRIVER
        |--------------------------------------------------------------------------
        */

        $driver =
            $data['driver'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $status =
            $data['status'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER
        |--------------------------------------------------------------------------
        */

        $order->update([

            /*
            |--------------------------------------------------------------------------
            | DELIVERY STATUS
            |--------------------------------------------------------------------------
            */

            'delivery_status' => $status,

            /*
            |--------------------------------------------------------------------------
            | TRACKING URL
            |--------------------------------------------------------------------------
            */

            'tracking_url' =>
                $data['trackingUrl']
                ?? $order->tracking_url,

            /*
            |--------------------------------------------------------------------------
            | DRIVER DETAILS
            |--------------------------------------------------------------------------
            */

            'driver_name' =>
                $driver['name']
                ?? $order->driver_name,

            'driver_phone' =>
                $driver['phone']
                ?? $order->driver_phone,

            'driver_id' =>
                $driver['id']
                ?? $order->driver_id,

            /*
            |--------------------------------------------------------------------------
            | PICKED
            |--------------------------------------------------------------------------
            */

            'picked_at' =>

                in_array($status, [
                    'picking',
                    'in_transit'
                ])
                ? now()
                : $order->picked_at,

            /*
            |--------------------------------------------------------------------------
            | DELIVERED
            |--------------------------------------------------------------------------
            */

            'delivered_at' =>

                $status == 'delivered'
                ? now()
                : $order->delivered_at,
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGS
        |--------------------------------------------------------------------------
        */

        Log::info('ORDER UPDATED', [

            'order_id' => $order->id,

            'status' => $status,

            'driver_name' =>
                $driver['name'] ?? null,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

   public function myOrders(Request $request)
{
    savePageVisit($request, 'My Orders');
        $orders = Order::where(
            'user_id',
            auth()->id()
        )->latest()->get();

        return view(
            'front.orders',
            compact('orders')
        );
    }

    public function orderDetails(Request $request, $id)
    {
        $order = Order::with([

            'items.product',
             'items.addons',
            'payment',
            'restaurant',
            'review',
             'invoice'

        ])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
            savePageVisit(
    $request,
    'Order Details',
    $order->restaurant_id,
    optional($order->restaurant)->name,
    $order->id
);
         
        $messages = Message::where('order_id', $order->id)
        ->where(function($q){

            $q->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id());

        })
        ->latest()
        ->get();   
        
        $complaints = Complaint::with('messages')
            ->where('order_id', $order->id)
            ->latest()
            ->get();

        $customerEvidence = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'customer'
        )->first();

        return view(
            'front.order-details',
            compact('order', 'messages', 'complaints', 'customerEvidence')
        );
    }

    public function orderStatus($id)
    {
        $order = Order::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        return response()->json([
            'status'          => $order->status,
            'delivery_status' => $order->delivery_status,
        ]);
    }

    public function transactions(Request $request)
{
    savePageVisit($request, 'Transactions');
        $payments = Payment::with([

            'restaurant',
            'order'

        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->get();

        return view(
            'front.transactions',
            compact('payments')
        );
    }

    public function submitReview(Request $request, $id)
    {
        $request->validate([

            'rating' => 'required|integer|min:1|max:5',

            'review' => 'nullable|string|max:1000'

        ]);

        $order = Order::where(

            'user_id',
            auth()->id()

        )
            ->where('id', $id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | ONLY DELIVERED ORDER
        |--------------------------------------------------------------------------
        */

        // if ($order->delivery_status != 'delivered') {

        //     return back()->with(

        //         'error',
        //         'Review allowed only after delivery.'
        //     );
        // }

        /*
        |--------------------------------------------------------------------------
        | PREVENT DUPLICATE
        |--------------------------------------------------------------------------
        */

        $already = Review::where(

            'order_id',
            $order->id

        )->exists();

        if ($already) {

            return back()->with(

                'error',
                'Review already submitted.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE REVIEW
        |--------------------------------------------------------------------------
        */

        $review = Review::create([

            'user_id' => auth()->id(),

            'restaurant_id' => $order->restaurant_id,

            'order_id' => $order->id,

            'rating' => $request->rating,

            'review' => $request->review,
            'status' => 'pending'

        ]);

        $restaurantAdmin = User::where(
            'restaurant_id',
            $order->restaurant_id
        )
        ->where('role', 'restaurant_admin')
        ->first();

        if($restaurantAdmin){

            sendNotification(

                $restaurantAdmin->id,

                'review_pending',

                'New Review Received',

                auth()->user()->name .
                ' submitted a ' .
                $request->rating .
                '★ review for your restaurant.',

                'review',

                $review->id,

                $order->id

            );
        }

        return back()->with(

            'success',
            'Review submitted successfully.'
        );
    }

    public function cancelOrder($id)
    {
        $order = Order::where(

            'user_id',
            auth()->id()

        )->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CANNOT CANCEL AFTER PICKUP
        |--------------------------------------------------------------------------
        */

        $blockedStatuses = [

            'waiting_at_pickup',
            'picking',
            'in_transit',
            'delivered'

        ];

        if (

            in_array(
                $order->delivery_status,
                $blockedStatuses
            )

        ) {

            return back()->with(

                'error',

                'Order cannot be cancelled after pickup has started.'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | ALREADY CANCELLED
        |--------------------------------------------------------------------------
        */

        if (

            $order->delivery_status == 'canceled'

        ) {

            return back()->with(

                'error',

                'Order already cancelled.'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | CANCEL ORDER
        |--------------------------------------------------------------------------
        */

        $order->update([

            'delivery_status' => 'canceled',

            'status' => 'cancelled'

        ]);

        sendNotification(

            auth()->id(),

            'order_cancelled',

            'Order Cancelled',

            'Your order #' .
            $order->id .
            ' has been cancelled successfully.',

            'order',

            $order->id,

            $order->id
        );

        $restaurantAdmin = User::where(
            'restaurant_id',
            $order->restaurant_id
        )
        ->where('role', 'restaurant_admin')
        ->first();

        if($restaurantAdmin){

            sendNotification(

                $restaurantAdmin->id,

                'order_cancelled',

                'Order Cancelled',

                auth()->user()->name .
                ' cancelled order #' .
                $order->id,

                'order',

                $order->id,

                $order->id
            );
        }
        /*
        |--------------------------------------------------------------------------
        | PAYMENT UPDATE
        |--------------------------------------------------------------------------
        */

        if ($order->payment) {

            $order->payment->update([

                'payment_status' => 'cancelled'

            ]);

        }

        if(
            $order->payment->payment_method != 'Cash On Delivery'
        ){

            sendNotification(

                auth()->id(),

                'refund_pending',

                'Refund Pending',

                'Your payment for order #' .
                $order->id .
                ' is eligible for refund. Restaurant will process it shortly.',

                'order',

                $order->id,

                $order->id
            );
        }

        

        return back()->with(

            'success',

            'Order cancelled successfully.'

        );
    }

    public function uploadCustomerEvidence(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string|max:1000',
        ]);

        $order = Order::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        $exists = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'customer'
        )->exists();

        if ($exists) {
            
            return back()->with(
                'error',
                'Evidence already uploaded.'
            );
        }

        $photoName =
            time().'_'.$request->photo->getClientOriginalName();

        $request->photo->move(
            public_path('order-evidence'),
            $photoName
        );

        OrderCompletionEvidence::create([
            'order_id'      => $order->id,
            'uploader_type' => 'customer',
            'photo'         => 'order-evidence/'.$photoName,
            'description'   => $request->description,
        ]);

        sendNotification(

            auth()->id(),

            'evidence_uploaded',

            'Evidence Submitted',

            'Your delivery evidence for order #' .
            $order->id .
            ' has been submitted successfully.',

            'order',

            $order->id,

            $order->id
        );

        $restaurantAdmin = User::where(
            'restaurant_id',
            $order->restaurant_id
        )
        ->where(
            'role',
            'restaurant_admin'
        )
        ->first();

        if($restaurantAdmin){

            sendNotification(

                $restaurantAdmin->id,

                'customer_evidence',

                'Customer Uploaded Evidence',

                auth()->user()->name .
                ' uploaded the evidence for order #' .
                $order->id,

                'order',

                $order->id,

                $order->id
            );
        }

        return back()->with(
            'success',
            'Evidence uploaded successfully.'
        );
    }
}