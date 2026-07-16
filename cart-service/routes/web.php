<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;

// Cart API Routes
Route::get('/api/cart', [CartController::class, 'getCart']);
Route::post('/api/cart/add/{product}', [CartController::class, 'add']);
Route::post('/api/cart/remove/{item}', [CartController::class, 'remove']);
Route::post('/api/cart/update-quantity/{item}', [CartController::class, 'updateQuantity']);
Route::post('/api/cart/clear', [CartController::class, 'clearCart']);

// Checkout API Routes
Route::post('/api/payment/submit', [CheckoutController::class, 'submitTransaction']);
Route::post('/api/payment/confirm', [CheckoutController::class, 'confirmTransaction']);
Route::post('/api/payment/update-method', [CheckoutController::class, 'updatePaymentMethod']);
Route::get('/api/payment/history', [CheckoutController::class, 'getHistory']);
Route::get('/api/payment/active', [CheckoutController::class, 'getActiveTransactions']);
Route::get('/api/checkout/{code}', [CheckoutController::class, 'getTransaction']);

// Confirmation API Routes
Route::post('/api/confirmation/update', [ConfirmationController::class, 'storeContact']);
Route::post('/api/confirmation/confirm-status', [ConfirmationController::class, 'confirmStatus']);
Route::post('/api/confirmation/finalize', [ConfirmationController::class, 'finalizeConfirmation']);

// Admin Transaction API Routes
Route::get('/api/admin/transactions', [TransactionController::class, 'index']);
Route::get('/api/admin/transactions/{id}', [TransactionController::class, 'show']);
Route::put('/api/admin/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/api/admin/transactions/{id}', [TransactionController::class, 'destroy']);

// Admin Order API Routes
Route::get('/api/admin/orders', [OrderController::class, 'index']);
Route::post('/api/admin/orders', [OrderController::class, 'store']);
Route::patch('/api/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

// Admin report API Routes
Route::get('/api/admin/reports', [ReportController::class, 'index']);

// Admin stats endpoint
Route::get('/api/admin/stats', function() {
    $today = now()->toDateString();
    $visitorsToday = \DB::table('orders')->whereDate('created_at', $today)->distinct('customer_name')->count('customer_name');
    
    $revenueToday = \DB::table('order_items')
        ->join('db_menu.products', 'order_items.product_id', '=', 'products.id')
        ->whereDate('order_items.created_at', $today)
        ->select(\DB::raw('SUM(order_items.quantity * products.price) as total'))
        ->value('total') ?? 0;
        
    return response()->json([
        'visitorsToday' => $visitorsToday,
        'revenueToday' => (float)$revenueToday,
    ]);
});