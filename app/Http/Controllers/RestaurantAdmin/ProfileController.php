<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::findOrFail(
            auth()->user()->restaurant_id
        );

        return view(
            'restaurant.profile.index',
            compact('restaurant')
        );
    }

    public function update(Request $request)
    {
        $restaurant = Restaurant::findOrFail(
            auth()->user()->restaurant_id
        );

        $image = $restaurant->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('restaurants', 'public');
        }

        $certificate = $restaurant->hygiene_certificate;

        if ($request->hasFile('hygiene_certificate')) {

            $file = $request->file('hygiene_certificate');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('restaurant-certificates'), $fileName);

            $certificate = 'restaurant-certificates/'.$fileName;
        }

        $restaurant->update([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'location' => $request->location,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'description' => $request->description,

            'image' => $image,

            'dine_in' => $request->dine_in,

            'home_delivery' => $request->home_delivery,

            'hygiene_rating' => $request->hygiene_rating,

            'hygiene_certificate' => $certificate,

            // New Fields
            'working_days' => $request->filled('working_days')
                ? implode(',', $request->working_days)
                : null,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,

        ]);

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'restaurant_status' => 'required|in:Open,Closed',
        ]);

        $restaurant = Restaurant::findOrFail(auth()->user()->restaurant_id);

        $restaurant->update([
            'restaurant_status' => $request->restaurant_status,
        ]);

        return back()->with('success', 'Restaurant status updated successfully.');
    }
}