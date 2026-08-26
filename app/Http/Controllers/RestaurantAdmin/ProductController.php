<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\GoogleDriveService;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )->latest()->get();

    //     return view(
    //         'restaurant.products.index',
    //         compact('products')
    //     );
    // }

    // public function index(Request $request)
    // {
    //     $search = $request->search;

    //     $products = Product::with('category')
    //         ->where('restaurant_id', auth()->user()->restaurant_id)
    //         ->when($search, function ($query) use ($search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('name', 'like', "%{$search}%")
    //                 ->orWhere('price', 'like', "%{$search}%")
    //                 ->orWhereHas('category', function ($category) use ($search) {
    //                     $category->where('name', 'like', "%{$search}%");
    //                 });
    //             });
    //         })
    //         ->latest()
    //         ->paginate(10)
    //         ->withQueryString();

    //     return view(
    //         'restaurant.products.index',
    //         compact('products', 'search')
    //     );
    // }

    public function index(Request $request)
{
    $search = $request->search;

    $products = Product::with('category')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->select('products.*')
        ->where('products.restaurant_id', auth()->user()->restaurant_id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.price', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($category) use ($search) {
                      $category->where('name', 'like', "%{$search}%");
                  });
            });
        })
        ->orderByRaw('categories.display_order IS NULL')
        ->orderBy('categories.display_order', 'ASC')
        ->orderBy('products.id', 'ASC')
        ->paginate(10)
        ->withQueryString();

    return view(
        'restaurant.products.index',
        compact('products', 'search')
    );
}

    public function create()
    {
        $categories = Category::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->get();

        return view(
            'restaurant.products.create',
            compact('categories')
        );
    }


    public function store(Request $request)
    {
        $image = null;

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image')
        //         ->store('products', 'public');
        // }

        if ($request->hasFile('image')) {

            $drive = new GoogleDriveService();

            $file = $drive->upload(
                $request->file('image')
            );

            $image = $file->id;
        }


        $product = Product::create([

            'restaurant_id' => auth()->user()->restaurant_id,

            'category_id' => $request->category_id,

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'image' => $image,

            'price' => $request->price,

            'currency' => 'Pound',

            'product_type' => $request->product_type ?? 'veg',

            'status' => 1
        ]);

         // Regular variant from product price
        $product->variants()->create([
            'name' => 'Regular',
            'price' => $request->price,
            'is_default' => 1,
            'status' => 1
        ]);

        // Additional variants
        if ($request->variant_name) {

            foreach ($request->variant_name as $index => $name) {

                if (!empty($name) && !empty($request->variant_price[$index])) {

                    $product->variants()->create([
                        'name' => $name,
                        'price' => $request->variant_price[$index],
                        'is_default' => 0,
                        'status' => 1
                    ]);
                }
            }
        }

        return redirect()
            ->route('restaurant.products.index')
            ->with('success', 'Product Added');
    }
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);

        $categories = Category::all();

        return view(
            'restaurant.products.edit',
            compact('product', 'categories')
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $image = $product->image;

        // if ($request->hasFile('image')) {

        //     $image = $request->file('image')
        //         ->store('products', 'public');
        // }

        if ($request->hasFile('image')) {

            $drive = new GoogleDriveService();

            // Delete old Google Drive image
            if (!empty($product->image) && !str_contains($product->image, '/')) {

                try {
                    $drive->delete($product->image);
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }

            // Upload new image
            $file = $drive->upload(
                $request->file('image')
            );

            $image = $file->id;
        }

        $product->update([

            'category_id' => $request->category_id,

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'image' => $image,

            'price' => $request->price,

            'product_type' => $request->product_type ?? 'veg'
        ]);


        // Update Regular variant
        $regularVariant = $product->variants()
            ->where('is_default', 1)
            ->first();

        if ($regularVariant) {
            $regularVariant->update([
                'price' => $request->price
            ]);
        } else {
            $product->variants()->create([
                'name' => 'Regular',
                'price' => $request->price,
                'is_default' => 1,
                'status' => 1
            ]);
        }

        // Delete existing non-default variants
        $product->variants()
            ->where('is_default', 0)
            ->delete();

        if ($request->variant_names) {

            foreach ($request->variant_names as $index => $name) {

                if (!empty($name) && !empty($request->variant_prices[$index])) {

                    $product->variants()->create([
                        'name' => $name,
                        'price' => $request->variant_prices[$index],
                        'is_default' => 0,
                        'status' => 1
                    ]);
                }
            }
        }

        return redirect('/restaurant/products')
            ->with('success', 'Updated');
    }

    // public function destroy($id)
    // {
    //     Product::findOrFail($id)->delete();

    //     return back()->with('success', 'Deleted');
    // }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        try {

            // Delete image from Google Drive
            if (!empty($product->image) && !str_contains($product->image, '/')) {

                $drive = new GoogleDriveService();

                $drive->delete($product->image);
            }

        } catch (\Exception $e) {

            \Log::error([
                'product_id' => $product->id,
                'google_drive_file_id' => $product->image,
                'error' => $e->getMessage()
            ]);
        }

        $product->delete();

        return back()->with('success', 'Deleted');
    }
}