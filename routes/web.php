<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\CheckoutController;

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
| 🔀 ROLE-BASED DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'guest';
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'user'  => redirect()->route('mode'),
        default => abort(403, 'Unauthorized'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| 👑 ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| 👤 USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mode', fn () => view('auth.mode'))->name('mode');
    Route::get('/home', fn () => view('auth.home'))->name('home');

    // Seat Reservation
    Route::get('/seat', [SeatController::class, 'index'])->name('reserve');
    Route::post('/seat', [SeatController::class, 'reserve'])->name('reserve.store');

    // Menu & Cart
    Route::get('/menu', [CartController::class, 'viewMenu'])->name('menu');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Payment Methods
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/credit', [CheckoutController::class, 'credit'])->name('payment.credit');
    Route::get('/checkout/dana', [CheckoutController::class, 'dana'])->name('payment.dana');
    Route::get('checkout/receipt', [CheckoutController::class, 'receipt'])->name('payment.receipt');
    Route::get('checkout/status', [CheckoutController::class, 'status'])->name('payment.status');
    Route::post('/payment/submit', [CheckoutController::class, 'submitTransaction'])->name('payment.submit');
    Route::post('/complete-order', [CheckoutController::class, 'completeOrder'])->name('complete.order');
    Route::get('/payment/status/final', [CheckoutController::class, 'statusFinal'])->name('payment.status.final');
    Route::post('/payment/confirm', [CheckoutController::class, 'confirmTransaction'])->name('payment.confirm');
    Route::get('/checkout/{code}', [CheckoutController::class, 'checkoutByCode'])->name('checkoutByCode');
// Untuk form update dari halaman checkout
    Route::post('/payment/update-dana', [CheckoutController::class, 'updateDana'])->name('payment.update.dana');
    Route::post('/payment/update-credit', [CheckoutController::class, 'updateCredit'])->name('payment.update.credit');




});
