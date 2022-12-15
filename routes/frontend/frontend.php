<?php

namespace Routes\Frontend;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\DashboardController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */


/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */

Route::group(['middleware' => ['auth', 'password_expires', 'verified']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', [AccountController::class, 'index'])->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
