<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RestaurantAuthController extends Controller
{
    /**
     * Restaurant Login API
     * Validates credentials, verifies restaurant account, and returns api_token + webview_url
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        $email = strtolower(trim($request->email));

        $user = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials.',
            ], 401, [], JSON_UNESCAPED_SLASHES);
        }

        // Restrict login strictly to restaurant accounts
        $isRestaurant = ($user->role === 'restaurant_admin' || !empty($user->restaurant_id));
        if (!$isRestaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Access restricted. Only restaurant accounts are permitted to log in.',
            ], 403, [], JSON_UNESCAPED_SLASHES);
        }

        // Verify restaurant is active
        $restaurant = $user->restaurant ?? Restaurant::find($user->restaurant_id);
        if (!$restaurant || (int)$restaurant->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your restaurant account has been deactivated. Please contact the administrator.',
            ], 403, [], JSON_UNESCAPED_SLASHES);
        }

        // Auto-verify email for restaurant user if not verified
        if (!$user->email_verified) {
            $user->update([
                'email_verified'    => 1,
                'email_verified_at' => now(),
            ]);
        }

        // Generate persistent API Token for Flutter
        $plainToken = bin2hex(random_bytes(32));
        $user->api_token = hash('sha256', $plainToken);
        $user->save();

        // Generate single-use SSO Token (valid for 5 minutes)
        $ssoToken = Str::random(64);
        Cache::put("sso_token_{$ssoToken}", [
            'user_id'    => $user->id,
            'created_at' => now()->timestamp,
        ], now()->addMinutes(5));

        // Clean webview URL with no redirect query parameter
        $webviewUrl = url("/auth/sso?token={$ssoToken}");

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully!',
            'user' => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'global_role'       => $user->role,
                'profile_photo_url' => $user->image ? asset($user->image) : null,
            ],
            'api_token'   => $plainToken,
            'webview_url' => $webviewUrl,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Restaurant Logout API
     * Invalidates mobile api_token
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }
}
