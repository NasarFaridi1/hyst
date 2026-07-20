<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([

    //         'email' => 'required|email',

    //         'password' => 'required'

    //     ]);

    //     if(Auth::attempt([

    //         'email' => $request->email,

    //         'password' => $request->password

    //     ])){

    //         // SUPER ADMIN

    //         if(auth()->user()->role == 'super_admin'){

    //             return redirect('/admin/dashboard');
    //         }

    //         // RESTAURANT ADMIN

    //         if(auth()->user()->role == 'restaurant_admin'){

    //             return redirect('/restaurant/dashboard');
    //         }

    //         // VENDOR

    //         if(auth()->user()->role == 'vendor'){

    //             return redirect('/vendor/dashboard');
    //         }

    //         // NORMAL USER

    //         return redirect('/');
    //     }

    //     return back()->with('error', 'Invalid Login');
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where(
            'email_hash',
            hash(
                'sha256',
                strtolower(trim($request->email))
            )
        )->first();

        if (
            $user &&
            Hash::check(
                $request->password,
                $user->password
            )
        ) {

            Auth::login($user);

            if ($user->role == 'super_admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role == 'restaurant_admin') {
                return redirect('/restaurant/dashboard');
            }

            if ($user->role == 'vendor') {
                return redirect('/vendor/dashboard');
            }

            return redirect('/');
        }

        return back()->with(
            'error',
            'Invalid Login Credentials'
        );
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/admin/login');
    }
}