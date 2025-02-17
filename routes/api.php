<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function() {
    // Check token if not expired and get authenticated user
    Route::get('/check-user', [AuthController::class, 'checkUser']);

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function() {
        Route::get('/list', 'list');
    });

    // Tasks routes
    Route::group(['prefix' => 'tasks', 'controller' => TaskController::class], function() {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::post('/update/{task}', 'update');
        Route::delete('/delete/{task}', 'delete');
        Route::get('/show/{task}', 'show');
    });
});


