<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAddon;

class ProductAddonController extends Controller
{
    public function index(Product $product)
    {
        $addons = $product->addons()->latest()->paginate(20);

        return view('restaurant.products.addons.index', compact('product','addons'));
    }

    public function create(Product $product)
    {
        return view('restaurant.products.addons.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'category_name'=>'required',
            'addon_name'=>'required',
            'price'=>'required|numeric'
        ]);

        $product->addons()->create($request->all());

        return back()->with('success','Addon Added Successfully');
    }

    public function edit(Product $product, ProductAddon $addon)
    {
        return view('restaurant.products.addons.edit', compact('product','addon'));
    }

    public function update(Request $request, Product $product, ProductAddon $addon)
    {
        $request->validate([
            'category_name'=>'required',
            'addon_name'=>'required',
            'price'=>'required|numeric'
        ]);

        $addon->update($request->all());

        return redirect()
            ->route('restaurant.products.addons.index',$product->id)
            ->with('success','Addon Updated');
    }

    public function destroy(Product $product, ProductAddon $addon)
    {
        $addon->delete();

        return back()->with('success','Addon Deleted');
    }
}