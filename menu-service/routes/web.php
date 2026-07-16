<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;

Route::get('/api/products', [MenuController::class, 'index']);
Route::get('/api/products/latest', [MenuController::class, 'latest']);
Route::post('/api/products', [MenuController::class, 'store']);
Route::put('/api/products/{id}', [MenuController::class, 'update']);
Route::delete('/api/products/{id}', [MenuController::class, 'destroy']);