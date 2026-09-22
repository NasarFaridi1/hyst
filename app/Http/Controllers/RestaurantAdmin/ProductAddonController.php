<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAddon;

class ProductAddonController extends Controller
{
    private function getRestaurantId()
    {
        $user = auth()->user();
        return $user->restaurant_id ?? optional($user->restaurant)->id;
    }

    public function index()
    {
        $restaurantId = $this->getRestaurantId();
        $addons = ProductAddon::where('restaurant_id', $restaurantId)
            ->latest()
            ->paginate(20);

        return view('restaurant.products.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('restaurant.products.addons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'addon_name'    => 'required',
            'price'         => 'required|numeric|min:0'
        ]);

        $restaurantId = $this->getRestaurantId();

        ProductAddon::create([
            'restaurant_id' => $restaurantId,
            'category_name' => $request->category_name,
            'addon_name'    => $request->addon_name,
            'price'         => $request->price,
            'status'        => $request->input('status', 1),
        ]);

        return redirect()
            ->route('restaurant.addons.index')
            ->with('success', 'Addon Added Successfully');
    }

    public function edit(ProductAddon $addon)
    {
        $restaurantId = $this->getRestaurantId();
        if ($addon->restaurant_id && $addon->restaurant_id != $restaurantId) {
            abort(403);
        }

        return view('restaurant.products.addons.edit', compact('addon'));
    }

    public function update(Request $request, ProductAddon $addon)
    {
        $restaurantId = $this->getRestaurantId();
        if ($addon->restaurant_id && $addon->restaurant_id != $restaurantId) {
            abort(403);
        }

        $request->validate([
            'category_name' => 'required',
            'addon_name'    => 'required',
            'price'         => 'required|numeric|min:0'
        ]);

        $addon->update([
            'category_name' => $request->category_name,
            'addon_name'    => $request->addon_name,
            'price'         => $request->price,
            'status'        => $request->input('status', 1),
        ]);

        return redirect()
            ->route('restaurant.addons.index')
            ->with('success', 'Addon Updated Successfully');
    }

    public function destroy(ProductAddon $addon)
    {
        $restaurantId = $this->getRestaurantId();
        if ($addon->restaurant_id && $addon->restaurant_id != $restaurantId) {
            abort(403);
        }

        $addon->delete();

        return back()->with('success', 'Addon Deleted Successfully');
    }
}