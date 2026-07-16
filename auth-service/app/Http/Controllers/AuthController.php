<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // API Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }

    // API Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // API Logout
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.'
        ]);
    }
}