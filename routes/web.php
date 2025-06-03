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
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;


/*
|--------------------------------------------------------------------------
| 🔐 AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🔀 ROLE-BASED DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'guest';
    return match ($role) {
        'admin' => redirect()->route('admin.index'),
        'user' => redirect()->route('home'),
        default => abort(403, 'Unauthorized'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| 👑 ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('logout');

    // Table Management
    Route::get('/table-management', [AdminController::class, 'tableManagement'])->name('table.management');
    Route::get('/edit-meja', [TableController::class, 'index'])->name('editMeja');
    Route::post('/table', [TableController::class, 'store'])->name('table.store');
    Route::put('/table/{table}', [TableController::class, 'update'])->name('table.update');
    Route::delete('/table/{table}', [TableController::class, 'destroy'])->name('table.delete');
    Route::get('/admin/table-management', [TableController::class, 'showTableManagement'])->name('admin.table.management');


    // Maanagement Reservation
    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [\App\Http\Controllers\Admin\TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [\App\Http\Controllers\Admin\TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [\App\Http\Controllers\Admin\TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Menu Management
    Route::get('/menu-management', [MenuController::class, 'index'])->name('menu.management');
    Route::post('/admin/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Order Management
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/admin/orders/create', [OrderController::class, 'create'])->name('aorders.create');
    Route::post('/admin/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Report
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});


/*
|--------------------------------------------------------------------------
| 👤 USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {


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