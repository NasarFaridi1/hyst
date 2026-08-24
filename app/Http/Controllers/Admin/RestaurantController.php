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
use Illuminate\Validation\ValidationException;

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
        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'password' => ['required', 'string', new \App\Rules\PasswordComplexity()],
                'location' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'postcode' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'description' => 'required|string',
                'category_ids' => 'required|array|min:1',
                'dietary_categories' => 'nullable|array',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'hygiene_certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'hygiene_rating' => 'required|integer|between:1,5',
            ]);



            // dump($request->all());
        


            $emailExist = User::where(
                'email_hash',
                hash('sha256', $request->email)
            )->first();

            // dd($emailExist);

            if ($emailExist) {
                return back()->with('error', 'Email already exist');
            }

        


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
                'dietary_categories' => $request->dietary_categories ?? [],
                'status' => 1,
                'hygiene_rating' => $request->hygiene_rating,
                'hygiene_certificate' => $certificate,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postcode' => $request->postcode,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'address' => $request->location,
                'worldpay_business_id' => $request->worldpay_business_id,
                'worldpay_username' => $request->worldpay_username,
                'worldpay_password' => $request->worldpay_password,
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'restaurant_admin',
                'restaurant_id' => $restaurant->id,
                'phone' => $request->phone,
                'email_verified' => 1,
                'email_verified_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.restaurants.index')
                ->with('success', 'Restaurant Added Successfully');

        } catch (ValidationException $e) {

            DB::rollBack();

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', $e->validator->errors()->first());

        } catch (\Exception $e) {

            DB::rollBack();

           

            Log::error($e);

            return back()->with('error', $e->getMessage());
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
            'dietary_categories' => $request->dietary_categories ?? [],
            'dine_in' => $request->has('dine_in') ? $request->dine_in : $restaurant->dine_in,
            'table_book' => $request->has('table_book') ? $request->table_book : $restaurant->table_book,
            'notification_sound' => $request->has('notification_sound') ? $request->notification_sound : ($restaurant->notification_sound ?? 'hyst_notification.mp3'),
            
            'status' => $request->status,
            'hygiene_rating' => $request->hygiene_rating,
            'hygiene_certificate' => $certificate,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postcode' => $request->postcode,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'address' => $request->location,
            'worldpay_business_id' => $request->worldpay_business_id,
            'worldpay_username' => $request->worldpay_username,
            'worldpay_password' => $request->worldpay_password,
        ]);

        if ((int)$request->status === 1) {
            $user = User::where('restaurant_id', $restaurant->id)
                ->orWhere('email', $restaurant->email)
                ->first();
            if ($user) {
                $user->update([
                    'email_verified' => 1,
                    'email_verified_at' => now(),
                ]);
            }
        }

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

            // 'transactworld_member_id' => 'required',

            // 'transactworld_account_id' => 'required',

            // 'transactworld_terminal_id' => 'required',

            // 'transactworld_checksum_key' => 'required',

            // 'transactworld_mode' => 'required|in:test,live'

            'worldpay_business_id' => 'required',
            'worldpay_username' => 'required',
            'worldpay_password' => 'required'


        ]);

        $restaurant = auth()->user()->restaurant;

        $restaurant->update([

            'worldpay_business_id' =>
                $request->worldpay_business_id,

            'worldpay_username' =>
                $request->worldpay_username,

            'worldpay_password' =>  
                $request->worldpay_password

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


    

    public function favorites(Request $request)
{
    savePageVisit($request, 'Favorite Restaurants');
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

    public function toggleStatus($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $newStatus = (int)$restaurant->status === 1 ? 0 : 1;
        $restaurant->update(['status' => $newStatus]);

        $user = User::where('restaurant_id', $restaurant->id)
            ->orWhere('email', $restaurant->email)
            ->first();

        if ($user && $newStatus === 1) {
            $user->update([
                'email_verified' => 1,
                'email_verified_at' => now(),
            ]);
        }

        $statusText = $newStatus === 1 ? 'activated' : 'deactivated';
        return back()->with('success', "Restaurant {$statusText} successfully.");
    }

    public function verifyEmail($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $user = User::where('restaurant_id', $restaurant->id)
            ->orWhere('email', $restaurant->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Associated user account not found for this restaurant.');
        }

        $user->update([
            'email_verified' => 1,
            'email_verified_at' => now(),
        ]);

        return back()->with('success', 'Email verified successfully for ' . $restaurant->name);
    }
}