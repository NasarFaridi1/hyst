<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductAddon;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;



class CartController extends Controller
{
   public function index(Request $request)
{
    savePageVisit($request, 'Cart');
        $cart = session()->get('cart', []);
        

        // dd($cart);

        return view(
            'front.cart',
            compact('cart')
        );
    }



    public function summary(Request $request): JsonResponse
    {
        // ── Adjust 'cart' to your actual session key ──
        $cart  = session('cart', []);
        $items = [];
        $subtotal = 0;

        $restaurantName = null;

        if (!empty($cart)) {
            $firstItem = reset($cart);

            $restaurant = \App\Models\Restaurant::find($firstItem['restaurant_id']);

            $restaurantName = $restaurant?->name;
        }

        foreach ($cart as $cartKey => $row) {

            $qty = (int) ($row['quantity'] ?? 1);

            $unitPrice =
                ($row['base_price'] ?? 0)
                +
                ($row['addon_total'] ?? 0);

            $lineTotal = $unitPrice * $qty;

            $subtotal += $lineTotal;

            $addonList = collect($row['addons'] ?? [])
                ->map(function ($addon) {
                    return [
                        'id' => $addon['id'],
                        'name' => $addon['addon_name'],
                        'price' => $addon['price'],
                        'category_name' => $addon['category_name'],
                    ];
                })
                ->values()
                ->toArray();

            $items[] = [
                'cart_key'     => $cartKey,
                'name'         => $row['name'],
                'qty'          => $qty,
                'price'        => $unitPrice,
                'line_total'   => $lineTotal,
                'variant_name' => $row['variant_name'] ?? null,
                'addons'       => $addonList,
            ];
        }

        return response()->json([
             'restaurant_name' => $restaurantName,
            'items'    => $items,
            'count'    => array_sum(array_column($items, 'qty')),
            'subtotal' => number_format($subtotal, 2),
        ]);
    }
    public function add(Request $request)
    {
        
        // if (!auth()->check()) {

        //     return response()->json([

        //         'success' => false,

        //         'message' => 'Please login first',

        //         'redirect' => route('login')

        //     ]);
        // }

        $product =
            Product::findOrFail(
                $request->product_id
            );
            savePageVisit(
                $request,
                'Add To Cart',
                $product->restaurant_id,
                null,
                null,
                $product->id
            );

        $variant = null;

        if ($request->filled('variant_id')) {

            $variant = ProductVariant::find(
                $request->variant_id
            );
        }
        
        $addons = collect();

        if ($request->filled('addons')) {

            $addons = ProductAddon::whereIn(
                'id',
                $request->addons
            )->get();
        }

        $addonTotal = $addons->sum('price');

        $quantity = max((int) $request->input('quantity', 1), 1);


        $addonItems = $addons->map(function($addon){

            return [

                'id' => $addon->id,

                'category_name' => $addon->category_name,

                'addon_name' => $addon->addon_name,

                'price' => $addon->price,

            ];

        })->values()->toArray();

        $addonIds = collect($addonItems)
            ->pluck('id')
            ->sort()
            ->implode('-');

        $cartKey =
            $product->id .
            '_' .
            ($variant?->id ?? 0) .
            '_' .
            $addonIds;

        $cart =
            session()->get(
                'cart',
                []
            );

        /*
        SINGLE RESTAURANT
        */

        if (!empty($cart)) {

            $firstItem =
                reset($cart);

            $oldProduct =
                Product::find(
                    $firstItem['id']
                );

            if (

                $oldProduct

                &&

                $oldProduct->restaurant_id
                !=
                $product->restaurant_id

            ) {

            

                return response()->json([
                    'success' => false,
                    'different_restaurant' => true,
                    'message' => 'Your cart already contains items from another restaurant. Do you want to clear the cart and add this item?'
                ]);
            

                session()->forget('cart');

                $cart = [];
            }
        }


        $basePrice = $variant
            ? $variant->price
            : $product->price;

        $finalPrice = $basePrice + $addonTotal;

        

        if (
            isset(
            
             $cart[$cartKey]
        )
        
        ) {

            

            // $cart[
            //     $cartKey
            // ]['quantity']++;
                $cart[$cartKey]['quantity'] += $quantity;
           

        } else {

            // $cart[
            //     $product->id
            // ] = [
            $cart[
                $cartKey
            ] = [
            
                'cart_key' => $cartKey,

                'restaurant_id' => $product->restaurant_id,

                'id' => $product->id,

                'name' => $product->name,
                'variant_id' => $variant?->id,

                'variant_name' => $variant?->name,

                // 'price' => $product->price,
                // 'price' => $variant
                // ? $variant->price
                // : $product->price,

                'addons' => $addonItems,

                'price' => $finalPrice,

                'base_price' => $basePrice,

                'addon_total' => $addonTotal,

                'image' => $product->image,

                // 'quantity' => 1

                'quantity' => $quantity
            ];
        }

        session()->put(
            'cart',
            $cart
        );

        return response()->json([

            'success' => true,

            'message' => 'Added to cart successfully',
            'cart_key' => $cartKey,
            

            'count' =>

                collect($cart)

                    ->sum('quantity')

        ]);
    }

    public function removeAddon($cartKey,$addonId)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$cartKey])){

            $cart[$cartKey]['addons'] = array_values(
                array_filter(
                    $cart[$cartKey]['addons'],
                    fn($addon)=>$addon['id'] != $addonId
                )
            );

            $addonTotal = collect($cart[$cartKey]['addons'])
                ->sum('price');

            $cart[$cartKey]['addon_total'] = $addonTotal;

            $cart[$cartKey]['price'] =
                $cart[$cartKey]['base_price'] + $addonTotal;

            session()->put('cart',$cart);
        }

        return back();
    }
    public function increase($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {

            $cart[$cartKey]['quantity']++;

        }

        session()->put('cart', $cart);

        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | DECREASE QTY
    |--------------------------------------------------------------------------
    */

    public function decrease($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {

            /*
            |--------------------------------------------------------------------------
            | MINIMUM 1
            |--------------------------------------------------------------------------
            */

            if ($cart[$cartKey]['quantity'] > 1) {

                $cart[$cartKey]['quantity']--;

            }

        }

        session()->put('cart', $cart);

        return back();
    }
    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        unset($cart[$cartKey]);

        session()->put('cart', $cart);

        return back();
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true
        ]);
    }
}