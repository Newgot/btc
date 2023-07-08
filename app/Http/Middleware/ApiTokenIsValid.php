<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $request->bearerToken() === config('api.token')
            ? $next($request)
            : response([
                'status' => 'error',
                'code' => 403,
                'message' => 'Invalid token',
            ], 403);
    }
}
