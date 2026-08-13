<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
        //check password strength 
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $request->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]);
        }

        $email = strtolower(trim($request->email));

        // Block @hyst.uk emails
        if (str_ends_with($email, '@hyst.uk')) {
            return response()->json([
                'status' => false,
                'message' => 'Registration with email addresses is not allowed.'
            ], 422);
        }

        // Check duplicate email
        $emailExist = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if ($emailExist) {
            return response()->json([
                'status' => false,
                'message' => 'Email already exists.'
            ], 422);
        }

        $otp = rand(100000, 999999);

        

        $verifyToken = Str::uuid()->toString();

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified' => 0,
            'email_otp' => $otp,
            'otp_expire_at' => Carbon::now()->addMinutes(10),
            'email_verify_token' => $verifyToken,
        ]);

        $verifyUrl = "https://hyst.uk/verify-email?token={$verifyToken}";

        Mail::to($user->email)->send(new VerifyOtpMail($otp,$verifyUrl));

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Verification code sent successfully.',
        //     'user_id' => $user->id
        // ]);
        return response()->json([
            'status' => true,
            'message' => 'Verification email sent successfully. Please check your inbox or spam and follow the instructions to verify your email.',
            'user_id' => $user->id
        ]);
    }

    // public function verifyEmail(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|exists:users,id',
    //         'otp' => 'required|digits:6'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $user = User::find($request->user_id);

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found.'
    //         ], 404);
    //     }

    //     if ($user->email_otp != $request->otp) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid OTP.'
    //         ], 422);
    //     }

    //     if (now()->gt($user->otp_expire_at)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'OTP expired.'
    //         ], 422);
    //     }

    //     $user->update([
    //         'email_verified' => 1,
    //         'email_verified_at' => now(),
    //         'email_otp' => null,
    //         'otp_expire_at' => null,
    //     ]);

    //     $token = $user->createToken('API Token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Email verified successfully.',
    //         'token' => $token,
    //         'user' => $user
    //     ]);
    // }

    public function verifyByLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'otp'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $token = $request->token;

        $user = User::where('email_verify_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid verification link.'
            ], 404);
        }

        if ($user->email_verified) {
            return response()->json([
                'status' => true,
                'message' => 'Your email is already verified.'
            ]);
        }

        if ($user->otp_expire_at && now()->gt($user->otp_expire_at)) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.'
            ], 422);
        }

        if ((string)$user->email_otp !== (string)trim($request->otp)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.'
            ], 422);
        }

        $user->update([
            'email_verified' => 1,
            'email_verified_at' => now(),
            'email_otp' => null,
            'otp_expire_at' => null,
            'email_verify_token' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully.'
        ]);
    }


    // public function resendOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|exists:users,id'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $user = User::find($request->user_id);

    //     $otp = rand(100000, 999999);

    //     $user->update([
    //         'email_otp' => $otp,
    //         'otp_expire_at' => now()->addMinutes(10)
    //     ]);

    //     Mail::to($user->email)->send(new VerifyOtpMail($otp));

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP sent successfully.'
    //     ]);
    // }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email_verify_token', $request->token)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid verification request.'
            ], 404);
        }

        if ($user->email_verified) {
            return response()->json([
                'status' => true,
                'message' => 'Your email is already verified.'
            ]);
        }

        $otp = rand(100000, 999999);
        $verifyToken = Str::random(64);

        $user->update([
            'email_otp' => $otp,
            'otp_expire_at' => now()->addMinutes(10),
            'email_verify_token' => $verifyToken,
        ]);

        $verifyUrl = "https://hyst.uk/verify-email?token={$verifyToken}";

        Mail::to($user->email)->send(new VerifyOtpMail($otp, $verifyUrl));

        return response()->json([
            'status' => true,
            'message' => 'A new verification email has been sent.',
            'token' => $verifyToken
        ]);
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $email = strtolower(trim($request->email));

        $user = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->role === 'restaurant_admin' || $user->restaurant_id) {
            $restaurant = $user->restaurant ?? \App\Models\Restaurant::find($user->restaurant_id);

            if (!$restaurant || (int)$restaurant->status === 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your restaurant account has been deactivated. Please contact the administrator.'
                ], 403);
            }

            if (!$user->email_verified) {
                $user->update([
                    'email_verified' => 1,
                    'email_verified_at' => now()
                ]);
            }
        }

        if (!$user->email_verified) {
            return response()->json([
                'status' => false,
                'message' => 'Please verify your email first.'
            ], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login credentials.'
            ], 401);
        }

        $plainToken = bin2hex(random_bytes(32));

        $user->api_token = hash('sha256', $plainToken);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Login successful. Welcome back! Enjoy your delicious food.',
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $cacheKey = 'pwd_reset_cooldown_' . md5($email);

        if (Cache::has($cacheKey)) {
            return response()->json([
                'status' => true,
                'message' => 'Password reset link sent successfully.'
            ]);
        }

        $user = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email not found.'
            ], 404);
        }

        Cache::put($cacheKey, true, 60);

        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(30),
            [
                'email' => $user->email
            ]
        );

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

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent successfully.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where(
            'email_hash',
            hash('sha256', strtolower(trim($request->email)))
        )->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function index()
    {
        $user = User::find(auth()->id());

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully.',
            'data' => $user
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $emailExists = User::where(
            'email_hash',
            hash('sha256', strtolower(trim($request->email)))
        )
        ->where('id', '!=', auth()->id())
        ->exists();

        if ($emailExists) {
            return response()->json([
                'status' => false,
                'message' => 'Email already exists.'
            ], 422);
        }

        $user = User::find(auth()->id());

        $user->update([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.',
            'data' => $user->fresh()
        ]);
    }

    public function dashboard()
    {
        $userId = auth()->id();

        $orders = Order::where('user_id', $userId)->count();

        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('is_read', 0)
            ->count();

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data fetched successfully.',
            'data' => [
                'total_orders' => $orders,
                'unread_notifications' => $unreadCount,
                'notifications' => $notifications,
            ]
        ]);
    }
}