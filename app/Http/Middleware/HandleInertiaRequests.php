<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use KgBot\LaravelLocalization\Facades\ExportLocalizations as ExportLocalization;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    // protected $rootView = 'app';
    public function rootView(Request $request)
    {
        // dd($request->route()->getName());
        // if ($request->requestUri == 'user');
        return 'app';
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        //dd(json_decode(config('footer_data')));
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
                'modal' => fn () => $request->session()->get('modal'),
            ],
            'lang' => ExportLocalization::export()->toFlat(),
            // 'auth' => [
            //     'user' => [
            //         'username' => "JohnDoe",
            //         'r' => auth()->check() ? substr(\Auth::user()->roles->pluck('name')[0], 0, 3) : ''
            //     ],
            // ],
            // 'ziggy' => function () use ($request) {
            //     return array_merge((new Ziggy)->toArray(), [
            //         'location' => $request->url(),
            //     ]);
            // },
            'appName' => config('app.name'),

            // Lazily
            'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'danger' => fn () => $request->session()->get('danger'),
                'warning' => fn () => $request->session()->get('warning'),
                'errors' => fn () => $request->session()->get('errors'),
                'banner' => fn () => $request->session()->get('banner'),
                'bannerStyle' => fn () => $request->session()->get('bannerStyle'),

            ],
            'headerTable' => [
                'project' => [
                    'project' => ['Status', 'Name', 'Client', 'Due', 'Actions'],
                    'task' => ['Status', 'Description', 'Due Date', 'Actions'],
                    'issue' => [
                        'Status', 'Priority', 'Description', 'Created', 'Actions'
                    ],
                    'file' => ['File Name', 'Uploaded At', 'Actions']
                ],
                'issue' => [
                    'issue' => [
                        'Status', 'Priority', 'Description', 'Project', 'Created', 'Actions'
                    ],
                    'note' => ['Description', 'Created', 'Actions'],
                    'file' => ['File Name', 'Uploaded At', 'Actions']
                ],
                'client' => [
                    'client' => ['Name', 'Actions'],
                    'contact' => [
                        'Name', 'Title', 'Email', 'Phone', 'Actions'
                    ],
                    'project' => ['Status', 'Name', 'Due', 'Actions'],
                    'file' => ['File Name', 'Uploaded At', 'Actions']
                ]
            ],


            'navbar_data' => function () {
                $isAdmin = false;
                if (\Auth::check() && \Auth::user()->hasRole('admin')) {
                    $isAdmin = true;
                }
                $cartCollection = \Cart::getContent();

                $numberOfItems = $this->formatNumberOfItems($cartCollection->count());
                $total = '$' . \Cart::getTotal();

                return [
                    'numberOfItems' => $numberOfItems,
                    'total' => $total,
                    'isAdmin' => $isAdmin
                ];
            },
        ]);
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
