@extends('frontend.layouts.app')

@section('title', ($bundle->meta_title) ? $bundle->meta_title : app_name() )
@section('meta_description', $bundle->meta_description)
@section('meta_keywords', $bundle->meta_keywords)

@push('after-styles')
    <style>
        .leanth-formation.go {
            right: 0;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>

@endpush

@section('content')


    <!-- Start of formation details section
        ============================================= -->
    <section id="formation-details" class="formation-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="formation-details-item border-bottom-0 mb-0">
                        <div class="formation-single-pic mb30">
                            @if($bundle->formation_image != "")
                                <img src="{{asset('storage/uploads/'.$bundle->formation_image)}}"
                                     alt="">
                            @endif
                        </div>
                        <div class="formation-single-text">
                            <div class="formation-title mt10 headline relative-position">
                                <h3><a href="{{ route('formations.show', [$bundle->slug]) }}"><b>{{$bundle->title}}</b></a>
                                    @if($bundle->trending == 1)
                                        <span class="trend-badge text-uppercase bold-font"><i
                                                    class="fas fa-bolt"></i> @lang('labels.frontend.badges.trending')</span>
                                    @endif

                                </h3>
                            </div>
                            <div class="formation-details-content">
                                <p>
                                    {!! $bundle->description !!}
                                </p>
                                @if(count($bundle->formations)  > 0)
                                <div class="my-4">
                                    @foreach($bundle->formations as $formation)
                                        @if($formation->mediaVideo && $formation->mediavideo->count() > 0)
                                            <div class="formation-single-text">
                                                @if($formation->mediavideo != null)
                                                    <h3 class="text-dark">{{$formation->title}}</h3>
                                                    <div class="formation-details-content mt-3">
                                                        <div class="video-container mb-5" data-id="{{$formation->mediavideo->id}}">
                                                            @if($formation->mediavideo->type == 'youtube')


                                                                <div id="player" class="js-player" data-plyr-provider="youtube"
                                                                     data-plyr-embed-id="{{$formation->mediavideo->file_name}}"></div>
                                                            @elseif($formation->mediavideo->type == 'vimeo')
                                                                <div id="player" class="js-player" data-plyr-provider="vimeo"
                                                                     data-plyr-embed-id="{{$formation->mediavideo->file_name}}"></div>
                                                            @elseif($formation->mediavideo->type == 'upload')
                                                                <video poster="" id="player" class="js-player" playsinline controls>
                                                                    <source src="{{$formation->mediavideo->url}}" type="video/mp4"/>
                                                                </video>
                                                            @elseif($formation->mediavideo->type == 'embed')
                                                                {!! $formation->mediavideo->url !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        @if(count($bundle->formations)  > 0)

                            <div class="formation-details-category ul-li">
                                <span class="float-none">@lang('labels.frontend.formation.formations')</span>
                            </div>
                            <div class="genius-post-item mb55">
                                <div class="tab-container">
                                    <div id="tab1" class="tab-content-1 pt35">
                                        <div class="best-formation-area best-formation-v2">
                                            <div class="row">
                                                @foreach($bundle->formations as $formation)
                                                    <div class="col-md-4">
                                                        <div class="best-formation-pic-text relative-position">
                                                            <div class="best-formation-pic relative-position"
                                                                 @if($formation->formation_image != "") style="background-image: url('{{asset('storage/uploads/'.$formation->formation_image)}}')" @endif>

                                                                @if($formation->trending == 1)
                                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                                        <i class="fas fa-bolt"></i>
                                                                        <span>@lang('labels.frontend.badges.trending')</span>
                                                                    </div>
                                                                @endif
                                                                @if($formation->free == 1)
                                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                                        <i class="fas fa-bolt"></i>
                                                                        <span>@lang('labels.backend.formations.fields.free')</span>
                                                                    </div>
                                                                @endif

                                                                <div class="formation-rate ul-li">
                                                                    <ul>
                                                                        @for($i=1; $i<=(int)$formation->rating; $i++)
                                                                            <li><i class="fas fa-star"></i></li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                                <div class="formation-details-btn">
                                                                    <a href="{{ route('formations.show', [$formation->slug]) }}">@lang('labels.frontend.formation.formation_detail')
                                                                        <i class="fas fa-arrow-right"></i></a>
                                                                </div>
                                                                <div class="blakish-overlay"></div>
                                                            </div>
                                                            <div class="best-formation-text">
                                                                <div class="formation-title mb20 headline relative-position">
                                                                    <h3>
                                                                        <a href="{{ route('formations.show', [$formation->slug]) }}">{{$formation->title}}</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="formation-meta">
                                                            <span class="formation-category"><a
                                                                        href="{{route('formations.category',['category'=>$formation->category->slug])}}">{{$formation->category->name}}</a></span>
                                                                    <span class="formation-author"><a href="#">{{ $formation->students()->count() }}
                                                                            @lang('labels.frontend.formation.students')</a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach

                                            <!-- /formation -->

                                            </div>
                                        </div>
                                    </div><!-- /tab-1 -->
                                </div>
                            </div>

                         @endif
                    <!-- /formation-details -->


                    </div>
                    <!-- /market guide -->

                    <div class="formation-review">
                        <div class="section-title-2 mb20 headline text-left">
                            <h2>@lang('labels.frontend.formation.bundle_reviews')</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ratting-preview">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="avrg-rating ul-li">
                                                <b>@lang('labels.frontend.formation.average_rating')</b>
                                                <span class="avrg-rate">{{$bundle_rating}}</span>
                                                <ul>
                                                    @for($r=1; $r<=$bundle_rating; $r++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                                <b>{{$total_ratings}} @lang('labels.frontend.formation.ratings')</b>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="avrg-rating ul-li">
                                                <span><b>@lang('labels.frontend.formation.details')</b></span>
                                                @for($r=5; $r>=1; $r--)
                                                    <div class="rating-overview">
                                                        <span class="start-item">{{$r}} @lang('labels.frontend.formation.stars')</span>
                                                        <span class="start-bar"></span>
                                                        <span class="start-count">{{$bundle->reviews()->where('rating','=',$r)->get()->count()}}</span>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /review overview -->

                    <div class="couse-comment">
                        <div class="blog-comment-area ul-li about-teacher-2">
                            @if(count($bundle->reviews) > 0)
                                <ul class="comment-list">
                                    @foreach($bundle->reviews as $item)
                                        <li class="d-block">
                                            <div class="comment-avater">
                                                <img src="{{$item->user->picture}}" alt="">
                                            </div>

                                            <div class="author-name-rate">
                                                <div class="author-name float-left">
                                                    @lang('labels.frontend.formation.by'):
                                                    <span>{{$item->user->full_name}}</span>
                                                </div>
                                                <div class="comment-ratting float-right ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                    @if(auth()->check() && ($item->user_id == auth()->user()->id))
                                                        <div>
                                                            <a href="{{route('bundles.review.edit',['id'=>$item->id])}}"
                                                               class="mr-2">@lang('labels.general.edit')</a>
                                                            <a href="{{route('bundles.review.delete',['id'=>$item->id])}}"
                                                               class="text-danger">@lang('labels.general.delete')</a>
                                                        </div>

                                                    @endif
                                                </div>
                                                <div class="time-comment float-right">{{$item->created_at->diffforhumans()}}</div>
                                            </div>
                                            <div class="author-designation-comment">
                                                <p>{{$item->content}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <h4> @lang('labels.frontend.formation.no_reviews_yet')</h4>
                            @endif

                            @if ($purchased_bundle)
                                @if(isset($review) || ($is_reviewed == false))
                                    <div class="reply-comment-box">
                                        <div class="review-option">
                                            <div class="section-title-2  headline text-left float-left">
                                                <h2>@lang('labels.frontend.formation.add_reviews')</h2>
                                            </div>
                                            <div class="review-stars-item float-right mt15">
                                                <span>@lang('labels.frontend.formation.your_rating'): </span>
                                                <div class="rating">
                                                    <label>
                                                        <input type="radio" name="stars" value="1"/>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="2"/>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="3"/>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="4"/>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="5"/>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                        <span class="icon"><i class="fas fa-star"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="teacher-faq-form">
                                            @php
                                                if(isset($review)){
                                                    $route = route('bundles.review.update',['id'=>$review->id]);
                                                }else{
                                                    $route = route('bundles.review',['formation'=>$bundle->id]);
                                                }
                                            @endphp
                                            <form method="POST"
                                                  action="{{$route}}"
                                                  data-lead="Residential">
                                                @csrf
                                                <input type="hidden" name="rating" id="rating">
                                                <label for="review">@lang('labels.frontend.formation.message')</label>
                                                <textarea name="review" class="mb-2" id="review" rows="2"
                                                          cols="20">@if(isset($review)){{$review->content}} @endif</textarea>
                                                <span class="help-block text-danger">{{ $errors->first('review', ':message') }}</span>
                                                <div class="nws-button text-center  gradient-bg text-uppercase">
                                                    <button type="submit"
                                                            value="Submit">@lang('labels.frontend.formation.add_review_now')
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="side-bar">
                        <div class="formation-side-bar-widget">
                            @if (!$purchased_bundle)
                                <h3>
                                    @if($bundle->free == 1)
                                        <span> {{trans('labels.backend.formations.fields.free')}}</span>
                                    @else
                                        @lang('labels.frontend.formation.price')
                                        <span>   {{$appCurrency['symbol'].' '.$bundle->price}}</span>
                                    @endif
                                </h3>

                                @if(auth()->check() && (auth()->user()->hasRole('student')) && (Cart::session(auth()->user()->id)->get( $bundle->id)))
                                    <button class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white bold-font"
                                            type="submit">@lang('labels.frontend.formation.added_to_cart')
                                    </button>
                                @elseif(!auth()->check())
                                    @if($bundle->free == 1)
                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#">@lang('labels.frontend.formation.get_now') <i
                                                    class="fas fa-caret-right"></i></a>
                                    @else
                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#">@lang('labels.frontend.formation.buy_now') <i
                                                    class="fas fa-caret-right"></i></a>

                                        <a id="openLoginModal"
                                           class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase "
                                           data-target="#myModal" href="#">@lang('labels.frontend.formation.add_to_cart')
                                            <i
                                                    class="fa fa-shopping-bag"></i></a>
                                    @endif
                                @elseif(auth()->check() && (auth()->user()->hasRole('student')))
                                    @if($bundle->free == 1)
                                        <form action="{{ route('cart.getnow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}"/>
                                            <input type="hidden" name="amount"
                                                   value="{{($bundle->free == 1) ? 0 : $bundle->price}}"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#">@lang('labels.frontend.formation.get_now') <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('cart.checkout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}"/>
                                            <input type="hidden" name="amount" value="{{ $bundle->price}}"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#">@lang('labels.frontend.formation.buy_now') <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                        <form action="{{ route('cart.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}"/>
                                            <input type="hidden" name="amount" value="{{ $bundle->price}}"/>
                                            <button type="submit"
                                                    class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase ">
                                                @lang('labels.frontend.formation.add_to_cart') <i
                                                        class="fa fa-shopping-bag"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <h6 class="alert alert-danger"> @lang('labels.frontend.formation.buy_note')</h6>
                                @endif
                                <div class="enrolled-student mb-3">
                                    <div class="comment-ratting float-left ul-li">
                                        <ul>
                                            @for($i=1; $i<=(int)$bundle->rating; $i++)
                                                <li><i class="fas fa-star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="student-number bold-font">
                                        {{ $bundle->students()->count() }}  @lang('labels.frontend.formation.enrolled')
                                    </div>
                                </div>
                            @endif


                        </div>


                        @if($recent_news->count() > 0)
                            <div class="side-bar-widget mt-0">
                                <h2 class="widget-title text-capitalize">@lang('labels.frontend.formation.recent_news')</h2>
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
                                            <h3 class="latest-title bold-font"><a
                                                        href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id])}}">{{$item->title}}</a>
                                            </h3>
                                        </div>
                                        <!-- /post -->
                                    @endforeach


                                    <div class="view-all-btn bold-font">
                                        <a href="{{route('blogs.index')}}">@lang('labels.frontend.formation.view_all_news')
                                            <i
                                                    class="fas fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if($global_featured_formation != "")
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize">@lang('labels.frontend.formation.featured_formation')</h2>
                                <div class="featured-formation">
                                    <div class="best-formation-pic-text relative-position pt-0">
                                        <div class="best-formation-pic relative-position "
                                             @if($global_featured_formation->formation_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_formation->formation_image)}})" @endif>

                                            @if($global_featured_formation->trending == 1)
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                </div>
                                            @endif

                                            @if($global_featured_formation->free == 1)
                                                <div class="trend-badge-3 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span>@lang('labels.backend.formations.fields.free')</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="best-formation-text" style="left: 0;right: 0;">
                                            <div class="formation-title mb20 headline relative-position">
                                                <h3>
                                                    <a href="{{ route('formations.show', [$global_featured_formation->slug]) }}">{{$global_featured_formation->title}}</a>
                                                </h3>
                                            </div>
                                            <div class="formation-meta">
                                                <span class="formation-category"><a
                                                            href="{{route('formations.category',['category'=>$global_featured_formation->category->slug])}}">{{$global_featured_formation->category->name}}</a></span>
                                                <span class="formation-author">{{ $global_featured_formation->students()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of formation details section
        ============================================= -->

@endsection

@push('after-scripts')
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>

    <script>
        const player = new Plyr('#player');
        $(document).on('change', 'input[name="stars"]', function () {
            $('#rating').val($(this).val());
        })
                @if(isset($review))
        var rating = "{{$review->rating}}";
        $('input[value="' + rating + '"]').prop("checked", true);
        $('#rating').val(rating);
        @endif
    </script>
@endpush
