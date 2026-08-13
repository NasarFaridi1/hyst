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
            ['content' => $this->sanitizeHtml($request->content)]
        );

        return back()->with(
            'success',
            'Restaurant Terms & Conditions updated successfully.'
        );
    }

    private function sanitizeHtml($content)
    {
        if (!$content) return '';

        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $content = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $content);
        $content = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', '', $content);
        $content = preg_replace('/<embed\b[^>]*>(.*?)<\/embed>/is', '', $content);
        $content = preg_replace('/on[a-z]+\s*=\s*(["\'])[^\1]*?\1/i', '', $content);
        $content = preg_replace('/on[a-z]+\s*=\s*[^"\'\s>]+/i', '', $content);
        $content = preg_replace('/href\s*=\s*(["\'])\s*javascript:[^\1]*?\1/i', 'href="#"', $content);

        return $content;
    }
}