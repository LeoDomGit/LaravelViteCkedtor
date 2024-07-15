<?php

// use App\Http\Middleware\JWT;
use Illuminate\Support\Facades\Route;
use Leo\Users\Controllers\UserController;
use App\Http\Middleware\CheckLogin;

Route::middleware(['web',CheckLogin::class])->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/', [UserController::class,'login'])->middleware('web');
Route::post('/users/checkLogin',[UserController::class,'checkLogin'])->middleware('web');
Route::put('/users/switch/{id}', [UserController::class,'switchUser'])->middleware(['web','auth:admin']);
Route::post('/api/manager/checkLogin',[UserController::class,'checkLoginManager']);
Route::get('/api/staff', [UserController::class,'staff_list']);


