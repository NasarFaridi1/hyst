<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class RestaurantPaymentController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $payments = Payment::with([
            'order',
            'order.user'
        ])
            ->where(
                'restaurant_id',
                auth()->user()->restaurant_id
            )
            ->whereDate(
                'created_at',
                today()
            )
            ->latest()
            ->get();

        return view(
            'restaurant.payments.index',
            compact('payments','restaurant')
        );
    }

    /*
|--------------------------------------------------------------------------
| ALL PAYMENTS
|--------------------------------------------------------------------------
*/

public function allPayments()
{
    $payments = Payment::with([
        'order',
        'order.user'
    ])
    ->where(
        'restaurant_id',
        auth()->user()->restaurant_id
    )
    ->latest()
    ->get();

    return view(
        'restaurant.payments.allpayment',
        compact('payments')
    );
}
}