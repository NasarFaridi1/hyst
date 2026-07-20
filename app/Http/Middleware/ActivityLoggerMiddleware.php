<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Throwable;

class ActivityLoggerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => strtoupper(
                    explode('/', trim($request->path(), '/'))[0] ?? 'SYSTEM'
                ),

                'action' => $request->method(),

                'reference_id' => null,

                'description' => $request->method() .
                    ' ' .
                    $request->path(),

                'ip_address' => $request->ip(),

                'payload' => [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'request' => $request->except([
                        'password',
                        'password_confirmation',
                        'token'
                    ])
                ],

                'response' => [
                    'status_code' => $response->getStatusCode()
                ],

                'status' => $response->getStatusCode() < 400
                    ? 'success'
                    : 'failed',
            ]);

        } catch (Throwable $e) {
            // Never break request because of logging
        }

        return $response;
    }
}