<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->restaurant;

        $coupons = Coupon::where('restaurant_id', $restaurant->id)
            ->latest()
            ->paginate(15);

        return view('restaurant.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('restaurant.coupons.create');
    }

    public function store(Request $request)
    {
        $restaurant = Auth::user()->restaurant;

        $request->validate([
            'code' => [
                'required',
                'max:100',
                Rule::unique('coupons')
                    ->where(function ($query) use ($restaurant) {
                        return $query->where('restaurant_id', $restaurant->id);
                    }),
            ],
            'title' => 'required|max:255',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'required|boolean',
        ]);

        Coupon::create([
            'restaurant_id' => $restaurant->id,
            'code' => strtoupper($request->code),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'per_user_limit' => $request->per_user_limit ?? 1,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('restaurant.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        $restaurant = Auth::user()->restaurant;

        abort_if($coupon->restaurant_id != $restaurant->id, 403);

        return view('restaurant.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $restaurant = Auth::user()->restaurant;

        abort_if($coupon->restaurant_id != $restaurant->id, 403);

        $request->validate([
            'code' => [
                'required',
                'max:100',
                Rule::unique('coupons')
                    ->ignore($coupon->id)
                    ->where(function ($query) use ($restaurant) {
                        return $query->where('restaurant_id', $restaurant->id);
                    }),
            ],
            'title' => 'required|max:255',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'required|boolean',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => $request->per_user_limit ?? 1,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('restaurant.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $restaurant = Auth::user()->restaurant;

        abort_if($coupon->restaurant_id != $restaurant->id, 403);

        $coupon->delete();

        return redirect()
            ->route('restaurant.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        $restaurantId = Product::find(reset($cart)['id'])->restaurant_id;

        $subtotal = collect($cart)->sum(function ($item) {
            return ($item['base_price'] + ($item['addon_total'] ?? 0))
                * $item['quantity'];
        });

        $coupon = Coupon::where('restaurant_id', $restaurantId)
            ->where('code', strtoupper($request->code))
            ->where('status',1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success'=>false,
                'message'=>'Invalid coupon.'
            ]);
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json([
                'success'=>false,
                'message'=>'Coupon expired.'
            ]);
        }

        if ($subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success'=>false,
                'message'=>'Minimum order amount is £'.$coupon->min_order_amount
            ]);
        }

        if ($coupon->type=='percentage') {

            $discount = ($subtotal * $coupon->value)/100;

            if($coupon->max_discount){
                $discount=min($discount,$coupon->max_discount);
            }

        } else {

            $discount=$coupon->value;

        }

        session([
            'coupon'=>[
                'id'=>$coupon->id,
                'discount'=>$discount
            ]
        ]);

        return response()->json([
            'success'=>true,
            'discount'=>$discount,
            'final'=>$subtotal-$discount
        ]);
    }
}