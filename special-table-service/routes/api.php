<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialReservationController;

/*
|--------------------------------------------------------------------------
| Special Table Microservice — API Routes
|--------------------------------------------------------------------------
| Semua route dilindungi middleware 'verify.token'
| yang memvalidasi Bearer token dari main app.
|--------------------------------------------------------------------------
*/

Route::middleware('verify.token')->group(function () {

    // Daftar meja special yang tersedia pada tanggal/waktu tertentu
    Route::get('/special/tables', [SpecialReservationController::class, 'availableTables']);

    // Simpan data form ke session (validasi + check availability)
    Route::post('/special/temp', [SpecialReservationController::class, 'tempStore']);

    // Konfirmasi & persist detail special setelah payment sukses
    Route::post('/special/confirm', [SpecialReservationController::class, 'confirm']);

    // Detail satu special reservation
    Route::get('/special/{id}', [SpecialReservationController::class, 'show']);

    // Batalkan special reservation
    Route::delete('/special/{id}', [SpecialReservationController::class, 'destroy']);

});
