<?php

use Illuminate\Support\Facades\Route;
use Leo\Bookings\Controllers\BookingController;

Route::apiResource('bookings', BookingController::class);

Route::prefix('api')->group(function () {
    Route::post('/bookings',[BookingController::class,'store']);
    Route::get('/customers',[BookingController::class,'getCustomer']);
    Route::get('/checkOut/{id}',[BookingController::class,'createBill']);
    Route::put('/bookings/{id}',[BookingController::class,'update']);
    Route::get('/bookings',[BookingController::class,'api_home'])->middleware('auth:sanctum');
    Route::get('/bookings/nhan-vien',[BookingController::class,'api_nhan_vien'])->middleware('auth:sanctum');
    Route::get('/submitBooking/{id}',[BookingController::class,'api_submitbooking_nhan_vien'])->middleware('auth:sanctum');
    Route::get('/cancelBooking/{id}',[BookingController::class,'api_cancelbooking_nhan_vien'])->middleware('auth:sanctum');


});
