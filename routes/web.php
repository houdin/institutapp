<?php

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\MessagesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\User\API\UserController;
use App\Http\Controllers\User\API\StateController;
use App\Http\Controllers\User\API\AddressController;
use App\Http\Controllers\User\API\BillingController;
use App\Http\Controllers\User\UserAccountController;
use App\Http\Controllers\User\API\ShoppingCartController;
use App\Http\Controllers\User\API\OrderController as ApiOrderController;
use App\Http\Controllers\User\API\SearchController as ApiSearchController;
use App\Models\Auth\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
// Route::get('lang/{lang}', [LanguageController::class, 'swap']);



Route::get('/sitemap-' . Str::slug(config('app.name')) . '/{file?}', [SitemapController::class, 'index']);



// Route::get('/', [HomeController::class, 'index'])->name('frontend.index');



/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__ . '/frontend/');
});

require_once __DIR__ . '/fortify.php';
require_once __DIR__ . '/jetstream.php';
require_once __DIR__ . '/project.php';
require_once __DIR__ . '/staticPages.php';

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



// Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {

//     //==== Messages Routes =====//
//     Route::get('messages', [MessagesController::class, 'index'])->name('messages');
//     Route::get('messages/unread', [MessagesController::class, 'getUnreadMessages'])->name('messages.unread');
//     Route::post('messages/send', [MessagesController::class, 'send'])->name('messages.send');
//     Route::post('messages/reply', [MessagesController::class, 'reply'])->name('messages.reply');
// });


Route::get('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');

Route::get('certificate-verification', [CertificateController::class, 'getVerificationForm'])->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', [CertificateController::class, 'verifyCertificate'])->name('frontend.certificates.verify');
Route::get('certificates/download', [CertificateController::class, 'download'])->name('certificates.download');





// Route::any('/{any}', function () {
//     return view('frontend.layouts.app');
// })->where('any', '^(?!appfxins|login|logout|register|user|certificate).*$');





Route::prefix('/blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('/{slug}', [BlogController::class, 'storeComment'])->name('blogs.comment');
    Route::post('/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
    Route::get('/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');
    Route::get('/{category}', [BlogController::class, 'getByCategory'])->name('blogs.category');
    Route::get('/{tag}', [BlogController::class, 'getByTag'])->name('blogs.tag');
});

// Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
// Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
// Route::get('blog', [BlogController::class, 'index'])->name('blogs.index');
// Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');
// Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
// Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

Route::get('teachers', [HomeController::class, 'getTeachers'])->name('teachers.index');
Route::get('teachers/{teacher}/show', [HomeController::class, 'showTeacher'])->name('teachers.show');


Route::post('app-conf', [HomeController::class, 'appConf'])->name('app.config');

Route::post('newsletter/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');



