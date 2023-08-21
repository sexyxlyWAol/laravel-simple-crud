<?php

namespace App\Http\Middleware;

// use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
//    protected function redirectTo(Request $request): ?string
//    {
//        return $request->expectsJson() ? null : route('login');
//    }

    public function handle(Request $request, Closure $next): Response
    {
        if (session('authenticated')) {
            return $next($request);
        }

        return response()->json(['success' => false, 'authenticated' => session('authenticated')], 403);
    }
}
