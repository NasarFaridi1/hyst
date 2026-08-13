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
use App\Mail\QuickAccountCreatedMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class UserRegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.user-register');
    }


public function checkEmail(Request $request)
{
    try {

        $emailHash = hash('sha256', strtolower(trim($request->email)));

        return response()->json([
            'hash' => $emailHash,
            'exists' => User::where('email_hash', $emailHash)->exists(),
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}

    public function register(Request $request)
    {

        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => env('TURNSTILE_SECRET_KEY'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        $result = $response->json();

        if (!($result['success'] ?? false)) {

            return redirect('/register')
                ->withInput()
                ->with('message', 'Please verify that you are human.')
                ->with('type', 'error');
        }

        // IP Rate Limiting (Max 3 attempts per minute per IP against automated/bot signups)
        $ipKey = 'register-ip:' . $request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 3)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return redirect('/register')
                ->withInput()
                ->with('message', "Automated or repeated registration attempts detected from your IP. Please wait {$seconds} seconds before trying again.")
                ->with('type', 'error');
        }
        RateLimiter::hit($ipKey, 60);

        // Email limit
        $emailKey = 'register-email:' . sha1(strtolower($request->email));

        if (RateLimiter::tooManyAttempts($emailKey, 2)) {
            return back()->with('message', 'Please wait before trying this email again.');
        }

        RateLimiter::hit($emailKey, 300);
        
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withInput()
                ->with('message', $validator->errors()->first())
                ->with('type', 'error');
        }

        // Block @hyst.uk email addresses
        $email = strtolower(trim($request->email));

        if (str_ends_with($email, 'hyst.uk')) {
            return redirect('/register')
                ->withInput()
                ->with('message', 'Registration with @hyst.uk email addresses is not allowed.')
                ->with('type', 'error');
        }

        // Check if email already exists
        $emailExist = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if ($emailExist) {
            return redirect('/register')
                ->withInput()
                ->with('message', 'Email already exists.')
                ->with('type', 'error');
        }


        $otp = rand(100000,999999);

        $verifyToken = Str::random(64);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'user',
            'email_verified'=>0,
            'email_otp'=>$otp,
            'otp_expire_at'=>Carbon::now()->addMinutes(10),
            'email_verify_token' => $verifyToken,
        ]);

        $verifyUrl = url('/verify-email?token=' . $verifyToken);
        Mail::to($user->email)->send(new VerifyOtpMail($otp ,$verifyUrl));


        return redirect('/verify-email?token=' . $verifyToken)
            ->with('message','Verification email sent successfully. Please check your inbox or spam and follow the instructions to verify your email.')
            ->with('type','success');

    }


    public function verifyEmailLink(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return redirect('/register')
                ->with('message', 'Invalid verification request.')
                ->with('type', 'error');
        }

        $user = User::where('email_verify_token', $token)->first();

        if (!$user) {
            return redirect('/login')
                ->with('message', 'Invalid or expired verification link.')
                ->with('type', 'error');
        }

        if ($user->email_verified) {
            Auth::login($user);
            $redirect = session()->pull('login_redirect', !empty(session('cart')) ? '/checkout' : '/');

            return redirect($redirect)
                ->with('message', 'Your email is already verified.')
                ->with('type', 'success');
        }

        $otp = trim($request->otp ?? '');

        if (empty($otp)) {
            return back()
                ->with('message', 'Please enter the verification code.')
                ->with('type', 'error');
        }

        if ($user->otp_expire_at && now()->gt($user->otp_expire_at)) {
            return back()
                ->with('message', 'Verification code has expired. Please request a new code.')
                ->with('type', 'error');
        }

        if ((string)$user->email_otp !== (string)$otp) {
            return back()
                ->with('message', 'Invalid verification code. Please check the code sent to your email.')
                ->with('type', 'error');
        }

        $user->update([
            'email_verified' => 1,
            'email_verified_at' => now(),
            'email_otp' => null,
            'otp_expire_at' => null,
            'email_verify_token' => null,
        ]);

        Auth::login($user);
        $redirect = session()->pull('login_redirect', !empty(session('cart')) ? '/checkout' : '/');

        return redirect($redirect)
            ->with('message', 'Email verified successfully.')
            ->with('type', 'success');
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $user = User::where('email_verify_token', $request->token)->first();

        if (!$user) {
            return redirect('/register')
                ->with('message', 'Invalid verification request.')
                ->with('type', 'error');
        }

        if ($user->email_verified) {
            return redirect('/')
                ->with('message', 'Your email is already verified.')
                ->with('type', 'success');
        }

        $otp = rand(100000, 999999);

        $verifyToken = Str::random(64);

        $user->update([
            'email_otp' => $otp,
            'otp_expire_at' => now()->addMinutes(10),
            'email_verify_token' => $verifyToken,
        ]);

        $verifyUrl = url('/verify-email?token=' . $verifyToken);

        Mail::to($user->email)->send(new VerifyOtpMail($otp, $verifyUrl));

        return redirect('/verify-email?token=' . $verifyToken)
            ->with('message', 'A new verification code has been sent to your email.')
            ->with('type', 'success');
    }

    public function quickCheckoutRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('quick_checkout_error', $validator->errors()->first());
        }

        $email = strtolower(trim($request->email));

        if (str_ends_with($email, 'hyst.uk')) {
            return redirect()->back()
                ->withInput()
                ->with('quick_checkout_error', 'Registration with @hyst.uk email addresses is not allowed.');
        }

        $emailHash = hash('sha256', $email);
        $emailExist = User::where('email_hash', $emailHash)->first();

        if ($emailExist) {
            return redirect()->back()
                ->withInput()
                ->with('quick_checkout_error', 'An account with this email already exists. Please log in below.');
        }

        $generatedPassword = Str::random(10);

        $user = User::create([
            'name'               => $request->name,
            'email'              => $email,
            'phone'              => $request->phone,
            'password'           => Hash::make($generatedPassword),
            'role'               => 'user',
            'email_verified'     => 1,
            'email_verified_at'  => now(),
            'email_otp'          => null,
            'otp_expire_at'      => null,
            'email_verify_token' => null,
        ]);

        try {
            Mail::to($user->email)->send(new QuickAccountCreatedMail($user, $generatedPassword));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Quick checkout mail failed: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('checkout')
            ->with('message', 'Account created successfully! Proceeding to checkout.')
            ->with('type', 'success');
    }
}