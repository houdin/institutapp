{{-- <nav class="navbar-menu float-left">
    <div class="nav-menu ul-li">
        <ul>
            @if(count($custom_menus) > 0 )

            @foreach($custom_menus as $key => $value)

            @if(!is_array($value) )

            <li class="">
                <a href="{{asset($value)}}"
                    class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                    id="menu-{{$value}}">{{$key}}</a>
            </li>

            @else
            <li class="menu-item-has-children ul-li-block">
                <a href="/#!">{{$key}}</a>
                <ul class="sub-menu">

                    @foreach($custom_menus[$key] as $label => $item)
                    @include('frontend.layouts.partials._dropdown', [$label, $item])
                    @endforeach

                </ul>
            </li>
            @endif

            @endforeach

            @endif

        </ul>
    </div>
</nav> --}}
<nav class="navbar-menu float-left">
    <div class="nav-menu ul-li">
        <ul>
            @if(count($custom_menus) > 0 )

            @foreach($custom_menus as $key => $value)

            @if(!is_array($value) )
            <li class="">
                <router-link to="{{'/' . $value}}"
                    class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                    id="menu-{{$value}}">{{strtoupper($key)}}</router-link>
            </li>

            @else
            <li class="menu-item-has-children ul-li-block">
                <router-link to="/">{{$key}}</router-link>
                <ul class="sub-menu">

                    @foreach($custom_menus[$key] as $label => $item)
                    @include('frontend.layouts.partials._nav_dropdown', [$label, $item])
                    @endforeach

                </ul>
            </li>
            @endif

            @endforeach

            @endif

        </ul>
    </div>
</nav>
