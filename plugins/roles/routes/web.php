<?php
use Illuminate\Support\Facades\Route;
use Leo\Roles\Controllers\RolesController;

Route::middleware(['web', 'auth.basic'])->group(function () {
    Route::resource('roles', RolesController::class);
});