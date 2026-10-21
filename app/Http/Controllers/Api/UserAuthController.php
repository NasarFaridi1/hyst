<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    /**
     * User / Customer Register API
     * Creates new user account, returns api_token + webview_url for seamless Flutter WebView flow.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => ['required', new \App\Rules\PasswordComplexity()],
            'phone'    => 'nullable|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        $email = strtolower(trim($request->email));

        // Block @hyst.uk email domain for public registrations
        if (str_ends_with($email, 'hyst.uk')) {
            return response()->json([
                'success' => false,
                'message' => 'Registration with @hyst.uk email addresses is not allowed.',
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        // Check if email already exists via email_hash
        $emailExist = User::where(
            'email_hash',
            hash('sha256', $email)
        )->first();

        if ($emailExist) {
            return response()->json([
                'success' => false,
                'message' => 'Email is already registered. Please login instead.',
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        // Generate persistent API Token for Flutter
        $plainToken = bin2hex(random_bytes(32));

        $user = User::create([
            'name'              => trim($request->name),
            'email'             => $email,
            'password'          => Hash::make($request->password),
            'phone'             => $request->phone ? trim($request->phone) : null,
            'role'              => 'user',
            'email_verified'    => 1,
            'email_verified_at' => now(),
            'api_token'         => hash('sha256', $plainToken),
        ]);

        // Generate single-use SSO Token (valid for 5 minutes)
        $ssoToken = Str::random(64);
        Cache::put("sso_token_{$ssoToken}", [
            'user_id'    => $user->id,
            'redirect'   => '/',
            'created_at' => now()->timestamp,
        ], now()->addMinutes(5));

        // Clean webview URL with no redirect query parameter
        $webviewUrl = url("/auth/sso?token={$ssoToken}");

        return response()->json([
            'success' => true,
            'message' => 'Account registered successfully!',
            'user' => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'global_role'       => $user->role,
                'profile_photo_url' => $user->image ? asset($user->image) : null,
            ],
            'api_token'   => $plainToken,
            'webview_url' => $webviewUrl,
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * User / Customer Login API
     * Validates credentials, checks user account, and returns api_token + webview_url
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

        // Restrict to customer/user accounts (block restaurant admin from customer login)
        if ($user->role === 'restaurant_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Access restricted. Restaurant accounts should use the restaurant login.',
            ], 403, [], JSON_UNESCAPED_SLASHES);
        }

        // Verify email is verified
        if (!$user->email_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first.',
            ], 403, [], JSON_UNESCAPED_SLASHES);
        }

        // Generate persistent API Token for Flutter
        $plainToken = bin2hex(random_bytes(32));
        $user->api_token = hash('sha256', $plainToken);
        $user->save();

        // Generate single-use SSO Token (valid for 5 minutes)
        $ssoToken = Str::random(64);
        Cache::put("sso_token_{$ssoToken}", [
            'user_id'    => $user->id,
            'redirect'   => '/',
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
     * User Logout API
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
