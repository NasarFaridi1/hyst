<?php

namespace App\Http\Controllers;

use App\Models\Order;

class UserInvoiceController extends Controller
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
            'user_id',
            auth()->id()
        )
        ->findOrFail($id);

        // if (auth()->id() !== $order->user_id) {
        //     abort(403, 'Unauthorized');
        // }

        return view(
            'front.invoice',
            compact('order')
        );
    }
}