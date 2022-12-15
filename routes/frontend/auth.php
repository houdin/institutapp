<?php

namespace Routes\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\API\UserController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ConfirmAccountController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\Auth\PasswordExpiredController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use App\Http\Controllers\Auth\RegisterValidationController;

/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */

Route::group(['namespace' => 'Auth', 'as' => 'auth.'],  function () {

    /*
    * These routes require the user to be logged in
    */
    Route::group(['middleware' => 'auth'], function () {


        //For when admin is logged in as user from backend
        Route::get('logout-as', [LoginController::class, 'logoutAs'])->name('logout-as');

        // // These routes can not be hit if the password is expired
        Route::group(['middleware' => 'password_expires'], function () {
            // Change Password Routes
            Route::patch('password/update', [UpdatePasswordController::class, 'update'])->name('password.update');
        });

        // Password expired routes
        if (is_numeric(config('access.users.password_expires_days'))) {
            Route::get('password/expired', [PasswordExpiredController::class, 'expired'])->name('password.expired');
            Route::patch('password/expired', [PasswordExpiredController::class, 'update'])->name('password.expired.update');
        }
    });

    /*
     * These routes require no user to be logged in
     */
    Route::group(['middleware' => 'guest'], function () {

        // Socialite Routes
        Route::get('connexion/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
        Route::get('connexion/{provider}/callback', [SocialLoginController::class, 'login']);

        // Registration Routes
        if (config('access.registration')) {
            // Route::get('register', [LoginController::class, 'showLoginForm'])->name('register');

            Route::post('user-email-taken', [RegisterValidationController::class, 'email'])->name('register.user.email');
            Route::post('user-username-taken', [RegisterValidationController::class, 'username'])->name('register.user.username');
        }

        // New Register Teacher Routes
        Route::get('teacher/register', [TeacherRegisterController::class, 'showTeacherRegistrationForm'])->name('teacher.register');
        Route::post('teacher/register', [TeacherRegisterController::class, 'register'])->name('teacher.register.post');
    });

    // Confirm Account Routes

    Route::get('account/confirm/{token}', [ConfirmAccountController::class, 'confirm'])->name('account.confirm');
    Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');


    // Route::get('/email/verification', function () {

    //     return view('frontend.auth.verify-email');

    // })->middleware('auth')->name('verification.notice');

    // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    //     $request->fulfill();

    //     return redirect()->route('frontend.auth.login');
    // })->middleware(['auth', 'signed'])->name('verification.verify');

    // Route::post('/email/verification-notification', function (Request $request) {
    //     $request->user()->sendEmailVerificationNotification();

    //     return back()->with('message', 'Verification link sent!');

    // })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

});
