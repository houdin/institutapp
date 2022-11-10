<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Config;
use App\Models\Locale;
use App\Models\Slider;
use App\Models\Formation;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Arcanedev\NoCaptcha\NoCaptchaV2;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use App\Resolvers\SocialUserResolver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Helpers\Frontend\Auth\Socialite;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use KgBot\LaravelLocalization\Facades\ExportLocalizations as ExportLocalization;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];




    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
	     * Sets third party service providers that are only needed on local/testing environments
	     */
        if ($this->app->environment() != 'production') {
            /**
             * Loader for registering facades.
             */
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

            /*
	         * Load third party local aliases
	         */
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
        }
        \Illuminate\Support\Collection::macro('lists', function ($a, $b = null) {
            return collect($this->items)->pluck($a, $b);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        /*
	     * Application locale defaults for various components
	     *
	     * These will be overridden by LocaleMiddleware if the session local is set
	     */

        /*
	     * setLocale for php. Enables ->formatLocalized() with localized values for dates
	     */
        setlocale(LC_TIME, config('app.locale_php'));


        /*
	     * Set the session variable for whether or not the app is using RTL support
	     * For use in the blade directive in BladeServiceProvider
	     */
        //        if (! app()->runningInConsole()) {
        //            if (config('locale.languages')[config('app.locale')][2]) {
        //                session(['lang-rtl' => true]);
        //            } else {
        //                session()->forget('lang-rtl');
        //            }
        //        }

        // Force SSL in production
        // if ($this->app->environment() == 'production') {
        //     URL::forceScheme('https');
        // }
        $url->forceScheme('https');
        // if (env('APP_ENV') !== 'local') {

        // }

        // Set the default string length for Laravel5.4
        Schema::defaultStringLength(191);

        Paginator::defaultView('vendor.pagination.bootstrap-4');

        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');


        if (Schema::hasTable('configs')) {
            foreach (Config::all() as $setting) {
                \Illuminate\Support\Facades\Config::set($setting->key, $setting->value);
            }
        }

        /*
	     * setLocale to use Carbon source locales. Enables diffForHumans() localized
	     */

        Carbon::setLocale(config('app.locale'));
        App::setLocale(config('app.locale'));
        config()->set('invoices.currency', config('app.currency'));


        // if (Schema::hasTable('sliders')) {
        //     $slides = Slider::where('status', 1)->orderBy('sequence', 'asc')->get();
        //     view()->composer('*', function ($view) use ($slides) {
        //         $view->with('slides', $slides);
        //     });
        // }

        view()->composer('*', function ($view) {
            // $captcha = null;
            // if (config('access.captcha.registration')) {
            //     $captcha = new NoCaptchaV2(config('no-captcha.secret'), config('no-captcha.sitekey'));
            // }

            $custom_menus = config('app.main_menu');
            $second_menus = config('app.second_menu');
            $footer_menus = config('app.footer_menu');
            $fxinstitut_lang = ExportLocalization::export()->toFlat();
            $max_depth = 1;
            $view->with(compact('custom_menus', 'second_menus', 'footer_menus', 'max_depth', 'fxinstitut_lang'));
        });

        view()->composer('frontend.layouts.partials.right-sidebar', function ($view) {


            $recent_news = Blog::orderBy('created_at', 'desc')->whereHas('category')->take(2)->get();

            $view->with(compact('recent_news'));
        });

        view()->composer('frontend.*', function ($view) {

            $global_featured_formation = Formation::withoutGlobalScope('filter')
                ->whereHas('category')
                ->where('published', '=', 1)
                ->where('featured', '=', 1)->where('trending', '=', 1)->first();

            $featured_formations = Formation::withoutGlobalScope('filter')->where('published', '=', 1)
                ->whereHas('category')
                ->where('featured', '=', 1)->take(8)->get();



            $view->with('image')->with(compact('global_featured_formation', 'featured_formations'));
        });

        view()->composer(['frontend.*', 'backend.*', 'vendor.invoices.*'], function ($view) {


            $appCurrency = getCurrency(config('app.currency'));

            if (Schema::hasTable('locales')) {
                $locales = Locale::pluck('short_name as locale')->toArray();
            }

            $view->with(compact('locales', 'appCurrency'));
        });


        view()->composer(['backend.*'], function ($view) {

            $locale_full_name = 'English';
            $locale =  Locale::where('short_name', '=', config('app.locale'))->first();
            if ($locale) {
                $locale_full_name = $locale->name;
            }
            // dd($locale);
            $view->with(compact('locale_full_name'));
        });
    }

    function menuList($array)
    {
        $temp_array = array();
        foreach ($array as $item) {
            if ($item->getsons($item->id)->except($item->id)) {
                $item->subs = $this->menuList($item->getsons($item->id)->except($item->id)); // here is the recursion
                $temp_array[] = $item;
            }
        }
        return $temp_array;
    }
}
