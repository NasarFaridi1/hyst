<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\RestaurantCategory;

class RestaurantController extends Controller
{
    /**
     * Restaurant List
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $restaurants = Restaurant::where('ambassador_id', Auth::id())

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");

                });

            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'ambassador.restaurants.index',
            compact('restaurants', 'search')
        );
    }

    /**
     * Create Restaurant
     */
    public function create()
    {
        $categories = RestaurantCategory::where(
            'status',
            'active'
        )->get();

        return view(
            'ambassador.restaurants.create',
            compact('categories')
        );
    }

    /**
     * Store Restaurant
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email',

            'phone' => 'required',

            'password' => ['required', new \App\Rules\PasswordComplexity()],

            'location' => 'required',

            'city' => 'required',

            'state' => 'required',

            'country' => 'required',

            'postcode' => 'required',

            'longitude' => 'required',

            'latitude' => 'required',

            'description' => 'required',

            'category_ids' => 'required|array|min:1',

            'dietary_categories' => 'nullable|array',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',

            'hygiene_certificate' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf',

            'hygiene_rating' => 'required'

        ]);

        if (User::where('email', $request->email)->exists()) {

            return back()
                ->withInput()
                ->with('error', 'Email already exists.');
        }

        DB::beginTransaction();

        try {

            $image = null;

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $imageName = time() . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('storage/restaurants'),
                    $imageName
                );

                $image = 'restaurants/' . $imageName;
            }

            $certificate = null;

            if ($request->hasFile('hygiene_certificate')) {

                $file = $request->file('hygiene_certificate');

                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('restaurant-certificates'),
                    $fileName
                );

                $certificate = 'restaurant-certificates/' . $fileName;
            }

            $restaurant = Restaurant::create([

                'ambassador_id' => Auth::id(),

                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . time(),
                'email' => $request->email,

                'phone' => $request->phone,

                'address' => $request->location,

                'location' => $request->location,

                'city' => $request->city,

                'state' => $request->state,

                'country' => $request->country,

                'postcode' => $request->postcode,

                'longitude' => $request->longitude,

                'latitude' => $request->latitude,

                'description' => $request->description,

                'category_ids' => $request->category_ids,

                'dietary_categories' => $request->dietary_categories ?? [],

                'image' => $image,

                'hygiene_rating' => $request->hygiene_rating,

                'hygiene_certificate' => $certificate,

                // Pending approval by Admin
                'status' => 0,

            ]);

            User::create([

                'restaurant_id' => $restaurant->id,

                'name' => $request->name,

                'email' => $request->email,

                'phone' => $request->phone,

                'password' => Hash::make($request->password),

                'role' => 'restaurant_admin',

                'status' => 0,

            ]);

            DB::commit();

            return redirect()
                ->route('ambassador.restaurants.index')
                ->with(
                    'success',
                    'Restaurant submitted successfully. Waiting for admin approval.'
                );

        } catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack();

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', $e->validator->errors()->first());

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

        /**
     * Edit Restaurant
     */
    public function edit($id)
    {
        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($id);

        $categories = RestaurantCategory::where(
            'status',
            'active'
        )->get();

        return view(
            'ambassador.restaurants.edit',
            compact(
                'restaurant',
                'categories'
            )
        );
    }

    /**
     * Update Restaurant
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($id);

        $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email',

            'phone' => 'required',

            'location' => 'required',

            'city' => 'required',

            'state' => 'required',

            'country' => 'required',

            'postcode' => 'required',

            'longitude' => 'required',

            'latitude' => 'required',

            'description' => 'required',

            'category_ids' => 'required|array|min:1',

            'dietary_categories' => 'nullable|array',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',

            'hygiene_certificate' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf',

            'hygiene_rating' => 'required'

        ]);

        DB::beginTransaction();

        try {

            $image = $restaurant->image;

            if ($request->hasFile('image')) {

                if (
                    $restaurant->image &&
                    file_exists(public_path('storage/' . $restaurant->image))
                ) {
                    unlink(public_path('storage/' . $restaurant->image));
                }

                $file = $request->file('image');

                $imageName = time() . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('storage/restaurants'),
                    $imageName
                );

                $image = 'restaurants/' . $imageName;
            }

            $certificate = $restaurant->hygiene_certificate;

            if ($request->hasFile('hygiene_certificate')) {

                if (
                    $restaurant->hygiene_certificate &&
                    file_exists(public_path($restaurant->hygiene_certificate))
                ) {
                    unlink(public_path($restaurant->hygiene_certificate));
                }

                $file = $request->file('hygiene_certificate');

                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('restaurant-certificates'),
                    $fileName
                );

                $certificate = 'restaurant-certificates/' . $fileName;
            }

            $restaurant->update([

                'name' => $request->name,

                'email' => $request->email,

                'phone' => $request->phone,

                'address' => $request->location,

                'location' => $request->location,

                'city' => $request->city,

                'state' => $request->state,

                'country' => $request->country,

                'postcode' => $request->postcode,

                'longitude' => $request->longitude,

                'latitude' => $request->latitude,

                'description' => $request->description,

                'category_ids' => json_encode($request->category_ids),

                'dietary_categories' => $request->dietary_categories ?? [],

                'image' => $image,

                'hygiene_rating' => $request->hygiene_rating,

                'hygiene_certificate' => $certificate,

                // Status same rahega
                'status' => $restaurant->status,

            ]);

            User::where('restaurant_id', $restaurant->id)
                ->where('role', 'restaurant_admin')
                ->update([

                    'name' => $request->name,

                    'email' => $request->email,

                    'phone' => $request->phone,

                ]);

            DB::commit();

            return redirect()
                ->route('ambassador.restaurants.index')
                ->with(
                    'success',
                    'Restaurant Updated Successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Delete Restaurant
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::where(
            'ambassador_id',
            Auth::id()
        )->findOrFail($id);

        DB::beginTransaction();

        try {

            if (
                $restaurant->image &&
                file_exists(public_path('storage/' . $restaurant->image))
            ) {
                unlink(public_path('storage/' . $restaurant->image));
            }

            if (
                $restaurant->hygiene_certificate &&
                file_exists(public_path($restaurant->hygiene_certificate))
            ) {
                unlink(public_path($restaurant->hygiene_certificate));
            }

            User::where('restaurant_id', $restaurant->id)
                ->where('role', 'restaurant_admin')
                ->delete();

            $restaurant->delete();

            DB::commit();

            return redirect()
                ->route('ambassador.restaurants.index')
                ->with(
                    'success',
                    'Restaurant Deleted Successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

}