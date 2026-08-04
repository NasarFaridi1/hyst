<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantDeliveryCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantDeliveryChargeController extends Controller
{
    protected function restaurant()
    {
        return Restaurant::where('email', Auth::user()->email)->firstOrFail();
    }

    public function index()
    {
        
        $restaurant = $this->restaurant();

        dd($restaurant->deliveryCharges()->orderBy('from_distance')->get());

        $charges = $restaurant->deliveryCharges()
            ->orderBy('from_distance')
            ->get();

        return view('restaurant.delivery-charges.index', compact('restaurant', 'charges'));
    }

    public function create()
    {
        return view('restaurant.delivery-charges.create');
    }

    public function store(Request $request)
    {
        $restaurant = $this->restaurant();

        $request->validate([
            'from_distance' => 'required|numeric|min:0',
            'to_distance' => 'required|numeric|gt:from_distance',
            'delivery_charge' => 'required|numeric|min:0',
            'free_delivery_min_order' => 'nullable|numeric|min:0',
        ]);

        RestaurantDeliveryCharge::create([
            'restaurant_id' => $restaurant->id,
            'from_distance' => $request->from_distance,
            'to_distance' => $request->to_distance,
            'delivery_charge' => $request->delivery_charge,
            'free_delivery_min_order' => $request->free_delivery_min_order,
        ]);

        return redirect()
            ->route('restaurant.delivery-charges.index')
            ->with('success', 'Delivery charge added successfully.');
    }

    public function edit(RestaurantDeliveryCharge $deliveryCharge)
    {
        $restaurant = $this->restaurant();

        abort_if($deliveryCharge->restaurant_id != $restaurant->id, 403);

        return view('restaurant.delivery-charges.edit', compact('deliveryCharge'));
    }

    public function update(Request $request, RestaurantDeliveryCharge $deliveryCharge)
    {
        $restaurant = $this->restaurant();

        abort_if($deliveryCharge->restaurant_id != $restaurant->id, 403);

        $request->validate([
            'from_distance' => 'required|numeric|min:0',
            'to_distance' => 'required|numeric|gt:from_distance',
            'delivery_charge' => 'required|numeric|min:0',
            'free_delivery_min_order' => 'nullable|numeric|min:0',
        ]);

        $deliveryCharge->update([
            'from_distance' => $request->from_distance,
            'to_distance' => $request->to_distance,
            'delivery_charge' => $request->delivery_charge,
            'free_delivery_min_order' => $request->free_delivery_min_order,
        ]);

        return redirect()
            ->route('restaurant.delivery-charges.index')
            ->with('success', 'Delivery charge updated successfully.');
    }

    public function destroy(RestaurantDeliveryCharge $deliveryCharge)
    {
        $restaurant = $this->restaurant();

        abort_if($deliveryCharge->restaurant_id != $restaurant->id, 403);

        $deliveryCharge->delete();

        return back()->with('success', 'Delivery charge deleted successfully.');
    }
}