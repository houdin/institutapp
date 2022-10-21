<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\SearchController;
use App\Http\Controllers\Frontend\User\API\SearchController as ApiSearchController;



// Search
Route::post('boutique/produit/{category}', [SearchController::class, 'category'])->name('shopping.search.product.category');
Route::post('boutique/produits', [SearchController::class, 'scout'])->name('shopping.search.products');
Route::post('boutique/produits/{search}', [SearchController::class, 'show'])->name('shopping.search.products.search');
Route::post('boutique/produits/api', [ApiSearchController::class, 'store'])->name('shopping.search.products.api');

Route::post('/search', [HomeController::class, 'searchFormation'])->name('search');
Route::post('/search-formation', [HomeController::class, 'searchFormation'])->name('search-formation');
Route::post('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
Route::post('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');
