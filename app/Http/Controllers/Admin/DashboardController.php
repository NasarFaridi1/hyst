<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Restaurant;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::count();

        $products = Product::count();

        $orders = Order::count();

        $users = User::count();

        $playersCount = 0;
        try {
            $playersCount = \App\Models\PlayerCatalogue::count();
        } catch (\Throwable $e) {}

        return view('admin.dashboard', compact(
            'restaurants',
            'products',
            'orders',
            'users',
            'playersCount'
        ));
    }
}