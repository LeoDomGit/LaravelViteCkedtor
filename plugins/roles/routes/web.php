<?php
use Illuminate\Support\Facades\Route;
use Leo\Roles\Controllers\RolesController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('roles', RolesController::class);
});