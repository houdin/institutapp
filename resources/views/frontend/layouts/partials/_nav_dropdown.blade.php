@if(is_array($item) )
    <li>
        <router-link class="" id="menu-{{$item}}" to="{{'/' . $item->link}}">{{trans('custom-menu.'.$menu_name.'.'.Str::slug($item->label))}}</router-link>
        <ul class="depth-1">
            @foreach($item->subs as $item)
                @include('frontend.layouts.partials._nav_dropdown', $item)
            @endforeach

        </ul>
    </li>
@else
    <li>
        <router-link class="" id="menu-{{$item}}" to="{{ '/' . $item}}">{{strtoupper($label)}}</router-link>
    </li>
@endif
