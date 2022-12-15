<!DOCTYPE html>
<!--
    ______ _  __    _               __   _  __          __
   / ____/| |/ /   (_)____   _____ / /_ (_)/ /_ __  __ / /_
  / /_    |   /   / // __ \ / ___// __// // __// / / // __/
 / __/   /   |   / // / / /(__  )/ /_ / // /_ / /_/ // /_
/_/     /_/|_|  /_//_/ /_//____/ \__//_/ \__/ \__,_/ \__/

-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-800" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (config('app.favicon_image') != '')
        <link rel="shortcut icon" type="image/x-icon"
            href="{{ asset('/assets/images/logos/' . config('app.favicon_image')) }}" />
    @endif
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    {{-- <link rel="stylesheet" href="https://rsms.me/inter/inter.css"> --}}


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

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans text-gray-200 antialiased bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 ">
    @inertia
</body>

</html>
