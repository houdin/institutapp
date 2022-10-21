<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotationsController;




//==============Quotation Routes =========================//
Route::post('devis/{stage}', [QuotationsController::class, 'index'])->name('quotation');
