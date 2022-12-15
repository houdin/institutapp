<?php

use App\Http\Controllers\StaticController;

Route::get('/effets-speciaux', [StaticController::class, 'specialEffects']);
Route::get('/3d-modelisation', [StaticController::class, 'modelisation3d']);
Route::get('/motion-design-graphics', [StaticController::class, 'motionDesign']);
Route::get('/animation', [StaticController::class, 'animation']);
Route::get('/tv-broadcast', [StaticController::class, 'tvBroadcast']);
Route::get('/storyboard', [StaticController::class, 'storyboard']);
Route::get('/architecture', [StaticController::class, 'architecture']);
Route::get('/web-applications', [StaticController::class, 'webApplication']);
Route::get('/marketing', [StaticController::class, 'marketing']);
