<?php

use Illuminate\Support\Facades\Route;
use Leo\Categories\Controllers\CategoriesController;

Route::resource('brands', CategoriesController::class);