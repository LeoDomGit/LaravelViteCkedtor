<?php

use Illuminate\Support\Facades\Route;
use Leo\Post\Controllers\PostCateController;
use App\Http\Middleware\CheckLogin;
Route::middleware(['web', CheckLogin::class])->group(function () {
    Route::resource('post-collections', PostCateController::class);
});

Route::prefix('api')->group(function () {
    Route::get('/post-collections',[PostCateController::class,'api_index']);
    Route::get('/post-collections/{id}',[PostCateController::class,'api_show']);
});
