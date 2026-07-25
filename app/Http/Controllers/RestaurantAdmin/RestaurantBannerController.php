<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;

use App\Models\Restaurant;
use App\Models\RestaurantBanner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantBannerController extends Controller
{
    public function index()
    {
        $restaurant = User::where('id', Auth::id())->firstOrFail();

        $banners = RestaurantBanner::where('restaurant_id', $restaurant->restaurant_id)
            ->latest()
            ->get();

        return view('restaurant.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('restaurant.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'status' => 'required'
        ]);

        $restaurant = User::where('id', Auth::id())->firstOrFail();

        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();

        $request->image->move(public_path('restaurant_banners'), $imageName);

        RestaurantBanner::create([
            'restaurant_id' => $restaurant->restaurant_id,
            'image' => 'restaurant_banners/' . $imageName,
            'status' => $request->status
        ]);

        return redirect()->route('restaurant.banners.index')
            ->with('success', 'Banner Added Successfully');
    }

    public function edit($id)
    {
        $banner = RestaurantBanner::findOrFail($id);

        return view('restaurant.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'status' => 'required'
        ]);

        $banner = RestaurantBanner::findOrFail($id);

        
        if ($request->hasFile('image')) {

            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();

            $request->image->move(public_path('restaurant_banners'), $imageName);

            $banner->image = 'restaurant_banners/' . $imageName;
        }

        $banner->status = $request->status;
        $banner->save();

        return redirect()->route('restaurant.banners.index')
            ->with('success', 'Banner Updated Successfully');
    }

    public function destroy($id)
    {
        $banner = RestaurantBanner::findOrFail($id);

        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $banner->delete();

        return back()->with('success', 'Banner Deleted Successfully');
    }

    public function updateSelfDelivery(Request $request)
    {
        $request->validate([
            'self_delivery' => 'required|boolean',
        ]);

        $restaurant = Restaurant::where('id', $request->restaurant_id)->firstOrFail();

        $restaurant->self_delivery = $request->self_delivery;
        $restaurant->save();

        return response()->json([
            'success' => true,
            'message' => 'Self delivery updated successfully.',
            'self_delivery' => $restaurant->self_delivery,
        ]);
    }
}