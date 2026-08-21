<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Restaurant;

class ProfileController extends Controller
{
    /**
     * Profile Page
     */
    public function index()
    {
        $user = Auth::user();

        $totalRestaurants = Restaurant::where(
            'ambassador_id',
            $user->id
        )->count();

        $activeRestaurants = Restaurant::where(
            'ambassador_id',
            $user->id
        )
        ->where('status',1)
        ->count();

        $pendingRestaurants = Restaurant::where(
            'ambassador_id',
            $user->id
        )
        ->where('status',0)
        ->count();

        // £100 Per Restaurant
        $restaurantEarnings = $totalRestaurants * 100;

        return view(
            'ambassador.profile.index',
            compact(
                'user',
                'totalRestaurants',
                'activeRestaurants',
                'pendingRestaurants',
                'restaurantEarnings'
            )
        );
    }

    /**
     * Edit Profile
     */
    public function edit()
    {
        $user = Auth::user();

        return view(
            'ambassador.profile.edit',
            compact('user')
        );
    }

    /**
     * Update Profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'name' => 'required|max:255',

            'phone' => 'nullable|max:20',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,jpg,webp',

            'password' => ['nullable', 'confirmed', new \App\Rules\PasswordComplexity()],

        ]);

        $image = $user->profile_image;

        if($request->hasFile('profile_image')){

            if(
                $user->profile_image &&
                file_exists(public_path('storage/'.$user->profile_image))
            ){
                unlink(public_path('storage/'.$user->profile_image));
            }

            $file = $request->file('profile_image');

            $imageName = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('storage/profile'),
                $imageName
            );

            $image = 'profile/'.$imageName;

        }

        $user->update([

            'name' => $request->name,

            'phone' => $request->phone,

            'profile_image' => $image,

            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,

        ]);

        return redirect()
            ->route('ambassador.profile.index')
            ->with(
                'success',
                'Profile Updated Successfully.'
            );
    }
}