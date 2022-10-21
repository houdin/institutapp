<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SideBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('frontend.products.partials._sidebar', function ($view) {
            $categories = \App\Models\Category::all();
            $view->with('categories', $categories);
        });

        View::composer('frontend.products.partials._navbar', function ($view) {
            $categories = \App\Models\Category::pluck('name');
            $view->with('categories', $categories);
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
}
