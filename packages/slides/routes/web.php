<?php
use Illuminate\Support\Facades\Route;
use Leo\Slides\Controllers\SlidesController;
use App\Http\Middleware\CheckLogin;

Route::resource('slides', SlidesController::class)->middleware(CheckLogin::class);

Route::get('api/slides/', [SlidesController::class,'api_index']);
Route::get('api/slides/{slug}', [SlidesController::class,'api_single']);
