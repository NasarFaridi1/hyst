<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantPolicy;
use Illuminate\Http\Request;

class RestaurantPolicyController extends Controller
{
    public function policy($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->first();
        $policy    = RestaurantPolicy::where('restaurant_id', $restaurant->id)->first();

        return view('front.policy', compact('policy', 'restaurant'));
    }
    public function edit($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        $policy = RestaurantPolicy::where('restaurant_id', $restaurant->id)->first();

        return view('admin.restaurant-policy.edit', compact('restaurant', 'policy'));
    }

    public function update(Request $request, $restaurant)
    {
        $request->validate([
            'content' => 'required',
        ]);

        RestaurantPolicy::updateOrCreate(
            ['restaurant_id' => $restaurant],
            ['content' => $request->content]
        );

        return back()->with('success', 'Restaurant Policy updated successfully.');
    }
}