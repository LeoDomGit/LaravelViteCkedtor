<?php

use App\Http\Middleware\JWT;
use Illuminate\Support\Facades\Route;
use Leo\Products\Controllers\ProductsController;

Route::resource('products', ProductsController::class)->middleware('auth.basic');
Route::put('/products/switch/{id}',[ProductsController::class,'switchProduct'])->middleware('auth.basic');
Route::delete('/products/drop-image/{id}/{imageName}', [ProductsController::class, 'removeImage'])->middleware('auth.basic');
Route::post('/products/set-image/{id}/{imageName}', [ProductsController::class, 'setImage'])->middleware('auth.basic');
Route::put('/products/{id}',[ProductsController::class,'update'])->middleware('auth.basic');
Route::post('/products/set-image/{id}/{imageName}', [ProductsController::class, 'setImage'])->middleware('auth.basic');

Route::prefix('api/')->name('api.')->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/',[ProductsController::class,'api_product']);
        Route::get('/{id}',[ProductsController::class,'api_single_product']);
        Route::post('/loadCart',[ProductsController::class,'api_load_cart_product']);
    });
});