<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;

use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function add(Request $request)
{
    $request->validate([
        'product_id'=>'required|exists:products,id',
        'variant_id'=>'nullable|exists:product_variants,id',
        'quantity'=>'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    $variant = null;

    if($request->variant_id){

        $variant = ProductVariant::find($request->variant_id);
    }

    $cart = Cart::firstOrCreate([
        'user_id'=>auth()->id()
    ]);

    /*
        One Restaurant Only
    */

    if(
        $cart->restaurant_id &&
        $cart->restaurant_id != $product->restaurant_id
    ){

        CartItem::where(
            'cart_id',
            $cart->id
        )->delete();
    }

    $cart->update([
        'restaurant_id'=>$product->restaurant_id
    ]);

    $price = $variant
        ? $variant->price
        : $product->price;

    $item = CartItem::where([
        'cart_id'=>$cart->id,
        'product_id'=>$product->id,
        'variant_id'=>$variant?->id
    ])->first();

    if($item){

        $item->increment(
            'quantity',
            $request->quantity
        );

    }else{

        CartItem::create([

            'cart_id'=>$cart->id,

            'product_id'=>$product->id,

            'variant_id'=>$variant?->id,

            'quantity'=>$request->quantity,

            'price'=>$price

        ]);

    }

    return response()->json([
        'status'=>true,
        'message'=>'Added to cart.'
    ]);
}

public function index()
{
    $cart = Cart::with([
        'restaurant',
        'items.product',
        'items.variant'
    ])
    ->where('user_id',auth()->id())
    ->first();

    if(!$cart){

        return response()->json([
            'status'=>true,
            'cart'=>null
        ]);
    }

    $subtotal = $cart->items->sum(function($item){

        return $item->price * $item->quantity;

    });

    return response()->json([

        'status'=>true,

        'cart'=>$cart,

        'subtotal'=>$subtotal

    ]);
}

public function update(Request $request,$id)
{
    $request->validate([
        'quantity'=>'required|integer|min:1'
    ]);

    $item = CartItem::findOrFail($id);

    $item->update([
        'quantity'=>$request->quantity
    ]);

    return response()->json([
        'status'=>true,
        'message'=>'Quantity updated.'
    ]);
}

public function remove($id)
{
    CartItem::findOrFail($id)->delete();

    return response()->json([
        'status'=>true,
        'message'=>'Item removed.'
    ]);
}

public function clear()
{
    $cart = Cart::where(
        'user_id',
        auth()->id()
    )->first();

    if($cart){

        $cart->items()->delete();
    }

    return response()->json([
        'status'=>true,
        'message'=>'Cart cleared.'
    ]);
}
}