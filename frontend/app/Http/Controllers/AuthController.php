<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = BackendClient::request()->post(BackendClient::authUrl('/api/login'), [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful() && $response->json('success')) {
            session(['user' => $response->json('user')]);
            
            if ($response->json('user.role') == 'admin') {
                return redirect()->route('admin.index');
            }
            return redirect()->route('home');
        }

        if ($response->status() === 422) {
            return back()->withErrors($response->json('errors', []))->withInput($request->except('password'));
        }

        return back()->withErrors([
            'email' => $response->json('message') ?? 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = BackendClient::request()->post(BackendClient::authUrl('/api/register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful() && $response->json('success')) {
            session(['user' => $response->json('user')]);
            return redirect()->route('dashboard');
        }

        if ($response->status() === 422) {
            return back()->withErrors($response->json('errors', []))->withInput($request->except('password'));
        }

        return back()->withErrors([
            'email' => $response->json('message') ?? 'Gagal melakukan registrasi.',
        ])->withInput($request->except('password'));
    }

    public function logout()
    {
        BackendClient::request()->post(BackendClient::authUrl('/api/logout'));
        session()->forget('user');
        return redirect()->route('home')->with('status', 'Anda telah berhasil logout.');
    }
}