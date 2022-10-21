<section id="best-formation" class="best-formation-section {{isset($class) ? $class : ''}}">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.search_our_formations')</span>
            <h2>@lang('labels.frontend.layouts.partials.browse_featured_formation')</h2>
        </div>
        <div class="best-formation-area mb45">
            <div class="row">
                @if(count($featured_formations) > 0)
                    @foreach($featured_formations as $item)
                        <div class="col-md-3">
                            <div class="best-formation-pic-text relative-position ">
                                <div class="best-formation-pic relative-position" @if($item->image )  style="background-image: url({{asset('storage/uploads/fmts/'.$item->image->name)}})" @endif>

                                    @if($item->trending == 1)
                                        <div class="trend-badge-2 text-center text-uppercase">
                                            <i class="fas fa-bolt"></i>
                                            <span>@lang('labels.frontend.badges.trending')</span>
                                        </div>
                                    @endif
                                        @if($item->free == 1)
                                            <div class="trend-badge-3 text-center text-uppercase">
                                                <i class="fas fa-bolt"></i>
                                                <span>@lang('labels.backend.formations.fields.free')</span>
                                            </div>
                                        @endif
                                    <div class="formation-price text-center gradient-bg">
                                        @if($item->free == 1)
                                            <span> {{trans('labels.backend.formations.fields.free')}}</span>
                                        @else
                                            <span>   {{$appCurrency['symbol'].' '.$item->price}}</span>
                                        @endif

                                    </div>
                                    <div class="formation-rate ul-li">
                                        <ul>
                                            @for($i=1; $i<=(int)$item->rating; $i++)
                                                <li><i class="fas fa-star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="formation-details-btn">
                                        <a class="text-uppercase" href="{{ route('formations.show', [$item->slug]) }}">@lang('labels.frontend.layouts.partials.formation_detail') <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                    <div class="blakish-overlay"></div>
                                </div>
                                <div class="best-formation-text">
                                    <div class="formation-title mb20 headline relative-position">
                                        <h3>
                                            <a href="{{ route('formations.show', [$item->slug]) }}">{{$item->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="formation-meta">
                                            <span class="formation-category"><a
                                                        href="{{route('formations.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a></span>
                                        <span class="formation-author">
                                                <a href="#">
                                                    {{ $item->students()->count() }}
                                                    @lang('labels.frontend.layouts.partials.students')</a>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-center">@lang('labels.general.no_data_available')</h4>
                @endif

            </div>
        </div>
    </div>
</section>
