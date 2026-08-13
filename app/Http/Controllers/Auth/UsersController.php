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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->filled('redirect')) {
            session(['login_redirect' => $request->redirect]);
        }

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

        

        if ($user->role === 'restaurant_admin' || $user->restaurant_id) {
            $restaurant = $user->restaurant ?? \App\Models\Restaurant::find($user->restaurant_id);

            if (!$restaurant || (int)$restaurant->status === 0) {
                return back()
                    ->with('message', 'Your restaurant account has been deactivated. Please contact the administrator.')
                    ->with('type', 'error')
                    ->with('error', 'Your restaurant account has been deactivated. Please contact the administrator.');
            }

            if (!$user->email_verified) {
                $user->update([
                    'email_verified' => 1,
                    'email_verified_at' => now()
                ]);
            }
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

            if ($guestFcmToken = session('guest_fcm_token')) {
                $user->update(['fcm_token' => $guestFcmToken]);
            }

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

            if ($user->role == 'support') {

                return redirect('/support/dashboard');

            }

           

            $redirect = session()->pull('login_redirect', $request->input('redirect', !empty(session('cart')) ? '/checkout' : '/'));

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
            'email' => 'required|email'
        ]);

        $ipKey = 'forgot-pwd-ip:' . $request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 3)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return back()
                ->with('message', "Too many password reset attempts. Please wait {$seconds} seconds.")
                ->with('type', 'error');
        }
        RateLimiter::hit($ipKey, 60);

        $email = strtolower(trim($request->email));
        $emailKey = 'forgot-pwd-email:' . sha1($email);
        if (RateLimiter::tooManyAttempts($emailKey, 2)) {
            return redirect('/login')
                ->with('message', 'If an account with that email address exists, a password reset link has been sent to your email.')
                ->with('type', 'success');
        }

        $user = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if ($user) {
            RateLimiter::hit($emailKey, 300);

            $url = URL::temporarySignedRoute(
                'password.reset',
                now()->addMinutes(30),
                [
                    'email' => $user->email
                ]
            );

            try {
                Mail::send(
                    'emails.reset-password',
                    [
                        'user' => $user,
                        'url' => $url
                    ],
                    function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('Reset Your Password');
                    }
                );
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Password reset mail error: ' . $e->getMessage());
            }
        }

        return redirect('/login')
            ->with('message', 'If an account with that email address exists, a password reset link has been sent to your email.')
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