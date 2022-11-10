<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BundlesController;
// use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TutorialsController;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\QuotationsController;
use App\Http\Controllers\TipstricksController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\MessagesController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\User\OrderController;
use App\Http\Controllers\Frontend\User\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Frontend\User\API\UserController;
use App\Http\Controllers\Frontend\User\API\StateController;
use App\Http\Controllers\Frontend\User\API\AddressController;
use App\Http\Controllers\Frontend\User\API\BillingController;
use App\Http\Controllers\Frontend\User\UserAccountController;
use App\Http\Controllers\Frontend\User\API\ShoppingCartController;
use App\Http\Controllers\Frontend\User\API\OrderController as ApiOrderController;
use App\Http\Controllers\Frontend\User\API\SearchController as ApiSearchController;

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


Route::get('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');

Route::get('certificate-verification', [CertificateController::class, 'getVerificationForm'])->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', [CertificateController::class, 'verifyCertificate'])->name('frontend.certificates.verify');
Route::get('certificates/download', [CertificateController::class, 'download'])->name('certificates.download');


Route::get('/', [HomeController::class, 'index']);


Route::any('/{any}', function () {
    return view('frontend.layouts.app');
})->where('any', '^(?!appfxins|login|logout|register|user|certificate).*$');





Route::prefix('appfxins')->group(function () {
    // AUTH
    Route::post('auth/login', [LoginController::class, 'login'])->name('login.api.post');



    Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
    Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
    Route::get('blog', [BlogController::class, 'getIndex'])->name('blogs.index');
    Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
    Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

    Route::get('teachers', [HomeController::class, 'getTeachers'])->name('teachers.index');
    Route::get('teachers/{id}/show', [HomeController::class, 'showTeacher'])->name('teachers.show');


    Route::post('app-conf', [HomeController::class, 'appConf'])->name('app.config');

    Route::post('newsletter/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

    //============Premium Routes=================//
    // Route::get('premium', [PremiumController::class, 'index'])->name('premium');
    Route::get('premium/{level?}', [PremiumController::class, 'premiums'])->name('premium.index');


    //============Formation Routes=================//
    Route::get('formations', [FormationsController::class, 'all'])->name('formations.all');
    Route::get('formation/{slug}', [FormationsController::class, 'show'])->name('formations.show');
    //Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
    Route::post('formation/{formation_id}/rating', [FormationsController::class, 'rating'])->name('formations.rating');
    Route::get('category/{category}/formations', [FormationsController::class, 'getByCategory'])->name('formations.category');
    Route::post('formations/{id}/review', [FormationsController::class, 'addReview'])->name('formations.review');
    Route::get('formations/review/{id}/edit', [FormationsController::class, 'editReview'])->name('formations.review.edit');
    Route::post('formations/review/{id}/edit', [FormationsController::class, 'updateReview'])->name('formations.review.update');
    Route::get('formations/review/{id}/delete', [FormationsController::class, 'deleteReview'])->name('formations.review.delete');

    Route::get('/formation/formation-cart-elem/{id}', [FormationsController::class, 'getCartSessionElem'])->name('formations.cartsession.elem');

    Route::get('formation/purchased/{formation_id}', [FormationsController::class, 'isPurchased'])->name('formations.purchased');

    //============Tutorial Routes=================//
    Route::get('tutoriels', [TutorialsController::class, 'all'])->name('tutorials.all');
    Route::get('tutoriel/{slug}', [TutorialsController::class, 'show'])->name('tutorials.show');
    //Route::post('tutorial/payment', [TutorialsController::class, 'payment'])->name('tutorials.payment');
    Route::post('tutoriel/{tutorial_id}/rating', [TutorialsController::class, 'rating'])->name('tutorials.rating');
    Route::get('category/{category}/tutoriels', [TutorialsController::class, 'getByCategory'])->name('tutorials.category');
    Route::post('tutoriels/{id}/review', [TutorialsController::class, 'addReview'])->name('tutorials.review');
    Route::get('tutoriels/review/{id}/edit', [TutorialsController::class, 'editReview'])->name('tutorials.review.edit');
    Route::post('tutoriels/review/{id}/edit', [TutorialsController::class, 'updateReview'])->name('tutorials.review.update');
    Route::get('tutoriels/review/{id}/delete', [TutorialsController::class, 'deleteReview'])->name('tutorials.review.delete');

    //===============Tips and Tricks Routes==================//
    Route::get('tips-tricks', [TipstricksController::class, 'index'])->name('tipstricks.all');
    Route::get('tips-trick/{slug}', [TipstricksController::class, 'show'])->name('tipstricks.show');
    //Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
    Route::post('tips-trick/{tipstrick_id}/rating', [TipstricksController::class, 'rating'])->name('tipstricks.rating');
    Route::get('category/{category}/tips-tricks', [TipstricksController::class, 'getByCategory'])->name('tipstricks.category');



    //==============Portfolio Routes==========================//
    Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolios.all');
    Route::get('portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
    //Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
    Route::post('portfolio/{portfolio_id}/rating', [PortfolioController::class, 'rating'])->name('portfolios.rating');
    Route::get('category/{category}/portfolios', [PortfolioController::class, 'getByCategory'])->name('portfolios.category');

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


    Route::group(['middleware' => 'auth'], function () {

        //==============Quotation Routes =========================//
        Route::get('devis/{stage}', [QuotationsController::class, 'index'])->name('quotation');

        Route::get('module/{formation_id}/{slug}/', [ModulesController::class, 'show'])->name('modules.show');
        Route::post('module/{slug}/test', [ModulesController::class, 'test'])->name('modules.test');
        Route::post('module/{slug}/retest', [ModulesController::class, 'retest'])->name('modules.retest');
        Route::post('video/progress', [ModulesController::class, 'videoProgress'])->name('update.videos.progress');
        Route::post('module/progress', [ModulesController::class, 'formationProgress'])->name('update.formation.progress');

        Route::get('module/question/{question_id}/{result_id}/', [ModulesController::class, 'check_result_question'])->name('modules.question.result');
        Route::get('module/question/option/{option_id}/{result_id}/', [ModulesController::class, 'question_option_answered'])->name('modules.option.result');
        Route::get('module/media/progress/{media_id}', [ModulesController::class, 'media_progress'])->name('modules.media.progress');
    });
    // Search
    Route::get('boutique/produit/{category}', [SearchController::class, 'category'])->name('shopping.search.product.category');
    Route::post('boutique/produits', [SearchController::class, 'scout'])->name('shopping.search.products');
    Route::get('boutique/produits/{search}', [SearchController::class, 'show'])->name('shopping.search.products.search');
    Route::post('boutique/produits/api', [ApiSearchController::class, 'store'])->name('shopping.search.products.api');

    Route::get('/search', [HomeController::class, 'searchFormation'])->name('search');
    Route::get('/search-formation', [HomeController::class, 'searchFormation'])->name('search-formation');
    Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
    Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');


    Route::get('/faqs', [HomeController::class, 'getFaqs'])->name('faqs');


    /*=============== Theme blades routes ends ===================*/


    Route::get('contact', [ContactController::class, 'index'])->name('contact');
    Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');


    Route::get('download', [HomeController::class, 'getDownload'])->name('download');

    Route::group(['middleware' => 'auth'], function () {
        Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.addToCart');
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::get('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
        Route::post('cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
        Route::post('cart/stripe-payment', [CartController::class, 'stripePayment'])->name('cart.stripe.payment');
        Route::post('cart/paypal-payment', [CartController::class, 'paypalPayment'])->name('cart.paypal.payment');
        Route::get('cart/paypal-payment/status', [CartController::class, 'getPaymentStatus'])->name('cart.paypal.status');

        Route::get('status', function () {
            return view('frontend.cart.status');
        })->name('status');

        Route::post('cart/offline-payment', [CartController::class, 'offlinePayment'])->name('cart.offline.payment');
        Route::post('cart/getnow', [CartController::class, 'getNow'])->name('cart.getnow');
    });


    ////////////////////////////////////////////////////////////
    /////////////////////////////////

    //Register User
    // Route::post('user-email-taken', [RegisterValidationController::class, 'email'])->name('register.user.email');
    // Route::post('user-username-taken', [RegisterValidationController::class, 'username'])->name('register.user.username');

    //User Account
    Route::get('user/user-account', [UserAccountController::class, 'index'])->name('user.account');
    Route::get('user/user-account/order/{id}', [UserAccountController::class, 'show'])->name('user.account.order');
    Route::get('user/get-states', [StateController::class, 'index'])->name('user.states');
    Route::resource('user/address', AddressController::class);



    // Shop Routes
    Route::get('boutique', [ProductsController::class, 'products'])->name('products.all');
    Route::get('boutique/view-product/{slug}', [ProductsController::class, 'show'])->name('products.show');

    Route::get('plugins', [ShopController::class, 'plugins'])->name('plugins.all');
    Route::get('plugin/{slug}', [ProductsController::class, 'show'])->name('plugins.show');

    Route::get('modeles-3d', [ShopController::class, 'modeles_3d'])->name('modeles.all');
    Route::get('modele-3d/{slug}', [ProductsController::class, 'show'])->name('modeles.show');

    Route::get('applications', [ShopController::class, 'products'])->name('applications.all');
    Route::get('application/{slug}', [ProductsController::class, 'show'])->name('application.show');



    // Shopping Cart Routes
    Route::post('boutique/cart/add', [ShoppingCartController::class, 'addToCart'])->name('shopping.cart.add');
    Route::post('boutique/cart/remove', [ShoppingCartController::class, 'remove'])->name('shopping.cart.destroy');
    Route::post('boutique/cart/update', [ShoppingCartController::class, 'update'])->name('shopping.cart.update');
    Route::get('boutique/cart/get', [ShoppingCartController::class, 'index'])->name('shopping.cart');

    //orders Page
    Route::get('order/{stage}', [OrderController::class, 'index'])->name('shopping.order.index');
    Route::post('order', [ApiOrderController::class, 'store'])->name('shopping.order.add.api');
    Route::patch('order/{order}', [ApiOrderController::class, 'update'])->name('shopping.order.update.api');
    Route::post('order/billing-form', [BillingController::class, 'store'])->name('shopping.order.billing.post');


    //orders API
    Route::get('order/invoice/{order}', [ApiOrderController::class, 'show'])->name('shopping.order.invoice.api');
}); // PREFIX APPXFINS


////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////



if (config('show_offers') == 1) {
    Route::get('offers', [CartController::class, 'getOffers'])->name('frontend.offers');
}

Route::get('email/verification', fn () => view('frontend.auth.verify-email'))->name('verification.notice');

//Home VueRouter







// Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
//     Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
// });
