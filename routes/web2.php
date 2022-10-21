<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\CartController;

use App\Http\Controllers\SitemapController;

use App\Http\Controllers\Backend\MessagesController;

use App\Http\Controllers\Frontend\Auth\LoginController;


/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
// Route::get('lang/{lang}', [LanguageController::class, 'swap']);



Route::get('/sitemap-' . Str::slug(config('app.name')) . '/{file?}', [SitemapController::class, 'index']);


//Route to clean up demo site
// Route::get('reset-demo',function (){
//     ini_set('memory_limit', '-1');
//     ini_set('max_execution_time', 1000);
//     try{
//         \Illuminate\Support\Facades\Artisan::call('refresh:site');
//         return 'Refresh successful!';
//     }catch (\Exception $e){
//         return $e->getMessage();
//     }

// });



/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__ . '/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['prefix' => 'user', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__ . '/backend/');
});



Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {

    //==== Messages Routes =====//
    Route::get('messages', [MessagesController::class, 'index'])->name('messages');
    Route::get('messages/unread', [MessagesController::class, 'getUnreadMessages'])->name('messages.unread');
    Route::post('messages/send', [MessagesController::class, 'send'])->name('messages.send');
    Route::post('messages/reply', [MessagesController::class, 'reply'])->name('messages.reply');
});




Route::get('/', function () {
    return view('frontend.layouts.app');
})->name('frontend.index');


if (config('show_offers') == 1) {
    Route::get('offers', [CartController::class, 'getOffers'])->name('frontend.offers');
}


Route::get('email/verification', fn () => view('frontend.auth.verify-email'))->name('verification.notice');

Route::any('/{any}', function () {
    return view('frontend.layouts.app');
})->where('any', '.*$');





Route::prefix('appfxins')->group(function () {

    // AUTH
    Route::post('auth/login', [LoginController::class, 'login'])->name('login.api.post');


















    ////////////////////////////////////////////////////////////
    /////////////////////////////////

    //Register User
    // Route::post('user-email-taken', [RegisterValidationController::class, 'email'])->name('register.user.email');
    // Route::post('user-username-taken', [RegisterValidationController::class, 'username'])->name('register.user.username');









}); // PREFIX APPXFINS


////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////





//Home VueRouter







// Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
//     Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
// });
