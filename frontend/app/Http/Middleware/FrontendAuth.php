<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FrontendAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userData = session('user');
        if ($userData) {
            $user = new User();
            $user->forceFill($userData);
            Auth::setUser($user);
            Auth::guard('web')->setUser($user);
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }
        return $next($request);
    }
}
