<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Force HTTPS security
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains; preload'
        );

        // Prevent clickjacking
        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        // Prevent MIME sniffing
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );


        // Referrer protection
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );


        // Browser permissions
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=()'
        );


        // Content Security Policy
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' data: https:; connect-src 'self' https:;"
        );


        return $response;
    }
}