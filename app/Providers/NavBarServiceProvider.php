<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Syscover\ShoppingCart\Facades\CartProvider;


class NavBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('frontend.products.partials._navbar', function ($view) {
            $isAdmin = false;
            if (Auth::check() && Auth::user()->hasRole('admin')) {
                $isAdmin = true;
            }
            $cartCollection = \Cart::getContent();

            $numberOfItems = $this->formatNumberOfItems($cartCollection->count());
            $total = '$' . \Cart::getTotal();
            $view->with([
                'numberOfItems' => $numberOfItems,
                'total' => $total,
                'isAdmin' => $isAdmin
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * receives the number of items in shopping cart and returns the correct message
     *
     * @param $number
     * @return string
     */
    protected function formatNumberOfItems($number)
    {
        if ($number === 0) {
            return 'Empty Cart';
        }
        if ($number === 1) {
            return '(1) item';
        }
        return "($number) items";
    }
}
