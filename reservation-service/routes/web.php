<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\SeatController;

// Table management APIs
Route::get('/api/tables', [TableController::class, 'index']);
Route::post('/api/tables', [TableController::class, 'store']);
Route::put('/api/tables/{table}', [TableController::class, 'update']);
Route::delete('/api/tables/{table}', [TableController::class, 'destroy']);

// Seat/Reservation APIs
Route::get('/api/seat/available', [SeatController::class, 'index']);
Route::post('/api/reserve/temp', [SeatController::class, 'tempReserve']);
Route::post('/api/reserve/confirm', [SeatController::class, 'confirmReservation']);

// Admin stats endpoint
Route::get('/api/admin/stats', function() {
    $today = now()->toDateString();
    return response()->json([
        'todayReservations' => \App\Models\Reservation::whereDate('created_at', $today)->count(),
        'tablesReserved' => \App\Models\Table::where('status', 'reserved')->count(),
        'tablesAvailable' => \App\Models\Table::where('status', 'available')->count(),
    ]);
});