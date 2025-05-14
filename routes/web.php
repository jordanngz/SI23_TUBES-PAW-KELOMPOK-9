<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Redirect root ke /login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect dashboard sesuai role
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'guest';

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'user') {
        return redirect()->route('home');
    }

    abort(403, 'Unauthorized');
})->middleware('auth')->name('dashboard');

// Admin dashboard (khusus admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Buat file resources/views/admin/dashboard.blade.php
    })->name('admin.dashboard');
});

// Home (khusus user biasa)
Route::get('/home', function () {
    return view('auth.home'); // Buat file resources/views/auth/home.blade.php
})->middleware('auth')->name('home');
