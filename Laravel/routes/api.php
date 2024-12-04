<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth:api');;
Route::post('/dashboard', [UsersController::class, 'dashboard'])->middleware('auth:api');;


// Route::post('/register', [AuthController::class, 'register'])->middleware('web');
// Route::post('/login', [AuthController::class, 'login'])->middleware('web');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
