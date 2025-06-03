<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Metode untuk menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Metode untuk proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buat credentials untuk Auth::attempt
        $credentials = $request->only('email', 'password');

        // Coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Jika berhasil login, redirect ke dashboard
            if (Auth::user()->role == "admin") {
                return view('admin.index');
            }else if (Auth::user()->role == "user") {
                return redirect()->route('home');
            }
            return redirect()->intended('/');
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // Metode untuk menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Metode untuk proses register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        // Login user yang baru dibuat
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard');
    }

    // Metode untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('status', 'Anda telah berhasil logout.');
    }
}