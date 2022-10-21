<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;



Route::post('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
Route::post('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
Route::post('blog', [BlogController::class, 'getIndex'])->name('blogs.index');
Route::post('blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
Route::post('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');
