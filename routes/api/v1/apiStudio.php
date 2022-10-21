<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TipstricksController;



//==============Portfolio Routes==========================//
Route::post('portfolio', [PortfolioController::class, 'index'])->name('portfolios.all');
Route::post('portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('portfolio/{portfolio_id}/rating', [PortfolioController::class, 'rating'])->name('portfolios.rating');
Route::post('category/{category}/portfolios', [PortfolioController::class, 'getByCategory'])->name('portfolios.category');


//===============Tips and Tricks Routes==================//
Route::post('tips-tricks', [TipstricksController::class, 'index'])->name('tipstricks.all');
Route::post('tips-trick/{slug}', [TipstricksController::class, 'show'])->name('tipstricks.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('tips-trick/{tipstrick_id}/rating', [TipstricksController::class, 'rating'])->name('tipstricks.rating');
Route::post('category/{category}/tips-tricks', [TipstricksController::class, 'getByCategory'])->name('tipstricks.category');

//============Premium Routes=================//
// Route::post('premium', [PremiumController::class, 'index'])->name('premium');
Route::post('premium/{level?}', [PremiumController::class, 'premiums'])->name('premium.index');
