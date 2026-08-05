<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Restaurant;
use App\Services\UberService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\SelfDeliveryService;

use App\Models\Address;

class UserAddressController extends Controller
{
    /**
     * Display all addresses of logged in user
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $addresses
        ]);
    }


   

    public function generateUberQuote(Request $request)
    {
        
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'selectedAddress_id' => 'required|exists:user_addresses,id',
        ]);

        try {

            $restaurant = Restaurant::findOrFail($request->restaurant_id);

            $userAddress = UserAddress::findOrFail($request->selectedAddress_id);

            $uber = new UberService();

            Log::info('Generating Uber Quote', [
                'restaurant_id' => $restaurant->id,
                'user_id' => Auth::id(),
            ]);

            $quote = $uber->quoteFromCheckout(
                $restaurant,
                Auth::user(),
                [
                    'address' => $userAddress->address,
                    'city' => $userAddress->city,
                    'state' => $userAddress->state,
                    'country' => $userAddress->country,
                    'postcode' => $userAddress->postcode,
                    'latitude' => $userAddress->latitude,
                    'longitude' => $userAddress->longitude,
                    'amount' => $request->finalTotal,
                ]
            );

            

            return response()->json([
                'success' => true,
                'message' => 'Uber quote generated successfully.',
                'data' => $quote
            ]);

        } catch (\Exception $e) {

            Log::error('Uber Quote Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store new address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|in:Home,Work,Other',
            'building_type' => 'required|in:House,Flat,Office,Hotel,Other',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'flat_number' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:50',
            'building_name' => 'nullable|string|max:255',
            'entrance' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();

        if (!empty($validated['is_default'])) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => 0]);
        }

        $address = UserAddress::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully.',
            'data' => $address
        ]);
    }

    /**
     * Update address
     */
    public function update(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'label' => 'nullable|in:Home,Work,Other',
            'building_type' => 'required|in:House,Flat,Office,Hotel,Other',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'flat_number' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:50',
            'building_name' => 'nullable|string|max:255',
            'entrance' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        if (!empty($validated['is_default'])) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => 0]);
        }

        $address->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.',
            'data' => $address
        ]);
    }

    /**
     * Delete address
     */
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())
            ->findOrFail($id);

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully.'
        ]);
    }

    /**
     * Set default address
     */
    public function setDefault($id)
    {
        UserAddress::where('user_id', Auth::id())
            ->update([
                'is_default' => 0
            ]);

        $address = UserAddress::where('user_id', Auth::id())
            ->findOrFail($id);

        $address->update([
            'is_default' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated.'
        ]);
    }

    /**
     * Get single address
     */
    public function show($id)
    {
        $address = UserAddress::where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }



    public function selfDeliveryQuote(
        Request $request,
        SelfDeliveryService $selfDeliveryService
    )
    {

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'selectedAddress_id' => 'required',
            'finalTotal' => 'required|numeric',
        ]);

        // return response()->json([
        //     'success' => true,
        //     'data' => [
        //         'restaurant_id' => $request->restaurant_id,
        //         'selectedAddress_id' => $request->selectedAddress_id,
        //         'finalTotal' => $request->finalTotal,
        //     ]
        // ]);
            

        $restaurant = Restaurant::findOrFail(
            $request->restaurant_id
        );

        $address = UserAddress::findOrFail(
            $request->selectedAddress_id
        );


        if (!$restaurant->self_delivery) {

            return response()->json([
                'success' => false,
                'message' => 'Restaurant does not support self delivery.',
            ], 422);

        }

        $result = $selfDeliveryService->calculate(

            $restaurant,

            (float)$address->latitude,

            (float)$address->longitude,

            (float)$request->finalTotal

        );

        if (!$result['success']) {

            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);

        }

        return response()->json([

            'success' => true,

            'data' => [

                'distance' => $result['distance'],

                'delivery_charge' => $result['delivery_charge'],

                'free_delivery' => $result['free_delivery'],

                'slab' => $result['slab'],

            ]

        ]);

    }
}