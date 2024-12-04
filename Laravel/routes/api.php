<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/logout', [UsersController::class, 'logout']);
Route::post('/dashboard', [UsersController::class, 'dashboard']);


// Route::post('/register', [AuthController::class, 'register'])->middleware('web');
// Route::post('/login', [AuthController::class, 'login'])->middleware('web');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
