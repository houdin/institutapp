<div class="col-md-3">
    <div class="side-bar">


        @if($recent_news->count() > 0)
            <div class="side-bar-widget first-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.recent_news')</h2>
                <div class="latest-news-posts">
                    @foreach($recent_news as $item)
                        <div class="latest-news-area">

                            @if($item->image != "")
                                <div class="latest-news-thumbnail relative-position"
                                     style="background-image: url({{asset('storage/uploads/'.$item->image)}})">
                                    <div class="blakish-overlay"></div>
                                </div>
                            @endif
                            <div class="date-meta">
                                <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                            </div>
                            <h3 class="latest-title bold-font"><a href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id])}}">{{$item->title}}</a></h3>
                        </div>
                        <!-- /post -->
                    @endforeach


                    <div class="view-all-btn bold-font">
                        <a href="{{route('blogs.index')}}">@lang('labels.frontend.layouts.partials.view_all_news') <i class="fas fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>

        @endif


        @if($global_featured_formation != "")
            <div class="side-bar-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.featured_formation')</h2>
                <div class="featured-formation">
                    <div class="best-formation-pic-text relative-position pt-0">
                        <div class="best-formation-pic relative-position " style="background-image: url({{asset('storage/uploads/'.$global_featured_formation->formation_image)}})">

                            @if($global_featured_formation->trending == 1)
                                <div class="trend-badge-2 text-center text-uppercase">
                                    <i class="fas fa-bolt"></i>
                                    <span>@lang('labels.frontend.badges.trending')</span>
                                </div>
                            @endif
                        </div>
                        <div class="best-formation-text" style="left: 0;right: 0;">
                            <div class="formation-title mb20 headline relative-position">
                                <h3><a href="{{ route('formations.show', [$global_featured_formation->slug]) }}">{{$global_featured_formation->title}}</a></h3>
                            </div>
                            <div class="formation-meta">
                                <span class="formation-category"><a href="{{route('formations.category',['category'=>$global_featured_formation->category->slug])}}">{{$global_featured_formation->category->name}}</a></span>
                                <span class="formation-author">{{ $global_featured_formation->students()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
