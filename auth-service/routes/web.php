<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

// Public Auth Endpoints
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/logout', [AuthController::class, 'logout']);

// User Management Endpoints
Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users', [UserController::class, 'store']);
Route::put('/api/users/{id}', [UserController::class, 'update']);
Route::delete('/api/users/{id}', [UserController::class, 'destroy']);