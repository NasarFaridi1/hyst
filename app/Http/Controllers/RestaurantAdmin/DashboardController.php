<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Restaurant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurantId = auth()->user()->restaurant_id;

        /*
        |--------------------------------------------------------------------------
        | TOTAL PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = Product::where(
            'restaurant_id',
            $restaurantId
        )->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDERS
        |--------------------------------------------------------------------------
        */

        $orders = Order::where(
            'restaurant_id',
            $restaurantId
        )->count();

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::where(
            'restaurant_id',
            $restaurantId
        )->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL EARNINGS
        |--------------------------------------------------------------------------
        */

        $earnings = Payment::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('payment_status', 'paid')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | PENDING ORDERS
        |--------------------------------------------------------------------------
        */

        $pendingOrders = Order::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('status', 'pending')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | COMPLETED ORDERS
        |--------------------------------------------------------------------------
        */

        $completedOrders = Order::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('status', 'completed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RECENT ORDERS
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::where(
            'restaurant_id',
            $restaurantId
        )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT PAYMENTS
        |--------------------------------------------------------------------------
        */

        $recentPayments = Payment::where(
            'restaurant_id',
            $restaurantId
        )
            ->latest()
            ->take(5)
            ->get();

        $restaurant = Restaurant::find($restaurantId);
        $restaurantUrl = route(
            'restaurant.products',
            $restaurant->slug
        );

        $restaurantQr = QrCode::format('svg')
            ->size(250)
            ->generate($restaurantUrl);

        return view(
            'restaurant.dashboard',
            compact(
                'products',
                'orders',
                'categories',
                'earnings',
                'pendingOrders',
                'completedOrders',
                'recentOrders',
                'recentPayments',
                'restaurant',
                'restaurantQr',
                'restaurantUrl',
            )
        );
    }
}