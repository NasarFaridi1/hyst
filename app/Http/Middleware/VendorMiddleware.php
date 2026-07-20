<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() &&
            auth()->user()->role == 'vendor'){

            return $next($request);
        }

        abort(403);
    }
}