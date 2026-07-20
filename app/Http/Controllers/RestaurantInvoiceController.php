<?php

namespace App\Http\Controllers;

use App\Models\Order;

class RestaurantInvoiceController extends Controller
{
    public function show($id)
    {
        $order = Order::with([
            'user',
            'restaurant',
            'items.product',
            'payment',
            'invoice'
        ])
        ->where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
        ->findOrFail($id);

        if (auth()->user()->restaurant_id !== $order->restaurant_id) {
            abort(403, 'Unauthorized');
        }

        return view(
            'restaurant.invoices.show',
            compact('order')
        );
    }
}