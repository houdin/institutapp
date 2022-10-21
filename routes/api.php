<?php

namespace Routes\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ApiController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\API\UserController;
use App\Http\Controllers\Frontend\User\API\StateController;
use App\Http\Controllers\Frontend\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\User\API\AddressController;
use App\Http\Controllers\Frontend\User\UserAccountController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\ConfirmAccountController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\TeacherRegisterController;
use App\Http\Controllers\Frontend\Auth\RegisterValidationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1')->group(function () {


    Route::prefix('auth')
        ->namespace('api\v1')
        ->group(function () {

            Route::post('signup-form', [ApiController::class, 'signupForm'])->name('api.register.form');
            Route::post('signup-save', [ApiController::class, 'signup'])->name('api.register.post');

            // Route::middleware(['auth:api'])->group(function () {


            // });
        });




    //Route::get('home-slides', [HomeController::class, 'home-slides'])->name('fxins-index');
    Route::post('home-data', [HomeController::class, 'home'])->name('home.data');




    Route::middleware(['auth:api'])
        ->namespace('api\v1')
        ->group(function () {

            Route::post('formations', [ApiController::class, 'getFormations']);
            Route::post('bundles', [ApiController::class, 'getBundles']);
            Route::post('search', [ApiController::class, 'search']);
            Route::post('latest-news', [ApiController::class, 'getLatestNews']);
            Route::post('teachers', [ApiController::class, 'getTeachers']);
            Route::post('single-teacher', [ApiController::class, 'getSingleTeacher']);
            Route::post('teacher-formations', [ApiController::class, 'getTeacherFormations']);
            Route::post('teacher-bundles', [ApiController::class, 'getTeacherBundles']);
            Route::post('get-faqs', [ApiController::class, 'getFaqs']);
            Route::post('contact-us', [ApiController::class, 'saveContactUs']);
            Route::post('single-formation', [ApiController::class, 'getSingleFormation']);
            Route::post('submit-review', [ApiController::class, 'submitReview']);
            Route::post('update-review', [ApiController::class, 'updateReview']);
            Route::post('single-module', [ApiController::class, 'getModule']);
            Route::post('video-progress', [ApiController::class, 'videoProgress']);
            Route::post('formation-progress', [ApiController::class, 'formationProgress']);
            Route::post('generate-certificate', [ApiController::class, 'generateCertificate']);
            Route::post('single-bundle', [ApiController::class, 'getSingleBundle']);
            Route::post('add-to-cart', [ApiController::class, 'addToCart']);
            Route::post('getnow', [ApiController::class, 'getNow']);
            Route::post('remove-from-cart', [ApiController::class, 'removeFromCart']);
            Route::post('get-cart-data', [ApiController::class, 'getCartData']);
            Route::post('clear-cart', [ApiController::class, 'clearCart']);
            Route::post('payment-status', [ApiController::class, 'paymentStatus']);
            Route::post('get-blog', [ApiController::class, 'getBlog']);
            Route::post('blog-by-category', [ApiController::class, 'getBlogByCategory']);
            Route::post('blog-by-tag', [ApiController::class, 'getBlogByTag']);
            Route::post('add-blog-comment', [ApiController::class, 'addBlogComment']);
            Route::post('delete-blog-comment', [ApiController::class, 'deleteBlogComment']);
            Route::post('forum', [ApiController::class, 'getForum']);
            Route::post('create-discussion', [ApiController::class, 'createDiscussion']);
            Route::post('store-response', [ApiController::class, 'storeResponse']);
            Route::post('update-response', [ApiController::class, 'updateResponse']);
            Route::post('delete-response', [ApiController::class, 'deleteResponse']);
            Route::post('messages', [ApiController::class, 'getMessages']);
            Route::post('compose-message', [ApiController::class, 'composeMessage']);
            Route::post('reply-message', [ApiController::class, 'replyMessage']);
            Route::post('unread-messages', [ApiController::class, 'getUnreadMessages']);
            Route::post('search-messages', [ApiController::class, 'searchMessages']);
            Route::post('my-certificates', [ApiController::class, 'getMyCertificates']);
            Route::post('my-purchases', [ApiController::class, 'getMyPurchases']);
            Route::post('my-account', [ApiController::class, 'getMyAccount']);
            Route::post('update-account', [ApiController::class, 'updateMyAccount']);
            Route::post('update-password', [ApiController::class, 'updatePassword']);
            Route::post('get-page', [ApiController::class, 'getPage']);
            Route::post('subscribe-newsletter', [ApiController::class, 'subscribeNewsletter']);
            Route::post('offers', [ApiController::class, 'getOffers']);
            Route::post('apply-coupon', [ApiController::class, 'applyCoupon']);
            Route::post('remove-coupon', [ApiController::class, 'removeCoupon']);
            Route::post('order-confirmation', [ApiController::class, 'orderConfirmation']);
        });
    Route::middleware(['auth:api'])
        ->namespace('api\v1')
        ->group(function () {

            Route::post('send-reset-link', [ApiController::class]);
        });
    Route::middleware(['auth:api'])
        ->namespace('api\v1')
        ->group(function () {

            Route::post('configs', [ApiController::class, 'getConfigs']);
        });

    Route::group(['as' => 'api.auth.'], function () {

        /*
     * These routes require no user to be logged in
     */
        Route::group(['middleware' => 'guest'], function () {
            // Authentication Routes
            // Route::get('login', [LoginController::class, 'showModal'])->name('login');
            // Route::get('connexion', [ApiController::class, 'showLoginForm'])->name('login');
            Route::post('login', [ApiController::class, 'login'])->name('login');


            // Socialite Routes
            Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
            Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);

            // Registration Routes
            if (config('access.registration')) {
                // Route::get('register', [LoginController::class, 'showLoginForm'])->name('register');
                // Route::get('inscription', [LoginController::class, 'showLoginForm'])->name('register');
                // Route::post('register', [RegisterController::class, 'register'])->name('register.post');

                Route::post('user-email-taken', [RegisterValidationController::class, 'email'])->name('register.user.email');
                Route::post('user-username-taken', [RegisterValidationController::class, 'username'])->name('register.user.username');
            }

            // // Password Reset Routes
            Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
            Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.post');

            Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
            Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

            // New Register Teacher Routes
            Route::get('teacher/register', [TeacherRegisterController::class, 'showTeacherRegistrationForm'])->name('teacher.register');
            Route::post('teacher/register', [TeacherRegisterController::class, 'register'])->name('teacher.register.post');
        });

        Route::group(['middleware' => 'auth:api'], function () {


            Route::post('logout', [ApiController::class, 'logout'])->name('logout');
            // Route::post('user/users-details', [UserController::class, 'index'])->name('users.details');
            //User Account
            Route::post('user/user-account', [UserAccountController::class, 'index'])->name('user.account');
            Route::post('user/user-account/order/{id}', [UserAccountController::class, 'show'])->name('user.account.order');
            Route::post('user/get-states', [StateController::class, 'index'])->name('user.states');
            Route::resource('user/address', AddressController::class);

            Route::post('user/users-details', [UserController::class, 'index'])->name('user.details');
            Route::post('user/users-check', [UserController::class, 'check'])->name('user.check');
            Route::post('user/users-role/{cn}/{err?}', [UserController::class, 'role'])->name('user.roles');
            Route::post('user/users-permission/{cn}/{err?}', [UserController::class, 'permission'])->name('user.permissions');
        });


        // Confirm Account Routes

        Route::get('account/confirm/{token}', [ConfirmAccountController::class, 'confirm'])->name('account.confirm');
        Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');
    });





    // Route::group(['as' => 'api.frontend.'], function () {
    //     include_route_files(__DIR__ . '/v1/');
    // });
});


// Route::get('/items', [HomeController::class, 'index']);

Route::prefix('auth')->group(function () {
});
