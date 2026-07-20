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

class UserRegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.user-register');
    }

    public function register(Request $request)
    {
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

        // $user = User::create([
        //     'name'     => $request->name,
        //     'email'    => $request->email,
        //     'password' => Hash::make($request->password),
        //     'role'     => 'user',
        // ]);

        // Auth::login($user);

        // return redirect('/')
        //     ->with('message', 'Registration Successful!')
        //     ->with('type', 'success');

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

        // session([
        //     'verify_user'=>$user->id
        // ]);

        return redirect('/verify-email?token=' . $verifyToken)
            ->with('message','Verification email sent successfully. Please check your inbox or spam and follow the instructions to verify your email.')
            ->with('type','success');

    }


    // public function verifyEmail(Request $request)
    // {
    //     $request->validate([
    //         'otp'=>'required'
    //     ]);

    //     $user = User::find(session('verify_user'));

    //     if(!$user){

    //         return redirect('/register');
    //     }

    //     if($user->email_otp != $request->otp){

    //         return back()
    //             ->with('message','Invalid OTP')
    //             ->with('type','error');
    //     }

    //     if(now()->gt($user->otp_expire_at)){

    //         return back()
    //             ->with('message','OTP Expired')
    //             ->with('type','error');
    //     }

    //     $user->update([
    //         'email_verified'=>1,
    //         'email_verified_at'=>now(),
    //         'email_otp'=>null,
    //         'otp_expire_at'=>null,
    //     ]);

    //     Auth::login($user);

    //     session()->forget('verify_user');

    //     return redirect('/')
    //         ->with('message','Email Verified Successfully.')
    //         ->with('type','success');
    // }


    public function verifyEmailLink(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return view('auth.verify-email');
        }

        $user = User::where('email_verify_token', $token)->first();

        if (!$user) {
            return redirect('/login')
                ->with('message', 'Invalid or expired verification link.')
                ->with('type', 'error');
        }

        if ($user->email_verified) {
            Auth::login($user);

            return redirect('/')
                ->with('message', 'Your email is already verified.')
                ->with('type', 'success');
        }

        $user->update([
            'email_verified' => 1,
            'email_verified_at' => now(),
            'email_otp' => null,
            'otp_expire_at' => null,
            'email_verify_token' => null,
        ]);

        Auth::login($user);

        return redirect('/')
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
}