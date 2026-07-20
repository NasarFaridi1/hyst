<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;

class RestaurantCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = RestaurantCategory::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('display_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.restaurant-categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create()
    {
        return view('admin.restaurant-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display_order' => 'required|integer|min:0',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = time().'_'.$request->image->getClientOriginalName();

            $request->image->move(public_path('resturant'), $image);
        }

        RestaurantCategory::create([
            'name' => $request->name,
            'display_order' => $request->display_order,
            'image' => $image,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()
            ->route('admin.restaurant-categories.index')
            ->with('success', 'Category Added Successfully');
    }

    public function edit($id)
    {
        $category = RestaurantCategory::findOrFail($id);

        return view(
            'admin.restaurant-categories.edit',
            compact('category')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'display_order' => 'required|integer|min:0',
        ]);

        

        $category = RestaurantCategory::findOrFail($id);

        $image = $category->image;

        if ($request->hasFile('image')) {

            if ($image && file_exists(public_path('resturant/'.$image))) {
                unlink(public_path('resturant/'.$image));
            }

            $image = time().'_'.$request->image->getClientOriginalName();

            $request->image->move(public_path('resturant'), $image);
        }

        $category->update([
            'name' => $request->name,
            'display_order' => $request->display_order,
            'image' => $image,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.restaurant-categories.index')
            ->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        RestaurantCategory::findOrFail($id)->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}