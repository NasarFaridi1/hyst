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
        $caughtException = null;

        try {
            $response = $next($request);
        } catch (Throwable $e) {
            $caughtException = $e;
            throw $e;
        } finally {
            try {
                $statusCode = isset($response) ? $response->getStatusCode() : 500;
                $isFailed = $statusCode >= 400 || $caughtException !== null;

                $responseData = [
                    'status_code' => $statusCode,
                ];

                $exception = $caughtException ?? (isset($response) && isset($response->exception) ? $response->exception : null);

                if ($exception instanceof Throwable) {
                    $responseData['error'] = [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'class' => get_class($exception),
                        'trace' => collect($exception->getTrace())->take(10)->map(function ($t) {
                            return [
                                'file' => $t['file'] ?? '',
                                'line' => $t['line'] ?? '',
                                'function' => $t['function'] ?? '',
                                'class' => $t['class'] ?? '',
                            ];
                        })->toArray(),
                    ];
                } elseif ($statusCode >= 400 && isset($response)) {
                    $content = $response->getContent();
                    if ($content && is_string($content) && strlen($content) < 5000) {
                        $json = json_decode($content, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                            if (isset($json['message']) || isset($json['error']) || isset($json['errors'])) {
                                $responseData['error'] = [
                                    'message' => $json['message'] ?? ($json['error'] ?? ('HTTP ' . $statusCode)),
                                    'details' => $json['errors'] ?? ($json['error'] ?? null),
                                ];
                            }
                        }
                    }
                }

                ActivityLog::create([
                    'user_id' => auth()->id(),

                    'module' => strtoupper(
                        explode('/', trim($request->path(), '/'))[0] ?? 'SYSTEM'
                    ),

                    'action' => $request->method(),

                    'reference_id' => null,

                    'description' => $request->method() .
                        ' ' .
                        $request->path() .
                        ($isFailed ? ' (' . $statusCode . ')' : ''),

                    'ip_address' => $request->ip(),

                    'payload' => [
                        'url' => $request->fullUrl(),
                        'method' => $request->method(),
                        'request' => $request->except([
                            'password',
                            'password_confirmation',
                            'token',
                            '_token',
                        ]),
                    ],

                    'response' => $responseData,

                    'status' => $isFailed ? 'failed' : 'success',
                ]);

            } catch (Throwable $e) {
                // Never break request because of logging failure
            }
        }

        return $response;
    }
}