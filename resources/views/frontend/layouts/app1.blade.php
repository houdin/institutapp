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

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
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

    {{-- @if (Request::segment(1) == 'boutique') --}}
    @if (true)
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'stripeKey' => config('services.stripe.key'),
                'urls' => \App\Library\Data\UrlData::get(),
            ]); ?>
        </script>
    @endif


</head>

<body class="wide">

    <div id="app">




        {{-- @if (Request::segment(1) == 'boutique') --}}

        <main-page inline-template>
            <div>
                <success-message v-show="showComponents.showMessage" :message="message">
                </success-message>

                <error-message v-show="showComponents.showError" :error-message="errorMessage">
                </error-message>
                <search-products-screen v-if="showComponents.search" :token="'{{ csrf_token() }}'">
                </search-products-screen>

                <main-front inline-template :show="showComponents">
                    <div class="">

                        @include('frontend.layouts.modals.loginModal')

                        @include('frontend.layouts.partials._header')

                        @if (Request::segment(1) == 'boutique')
                            @include('frontend.products.partials._messages')
                        @endif
                        @yield('content')

                    </div>

                </main-front>


                @include('frontend.layouts.partials._footer')
            </div>
        </main-page>



        {{-- @else --}}

        {{-- @yield('content') --}}

        {{-- @endif --}}




    </div>

    {{--     @include('cookieConsent::index')
 --}}
    {{-- Scripts --}}

    @stack('before-scripts')

    <!-- For Js Library -->
    {{--  @include('frontend.layouts.partials._scripts') --}}

    <script>
        @if (session()->has('show_login') && session('show_login') == true)
            @dd(session('show_login'))
            $('#myModal').modal('show');
            window.alert('Hoududidn')
        @endif
    </script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
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
    <script src="{{ mix('assets/js/app.js') }}"></script>

    {{--
    @if (Request::segment(1) == 'boutique')
        @include('frontend.layouts.partials._scripts')
        <script src="{{ mix('assets/js/app_ecommerce.js') }}"></script>
    @else
        @include('frontend.layouts.partials._scripts')
        <script src="{{ mix('assets/js/app_ecommerce.js') }}" ></script>
    @endif
    --}}


    <style>
        .alertify-notifier .ajs-message {
            color: #ffffff;
        }
    </style>

    @yield('js')

    @stack('after-scripts')

    @include('includes.partials.ga')
</body>

</html>
