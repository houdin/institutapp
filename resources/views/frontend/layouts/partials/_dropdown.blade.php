@if(is_array($item) )
    <li>
        <a class="" id="menu-{{$item}}" href="{{$item->link}}">{{trans('custom-menu.'.$menu_name.'.'.Str::slug($item->label))}}</a>
        <ul class="depth-1">
            @foreach($item->subs as $item)
                @include('frontend.layouts.partials._dropdown', $item)
            @endforeach

        </ul>
    </li>
@else
    <li>
        <router-link class="" id="menu-{{$item}}" to="{{asset($item)}}">{{$label}}</router-link>
        {{-- <a class="" id="menu-{{$item}}" href="{{asset($item)}}">{{$label}}</a> --}}
    </li>
@endif
