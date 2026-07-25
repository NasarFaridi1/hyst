<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftCardController extends Controller
{
    public function index()
    {
        $giftCards = GiftCard::latest()->paginate(15);

        return view('admin.gift-cards.index', compact('giftCards'));
    }

    public function create()
    {
        return view('admin.gift-cards.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:gift_cards,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'amount' => 'required|numeric|min:1',
            'minimum_order_amount' => 'nullable|numeric|min:0',

            'total_usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',

            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',

            'status' => 'required|in:active,inactive',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['balance'] = $data['amount'];
        $data['total_used'] = 0;
        $data['created_by'] = auth()->id();

        GiftCard::create($data);

        return redirect()
            ->route('admin.gift-cards.index')
            ->with('success', 'Gift card created successfully.');
    }

    public function edit(GiftCard $giftCard)
    {
        return view('admin.gift-cards.edit', compact('giftCard'));
    }

    public function update(Request $request, GiftCard $giftCard)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:gift_cards,code,' . $giftCard->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'minimum_order_amount' => 'nullable|numeric|min:0',

            'total_usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',

            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',

            'status' => 'required|in:active,inactive',
        ]);

        $data['code'] = strtoupper($data['code']);

        $giftCard->update($data);

        return redirect()
            ->route('admin.gift-cards.index')
            ->with('success', 'Gift card updated successfully.');
    }

    public function destroy(GiftCard $giftCard)
    {
        $giftCard->delete();

        return redirect()
            ->route('admin.gift-cards.index')
            ->with('success', 'Gift card deleted successfully.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $cart = session('cart', []);

        if(empty($cart)){
            return response()->json([
                'success'=>false,
                'message'=>'Cart is empty.'
            ]);
        }

        $subtotal = collect($cart)->sum(function($item){
            return ($item['base_price'] + ($item['addon_total'] ?? 0))
                * $item['quantity'];
        });

        $offerDiscount = (float) $request->input('offer_discount', 0);
        $couponDiscount = (float) $request->input('coupon_discount', 0);
        $remainingSubtotal = max($subtotal - $offerDiscount - $couponDiscount, 0);

        $giftCard = GiftCard::where('code', strtoupper(trim($request->code)))
            ->where('status','active')
            ->first();

        if(!$giftCard){
            return response()->json([
                'success'=>false,
                'message'=>'Invalid Gift Card.'
            ]);
        }

        if($giftCard->expires_at && now()->gt($giftCard->expires_at)){
            return response()->json([
                'success'=>false,
                'message'=>'Gift Card expired.'
            ]);
        }

        if($giftCard->minimum_order_amount && $remainingSubtotal < $giftCard->minimum_order_amount){
            return response()->json([
                'success'=>false,
                'message'=>'Minimum order amount is £'.number_format($giftCard->minimum_order_amount,2)
            ]);
        }

        if($giftCard->balance <= 0){
            return response()->json([
                'success'=>false,
                'message'=>'Gift Card balance exhausted.'
            ]);
        }

        $discount = min($giftCard->balance, $remainingSubtotal);

        return response()->json([
            'success'=>true,
            'gift_card_id'=>$giftCard->id,
            'gift_card'=>$giftCard->code,
            'discount'=>number_format(round($discount,2), 2, '.', ''),
            'subtotal'=>number_format(round($remainingSubtotal,2), 2, '.', ''),
            'balance'=>number_format(round($giftCard->balance,2), 2, '.', '')
        ]);
    }
}