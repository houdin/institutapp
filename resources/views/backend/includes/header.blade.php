<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-menu') }}"></use>
            </svg>
        </button>
        {{-- <a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
        </a> --}}
        {{-- <a class="header-brand" href="{{ route('admin.dashboard') }}">
            <img class="navbar-brand-full" src="{{asset('assets/images/logos/'.config('app.logo_b_image'))}}" height="25"
                alt="Square Logo">
            <img class="navbar-brand-minimized" src="{{asset('assets/images/logos/'.config('app.logo_popup'))}}" height="30"
                alt="Square Logo">
        </a> --}}
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item px-3">
                <a class="nav-link" href="/"><i class="icon-home"></i></a>
            </li>

            <li class="nav-item px-3">
                <a class="nav-link"
                    href="{{ route('admin.dashboard') }}">@lang('backend/navs.frontend.dashboard')</a>
            </li>
            {{-- @if (config('locale.status') && count(config('locale.languages')) > 1) --}}
            {{-- <li class="nav-item px-3 dropdown"> --}}
            {{-- <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> --}}
            {{-- <span class="d-md-down-none">@lang('backend/menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</span> --}}
            {{-- </a> --}}

            {{-- @include('includes.partials.lang') --}}
            {{-- </li> --}}
            {{-- @endif --}}
            @if (config('locale.status') && count($locales) > 1)

                <li class="nav-item px-3 dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-md-down-none">@lang('backend/menus.language-picker.language')
                            ({{ strtoupper(app()->getLocale()) }})</span>
                    </a>

                    @include('includes.partials.lang')
                </li>
            @endif

        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-bell') }}"></use>
                    </svg>

                </a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-list-rich') }}">
                        </use>
                    </svg></a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-envelope-open') }}">
                        </use>
                    </svg>
                    <span class="badge badge-pill d-none badge-sm bg-success unreadMessageCounter"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>@lang('backend/navs.general.messages')</strong>
                    </div>
                    <div class="unreadMessages">
                        <p class="mb-0 text-center py-2">@lang('backend/navs.general.no_messages')</p>
                    </div>


                </div>
            </li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <img src="{{ $logged_in_user->picture }}" class="img-avatar rounded-circle"
                        alt="{{ $logged_in_user->email }}" width="20%">
                    <span style="right: 0;left: inherit"
                        class="badge d-md-none d-lg-none d-none mob-notification badge-sm bg-success">!</span>
                    <span class="d-md-down-none">{{ $logged_in_user->full_name }}</span>
                </a>


                <div class="dropdown-menu dropdown-menu-end pt-0">

                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">@lang('backend/navs.general.account')</div>
                    </div>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-bell') }}"></use>
                        </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span></a>
                    <a class="dropdown-item" href="{{ route('admin.messages') }}">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-envelope-open') }}">
                            </use>
                        </svg> @lang('backend/navs.general.messages')<span
                            class="badge unreadMessageCounter d-none badge-sm bg-success ms-2">5</span></a>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-task') }}">
                            </use>
                        </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span></a>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-comment-square') }}">
                            </use>
                        </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span></a>
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Settings</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('admin.account') }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-user') }}">
                            </use>
                        </svg> @lang('backend/navs.general.profile')</a>

                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-settings') }}">
                            </use>
                        </svg> Settings</a><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-credit-card') }}">
                            </use>
                        </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span></a><a
                        class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-file') }}">
                            </use>
                        </svg> Projects<span class="badge badge-sm bg-primary ms-2">42</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-lock-locked') }}">
                            </use>
                        </svg> Lock Account</a>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('assets/img/backend/icons/sprites/free.svg#cil-account-logout') }}">
                            </use>
                        </svg> @lang('backend/navs.general.logout')</a>

                    <form id="logout-form" action="{{ route('frontend.auth.logout') }}" method="POST"
                        style="display: none;">
                        {{ csrf_field() }}
                    </form>


                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Home</span>
                </li>
                <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
        </nav>
    </div>
</header>
