<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $restaurantId = auth()->user()->restaurant_id;

        $categories = Category::where('restaurant_id', $restaurantId)
            ->whereNull('parent_id')
            ->orderByRaw('display_order IS NULL, display_order ASC')
            ->orderBy('id', 'ASC')
            ->latest()
            ->get();

        return view('restaurant.categories.index', compact('categories'));
    }

    public function create()
    {
        $restaurantId = auth()->user()->restaurant_id;

        $categories = Category::whereNull('parent_id')
            ->where('restaurant_id', $restaurantId)
            ->get();

        return view('restaurant.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $image = null;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('categories', 'public');

        }

        Category::create([

            'restaurant_id' => $restaurantId,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'image' => $image,
             'display_order' => $request->display_order,
            'status' => 1

        ]);

        return redirect()
            ->route('restaurant.categories.index')
            ->with('success', 'Category Added');
    }

    public function edit($id)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $category = Category::where('restaurant_id', $restaurantId)
            ->findOrFail($id);

        $categories = Category::whereNull('parent_id')
            ->where('restaurant_id', $restaurantId)
            ->where('id', '!=', $id)
            ->get();

        return view(
            'restaurant.categories.edit',
            compact('category', 'categories')
        );
    }

    public function update(Request $request, $id)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $category = Category::where('restaurant_id', $restaurantId)
            ->findOrFail($id);

        $image = $category->image;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('categories', 'public');

        }

        $category->update([

            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $image,
             'display_order' => $request->display_order,

        ]);

        return redirect()
            ->route('restaurant.categories.index')
            ->with('success', 'Category Updated');
    }

    public function destroy($id)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $category = Category::where('restaurant_id', $restaurantId)
            ->findOrFail($id);

        $category->delete();

        return back()->with('success', 'Deleted');
    }
}