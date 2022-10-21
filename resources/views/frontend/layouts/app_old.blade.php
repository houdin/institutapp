<!DOCTYPE html>
<!--
    ______ _  __    _               __   _  __          __
   / ____/| |/ /   (_)____   _____ / /_ (_)/ /_ __  __ / /_
  / /_    |   /   / // __ \ / ___// __// // __// / / // __/
 / __/   /   |   / // / / /(__  )/ /_ / // /_ / /_/ // /_
/_/     /_/|_|  /_//_/ /_//____/ \__//_/ \__/ \__,_/ \__/

-->
{{-- @langrtl
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- @endlangrtl --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(config('app.favicon_image') != "")
    <link rel="shortcut icon" type="image/x-icon" href="{{asset("assets/images/logos/".config('app.favicon_image'))}}" />
    @endif
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">


    @yield('css')
    @stack('after-styles')

    @if(config('onesignal_status') == 1)
    {!! config('onesignal_data') !!}
    @endif

    @if(config('google_analytics_id') != "")
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('google_analytics_id')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{config('google_analytics_id')}}');
    </script>
    @endif

    @if(true)

        <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
        </script>
    @endif
{{-- @dd(no_captcha()->display()->item) --}}
@if(true)
{{-- @dd(URL::to('/')) --}}
    <script>


        window.Laravel = @php echo json_encode([
            'app'   => array(
                'name' => config('app.name'),
                'home_url' => URL::to('/'),
                'logo_w' => config('app.logo_w_image'),
                'logo_popup' => config('app.logo_popup'),
                'custom_menus' => $custom_menus,
                'second_menus' => $second_menus,
                'csrfToken' => csrf_token(),
                'recaptcha' => [
                    'sitekey' => config('no-captcha.sitekey')
                ],
                'user' => auth()->check() ? true : false
            ),
            'csrfToken' => csrf_token(),
            'stripeKey' => config('services.stripe.key'),
            'urls'      => \App\Library\Data\UrlData::get(),
            'ajax'  => false,
            'appCurrency' => $appCurrency['symbol']

        ]); @endphp

        window.default_locale = "fr";
        window.fallback_locale = "en";
        window.messages = @json($fxinstitut_lang);
        window.fxicons = @json(App\Library\Data\Iconsdata::get());
        // window.fxin_lang = @json($fxinstitut_lang)


    </script>

    @endif


</head>

<body class="wide">
    <div id="app">

        {{-- {{ Cookie::make('my_user', Auth::user(), 1) }} --}}

        {{-- @if (!Request::ajax())

        @include('frontend.layouts.partials._initial_content')

        @else --}}



        <main-page v-slot="{showComponents, message, errorMessage}">
                {{-- <auth-form ></auth-form> --}}
                {{-- <router-view name="authView" ></router-view> --}}

                {{-- @include('frontend.layouts.modals.loginModal') --}}

                <header-app>

                </header-app>

                <success-message v-show="showComponents.showMessage" :message="message">
                </success-message>

                <error-message v-show="showComponents.showError" :error-message="errorMessage">
                </error-message>


                <breadcrumbs v-show="$route.name!=='home'"></breadcrumbs>
                {{-- @if(Request::segment(1) )

                    @include('frontend.layouts.partials._breadcrumb')

                @endif --}}

                {{-- @yield('content') --}}

                <router-view ></router-view>
                <router-view name="loginview"></router-view>
                <router-view name="registerview"></router-view>
                <router-view name="authview"></router-view>

                {{-- <router-view v-if="request_ajax" >
                    @if (!Request::ajax())
                    @yield('content')

                    @endif

                </router-view> --}}
                {{-- @php

                if( Request::ajax()){
                }

                @endphp --}}


                {{-- <router-view name="authView" :appdata="AppData" :currentuser="currentUser"></router-view> --}}


                <vue-progress-bar></vue-progress-bar>
        </main-page>


        {{-- @endif --}}

        @include('frontend.layouts.partials._footer')

    </div>

    <div id="modal-root"></div>



    @include('cookieConsent::index')

    {{--Scripts --}}

    @stack('before-scripts')

    <!-- For Js Library -->
    {{--  @include('frontend.layouts.partials._scripts') --}}




    <script>

        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};

        // @if((session()->has('show_login')) && (session('show_login') == true))
        //     // @dd(session('show_login'))
        //     $('#myModal').modal('show');
        //     // window.alert('Hoududidn')
        // @endif

        </script>

        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <script>
            window.addEventListener('load', function () {

                    alertify.set('notifier', 'position', 'top-right');
                });

                function showNotice(type, message) {
                    var alertifyFunctions = {
                        'success': alertify.success,
                        'error': alertify.error,
                        'info': alertify.message,
                        'warning': alertify.warning
                    };

                    alertifyFunctions[type](message, 10);
                }
        </script>
    <script src="{{ mix('assets/js/app.js') }}"></script>
    <script>
        // $( document ).ready(function() {
        //     $('section:not(.footer-area-section, .breadcrumb-section)').addClass('_section_page_')
        // });
    </script>

    @if(config('access.captcha.registration'))

    {!! no_captcha()->script() !!}

    @endif
    {{--
    @if(Request::segment(1) =='boutique')
        @include('frontend.layouts.partials._scripts')
        <script src="{{ mix('assets/js/app_ecommerce.js') }}"></script>
    @else
        @include('frontend.layouts.partials._scripts')
        <script src="{{ mix('assets/js/app_ecommerce.js') }}" ></script>
    @endif
    --}}


    <style>
        .alertify-notifier .ajs-message{
            color: #ffffff;
        }
    </style>

    @yield('js')

    @stack('after-scripts')

    @include('includes.partials.ga')
</body>



</html>

