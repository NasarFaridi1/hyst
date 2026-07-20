<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization token is required.'
            ], 401);
        }

        $user = User::where(
            'api_token',
            hash('sha256', $token)
        )->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token.'
            ], 401);
        }

        Auth::setUser($user);

        return $next($request);
    }
}