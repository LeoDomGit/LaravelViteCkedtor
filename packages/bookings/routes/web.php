<?php

use Illuminate\Support\Facades\Route;
use Leo\Bookings\Controllers\BookingController;

Route::apiResource('api/bookings', BookingController::class);
Route::apiResource('bookings', BookingController::class);

Route::prefix('api')->group(function () {
    Route::get('/bookings',[BookingController::class,'api_home'])->middleware('auth:sanctum');
    Route::get('/bookings/nhan-vien',[BookingController::class,'api_nhan_vien'])->middleware('auth:sanctum');

});
