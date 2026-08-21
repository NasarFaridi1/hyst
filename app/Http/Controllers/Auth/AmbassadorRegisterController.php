<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class AmbassadorRegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.ambassador-register');
    }

    public function register(Request $request)
    {
        // IP Rate Limiting (Max 3 attempts per minute per IP against automated/bot signups)
        $ipKey = 'register-ip:' . $request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 3)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return back()
                ->withInput()
                ->with('message', "Automated or repeated registration attempts detected from your IP. Please wait {$seconds} seconds before trying again.")
                ->with('type', 'error');
        }
        RateLimiter::hit($ipKey, 60);
        $validator = Validator::make($request->all(), [

            'name' => 'required|max:255',

            'email' => 'required|email',

            'phone' => 'required',

            'password' => ['required', new \App\Rules\PasswordComplexity()],

        ]);

        if ($validator->fails()) {

            return back()
                ->withInput()
                ->with('message', $validator->errors()->first())
                ->with('type', 'error');

        }

        $email = strtolower(trim($request->email));

        if (str_ends_with($email, 'hyst.uk')) {

            return back()
                ->withInput()
                ->with('message', 'Registration with @hyst.uk email addresses is not allowed.')
                ->with('type', 'error');

        }

        $exist = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if ($exist) {

            return back()
                ->withInput()
                ->with('message', 'Email already exists.')
                ->with('type', 'error');

        }

        $otp = rand(100000,999999);

        $verifyToken = Str::random(64);

        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'password' => Hash::make($request->password),

            'role' => 'ambassador',

            'status' => 1,

            'email_verified' => 0,

            'email_otp' => $otp,

            'otp_expire_at' => Carbon::now()->addMinutes(10),

            'email_verify_token' => $verifyToken,

        ]);

        $verifyUrl = url('/ambassador/verify-email?token='.$verifyToken);

        Mail::to($user->email)
            ->send(new VerifyOtpMail($otp,$verifyUrl));

        return redirect('/ambassador/verify-email?token='.$verifyToken)
            ->with('message','Verification email sent successfully.')
            ->with('type','success');
    }

public function verifyEmailLink(Request $request)
{
    $token = $request->token;

    if (!$token) {
        return view('auth.verify-email');
    }

    $user = User::where('email_verify_token', $token)->first();

    if (!$user) {
        return redirect('/ambassador/register')
            ->with('message', 'Invalid or expired verification link.')
            ->with('type', 'error');
    }

    if ($user->email_verified) {

        Auth::login($user);

        return redirect()->route('ambassador.dashboard')
            ->with('message', 'Your email is already verified.')
            ->with('type', 'success');
    }

    // Sirf OTP page show karega
    return view('auth.ambassador-verify-email', compact('user'));
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'token' => 'required',
        'otp' => 'required|digits:6',
    ]);

    $user = User::where('email_verify_token',$request->token)->first();

    if(!$user){
        return back()->with('message','Invalid verification request.')
                     ->with('type','error');
    }

    if(now()->gt($user->otp_expire_at)){
        return back()->with('message','OTP expired.')
                     ->with('type','error');
    }

    if($user->email_otp != $request->otp){
        return back()->with('message','Invalid OTP.')
                     ->with('type','error');
    }

    $user->update([
        'email_verified'=>1,
        'email_verified_at'=>now(),
        'email_otp'=>null,
        'otp_expire_at'=>null,
        'email_verify_token'=>null,
    ]);

    Auth::login($user);

    return redirect()->route('ambassador.dashboard')
        ->with('message','Email verified successfully.')
        ->with('type','success');
}

public function resendOtp(Request $request)
{
    $request->validate([
        'token'=>'required'
    ]);

    $ipKey = 'resend-otp-ip:' . $request->ip();
    if (RateLimiter::tooManyAttempts($ipKey, 3)) {
        $seconds = RateLimiter::availableIn($ipKey);
        return back()
            ->with('message', "Too many OTP resend attempts. Please wait {$seconds} seconds before trying again.")
            ->with('type', 'error');
    }

    $user = User::where('email_verify_token',$request->token)->first();

    if(!$user){
        return redirect()->route('ambassador.register');
    }

    $userKey = 'resend-otp-user:' . $user->id;
    if (RateLimiter::tooManyAttempts($userKey, 1)) {
        $seconds = RateLimiter::availableIn($userKey);
        return back()
            ->with('message', "Please wait {$seconds} seconds before requesting a new verification code.")
            ->with('type', 'error');
    }

    RateLimiter::hit($ipKey, 60);
    RateLimiter::hit($userKey, 60);

    $otp = rand(100000,999999);

    $verifyToken = Str::random(64);

    $user->update([
        'email_otp'=>$otp,
        'otp_expire_at'=>now()->addMinutes(10),
        'email_verify_token'=>$verifyToken,
    ]);

    $verifyUrl = url('/ambassador/verify-email?token='.$verifyToken);

    Mail::to($user->email)
        ->send(new VerifyOtpMail($otp,$verifyUrl));

    return redirect('/ambassador/verify-email?token='.$verifyToken)
        ->with('message','OTP sent successfully.')
        ->with('type','success');
}
}