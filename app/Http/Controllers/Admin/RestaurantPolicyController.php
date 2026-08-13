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
            ['content' => $this->sanitizeHtml($request->content)]
        );

        return back()->with('success', 'Restaurant Policy updated successfully.');
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