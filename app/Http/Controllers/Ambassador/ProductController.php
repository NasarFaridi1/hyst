<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;

class ProductController extends Controller
{
    public function index(Request $request,$restaurantId)
{
    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $search = $request->search;

    $products = Product::where(
            'restaurant_id',
            $restaurant->id
        )
        ->when($search,function($query) use($search){

            $query->where(function($q) use($search){

                $q->where('name','like',"%{$search}%")
                  ->orWhere('description','like',"%{$search}%");

            });

        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'ambassador.products.index',
        compact(
            'restaurant',
            'products',
            'search'
        )
    );
}

public function create($restaurantId)
{

    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $categories = Category::where(
            'restaurant_id',
            $restaurant->id
        )
        ->where('status',1)
        ->orderBy('display_order')
        ->get();

    return view(
        'ambassador.products.create',
        compact(
            'restaurant',
            'categories'
        )
    );

}

public function store(Request $request,$restaurantId)
{

    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $request->validate([

        'category_id'=>'required|exists:categories,id',

        'name'=>'required|max:255',

        'description'=>'nullable',

        'price'=>'required|numeric',

        'image'=>'nullable|image|mimes:jpg,jpeg,png,webp',

        'status'=>'required'

    ]);

    $image = null;

    if($request->hasFile('image')){

        $file = $request->file('image');

        $imageName = time().'_'.$file->getClientOriginalName();

        $file->move(
            public_path('storage/products'),
            $imageName
        );

        $image = 'products/'.$imageName;

    }

    Product::create([

        'restaurant_id'=>$restaurant->id,

        'vendor_id'=>Auth::id(),

        'category_id'=>$request->category_id,

        'name'=>$request->name,

        'slug'=>Str::slug($request->name).'-'.time(),

        'description'=>$request->description,

        'price'=>$request->price,

        'currency'=>'GBP',

        'image'=>$image,

        'product_type'=>$request->product_type ?? 'veg',

        'status'=>$request->status,

    ]);

    return redirect()
        ->route(
            'ambassador.products.index',
            $restaurant->id
        )
        ->with(
            'success',
            'Product Added Successfully.'
        );

}

public function edit($restaurantId, $productId)
{
    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $product = Product::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($productId);

    $categories = Category::where(
        'restaurant_id',
        $restaurant->id
    )
    ->where('status',1)
    ->orderBy('display_order')
    ->get();

    return view(
        'ambassador.products.edit',
        compact(
            'restaurant',
            'product',
            'categories'
        )
    );
}
public function update(Request $request,$restaurantId,$productId)
{
    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $product = Product::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($productId);

    $request->validate([

        'category_id' => 'required|exists:categories,id',

        'name' => 'required|max:255',

        'description' => 'nullable',

        'price' => 'required|numeric',

        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',

        'status' => 'required'

    ]);

    $image = $product->image;

    if($request->hasFile('image')){

        if(
            $product->image &&
            file_exists(public_path('storage/'.$product->image))
        ){
            unlink(public_path('storage/'.$product->image));
        }

        $file = $request->file('image');

        $imageName = time().'_'.$file->getClientOriginalName();

        $file->move(
            public_path('storage/products'),
            $imageName
        );

        $image = 'products/'.$imageName;

    }

    $product->update([

        'category_id' => $request->category_id,

        'name' => $request->name,

        'slug' => Str::slug($request->name).'-'.time(),

        'description' => $request->description,

        'price' => $request->price,

        'image' => $image,

        'product_type' => $request->product_type ?? 'veg',

        'status' => $request->status,

    ]);

    return redirect()
        ->route(
            'ambassador.products.index',
            $restaurant->id
        )
        ->with(
            'success',
            'Product Updated Successfully.'
        );
}

public function destroy($restaurantId, $productId)
{
    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $product = Product::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($productId);

    if (
        $product->image &&
        file_exists(public_path('storage/'.$product->image))
    ) {
        unlink(public_path('storage/'.$product->image));
    }

    $product->delete();

    return redirect()
        ->route(
            'ambassador.products.index',
            $restaurant->id
        )
        ->with(
            'success',
            'Product Deleted Successfully.'
        );
}
}