//============Formation Routes=================//
Route::get('formations', [FormationsController::class, 'index'])->name('formations.index');
Route::get('formations/{slug}', [FormationsController::class, 'show'])->name('formations.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('formations/{formation_id}/rating', [FormationsController::class, 'rating'])->name('formations.rating');
Route::get('category/{category}/formations', [FormationsController::class, 'getByCategory'])->name('formations.category');
Route::post('formations/{id}/review', [FormationsController::class, 'addReview'])->name('formations.review');
Route::get('formations/review/{id}/edit', [FormationsController::class, 'editReview'])->name('formations.review.edit');
Route::post('formations/review/{id}/edit', [FormationsController::class, 'updateReview'])->name('formations.review.update');
Route::get('formations/review/{id}/delete', [FormationsController::class, 'deleteReview'])->name('formations.review.delete');

Route::get('/formations/formation-cart-elem/{id}', [FormationsController::class, 'getCartSessionElem'])->name('formations.cartsession.elem');

Route::get('formations/purchased/{formation_id}', [FormationsController::class, 'isPurchased'])->name('formations.purchased');

//============Tutorial Routes=================//
Route::get('tutoriels', [TutorialsController::class, 'all'])->name('tutorials.all');
Route::get('tutoriels/{slug}', [TutorialsController::class, 'show'])->name('tutorials.show');
//Route::post('tutorial/payment', [TutorialsController::class, 'payment'])->name('tutorials.payment');
Route::post('tutoriel/{tutorial_id}/rating', [TutorialsController::class, 'rating'])->name('tutorials.rating');
Route::get('category/{category}/tutoriels', [TutorialsController::class, 'getByCategory'])->name('tutorials.category');
Route::post('tutoriels/{id}/review', [TutorialsController::class, 'addReview'])->name('tutorials.review');
Route::get('tutoriels/review/{id}/edit', [TutorialsController::class, 'editReview'])->name('tutorials.review.edit');
Route::post('tutoriels/review/{id}/edit', [TutorialsController::class, 'updateReview'])->name('tutorials.review.update');
Route::get('tutoriels/review/{id}/delete', [TutorialsController::class, 'deleteReview'])->name('tutorials.review.delete');

//===============Tips and Tricks Routes==================//
Route::get('tips-tricks', [TipstricksController::class, 'index'])->name('tipstricks.all');
Route::get('tips-tricks/{slug}', [TipstricksController::class, 'show'])->name('tipstricks.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('tips-tricks/{tipstrick_id}/rating', [TipstricksController::class, 'rating'])->name('tipstricks.rating');
Route::get('category/{category}/tips-tricks', [TipstricksController::class, 'getByCategory'])->name('tipstricks.category');



//==============Portfolio Routes==========================//
Route::get('portfolios', [PortfolioController::class, 'index'])->name('portfolios.all');
Route::get('portfolios/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
//Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
Route::post('portfolios/{portfolio_id}/rating', [PortfolioController::class, 'rating'])->name('portfolios.rating');
Route::get('category/{category}/portfolios', [PortfolioController::class, 'getByCategory'])->name('portfolios.category');


// Search
Route::get('produits/{category}', [SearchController::class, 'category'])->name('shopping.search.product.category');
Route::post('produits', [SearchController::class, 'scout'])->name('shopping.search.products');
Route::get('produits/{search}', [SearchController::class, 'show'])->name('shopping.search.products.search');
Route::post('produits/api', [ApiSearchController::class, 'store'])->name('shopping.search.products.api');

Route::get('/search', [HomeController::class, 'searchFormation'])->name('search');
Route::get('/search-formation', [HomeController::class, 'searchFormation'])->name('search-formation');
Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');


Route::get('/faqs', [HomeController::class, 'getFaqs'])->name('faqs');


/*=============== Theme blades routes ends ===================*/


Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');


Route::get('download', [HomeController::class, 'getDownload'])->name('download');

Route::group([
    'middleware' =>
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
], function () {

    //==============Quotation Routes =========================//
    Route::get('devis/{stage}', [QuotationsController::class, 'index'])->name('quotation');

    Route::get('modules/{formation_id}/{slug}/', [ModulesController::class, 'show'])->name('modules.show');
    Route::post('modules/{slug}/test', [ModulesController::class, 'test'])->name('modules.test');
    Route::post('modules/{slug}/retest', [ModulesController::class, 'retest'])->name('modules.retest');
    Route::post('modules/video/progress', [ModulesController::class, 'videoProgress'])->name('update.videos.progress');
    Route::post('modules/progress', [ModulesController::class, 'formationProgress'])->name('update.formation.progress');




    Route::get('module/question/{question_id}/{result_id}/', [ModulesController::class, 'check_result_question'])->name('modules.question.result');
    Route::get('module/question/option/{option_id}/{result_id}/', [ModulesController::class, 'question_option_answered'])->name('modules.option.result');
    Route::get('module/media/progress/{media_id}', [ModulesController::class, 'media_progress'])->name('modules.media.progress');
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



if (config('show_offers') == 1) {
    Route::get('offers', [CartController::class, 'getOffers'])->name('frontend.offers');
}

// Route::get('email/verification', fn () => view('frontend.auth.verify-email'))->name('verification.notice');



Route::get('/users', function () {
    return Inertia::render('Users/Index', [
        'users' => User::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->whereRaw("concat(first_name,' ',last_name) like '%{$search}%'");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
            ]),
        'filters' => Request::only(['search'])
    ]);
});

Route::get('/users/create', function () {
    return Inertia::render('Users/Create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/back', function () {

    return redirect()->back();
})->name('back');

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
});



// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// })->name('home');

// Route::post('/users', function () {


//     $attributes = Request::validate([
//         'first_name' => 'required',
//         'last_name' => 'required',
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     User::create($attributes);

//     return Request::route('/users');
// });



// require __DIR__ . '/auth.php';
