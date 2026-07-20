<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\OrderOffer;
use Illuminate\Http\Request;

class OrderOfferController extends Controller
{
    public function index()
    {
        $offers = OrderOffer::latest()->get();

        return view('restaurant.order-offers.index', compact('offers'));
    }

    public function create()
    {
        return view('restaurant.order-offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'min_order_value' => 'required|numeric',
            'value' => 'required|numeric',
            'value_type' => 'required|in:fixed,percentage',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $request->merge([
            'restaurant_id' => auth()->user()->restaurant_id,
        ]);

        OrderOffer::create($request->all());

        return redirect('/restaurant/order-offers')
            ->with('success', 'Offer created successfully');
    }

    public function edit($id)
    {
        $offer = OrderOffer::findOrFail($id);

        return view('restaurant.order-offers.edit', compact('offer'));
    }

    public function update(Request $request, $id)
    {
        $offer = OrderOffer::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'min_order_value' => 'required|numeric',
            'value' => 'required|numeric',
            'value_type' => 'required|in:fixed,percentage',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $request->merge([
            'restaurant_id' => auth()->user()->restaurant_id,
        ]);

        $offer->update($request->all());

        return redirect('/restaurant/order-offers')
            ->with('success', 'Offer updated successfully');
    }

    public function destroy($id)
    {
        OrderOffer::findOrFail($id)->delete();

        return back()->with('success', 'Offer deleted successfully');
    }
}