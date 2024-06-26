<?php
use Illuminate\Support\Facades\Route;
use Leo\Roles\Controllers\RolesController;
use App\Http\Middleware\CheckLogin;

Route::resource('roles', RolesController::class)->middleware(CheckLogin::class);