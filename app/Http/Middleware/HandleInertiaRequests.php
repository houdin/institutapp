<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        // 'auth' => [
        //         'user' => $request->user(),
        //     ]
        return array_merge(parent::share($request), [
            'app' => [
                'name' => config('app.name'),
                'logo_w_image' => config('app.logo_w_image'),
                'logo_popup' => config('app.logo_popup'),
                'main_menu' => config('app.main_menu'),
                'second_menu' => config('app.second_menu'),
                'recaptcha' => [
                    'sitekey' => config('no-captcha.sitekey'),
                ],
                'user' => auth()->check() ? true : false,
                'footer_data' => json_decode(config('footer_data')),
                'footer_menus' => config('app.footer_menu'),
                'show_offers' => config('show_offers'),
                'appCurrency' => getCurrency(config('app.currency')),
            ],
            'auth' => [
                'user' => [
                    'username' => "JohnDoe",
                    'r' => auth()->check() ? substr(\Auth::user()->roles->pluck('name')[0], 0, 3) : ''
                ],
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);
    }
}
