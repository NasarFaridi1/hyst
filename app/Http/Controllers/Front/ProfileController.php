<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
{
        savePageVisit($request, 'Profile');
        $addresses = UserAddress::where('user_id', auth()->id())
        ->orderByDesc('is_default')
        ->latest()
        ->get();

        $loyaltyRewards = \App\Models\LoyaltyReward::with('restaurant')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('front.profile', compact('addresses', 'loyaltyRewards'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
        ]);

        $user = auth()->user();

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }
}