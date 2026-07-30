<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role != 'restaurant_admin') {
            abort(403);
        }

        $user = auth()->user();
        $restaurant = $user->restaurant ?? \App\Models\Restaurant::find($user->restaurant_id);

        if (!$restaurant || (int)$restaurant->status === 0) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your restaurant account has been deactivated. Please contact the administrator.'
                ], 403);
            }

            return redirect('/login')
                ->with('message', 'Your restaurant account has been deactivated. Please contact the administrator.')
                ->with('type', 'error')
                ->with('error', 'Your restaurant account has been deactivated. Please contact the administrator.');
        }

        return $next($request);
    }
}
