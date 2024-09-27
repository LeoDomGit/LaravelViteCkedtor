<?php

use Illuminate\Support\Facades\Route;
use khanhduy\Comment\Controllers\CommentController;

Route::resource('comments', CommentController::class)->middleware(['web', 'admin:web']);

Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::post('/comments', [CommentController::class, 'addComment']);
    Route::put('/comments/{id}', [CommentController::class, 'updatedComment']);
    Route::delete('/comments/{id}', [CommentController::class, 'deleteComment']);
});