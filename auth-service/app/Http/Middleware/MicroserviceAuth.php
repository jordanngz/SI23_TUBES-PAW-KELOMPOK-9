<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MicroserviceAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->header('X-User-Id');
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $user = new User([
                    'name' => $request->header('X-User-Name', 'User'),
                    'email' => $request->header('X-User-Email', 'user@example.com'),
                    'role' => $request->header('X-User-Role', 'user'),
                ]);
                $user->id = (int)$userId;
            }
            Auth::setUser($user);
        }
        return $next($request);
    }
}
