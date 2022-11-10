<div>
    <header-app></header-app>
    <success-message v-show="showComponents.showMessage" :message="message">
    </success-message>

    <error-message v-show="showComponents.showError" :error-message="errorMessage">
    </error-message>

    <nav>
        <ul>
            @if (auth()->check())
                <li class="">
                    <a href="#!">{{ $logged_in_user->name }}</a>
                    <ul class="">
                        @can('view backend')
                            <li>
                                <a href="{{ route('admin.dashboard') }}">@lang('navs.frontend.dashboard')</a>
                            </li>
                        @endcan


                        <li>
                            <a href="{{ route('logout') }}">@lang('navs.general.logout')</a>
                        </li>
                    </ul>
                </li>
            @else
                <li>
                    <div class=" ">
                        <a id="openLoginModal" data-target="#myModal" href="#">@lang('navs.general.login')</a>
                        <!-- The Modal -->
                    </div>
                </li>
            @endif
        </ul>

    </nav>
    <breadcrumbs></breadcrumbs>

    <div id="">

        @include('frontend.layouts.modals.loginModal')

        {{-- @include('frontend.layouts.partials._header') --}}

        @if (Request::segment(1) == 'boutique')
            @include('frontend.products.partials._messages')
        @endif

        @yield('content')

    </div>

</div>
