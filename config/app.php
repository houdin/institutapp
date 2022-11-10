<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'FXinstitut'),


    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value is the version of your application. This value is used when
    | the framework needs to place the application's version in a notification
    | or any other location as required by the application or its packages.
    |
    */
    'version' => '1.0',


    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://fxinstitut.test'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Date Format
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default date format for your application, which
    | will be used with date and date-time functions.
    |
    */

    'date_format' => 'Y-m-d',
    'date_format_js' => 'yy-mm-dd',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */
    'faker_locale' => 'en_US',


    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,

        /*
         * Package Service Providers...
         */
        DevDojo\Chatter\ChatterServiceProvider::class,
        UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,
        Yajra\DataTables\ButtonsServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Gerardojbaez\Messenger\MessengerServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        Darryldecode\Cart\CartServiceProvider::class,
        ConsoleTVs\Invoices\InvoicesServiceProvider::class,
        Torann\GeoIP\GeoIPServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
        Laravel\Cashier\CashierServiceProvider::class,
        Laravel\Scout\ScoutServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,


        Barryvdh\TranslationManager\ManagerServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,

        Maatwebsite\Excel\ExcelServiceProvider::class,
        Chumper\Zipper\ZipperServiceProvider::class,
        Mtownsend\ReadTime\Providers\ReadTimeServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BladeServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\ObserverServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\SideBarServiceProvider::class,
        App\Providers\NavBarServiceProvider::class,
        App\Providers\ValidationServiceProvider::class,

        Barryvdh\Debugbar\ServiceProvider::class,

        App\Providers\TranslationServiceProvider::class,



    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [


        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Debugbar' => Barryvdh\Debugbar\Facade\Debugbar::class,
        'DataTables' => Yajra\DataTables\Facades\DataTables::class,
        'Zipper' => Chumper\Zipper\Zipper::class,
        'GeoIP' => \Torann\GeoIP\Facades\GeoIP::class,



        /*
         * Package Aliases
         */
        'Active' => HieuLe\Active\Facades\Active::class,
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Messenger' => Gerardojbaez\Messenger\Facades\Messenger::class,
        'Agent' => Jenssegers\Agent\Facades\Agent::class,
        'Cart' => Darryldecode\Cart\Facades\CartFacade::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,



    ],

    /*

    /*
   |--------------------------------------------------------------------------
   | Theme Layout Type
   | You can choose from any two "wide" and "box"
   |--------------------------------------------------------------------------
   */
    'layout_type' => 'box-layout',

    /*
   |--------------------------------------------------------------------------
   | Counter
   | You can use "static" or "Database" option from backend
   |--------------------------------------------------------------------------
   */
    'counter' => 1,
    'total_students' => '1M+',
    'total_formations' => '1k+',
    'total_teachers' => '200+',

    /*
    |--------------------------------------------------------------------------
    | Logos
    | For entire frontend.
    |--------------------------------------------------------------------------
    */
    'logo_b_image' => 'fxinstitut-logo-black.png',
    'logo_w_image' => 'fxinstitut-logo-white.png',
    'logo_white_image' => 'fxinstitut-logo-white.png',
    'logo_popup' => 'fxinstitut-logo-popup.png',
    'favicon_image' => 'fxinstitut-logo-32.png',

    /*
    |--------------------------------------------------------------------------
    | Contact Data
    |--------------------------------------------------------------------------
    */
    'contact_data' => '{[]}',


    'debug_blacklist' => [
        '_ENV' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET'
        ],
        '_SERVER' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET'
        ],
        '_POST' => [
            'password',
        ],
    ],

    'main_menu' => [
        [
            "name" => "Solutions",
            "submenu" => [
                'Effets Spéciaux' => [
                    "href" =>
                    'effets-speciaux',
                    "icon" =>
                    'Bolt',
                    "description" =>
                    'effets-speciaux',
                ],
                '3D & Modélisation' => [
                    "href" =>
                    '3d-&-modelisation',
                    "icon" =>
                    'Cube',
                    "description" =>
                    'effets-speciaux',
                ],
                'Motion & Design Graphics' =>
                [
                    "href" =>
                    'motion-&-design-graphics',
                    "icon" =>
                    'ChartBar',
                    "description" =>
                    'effets-speciaux',
                ],
                'Animation' => [
                    "href" =>
                    'animation',
                    "icon" =>
                    'ArrowTrendingUp',
                    "description" =>
                    'effets-speciaux',
                ],
                'TV & Broadcast' => [
                    "href" =>
                    'tv-&-broadcast',
                    "icon" =>
                    'Tv',
                    "description" =>
                    'effets-speciaux',
                ],
                'Storyboard' => [
                    "href" =>
                    'storyboard',
                    "icon" =>
                    'PaintBrush',
                    "description" =>
                    'effets-speciaux',
                ],
                'Architecture' => [
                    "href" =>
                    'architecture',
                    "icon" =>
                    'BuildingOffice',
                    "description" =>
                    'effets-speciaux',
                ],
                'Web & Applications' => [
                    "href" =>
                    'web-&-applications',
                    "icon" =>
                    'GlobeAlt',
                    "description" =>
                    'effets-speciaux',
                ],
                'Marketing' => [
                    "href" =>
                    'marketing',
                    "icon" =>
                    'Megaphone',
                    "description" =>
                    'effets-speciaux',
                ],
                'callToAction' => [
                    'Demande Devis' => [
                        "href" =>
                        'devis/type',
                        "icon" =>
                        'DocumentText',
                        "description" =>
                        'effets-speciaux',
                    ],
                    'Assistance' => [
                        "href" =>
                        'assistance',
                        "icon" =>
                        'Phone',
                        "description" =>
                        'effets-speciaux',
                    ]
                ]

            ]
        ],
        // [
        //     "name" => "Clients",
        //     "href" => "clients",
        // ],
        [
            "name" => "Tarifs",
            "href" => "tarifs",
        ],
        [
            "name" => "Produits",
            "submenu" => [
                'Boutique' =>
                [
                    "href" =>
                    'boutique',
                    "icon" =>
                    'ShoppingCart',
                    "description" =>
                    'effets-speciaux',
                ],
                'Plugins' => [
                    "href" =>
                    'plugins',
                    "icon" =>
                    'ArrowRightCircle',
                    "description" =>
                    'effets-speciaux',
                ],
                'Modèles 3D' =>
                [
                    "href" =>
                    'modeles-3d',
                    "icon" =>
                    'Cube',
                    "description" =>
                    'effets-speciaux',
                ],
                'Applications' =>
                [
                    "href" =>
                    'applications',
                    "icon" =>
                    'DevicePhoneMobile',
                    "description" =>
                    'effets-speciaux',
                ],
                'callToAction' => [
                    'Assistance' => [
                        "href" =>
                        'assistance',
                        "icon" =>
                        'Phone',
                        "description" =>
                        'effets-speciaux',
                    ]
                ]

            ]
        ],
        [
            "name" => "Ressources",
            "submenu" => [
                'Formations' => [
                    "href" =>
                    'formations',
                    "icon" =>
                    'Bookmark',
                    "description" =>
                    'effets-speciaux',
                ],
                'Tutoriels' => [
                    "href" =>
                    'tutoriels',
                    "icon" =>
                    'BookmarkSquare',
                    "description" =>
                    'effets-speciaux',
                ],
                'Cursus' => [
                    "href" =>
                    'cursus',
                    "icon" =>
                    'Share',
                    "description" =>
                    'effets-speciaux',
                ],
                'Support' => [
                    "href" =>
                    'support',
                    "icon" =>
                    'QuestionMarkCircle',
                    "description" =>
                    'effets-speciaux',
                ],
                'Tips & Tricks' => [
                    "href" =>
                    'tips-tricks',
                    "icon" =>
                    'CommandLine',
                    "description" =>
                    'effets-speciaux',
                ],

            ],
        ],
        [
            "name" => "Institut",
            "submenu" => [
                // 'Portfolio' => [
                //     "href" =>
                //     'portfolio',
                //     "icon" =>
                //     'Photo',
                //     "description" =>
                //     'effets-speciaux',
                // ],
                // 'Events' => [
                //     "href" =>
                //     'events',
                //     "icon" =>
                //     'Rss',
                //     "description" =>
                //     'effets-speciaux',
                // ],
                'Team' => [
                    "href" =>
                    'team',
                    "icon" =>
                    'UserGroup',
                    "description" =>
                    'effets-speciaux',
                ],
                'Recrutement' => [
                    "href" =>
                    'recrutement',
                    "icon" =>
                    'UserPlus',
                    "description" =>
                    'effets-speciaux',
                ],
                'Challenge' => [
                    "href" =>
                    'challenge',
                    "icon" =>
                    'Trophy',
                    "description" =>
                    'effets-speciaux',
                ],
                'Blog' => [
                    "href" =>
                    'blog',
                    "icon" =>
                    'PencilSquare',
                    "description" =>
                    'effets-speciaux',
                ],
                'Forum' => [
                    "href" =>
                    'forums',
                    "icon" =>
                    'ChatBubbleLeftRight',
                    "description" =>
                    'effets-speciaux',
                ],
                'Contact' => [
                    "href" =>
                    'contact',
                    "icon" =>
                    'Phone',
                    "description" =>
                    'effets-speciaux',
                ]
            ]
        ],



    ],

    'second_menu' => [
        'Blog' => 'blog',
        'Premium' => 'premium',
        'Challenge' => 'challenge',

        'Forum' => 'forums',
        'Support' => 'support'

    ],
    'footer_menu' => [
        [
            "name" => "Solutions",
            'submenu' => [
                'Effets Spéciaux' => 'effets-speciaux',
                '3D & After Effetcs' => '3d-&-after-effects',
                'Design Graphics' => 'design-graphics',
                'Storyboard' => 'storyboard',
                'Web & Applications' => 'web-&-applications',
                'Location' => 'location',
                'Assistance' => 'assistance',
                'Devis' => 'devis/type',

            ]
        ],
        [
            "name" => "Produits",
            'submenu' => [
                'Shop' => 'boutique',
                'Plugins' => 'plugins',
                'Modèles 3D' => 'modeles-3d',
                'Applications' => 'applications',
                'Assistance' => 'assistance',

            ]
        ],
        [
            "name" => "Public",
            'submenu' => [
                'Blog' => 'blog',
                'Challenge' => 'challenge',
                'Forum' => 'forums',
                'Support' => 'support',
                'Recrutement' => 'recrutement'

            ]
        ]


    ]



];
