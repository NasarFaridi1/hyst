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
        return view('front.profile', compact('addresses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
        ]);

        $emailExists = User::where(
            'email_hash',
            hash(
                'sha256',
                strtolower(trim($request->email))
            )
        )
        ->where('id', '!=', auth()->id())
        ->exists();

        if ($emailExists) {

            

            return back()->with(
                'error',
                'Email already exists.'
            );
        }

        $user = auth()->user();

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }
}