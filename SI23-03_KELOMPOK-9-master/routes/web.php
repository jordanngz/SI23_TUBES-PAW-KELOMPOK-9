<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SeatController;

/*
|--------------------------------------------------------------------------
| 🔐 AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🔀 DASHBOARD REDIRECT BY ROLE
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'guest';

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'user'  => redirect()->route('mode'),
        default => abort(403, 'Unauthorized access.'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| 👑 ADMIN ROUTES (Requires 'admin' middleware)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn () => view('admin.dashboardAdmin'))->name('dashboard');
Route::get('/edit-meja', fn () => view('admin.edit-meja'))->name('editMeja');
Route::get('/edit-menu', fn () => view('admin.edit-menu'))->name('editMenu');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
});

/*
|--------------------------------------------------------------------------
| 👤 USER ROUTES (Requires login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mode', fn () => view('auth.mode'))->name('mode');
    Route::get('/home', fn () => view('auth.home'))->name('home');

    // 🔵 Seat Reservation
    Route::get('/seat', [SeatController::class, 'index'])->name('reserve');
    Route::post('/seat', [SeatController::class, 'reserve'])->name('reserve.store');

    // 🍽️ Menu & Cart
    Route::get('/menu', [CartController::class, 'viewMenu'])->name('menu');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});
