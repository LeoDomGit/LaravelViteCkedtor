<?php

use App\Http\Middleware\CheckLogin;
use App\Packages\Revenues\src\Controllers\RevenueController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', CheckLogin::class])->group(function () {
    Route::resource('revenues', RevenueController::class);
});
//product
Route::get('revenue/product', [RevenueController::class, 'getProductRevenue']);
Route::get('revenue/products/daily', [RevenueController::class, 'getProductRevenueByDate']);
Route::get('revenue/products/monthly', [RevenueController::class, 'getProductRevenueByMonth']);

// services
Route::get('revenue/services', [RevenueController::class, 'getServiceRevenue']);
Route::get('revenue/services/daily', [RevenueController::class, 'getServiceRevenueByDate']);
Route::get('revenue/services/monthly', [RevenueController::class, 'getServiceRevenueByMonth']);
Route::get('revenue/services/weekly-monthly', [RevenueController::class, 'getServiceRevenueByWeekMonth']);