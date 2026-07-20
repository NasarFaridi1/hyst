<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\RestaurantFavorite;
use Illuminate\Support\Facades\DB;
use App\Models\RestaurantCategory;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    // public function index()
    // {
    //     $restaurants = Restaurant::latest()->get();

    //     return view('admin.restaurants.index',
    //         compact('restaurants'));
    // }

    public function index(Request $request)
    {
        $search = $request->search;

        $restaurants = Restaurant::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->orderByRaw("
                CASE
                    WHEN display_order IS NULL THEN 999999
                    ELSE display_order
                END ASC
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.restaurants.index', compact(
            'restaurants',
            'search'
        ));
    }

    public function create()
    {
         $categories = RestaurantCategory::where('status', 'active')->get();
        return view('admin.restaurants.create' , compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $image = null;

    //     if($request->hasFile('image')){

    //         $image = $request->file('image')
    //             ->store('restaurants','public');
    //     }

    //     $restaurant = Restaurant::create([

    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name),

    //         'email' => $request->email,

    //         'phone' => $request->phone,

    //         'location' => $request->location,

    //         'description' => $request->description,

    //         'image' => $image,

    //         'status' => 1
    //     ]);





    //     // CREATE RESTAURANT ADMIN USER

    //     User::create([

    //         'name' => $request->name,

    //         'email' => $request->email,

    //         'password' => Hash::make($request->password),

    //         'role' => 'restaurant_admin',

    //         'restaurant_id' => $restaurant->id,

    //         'phone' => $request->phone
    //     ]);





    //     return redirect()
    //         ->route('admin.restaurants.index')
    //         ->with('success','Restaurant Added Successfully');
    // }

    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6',
            'location' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postcode' => 'required',
            
            'longitude' => 'required',
            'latitude' => 'required',
            'description' => 'required',
            'category_ids' => 'required|array|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'hygiene_certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'hygiene_rating' => 'required',

            
            
        ]);


        // dd($request->all());

      

       


        $emailExist = User::where('email', $request->email)->first();

        if ($emailExist) {
            return back()->with('error', 'Email already exist');
        }

        DB::beginTransaction();

        try {


            $image = null;

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $imageName = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('storage/restaurants'), $imageName);

                $image = 'restaurants/'.$imageName;
            }
            $certificate = null;

            if ($request->hasFile('hygiene_certificate')) {

                $file = $request->file('hygiene_certificate');

                $fileName = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('restaurant-certificates'), $fileName);

                $certificate = 'restaurant-certificates/'.$fileName;
            }

            $restaurant = Restaurant::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name . '-' . time()),
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->location,
                'description' => $request->description,
                'image' => $image,
                'category_ids' => $request->category_ids,
                'status' => 1,
                'hygiene_rating' => $request->hygiene_rating,
                'hygiene_certificate' => $certificate,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postcode' => $request->postcode,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'address' => $request->location
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'restaurant_admin',
                'restaurant_id' => $restaurant->id,
                'phone' => $request->phone,
                
            ]);

            DB::commit();

            return redirect()
                ->route('admin.restaurants.index')
                ->with('success', 'Restaurant Added Successfully');

        } catch (\Exception $e) {

            dd($e);

            DB::rollBack();

            Log::error($e->getMessage());

            return back()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $categories = RestaurantCategory::where('status', 'active')->get();
        return view('admin.restaurants.edit',
            compact('restaurant', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $image = $restaurant->image;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('storage/restaurants'), $imageName);

            $image = 'restaurants/'.$imageName;
        }

        $certificate = $restaurant->hygiene_certificate;

        if ($request->hasFile('hygiene_certificate')) {

            // Delete old certificate
            if (
                $restaurant->hygiene_certificate &&
                file_exists(public_path($restaurant->hygiene_certificate))
            ) {
                unlink(public_path($restaurant->hygiene_certificate));
            }

            $file = $request->file('hygiene_certificate');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('restaurant-certificates'), $fileName);

            $certificate = 'restaurant-certificates/'.$fileName;
        }


        $restaurant->update([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'location' => $request->location,

            'description' => $request->description,

            'image' => $image,

            'category_ids'=>$request->category_ids,
            
            'status' => $request->status,
            'hygiene_rating' => $request->hygiene_rating,
            'hygiene_certificate' => $certificate,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postcode' => $request->postcode,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'address' => $request->location
        ]);

        return redirect()
            ->route('admin.restaurants.index')
            ->with('success','Restaurant Updated');
    }


    public function destroy(string $id)
    {
        Restaurant::findOrFail($id)->delete();

        return back()->with('success','Deleted');
    }


    public function updatePaymentSettings(Request $request)
    {
        $request->validate([

            'transactworld_member_id' => 'required',

            'transactworld_account_id' => 'required',

            'transactworld_terminal_id' => 'required',

            'transactworld_checksum_key' => 'required',

            'transactworld_mode' => 'required|in:test,live'

        ]);

        $restaurant = auth()->user()->restaurant;

        $restaurant->update([

            'transactworld_member_id' =>
                $request->transactworld_member_id,

            'transactworld_account_id' =>
                $request->transactworld_account_id,

            'transactworld_terminal_id' =>
                $request->transactworld_terminal_id,

            'transactworld_checksum_key' =>
                $request->transactworld_checksum_key,

            'transactworld_mode' =>
                $request->transactworld_mode

        ]);

        return back()->with(
            'success',
            'Payment Settings Updated Successfully'
        );
    }

   

    public function favorite(Restaurant $restaurant)
    {
        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $userId = auth()->id();

        $favorite = RestaurantFavorite::where(
            'restaurant_id',
            $restaurant->id
        )
        ->where(
            'user_id',
            $userId
        )
        ->first();

        if (!$favorite) {

            RestaurantFavorite::create([
                'restaurant_id' => $restaurant->id,
                'user_id'       => $userId,
            ]);

            $restaurant->update([
                'favorite_count' => RestaurantFavorite::where(
                    'restaurant_id',
                    $restaurant->id
                )->count()
            ]);
        }

        return response()->json([
            'success' => true,
            'favorite_count' => $restaurant->fresh()->favorite_count
        ]);
    }


    

    public function favorites()
    {
        $restaurants = Restaurant::with([
            'featuredOffer',
            'reviews'
        ])
        ->whereIn(
            'id',
            RestaurantFavorite::where(
                'user_id',
                auth()->id()
            )->pluck('restaurant_id')
        )
        ->latest()
        ->get();

        return view(
            'front.favorite-restaurants',
            compact('restaurants')
        );
    }

    public function removeFavorite(
        Restaurant $restaurant
    )
    {
        RestaurantFavorite::where(
            'restaurant_id',
            $restaurant->id
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->delete();

        $favoriteCount = RestaurantFavorite::where(
            'restaurant_id',
            $restaurant->id
        )->count();

        $restaurant->update([
            'favorite_count' => $favoriteCount
        ]);

        return back()->with(
            'success',
            'Restaurant removed from favorites.'
        );
    }

    public function updateOrder(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'display_order' => 'nullable|integer|min:1',
        ]);

        $restaurant->update([
            'display_order' => $request->display_order,
        ]);

        return back()->with('success', 'Display order updated successfully.');
    }

}