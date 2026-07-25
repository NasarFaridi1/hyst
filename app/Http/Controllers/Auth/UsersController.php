<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class UsersController extends Controller
// {
//     public function showLogin(Request $request)
//     {
       
       
//         return view('auth.login',[
//             'redirect' => $request->redirect
//         ]);
//     }

//     public function login(Request $request)
//     {
//         if (Auth::attempt([
//             'email' => $request->email,
//             'password' => $request->password
//         ])) {

//             // return redirect('/');
//             // return redirect()->intended('/');
//             // $request->session()->regenerate();

            
//             $redirect = urldecode($request->redirect ?? '/');

//             // Prevent external redirects
//             if (
//                 !str_starts_with($redirect, url('/'))
//             ) {
//                 $redirect = '/';
//             }

//             return redirect($redirect)
//                 ->with('success', 'Login Successfully!');
//         }

//         return back()->with('error', 'Invalid Login');
//     }
// }


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{
    public function showLogin(Request $request)
    {
        // return view('auth.login', [
        //     'redirect' => $request->redirect
        // ]);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // $credentials = [
        //     'email'    => $request->email,
        //     'password' => $request->password,
        // ];

        // if (Auth::attempt($credentials)) {

        //     $redirect = urldecode($request->redirect ?? '/');

        //     // Prevent external redirects
        //     if (
        //         empty($redirect) ||
        //         !str_starts_with($redirect, url('/'))
        //     ) {
        //         $redirect = url('/');
        //     }

        //     $separator = str_contains($redirect, '?') ? '&' : '?';

        //     return redirect(
        //         $redirect .
        //         $separator .
        //         'message=' . urlencode('Login Successfully!') .
        //         '&type=success'
        //     );
        // }

        $user = User::where(
            'email_hash',
            hash(
                'sha256',
                strtolower(trim($request->email))
            )
        )->first();


        if(!$user){
            return redirect('/login')
            ->with('message', 'User not found')
            ->with('type', 'error');
        }

        if (!$user->email_verified) {

            return back()
                ->with('message','Please verify your email first.')
                ->with('type','error');
        }
        

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
            if ($user->role == 'ambassador') {

                return redirect('/ambassador/dashboard');

            }

            // $redirect = urldecode($request->redirect ?? '/');
            $redirect = session()->pull('login_redirect', '/');

            // dd($redirect);

            // if (
            //     empty($redirect) ||
            //     !str_starts_with($redirect, url('/'))
            // ) {
            //     $redirect = url('/');
            // }

            // $separator = str_contains($redirect, '?')
            //     ? '&'
            //     : '?';

            // return redirect(
            //     $redirect .
            //     $separator .
            //     'message=' .
            //     urlencode('Login Successfully!') .
            //     '&type=success'
            // );
            return redirect($redirect)
                ->with([
                    'message' => 'Login successful. Welcome back! Enjoy your delicious food!',
                    'type' => 'success'
                ]);
        }
        // return redirect(
        //     route('login', [
        //         'redirect' => $request->redirect,
        //         'message'  => 'Invalid Login Credentials',
        //         'type'     => 'error',
        //     ])
        // );

        return back()->with([
            'message' => 'Invalid Login Credentials',
            'type' => 'error'
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('cart');
        
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // return redirect('/?message=' . urlencode('Logged Out Successfully') . '&type=success');
        return redirect('/')
        ->with([
            'message' => 'Logged Out Successfully',
            'type' => 'success'
        ]);
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // public function forgotPassword(Request $request)
    // {
    //     // $user = User::where(
    //     //     'email',
    //     //     $request->email
    //     // )->first();

    //     $user = User::where(
    //         'email_hash',
    //         hash(
    //             'sha256',
    //             strtolower(trim($request->email))
    //         )
    //     )->first();
    //     if (!$user) {

    //         return redirect(
    //             '/forgot-password?message=' .
    //             urlencode('Email not found') .
    //             '&type=error'
    //         );
    //     }

    //     $user->update([
    //         'password' => Hash::make(
    //             $request->password
    //         )
    //     ]);

    //     return redirect(
    //         '/login?message=' .
    //         urlencode('Password Updated Successfully') .
    //         '&type=success'
    //     );
    // }


    

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email'
        ]);

        $email = strtolower(trim($request->email));

        $user = User::where(
            'email_hash',
            hash('sha256',$email)
        )->first();

    if (!$user) {

    return back()
        ->with('message', 'Invalid email address.')
        ->with('type', 'error');
}

        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(30),
            [
                'email'=>$user->email
            ]
        );

        Mail::send(
            'emails.reset-password',
            [
                'user'=>$user,
                'url'=>$url
            ],
            function($message) use($user){
                $message->to($user->email)
                        ->subject('Reset Your Password');
            }
        );

        return redirect('/login')
        ->with('message', 'Password reset link has been sent to your email.')
        ->with('type', 'success');
    }

    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password',[
            'email'=>$request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where(
            'email_hash',
            hash('sha256', strtolower(trim($request->email)))
        )->first();

        if (!$user) {
            return redirect('/forgot-password') // or ->to('/forgot-password')
                ->with('message', 'User not found')
                ->with('type', 'error');
        }

        $user->update([
            'password'=>Hash::make($request->password)
        ]);

        return redirect('/login')
        ->with('message', 'Password updated successfully.')
        ->with('type', 'success');
    }
}