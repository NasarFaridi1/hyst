<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantTermsCondition;
use Illuminate\Http\Request;

class RestaurantTermsConditionController extends Controller
{
    public function restaurantTerms($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        $terms = RestaurantTermsCondition::where(
            'restaurant_id',
            $restaurant->id
        )->first();

        return view(
            'front.restaurant-terms',
            compact('restaurant', 'terms')
        );
    }
    public function edit($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        $terms = RestaurantTermsCondition::firstOrCreate(
            ['restaurant_id' => $restaurant->id],
            ['content' => '']
        );

        return view('admin.restaurant-terms.edit', compact(
            'restaurant',
            'terms'
        ));
    }

    public function update(Request $request, $restaurant)
    {
        $request->validate([
            'content' => 'required',
        ]);

        RestaurantTermsCondition::updateOrCreate(
            ['restaurant_id' => $restaurant],
            ['content' => $request->content]
        );

        return back()->with(
            'success',
            'Restaurant Terms & Conditions updated successfully.'
        );
    }
}