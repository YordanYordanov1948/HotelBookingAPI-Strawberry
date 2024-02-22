<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{room}', [RoomController::class, 'show']);
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/customers', [CustomerController::class, 'index']);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/rooms', [RoomController::class, 'store']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'deleteBooking']);

    // User route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

