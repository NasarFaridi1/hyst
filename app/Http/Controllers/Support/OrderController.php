<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $orders = Order::with(['user', 'restaurant'])
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('restaurant', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('support.orders.index', compact('orders', 'search'));
    }

    public function show($id)
    {
        $order = Order::with([
            'user',
            'restaurant',
            'items.product',
            'payment',
            'review',
            'invoice'
        ])->findOrFail($id);

        return view('support.orders.show', compact('order'));
    }
}
