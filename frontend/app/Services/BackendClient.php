<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class BackendClient
{
    public static function request()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        
        if (Auth::check()) {
            $user = Auth::user();
            $headers['X-User-Id'] = $user->id;
            $headers['X-User-Name'] = $user->name;
            $headers['X-User-Email'] = $user->email;
            $headers['X-User-Role'] = $user->role;
        }

        return Http::withHeaders($headers)->timeout(15);
    }

    public static function authUrl($path = '')
    {
        return rtrim(config('services.auth.url', 'http://auth-service:8000'), '/') . '/' . ltrim($path, '/');
    }

    public static function menuUrl($path = '')
    {
        return rtrim(config('services.menu.url', 'http://menu-service:8000'), '/') . '/' . ltrim($path, '/');
    }

    public static function reservationUrl($path = '')
    {
        return rtrim(config('services.reservation.url', 'http://reservation-service:8000'), '/') . '/' . ltrim($path, '/');
    }

    public static function cartUrl($path = '')
    {
        return rtrim(config('services.cart.url', 'http://cart-service:8000'), '/') . '/' . ltrim($path, '/');
    }
}
