<?php
use Illuminate\Support\Facades\Route;
use Leo\Slides\Controllers\SlidesController;

Route::resource('slides', SlidesController::class)->middleware('auth');

Route::get('api/slides/', [SlidesController::class,'api_index']);
Route::get('api/slides/{slug}', [SlidesController::class,'api_single']);
