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
     * Authenticate restaurant user and return API token and WebView SSO URL.
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
            ], 422);
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
            ], 401);
        }

        // Restrict login strictly to restaurant accounts
        $isRestaurant = ($user->role === 'restaurant_admin' || !empty($user->restaurant_id));
        if (!$isRestaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Access restricted. Only restaurant accounts are permitted to log in.',
            ], 403);
        }

        // Verify restaurant is active
        $restaurant = $user->restaurant ?? Restaurant::find($user->restaurant_id);
        if (!$restaurant || (int)$restaurant->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your restaurant account has been deactivated. Please contact the administrator.',
            ], 403);
        }

        // Auto verify restaurant user email if not yet verified
        if (!$user->email_verified) {
            $user->update([
                'email_verified'    => 1,
                'email_verified_at' => now(),
            ]);
        }

        // Generate persistent API Token
        $plainToken = bin2hex(random_bytes(32));
        $user->api_token = hash('sha256', $plainToken);
        $user->save();

        // Generate short-lived, single-use SSO Token (valid for 5 minutes)
        $ssoToken = Str::random(64);
        Cache::put("sso_token_{$ssoToken}", [
            'user_id'    => $user->id,
            'created_at' => now()->timestamp,
        ], now()->addMinutes(5));

        $redirectPath = $request->input('redirect', '/restaurant/orders');
        $webviewUrl = url("/auth/sso?token={$ssoToken}&redirect=" . urlencode($redirectPath));

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
        ]);
    }

    /**
     * Get authenticated restaurant user profile.
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $restaurant = $user->restaurant ?? Restaurant::find($user->restaurant_id);

        return response()->json([
            'success' => true,
            'user' => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'global_role'       => $user->role,
                'profile_photo_url' => $user->image ? asset($user->image) : null,
                'restaurant'        => $restaurant,
            ],
        ]);
    }

    /**
     * Logout restaurant user (revoke api token).
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
        ]);
    }
}
