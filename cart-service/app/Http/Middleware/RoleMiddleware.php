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
    public function handle(Request $request, Closure $next, $role = null) // ✅ diperbaiki di sini
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        if ($role !== null && Auth::user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        if ($role === null && Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
