<?php

use Illuminate\Support\Facades\Route;
use Leo\Bills\Controllers\BillsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/vnpay',[BillsController::class,'vnpay']);
Route::get('/return-vnpay',[BillsController::class,'return']);
