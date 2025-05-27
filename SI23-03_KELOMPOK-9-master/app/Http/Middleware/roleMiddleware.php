<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // If a specific role is required and user doesn't have it
        if ($role !== null && Auth::user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        // If no role is specified, treat as admin middleware (for backward compatibility)
        if ($role === null && Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}