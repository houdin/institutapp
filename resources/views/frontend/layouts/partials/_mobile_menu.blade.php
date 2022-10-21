<div class="mobile-menu">
    <div class="logo">
        <router-link to="{{url('/')}}">
            <img src={{asset("assets/images/logos/".config('app.logo_w_image'))}} alt="Logo">
        </router-link>
    </div>
    <nav>
        <ul>
            @if(count($custom_menus) > 0 )
            @foreach($custom_menus as $key => $menu)
            {{-- @if($menu['id'] == $menu['parent']) --}}
            @if(is_array($menu) )
            <li class="">
                <router-link to="#!">{{ $key }}</router-link>
                <ul class="">
                    @foreach($custom_menus[$key] as $label => $item)
                    @include('frontend.layouts.partials._nav_dropdown', [$label, $item])
                    @endforeach
                </ul>
            </li>
            @else
            <li class="">
                <router-link to="{{$menu}}"
                    class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                    id="menu-{{$menu}}">{{$key}}</router-link>
            </li>
            @endif

            {{-- @endif --}}
            @endforeach
            @endif
            <div class="">

                {{-- @dd( $value) --}}
                @foreach($second_menus as $label => $item)
                <li class="nav-item second">
                    <router-link to="{{$item}}" class="nav-link second"><span>{{$label}}</span></router-link>
                </li>
                @endforeach


            </div>
            @if(auth()->check())
            <li class="">
                <router-link to="#!">{{ $logged_in_user->name}}</router-link>
                <ul class="">
                    @can('view backend')
                    <li>
                        <router-link to="{{ route('admin.dashboard') }}">@lang('navs.frontend.dashboard')</router-link>
                    </li>
                    @endcan


                    <li>
                        <router-link to="{{ route('frontend.auth.logout') }}">@lang('navs.general.logout')</router-link>
                    </li>
                </ul>
            </li>
            @else
            <li>
                <div class="">
                    <router-link id="openLoginModal" data-target="#myModal" to="#">@lang('navs.general.login')</router-link>
                    <!-- The Modal -->
                </div>
            </li>
            @endif
            {{-- ///////// END MAIN MENU CLASS  /////// --}}

        </ul>
    </nav>

</div>
