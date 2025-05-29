<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\receipt_controller; // tambahkan ini jika belum
use App\Http\Controllers\TableController; // tambahkan ini jika belum
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfirmationController;

/*
|--------------------------------------------------------------------------
| 🔐 AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));
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
        'admin' => redirect()->route('admin.index'),
        'user' => redirect()->route('mode'),
        default => abort(403, 'Unauthorized'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| 👑 ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
    Route::get('/table-management', [AdminController::class, 'tableManagement'])->name('table.management');
    Route::get('/edit-meja', [TableController::class, 'index'])->name('editMeja');
    Route::post('/table', [TableController::class, 'store'])->name('table.store');
    Route::put('/table/{table}', [TableController::class, 'update'])->name('table.update');
    Route::delete('/table/{table}', [TableController::class, 'destroy'])->name('table.delete');
});


/*
|--------------------------------------------------------------------------
| 👤 USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mode', fn() => view('auth.mode'))->name('mode');
    Route::get('/home', fn() => view('auth.home'))->name('home');

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
    Route::post('/payment/submit', [CheckoutController::class, 'submitTransaction'])->name('payment.submit');
    Route::post('/complete-order', [CheckoutController::class, 'completeOrder'])->name('complete.order');
    Route::get('/payment/status/final', [CheckoutController::class, 'statusFinal'])->name('payment.status.final');
    Route::get('/payment/history', [CheckoutController::class, 'showHistory'])->name('payment.history');
    Route::post('/payment/confirm', [CheckoutController::class, 'confirmTransaction'])->name('payment.confirm');
    Route::get('/checkout/{code}', [CheckoutController::class, 'checkoutByCode'])->name('checkoutByCode');

    // Untuk form update dari halaman checkout
    Route::post('/payment/update-dana', [CheckoutController::class, 'updateDana'])->name('payment.update.dana');
    Route::post('/payment/update-credit', [CheckoutController::class, 'updateCredit'])->name('payment.update.credit');

    Route::post('/reserve/temp', [SeatController::class, 'tempReserve'])->name('reserve.temp');
    Route::post('/reserve/confirm', [SeatController::class, 'confirmReservation'])->name('confirm.reservation');

    // Confirm 
    Route::get('/confirm/{transactionCode}', [CheckoutController::class, 'confirmView'])->name('confirm.view');
    Route::post('/confirmation/update', [ConfirmationController::class, 'storeContact'])->name('confirmation.store');
    Route::post('/confirmation/confirm-status', [ConfirmationController::class, 'confirmStatus'])->name('confirmation.status.confirm');
    Route::post('/confirmation/finalize', [ConfirmationController::class, 'finalizeConfirmation'])->name('confirmation.finalize');


});