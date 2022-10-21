<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BundlesController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\TutorialsController;
use App\Http\Controllers\FormationsController;

//============Formation Routes=================//
Route::post('formations', [FormationsController::class, 'all'])->name('formations.all');
Route::post('formation/{slug}', [FormationsController::class, 'show'])->name('formations.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('formation/{formation_id}/rating', [FormationsController::class, 'rating'])->name('formations.rating');
Route::post('category/{category}/formations', [FormationsController::class, 'getByCategory'])->name('formations.category');
Route::post('formations/{id}/review', [FormationsController::class, 'addReview'])->name('formations.review');
Route::get('formations/review/{id}/edit', [FormationsController::class, 'editReview'])->name('formations.review.edit');
Route::post('formations/review/{id}/edit', [FormationsController::class, 'updateReview'])->name('formations.review.update');
Route::post('formations/review/{id}/delete', [FormationsController::class, 'deleteReview'])->name('formations.review.delete');

Route::post('/formation/formation-cart-elem/{id}', [FormationsController::class, 'getCartSessionElem'])->name('formations.cartsession.elem');

Route::post('formation/purchased/{formation_id}', [FormationsController::class, 'isPurchased'])->name('formations.purchased');



Route::group(['middleware' => 'auth:api'], function () {



    Route::get('module/{formation_id}/{slug}/', [ModulesController::class, 'show'])->name('modules.show');
    Route::post('module/{slug}/test', [ModulesController::class, 'test'])->name('modules.test');
    Route::post('module/{slug}/retest', [ModulesController::class, 'retest'])->name('modules.retest');
    Route::post('video/progress', [ModulesController::class, 'videoProgress'])->name('update.videos.progress');
    Route::post('module/progress', [ModulesController::class, 'formationProgress'])->name('update.formation.progress');

    Route::get('module/question/{question_id}/{result_id}/', [ModulesController::class, 'check_result_question'])->name('modules.question.result');
    Route::get('module/question/option/{option_id}/{result_id}/', [ModulesController::class, 'question_option_answered'])->name('modules.option.result');
    Route::get('module/media/progress/{media_id}', [ModulesController::class, 'media_progress'])->name('modules.media.progress');
});

//============Tutorial Routes=================//
Route::post('tutoriels', [TutorialsController::class, 'all'])->name('tutorials.all');
Route::post('tutoriel/{slug}', [TutorialsController::class, 'show'])->name('tutorials.show');
//Route::post('tutorial/payment', [TutorialsController::class, 'payment'])->name('tutorials.payment');
Route::post('tutoriel/{tutorial_id}/rating', [TutorialsController::class, 'rating'])->name('tutorials.rating');
Route::post('category/{category}/tutoriels', [TutorialsController::class, 'getByCategory'])->name('tutorials.category');
Route::post('tutoriels/{id}/review', [TutorialsController::class, 'addReview'])->name('tutorials.review');
Route::get('tutoriels/review/{id}/edit', [TutorialsController::class, 'editReview'])->name('tutorials.review.edit');
Route::post('tutoriels/review/{id}/edit', [TutorialsController::class, 'updateReview'])->name('tutorials.review.update');
Route::post('tutoriels/review/{id}/delete', [TutorialsController::class, 'deleteReview'])->name('tutorials.review.delete');


//============Bundle Routes=================//
Route::get('bundles', [BundlesController::class, 'all'])->name('bundles.all');
Route::get('bundle/{slug}', [BundlesController::class, 'show'])->name('bundles.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('bundle/{bundle_id}/rating', [BundlesController::class, 'rating'])->name('bundles.rating');
Route::get('category/{category}/bundles', [BundlesController::class, 'getByCategory'])->name('bundles.category');
Route::post('bundles/{id}/review', [BundlesController::class, 'addReview'])->name('bundles.review');
Route::get('bundles/review/{id}/edit', [BundlesController::class, 'editReview'])->name('bundles.review.edit');
Route::post('bundles/review/{id}/edit', [BundlesController::class, 'updateReview'])->name('bundles.review.update');
Route::get('bundles/review/{id}/delete', [BundlesController::class, 'deleteReview'])->name('bundles.review.delete');
