<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth('api')->check()) {
            return response()->json(['status_code' => 401, 'message' => 'Unauthenticated.']);
        }

        return $next($request);
    }
}
