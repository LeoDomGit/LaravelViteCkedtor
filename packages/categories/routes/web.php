<?php

use Illuminate\Support\Facades\Route;
use Leo\Categories\Controllers\CategoriesController;

Route::resource('categories', CategoriesController::class)->middleware('auth');

Route::prefix('api')->group(function () {
    Route::get('/categories',[CategoriesController::class,'api_index']);
    Route::get('/categories/{id}',[CategoriesController::class,'api_show']);
});