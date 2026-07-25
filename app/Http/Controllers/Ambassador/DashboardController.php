<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambassador Restaurants
        $restaurantIds = Restaurant::where('ambassador_id', $user->id)
            ->pluck('id');

        // Restaurants
        $totalRestaurants = $restaurantIds->count();

        $pendingRestaurants = Restaurant::whereIn('id', $restaurantIds)
            ->where('status', 0)
            ->count();

        $activeRestaurants = Restaurant::whereIn('id', $restaurantIds)
            ->where('status', 1)
            ->count();

        // Categories
        $totalCategories = Category::whereIn(
            'restaurant_id',
            $restaurantIds
        )->count();

        // Products
        $totalProducts = Product::whereIn(
            'restaurant_id',
            $restaurantIds
        )->count();

        return view(
            'ambassador.dashboard',
            compact(
                'totalRestaurants',
                'pendingRestaurants',
                'activeRestaurants',
                'totalCategories',
                'totalProducts'
            )
        );
    }
}