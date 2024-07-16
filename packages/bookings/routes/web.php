<?php

use Illuminate\Support\Facades\Route;
use Leo\Bookings\Controllers\BookingController;

Route::apiResource('api/bookings', BookingController::class);
Route::apiResource('bookings', BookingController::class);

Route::prefix('api')->group(function () {
    Route::prefix('bookings')->group(function () {
        Route::get('/',[BookingController::class,'api_home'])->middleware('auth:sanctum');
    });

});
