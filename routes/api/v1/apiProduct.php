<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Frontend\User\OrderController;
use App\Http\Controllers\Frontend\User\API\BillingController;
use App\Http\Controllers\Frontend\User\API\ShoppingCartController;
use App\Http\Controllers\Frontend\User\API\OrderController as ApiOrderController;



// Shop Routes
Route::post('boutique', [ProductsController::class, 'products'])->name('products.all');
Route::post('boutique/view-product/{slug}', [ProductsController::class, 'show'])->name('products.show');

Route::post('plugins', [ShopController::class, 'plugins'])->name('plugins.all');
Route::post('plugin/{slug}', [ProductsController::class, 'show'])->name('plugins.show');

Route::post('modeles-3d', [ShopController::class, 'modeles_3d'])->name('modeles.all');
Route::post('modele-3d/{slug}', [ProductsController::class, 'show'])->name('modeles.show');

Route::post('applications', [ShopController::class, 'products'])->name('applications.all');
Route::post('application/{slug}', [ProductsController::class, 'show'])->name('application.show');



// Shopping Cart Routes
Route::post('boutique/cart/add', [ShoppingCartController::class, 'addToCart'])->name('shopping.cart.add');
Route::post('boutique/cart/remove', [ShoppingCartController::class, 'remove'])->name('shopping.cart.destroy');
Route::post('boutique/cart/update', [ShoppingCartController::class, 'update'])->name('shopping.cart.update');
Route::post('boutique/cart/get', [ShoppingCartController::class, 'index'])->name('shopping.cart');

//orders Page
Route::post('order/{stage}', [OrderController::class, 'index'])->name('shopping.order.index');
Route::post('order', [ApiOrderController::class, 'store'])->name('shopping.order.add.api');
Route::patch('order/{order}', [ApiOrderController::class, 'update'])->name('shopping.order.update.api');
Route::post('order/billing-form', [BillingController::class, 'store'])->name('shopping.order.billing.post');



Route::group(['middleware' => 'auth:api'], function () {

    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    Route::post('cart/stripe-payment', [CartController::class, 'stripePayment'])->name('cart.stripe.payment');
    Route::post('cart/paypal-payment', [CartController::class, 'paypalPayment'])->name('cart.paypal.payment');
    Route::post('cart/paypal-payment/status', [CartController::class, 'getPaymentStatus'])->name('cart.paypal.status');

    Route::post('status', function () {
        return view('frontend.cart.status');
    })->name('status');

    Route::post('cart/offline-payment', [CartController::class, 'offlinePayment'])->name('cart.offline.payment');
    Route::post('cart/getnow', [CartController::class, 'getNow'])->name('cart.getnow');
});
