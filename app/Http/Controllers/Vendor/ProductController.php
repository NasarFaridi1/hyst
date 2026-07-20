<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where(
            'vendor_id',
            auth()->id()
        )->latest()->get();

        return view(
            'vendor.products.index',
            compact('products')
        );
    }

    public function create()
    {
        $categories = Category::all();

        return view(
            'vendor.products.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $image = null;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([

            'vendor_id' => auth()->id(),

            'category_id' => $request->category_id,

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'image' => $image,

            'price' => $request->price,

            'currency' => 'EUR',

            'status' => 1
        ]);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product Added');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::all();

        return view(
            'vendor.products.edit',
            compact('product', 'categories')
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $image = $product->image;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('products', 'public');
        }

        $product->update([

            'category_id' => $request->category_id,

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'image' => $image,

            'price' => $request->price
        ]);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Updated');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return back()->with('success', 'Deleted');
    }
}