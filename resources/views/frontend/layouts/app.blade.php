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
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    @stack('before-styles')

    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead



    @yield('css')
    @stack('after-styles')

</head>

<body class="wide font-sans antialiased">

    @inertia


</body>

</html>
