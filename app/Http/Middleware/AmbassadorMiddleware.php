<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AmbassadorMiddleware
{
    public function handle($request, Closure $next)
    {

        if(
            Auth::check()
            &&
            Auth::user()->role=='ambassador'
        ){

            return $next($request);

        }

        abort(403);

    }
}