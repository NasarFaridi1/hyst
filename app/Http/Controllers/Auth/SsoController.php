<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Restaurant;

class SsoController extends Controller
{
    /**
     * Consume one-time SSO token and initiate authenticated web session for WebView.
     */
    public function consumeToken(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/login')->with([
                'message' => 'SSO authentication token is missing.',
                'type'    => 'error',
                'error'   => 'SSO authentication token is missing.',
            ]);
        }

        // Atomically retrieve and delete token (burn-after-reading prevents replay attacks)
        $ssoData = Cache::pull("sso_token_{$token}");

        if (!$ssoData || empty($ssoData['user_id'])) {
            return redirect('/login')->with([
                'message' => 'The sign-in link has expired or has already been used.',
                'type'    => 'error',
                'error'   => 'The sign-in link has expired or has already been used.',
            ]);
        }

        $user = User::find($ssoData['user_id']);

        if (!$user) {
            return redirect('/login')->with([
                'message' => 'User account not found.',
                'type'    => 'error',
                'error'   => 'User account not found.',
            ]);
        }

        // Verify restaurant status is active
        if ($user->role === 'restaurant_admin' || !empty($user->restaurant_id)) {
            $restaurant = $user->restaurant ?? Restaurant::find($user->restaurant_id);
            if (!$restaurant || (int)$restaurant->status === 0) {
                return redirect('/login')->with([
                    'message' => 'Your restaurant account has been deactivated. Please contact the administrator.',
                    'type'    => 'error',
                    'error'   => 'Your restaurant account has been deactivated. Please contact the administrator.',
                ]);
            }
        }

        // Log the user into the Laravel web session with persistent remember cookie
        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->role === 'restaurant_admin' || !empty($user->restaurant_id)) {
            session()->flash('restaurant_just_logged_in', true);
        }

        $defaultRedirect = ($user->role === 'restaurant_admin' || !empty($user->restaurant_id))
            ? '/restaurant/orders'
            : '/';

        $redirect = $ssoData['redirect'] ?? $request->query('redirect', $defaultRedirect);

        // Prevent external open-redirect vulnerabilities
        if (
            empty($redirect) ||
            str_starts_with($redirect, 'http://') ||
            str_starts_with($redirect, 'https://') ||
            str_starts_with($redirect, '//')
        ) {
            $redirect = $defaultRedirect;
        }

        return redirect($redirect);
    }
}
