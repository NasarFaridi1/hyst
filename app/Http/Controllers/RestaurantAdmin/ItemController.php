<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Restaurant;

class ItemController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where(
            'email',
            auth()->user()->email
        )->first();

        $items = Item::where(
            'restaurant_id',
            $restaurant->id
        )->latest()->get();

        return view(
            'restaurant.items.index',
            compact('items')
        );
    }

    public function create()
    {
        return view('restaurant.items.create');
    }

    public function store(Request $request)
    {
        $restaurant = Restaurant::where(
            'email',
            auth()->user()->email
        )->first();

        $image = null;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('items','public');
        }

        Item::create([

            'restaurant_id' => $restaurant->id,

            'name' => $request->name,

            'unit' => $request->unit,

            'price' => $request->price,

            'quantity' => $request->quantity,

            'description' => $request->description,

            'image' => $image,

            'status' => 1

        ]);

        return redirect('/restaurant/items')
            ->with('success','Item Added');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view(
            'restaurant.items.edit',
            compact('item')
        );
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $image = $item->image;

        if($request->hasFile('image')){

            $image = $request->file('image')
                ->store('items','public');
        }

        $item->update([

            'name' => $request->name,

            'unit' => $request->unit,

            'price' => $request->price,

            'quantity' => $request->quantity,

            'description' => $request->description,

            'image' => $image,

        ]);

        return redirect('/restaurant/items')
            ->with('success','Item Updated');
    }

    public function destroy($id)
    {
        Item::destroy($id);

        return back()
            ->with('success','Item Deleted');
    }
}