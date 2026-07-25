<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Restaurant;

class CategoryController extends Controller
{

    /**
     * Category List
     */
    public function index($restaurantId)
    {

        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($restaurantId);

        $categories = Category::where(
            'restaurant_id',
            $restaurant->id
        )
        ->latest()
        ->paginate(10);

        return view(
            'ambassador.categories.index',
            compact(
                'restaurant',
                'categories'
            )
        );
    }

    /**
     * Create Category
     */
    public function create($restaurantId)
    {

        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($restaurantId);

        $parents = Category::where(
            'restaurant_id',
            $restaurant->id
        )
        ->whereNull('parent_id')
        ->get();

        return view(
            'ambassador.categories.create',
            compact(
                'restaurant',
                'parents'
            )
        );
    }

    /**
     * Store Category
     */
    public function store(Request $request,$restaurantId)
    {

        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($restaurantId);

        $request->validate([

            'name' => 'required|max:255',

            'parent_id' => 'nullable|exists:categories,id',

            'display_order' => 'nullable|numeric',

            'image' => 'nullable|image'

        ]);

        $image = null;

        if($request->hasFile('image')){

            $file = $request->file('image');

            $imageName = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('storage/categories'),
                $imageName
            );

            $image = 'categories/'.$imageName;

        }

        Category::create([

            'restaurant_id' => $restaurant->id,

            'name' => $request->name,

            'slug' => Str::slug($request->name).'-'.time(),

            'parent_id' => $request->parent_id,

            'image' => $image,

            'display_order' => $request->display_order,

            'status' => 1

        ]);

        return redirect()
            ->route(
                'ambassador.categories.index',
                $restaurant->id
            )
            ->with(
                'success',
                'Category Added Successfully.'
            );

    }

    public function edit($restaurantId,$id)
{

    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $category = Category::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($id);

    $parents = Category::where(
        'restaurant_id',
        $restaurant->id
    )
    ->whereNull('parent_id')
    ->where('id','!=',$id)
    ->get();

    return view(
        'ambassador.categories.edit',
        compact(
            'restaurant',
            'category',
            'parents'
        )
    );

}

public function destroy($restaurantId,$id)
{

    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $category = Category::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($id);

    $category->delete();

    return back()->with(
        'success',
        'Category Deleted Successfully.'
    );

}

public function update(Request $request,$restaurantId,$id)
{

    $restaurant = Restaurant::where(
        'ambassador_id',
        Auth::id()
    )->findOrFail($restaurantId);

    $category = Category::where(
        'restaurant_id',
        $restaurant->id
    )->findOrFail($id);

    $request->validate([

        'name'=>'required|max:255',

        'parent_id'=>'nullable|exists:categories,id',

        'display_order'=>'nullable|numeric',

        'image'=>'nullable|image'

    ]);

    $image = $category->image;

    if($request->hasFile('image')){

        if(
            $category->image &&
            file_exists(public_path('storage/'.$category->image))
        ){
            unlink(public_path('storage/'.$category->image));
        }

        $file = $request->file('image');

        $imageName = time().'_'.$file->getClientOriginalName();

        $file->move(
            public_path('storage/categories'),
            $imageName
        );

        $image='categories/'.$imageName;

    }

    $category->update([

        'name'=>$request->name,

        'slug'=>Str::slug($request->name).'-'.time(),

        'parent_id'=>$request->parent_id,

        'display_order'=>$request->display_order,

        'image'=>$image

    ]);

    return redirect()
        ->route(
            'ambassador.categories.index',
            $restaurant->id
        )
        ->with(
            'success',
            'Category Updated Successfully.'
        );

}

}