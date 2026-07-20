<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $restaurantId = auth()->user()->restaurant_id;

        $customers = User::whereHas('orders', function ($q) use ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        })
            ->withCount([
                'orders as total_orders' => function ($q) use ($restaurantId) {
                    $q->where('restaurant_id', $restaurantId);
                }
            ])
            ->paginate(15);

        // Restaurant Top Selling Dishes
        $restaurantFavouriteDishes = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.restaurant_id', $restaurantId)
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_orders')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();

        return view('restaurant.customers.index', compact(
            'customers',
            'restaurantFavouriteDishes'
        ));
    }

    public function show($id)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $customer = User::findOrFail($id);

        $orders = Order::with('items.product')
            ->where('restaurant_id', $restaurantId)
            ->where('user_id', $id)
            ->latest()
            ->get();

        // Customer Lifetime Value
        // Customer Lifetime Value
        $clv = $orders->sum('total_amount');

        /*
        |--------------------------------------------------------------------------
        | Customer Favourite Dishes
        |--------------------------------------------------------------------------
        */

        $customerFavouriteDishes = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.restaurant_id', $restaurantId)
            ->where('orders.user_id', $id)
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_orders')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_orders')
            ->limit(5)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Restaurant Top Selling Dishes
        |--------------------------------------------------------------------------
        */

        $restaurantFavouriteDishes = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.restaurant_id', $restaurantId)
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_orders')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();

        return view('restaurant.customers.show', compact(
            'customer',
            'orders',
            'clv',
            'customerFavouriteDishes',
            'restaurantFavouriteDishes'
        ));
    }

public function onlineOrdering()
{
    $restaurantId = auth()->user()->restaurant_id;

    // Order Type count
    $orderTypes = Order::where('restaurant_id', $restaurantId)
        ->select(
            'order_type',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('order_type')
        ->get();

    // Web aur App orders count
    $orderSources = Order::where('restaurant_id', $restaurantId)
        ->whereIn('order_from', ['web', 'app'])
        ->select(
            'order_from',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('order_from')
        ->get();

    return view(
        'restaurant.ordering.index',
        compact('orderTypes', 'orderSources')
    );
}
}