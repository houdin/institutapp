<section id="latest-area" class="latest-area-section {{isset($pt) ? $pt : ''}}">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="latest-area-content  mb-5">
                    <div class="section-title-2 mb30 headline text-left">
                        <h4 class="uppercase">@lang('labels.frontend.layouts.partials.latest_news_blog')</h4>
                    </div>
                    <div class="latest-news-posts">
                        @if( $snipet )

                        <h3 class="latest-title bold-font color-base-3"><a
                            href="{{route('tipstrick.show',['slug' => $snipet->slug.'-'.$snipet->id])}}">{{$snipet->title}}</a>
                        </h3>
                        <p class="latest-content">
                            <a
                                    href="{{route('tipstrick.show',['slug'=>$snipet->slug])}}">{{$snipet->excerpt()}}</a>
                        </p>
                        <div>

                            @include('frontend.layouts.partials._code', [$snipet])
                        </div>

                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('blogs.index')}}" class="color-base-3">@lang('labels.frontend.layouts.partials.view_all_news'){{--Nos Snipets--}}<i class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-4 rounded-lg" style="background-color: #222329">
            <div class="col-lg-4 col-md-4  col-sm-6">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb30 headline text-left">
                        <h4 class="uppercase">@lang('labels.frontend.layouts.partials.latest_news_blog')</h4>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($products) > 0)
                            @foreach($products as  $item)
                                <div class="latest-news-area product">
                                    @if($item->image )
                                    <a href="{{route('shopping.product.show',['slug' => $item->slug])}}">
                                        <div class="products-news-thumbnail relative-position"
                                             style="background-image: url('{{asset("assets/images/pdts/".$item->image->name)}}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    </a>
                                    @endif

                                </div>

                        @endforeach
                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('blogs.index')}}" class="color-base-3">@lang('labels.frontend.layouts.partials.view_all_news')<i class="fas fa-chevron-circle-right"></i></a>{{--Tous les Produits--}}
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb30 headline text-left">
                        <h4>@lang('labels.frontend.layouts.partials.latest_news_blog')</h4>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($tutorials) > 0)
                            @foreach($tutorials as  $item)
                                <div class="latest-news-area product">
                                    @if($item->image )
                                    <a href="{{route('tutorials.show',['slug' => $item->slug])}}">
                                        <div class="products-news-thumbnail relative-position"
                                             style="background-image: url('{{asset("assets/images/tols/".$item->image->name)}}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    </a>
                                    @endif
                                </div>

                        @endforeach
                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('formations.all',['type'=>'trending'])}}" class="color-base-3">@lang('labels.frontend.layouts.partials.view_all_news'){{--Tous nos Tutoriels  --}}<i
                                        class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-md-4 pt-md-4 pt-lg-0 col-sm-12">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb30 headline text-left">
                        <h4>@lang('labels.frontend.layouts.partials.latest_news_blog')</h4>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($news) > 0)
                            @foreach($news as  $item)
                                <div class="latest-news-area">
                                    @if($item->image )
                                        <div class="latest-news-thumbnail relative-position"
                                             style="background-image: url('{{ asset("storage/uploads/" . featured_image($item, 2)) }}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    @endif
                                    <h3 class="latest-title bold-font color-base-3"><a
                                                href="{{route('blogs.index',['slug' => $item->slug.'-'.$item->id])}}">{{$item->title}}</a>
                                    </h3>
                                    <p class="latest-content">
                                        <a
                                                href="{{route('formations.show',['slug'=>$item->slug])}}">{{$item->excerpt()}}</a>
                                    </p>
                                    <div class="formation-viewer ul-li">
                                        <ul>
                                            {{--<li><a href=""><i class="fas fa-user"></i> 1.220</a></li>--}}
                                            @if($item->comments->count() > 1)
                                                <li><a href=""><i
                                                                class="fas fa-comment-dots"></i>{{ $item->comments->count() }}
                                                    </a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                        @endforeach
                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('blogs.index')}}" class="color-base-3">@lang('labels.frontend.layouts.partials.view_all_news'){{--Nos Articles --}}<i class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
