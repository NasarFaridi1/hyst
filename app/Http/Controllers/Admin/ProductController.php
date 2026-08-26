<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Str;

use App\Services\GoogleDriveService;
use Illuminate\Http\File;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::with(
    //         'category',
    //         'restaurant',
    //         'vendor'
    //     )->latest()->get();

    //     return view('admin.products.index', compact('products'));
    // }

    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::with([
                'category',
                'restaurant',
                'vendor'
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('restaurant', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact(
            'products',
            'search'
        ));
    }

    public function create()
    {
        $categories = Category::all();

        $restaurants = Restaurant::all();

        $vendors = User::where('role','vendor')->get();

        return view('admin.products.create',
            compact('categories','restaurants','vendors'));
    }

    public function store(Request $request)
    {
        $image = null;

        // if($request->hasFile('image')){
        //     $image = $request->file('image')
        //         ->store('products','public');
        // }

        if ($request->hasFile('image')) {

            $drive = new GoogleDriveService();

            $file = $drive->upload(
                $request->file('image')
            );

            $image = $file->id;
        }

        Product::create([
            'restaurant_id' => $request->restaurant_id,
            'vendor_id' => $request->vendor_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'currency' => 'EUR',
            'product_type' => $request->product_type ?? 'veg',
            'status' => 1
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success','Product Added');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::all();

        $restaurants = Restaurant::all();

        $vendors = User::where('role','vendor')->get();

        return view('admin.products.edit',
            compact(
                'product',
                'categories',
                'restaurants',
                'vendors'
            ));
    }

    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $image = $product->image;

    //     if($request->hasFile('image')){
    //         $image = $request->file('image')
    //             ->store('products','public');
    //     }

    //     $product->update([
    //         'restaurant_id' => $request->restaurant_id,
    //         'vendor_id' => $request->vendor_id,
    //         'category_id' => $request->category_id,
    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name),
    //         'description' => $request->description,
    //         'image' => $image,
    //         'price' => $request->price
    //     ]);

    //     return redirect()
    //         ->route('admin.products.index')
    //         ->with('success','Updated');
    // }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $image = $product->image;

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
            'restaurant_id' => $request->restaurant_id,
            'vendor_id' => $request->vendor_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'product_type' => $request->product_type ?? 'veg'
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Updated');
    }

    // public function destroy($id)
    // {
    //     Product::findOrFail($id)->delete();

    //     return back()->with('success','Deleted');
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


    

    
    // ----------use when migrate image db to drive-----
    // public function migrateRemainingImages()
    // {
    //     $drive = new GoogleDriveService();

    //     $success = 0;
    //     $failed = 0;

    //     Product::whereNotNull('image')
    //         ->where('image', 'like', '%/%') // only local paths
    //         ->chunkById(100, function ($products) use ($drive, &$success, &$failed) {

    //             foreach ($products as $product) {

    //                 try {

    //                     $path = public_path('storage/' . $product->image);

    //                     if (!file_exists($path)) {
    //                         $failed++;
    //                         continue;
    //                     }

    //                     $uploadedFile = $drive->upload(
    //                         new File($path)
    //                     );

    //                     $product->update([
    //                         'image' => $uploadedFile->id
    //                     ]);

    //                     $success++;

    //                 } catch (\Exception $e) {

    //                     \Log::error([
    //                         'product_id' => $product->id,
    //                         'error' => $e->getMessage()
    //                     ]);

    //                     $failed++;
    //                 }
    //             }
    //         });

    //     dd([
    //         'successfully_migrated' => $success,
    //         'failed' => $failed
    //     ]);
    // }
}