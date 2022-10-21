        <header id="header">
            <div id="main-menu" class="main-menu-container menu-bg-overlay">
                <div class="main-menu position-relative" style="z-index: 100">
                    <div class="container">
                        <div class="navbar-default">
                            <div class="navbar-header float-left">
                                <a class="navbar-brand text-uppercase" href="{{url('/')}}">
                                    {{--<img src="{{asset("storage/logos/".config('app.logo_w_image'))}}" alt="logo">--}}
                                    <img src="{{asset("assets/images/logos/".config('app.logo_w_image'))}}" alt="logo">
                                </a>
                            </div><!-- /.navbar-header -->


                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <nav class="navbar-menu float-left">
                                <div class="nav-menu ul-li">
                                    <ul>
                                        @if(count($custom_menus) > 0 )

                                        @foreach($custom_menus as $key => $value)
                                        {{--@if(is_array($menu['id']) && $menu['id'] == $menu['parent'])--}}
                                        {{--@if($menu->subs && (count($menu->subs) > 0))--}}
                                        {{-- @if($menu['id'] == $menu['parent']) --}}
                                        @if(!is_array($value) )
                                        <li class="">
                                            <a href="{{asset($value)}}"
                                            class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                            id="menu-{{$value}}">{{$key}}</a>
                                        </li>

                                        @else
                                        <li class="menu-item-has-children ul-li-block">
                                            <a
                                            href="/#!">{{$key}}</a>
                                            <ul class="sub-menu">
                                                {{-- @dd( $value) --}}
                                                @foreach($custom_menus[$key] as $label => $item)
                                                @include('frontend.layouts.partials._dropdown', [$label, $item])
                                                @endforeach

                                            </ul>
                                        </li>
                                        @endif
                                        {{-- @endif --}}
                                        @endforeach

                                        @endif

                                    </ul>
                                </div>
                            </nav>
                            <ul class="nav justify-content-end">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Link</a>
                                </li>
                                <li class="nav-item mr-3">
                                    <div class="cart-search ul-li">
                                        <ul>
                                            <li>
                                                <a href="{{route('cart.index')}}"><i class="fas fa-shopping-bag"></i>
                                                    @if(auth()->check() && Cart::session(auth()->user()->id)->getTotalQuantity()
                                                    != 0)
                                                    <span
                                                        class="badge badge-danger position-absolute">{{Cart::session(auth()->user()->id)->getTotalQuantity()}}</span>
                                                    @endif
                                                </a>
                                            </li>
                                        </ul>
                                        {{-- <ul>
                                            <navbar-cart :cart="cart"
                                                        @remove-item="removeItem"
                                                        @update-quantity="updateCart">

                                            </navbar-cart>
                                        </ul> --}}
                                    </div>

                                </li>

                                <navbar-cart :cart="cart"
                                            @remove-item="removeItem"
                                            @update-quantity="updateCart">

                                </navbar-cart>

                                    @if(auth()->check())
                                    <li class="menu-item-has-children ul-li-block">
                                        <a href="#!">{{ $logged_in_user->name }}<span class="ml-2 d-inline-block border border-warning rounded-circle" style="width:30px; height:30px; padding-top:3px"><i class="fas fa-user ml-2"></i></span> </a>
                                        <ul class="sub-menu">
                                            @can('view backend')
                                            <li>
                                                <a
                                                    href="{{ route('admin.dashboard') }}">@lang('navs.frontend.dashboard')</a>
                                            </li>
                                            @endcan

                                            <li>
                                                <a
                                                    href="{{ route('frontend.auth.logout') }}" >@lang('navs.general.logout')</a>

                                            </li>
                                        </ul>
                                    </li>
                                    @else
                                    <li>
                                        <div class="log-in mt-0">
                                            <a id="openLoginModal" data-target="#myModal"
                                                href="#">@lang('navs.general.login')</a>
                                            {{--@include('frontend.layouts.modals.loginModal')--}}

                                        </div>
                                    </li>
                                    @endif

                            </ul>

                            <div class="mobile-menu">
                                <div class="logo">
                                    <a href="{{url('/')}}">
                                        <img src={{asset("assets/images/logos/".config('app.logo_w_image'))}} alt="Logo">
                                    </a>
                                </div>
                                <nav>
                                    <ul>
                                        @if(count($custom_menus) > 0 )
                                        @foreach($custom_menus as $key => $menu)
                                        {{-- @if($menu['id'] == $menu['parent']) --}}
                                        @if(is_array($menu) )
                                        <li class="">
                                            <a
                                                href="#!">{{ $key }}</a>
                                            <ul class="">
                                                @foreach($custom_menus[$key] as $label => $item)
                                                @include('frontend.layouts.partials._dropdown', [$label, $item])
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li class="">
                                            <a href="{{asset($menu)}}"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="menu-{{$menu}}">{{$key}}</a>
                                        </li>
                                        @endif

                                        {{-- @endif --}}
                                        @endforeach
                                        @endif
                                        <div class="">

                                            {{-- @dd( $value) --}}
                                            @foreach($second_menus as $label => $item)
                                             <li class="nav-item second">
                                                <a href="{{asset($item)}}" class="nav-link second"><span>{{$label}}</span></a>
                                            </li>
                                            @endforeach


                                        </div>
                                        @if(auth()->check())
                                        <li class="">
                                            <a href="#!">{{ $logged_in_user->name}}</a>
                                            <ul class="">
                                                @can('view backend')
                                                <li>
                                                    <a
                                                        href="{{ route('admin.dashboard') }}">@lang('navs.frontend.dashboard')</a>
                                                </li>
                                                @endcan


                                                <li>
                                                    <a
                                                        href="{{ route('frontend.auth.logout') }}">@lang('navs.general.logout')</a>
                                                </li>
                                            </ul>
                                        </li>
                                        @else
                                        <li>
                                            <div class=" ">
                                                <a id="openLoginModal" data-target="#myModal"
                                                    href="#">@lang('navs.general.login')</a>
                                                <!-- The Modal -->
                                            </div>
                                        </li>
                                        @endif
                                                        {{-- ///////// END MAIN MENU CLASS  /////// --}}

                                    </ul>
                                </nav>

                            </div>
                        </div>
                        {{-- ///////// END NAVBAR DEFAULT  /////// --}}

                    </div>
                    {{-- ///////// END CONTAINER  /////// --}}
                </div>
                {{-- ///////// END MAIN MENU CLASS  /////// --}}
                <div class="second-menu shadow nav-menu position-relative" style="z-index: 10">
                    <div class="container">
                            <div class="second-menu-nav float-left pt-1" >
                            <ul id="menu-sub-menu" class="nav ml-3">
                                {{-- @dd( $value) --}}
                                @foreach($second_menus as $label => $item)
                                @include('frontend.layouts.partials._dropdown-second', [$label, $item])
                                @endforeach

                            </ul>
                        </div>
                        <div class="header-search-wrap float-right mr-4" >
                            <search-header :token="'{{ csrf_token() }}'">
                            </search-header>
                            {{-- <form role="search" method="get" class="search_form" action="https://fxinstitut.com/">
                                <div class="searchBox">
                                    <input class="searchInput search-field" type="search" name="s" placeholder="Rechercher…" value="">
                                    <a href="#" class="header-search-trigger searchButton"><span><i class="fas fa-search"></i></span></a>
                                </div>
                            </form> --}}
                        </div>
                    </div>

                </div>
            </div>
            {{-- ///////// END MAIN MENU ID  /////// --}}
        </header>
        @if ( count(Request::segments()) > 0)



        <section id="breadcrumb" class="breadcrumb-section relative-position background-style">
            <div class="blakish-overlay"></div>
            <div class="container">
                <div class="page-breadcrumb-content text-center">
                    <div class="page-breadcrumb-title">
                        <h2 class="breadcrumb-head black bold">
                            <span>
                            @if ( count(Request::segments()) == 1 )
                                @if (Request::segment(1) == 'contact')
                                 {{ env('APP_NAME') ." ". Request::segment(1) }}

                                @elseif (Request::segment(1) == 'contct')

                                @else
                                    {{ Request::segment(1) }}

                                @endif
                            @elseif ( count(Request::segments()) == 2)
                                {{ Request::segment(1) . ' > ' . Request::segment(2)}}
                            @elseif ( isset($category))
                                {{ $category->name }}
                            @elseif ( isset($q))
                                {{ ".$q." }}
                            @elseif ( isset($teacher))
                                {{ $teacher->full_name }}
                            @endif

                            </span>
                        </h2>
                    </div>
                </div>
            </div>
        </section>

        @endif
