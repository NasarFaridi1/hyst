<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantRefundPolicy;
use Illuminate\Http\Request;

class RestaurantRefundPolicyController extends Controller
{
    public function edit($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        $policy = RestaurantRefundPolicy::firstOrCreate(
            ['restaurant_id' => $restaurant->id],
            ['content' => '']
        );

        return view('admin.restaurant-refund.edit', compact(
            'restaurant',
            'policy'
        ));
    }

    public function update(Request $request, $restaurant)
    {
        $request->validate([
            'content' => 'required',
        ]);

        RestaurantRefundPolicy::updateOrCreate(
            ['restaurant_id' => $restaurant],
            ['content' => $request->content]
        );

        return back()->with(
            'success',
            'Refund policy updated successfully.'
        );
    }

    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        $policy = RestaurantRefundPolicy::where(
            'restaurant_id',
            $restaurant->id
        )->first();

        return view('front.restaurant-refund-policy', compact(
            'restaurant',
            'policy'
        ));
    }
}