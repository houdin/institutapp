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
    @if (config('app.favicon_image') != '')
        <link rel="shortcut icon" type="image/x-icon"
            href="{{ asset('assets/images/logos/' . config('app.favicon_image')) }}" />
    @endif
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">


    @yield('css')
    @stack('after-styles')

    @if (config('onesignal_status') == 1)
        {!! config('onesignal_data') !!}
    @endif

    @if (config('google_analytics_id') != '')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ config('google_analytics_id') }}');
        </script>
    @endif



    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
    <?php
    $Lara = [
        'app' => [
            'name' => config('app.name'),
            'home_url' => URL::to('/'),
            'logo_w_image' => config('app.logo_w_image'),
            'logo_popup' => config('app.logo_popup'),
            'custom_menus' => $custom_menus,
            'second_menus' => $second_menus,
            'csrfToken' => csrf_token(),
            'recaptcha' => [
                'sitekey' => config('no-captcha.sitekey'),
            ],
            'user' => auth()->check() ? true : false,
            'footer_data' => json_decode(config('footer_data')),
            'footer_menus' => $footer_menus,
            'show_offers' => config('show_offers'),
        ],
        'csrfToken' => csrf_token(),
        'stripeKey' => config('services.stripe.key'),
        'urls' => \App\Library\Data\UrlData::get(),
        'ajax' => false,
        'appCurrency' => $appCurrency['symbol'],
    ];
    ?>

    <script>
        window.Laravel = @json($Lara)

        window.default_locale = "fr";
        window.fallback_locale = "en";
        window.messages = @json($fxinstitut_lang);

        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};
    </script>



</head>

<body class="wide">

    <div class="page-wrapper">

        <main-page></main-page>


    </div>


    {{-- @include('cookieConsent::index') --}}

    {{-- Scripts --}}

    @stack('before-scripts')

    <!-- For Js Library -->
    {{-- @include('frontend.layouts.partials._scripts') --}}



    <script src="{{ mix('assets/js/app.js') }}"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    {{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> --}}
    <script>
        // alertify.alert('Ready!');
        window.addEventListener('load', function() {

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



    {{-- @if (config('access.captcha.registration'))

    {!! no_captcha()->script() !!}

    @endif --}}



    @yield('js')

    @stack('after-scripts')

    @include('includes.partials.ga')
</body>



</html>
