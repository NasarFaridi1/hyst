<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;

class OfferController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $offers = Offer::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
            ->latest()
            ->get();

        return view(
            'restaurant.offers.index',
            compact('offers')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = Product::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->latest()->get();

        return view(
            'restaurant.offers.create',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required',

            'type' => 'required',

            'value' => 'required',

            'value_type' => 'required',

            'image' => 'nullable|image',
            'products' => 'required|array',

        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request
                ->file('image')
                ->store('offers', 'public');
        }

        $offer = Offer::create([

            'restaurant_id' => auth()->user()->restaurant_id,

            'title' => $request->title,

            'description' => $request->description,

            'type' => $request->type,

            'value' => $request->value,

            'value_type' => $request->value_type,

            'image' => $image,

            'is_active' => $request->is_active,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,
        ]);
        $offer->products()->sync(
            $request->products
        );

        return redirect(
            '/restaurant/offers'
        )->with(
                'success',
                'Offer Created Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
        $offer = Offer::with('products')
            ->findOrFail($id);

        $products = Product::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->latest()->get();

        return view(
            'restaurant.offers.edit',
            compact(
                'offer',
                'products'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        string $id
    ) {
        $offer = Offer::findOrFail($id);

        $request->validate([
            'products' => 'required|array',

            'title' => 'required',

            'type' => 'required',

            'value' => 'required',

            'value_type' => 'required',
        ]);

        $image = $offer->image;

        if ($request->hasFile('image')) {
            $image = $request
                ->file('image')
                ->store('offers', 'public');
        }

        $offer->update([

            'title' => $request->title,

            'description' => $request->description,

            'type' => $request->type,

            'value' => $request->value,

            'value_type' => $request->value_type,

            'image' => $image,

            'is_active' => $request->is_active,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,
        ]);

        $offer->products()->sync(
            $request->products
        );
        return redirect(
            '/restaurant/offers'
        )->with(
                'success',
                'Offer Updated Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);

        $offer->delete();

        return back()->with(
            'success',
            'Offer Deleted Successfully'
        );
    }

    /*
|--------------------------------------------------------------------------
| FEATURED OFFER
|--------------------------------------------------------------------------
*/

    public function featured($id)
    {
        $restaurantId = auth()->user()->restaurant_id;

        /*
        |--------------------------------------------------------------------------
        | REMOVE OLD FEATURED
        |--------------------------------------------------------------------------
        */

        Offer::where(
            'restaurant_id',
            $restaurantId
        )->update([
                    'is_featured' => 0
                ]);

        /*
        |--------------------------------------------------------------------------
        | MAKE NEW FEATURED
        |--------------------------------------------------------------------------
        */

        Offer::where(
            'id',
            $id
        )
            ->where(
                'restaurant_id',
                $restaurantId
            )
            ->update([
                'is_featured' => 1
            ]);

        return back()->with(
            'success',
            'Featured Offer Updated'
        );
    }
}