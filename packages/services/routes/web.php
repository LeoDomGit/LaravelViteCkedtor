<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;

Route::middleware(['web', CheckLogin::class])->group(function () {
    Route::resource('services', ProductsController::class);
});