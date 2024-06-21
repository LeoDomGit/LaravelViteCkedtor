<?php

use Illuminate\Support\Facades\Route;
use Leo\Brands\Controllers\BrandsController;

Route::resource('brands', BrandsController::class);