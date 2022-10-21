<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;




Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::post('comments/{comment}', [CommentController::class, 'reply'])->name('comments.reply');
