<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCharge;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeCharge = ProductCharge::where('is_active', 1)->first();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalHystChargesCollected = Order::sum('hyst_charge');

        return view('system_admin.dashboard', compact(
            'activeCharge',
            'totalProducts',
            'totalOrders',
            'totalHystChargesCollected'
        ));
    }
}
