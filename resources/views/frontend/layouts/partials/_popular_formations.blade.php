
<!-- Start popular formation
       ============================================= -->
@if(count($popular_formations) > 0)
    <section id="popular-formation" class="popular-formation-section {{isset($class) ? $class : ''}}">
        <div class="container">
            <div class="section-title mb20 headline text-left ">
                <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.learn_new_skills')</span>
                <h2>@lang('labels.frontend.layouts.partials.popular_formations')</h2>
            </div>
            <div id="formation-slide-item" class="formation-slide owl-carousel owl-theme owl-responsive-1000">
                @foreach($popular_formations as $item)
                    <div class="formation-item-pic-text ">
                        <div class="formation-pic relative-position mb25" @if($item->image)  style="background-image: url({{asset('storage/uploads/fmts/'.$item->image->name)}})" @endif>

                            <div class="formation-price text-center gradient-bg">
                                @if($item->free == 1)
                                    <span> {{trans('labels.backend.formations.fields.free')}}</span>
                                @else
                                   <span>   {{$appCurrency['symbol'].' '.$item->price}}</span>
                                @endif
                            </div>
                            <div class="formation-details-btn">
                                <a class="text-uppercase" href="{{ route('formations.show', [$item->slug]) }}">@lang('labels.frontend.layouts.partials.formation_detail') <i
                                            class="fas fa-arrow-right"></i></a>
                            </div>

                        </div>
                        <div class="formation-item-text">
                            <div class="formation-meta">
                                    <span class="formation-category bold-font"><a
                                                href="{{route('formations.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a></span>
                                <span class="formation-author bold-font">
                                @foreach($item->teachers as $teacher)
                                        <a href="#">{{$teacher->first_name}}</a></span>
                                @endforeach
                                <div class="formation-rate ul-li">
                                    <ul>
                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div class="formation-title mt10 headline pb45 relative-position">
                                <h3><a href="{{ route('formations.show', [$item->slug]) }}">{{$item->title}}</a>
                                    @if($item->trending == 1)
                                        <span
                                                class="trend-badge text-uppercase bold-font"><i
                                                    class="fas fa-bolt"></i> @lang('labels.frontend.badges.trending')</span>
                                    @endif

                                </h3>
                            </div>
                            <div class="formation-viewer ul-li">
                                <ul>
                                    <li><a href=""><i class="fas fa-user"></i> {{ $item->students()->count() }}
                                        </a>
                                    </li>
                                    <li><a href=""><i class="fas fa-comment-dots"></i> {{count($item->reviews) }}</a></li>
                                    {{--<li><a href="">125k Unrolled</a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /item -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- End popular formation
        ============================================= -->
@endif
