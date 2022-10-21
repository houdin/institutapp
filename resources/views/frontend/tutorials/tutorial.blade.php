@extends('frontend.layouts.app')

@section('title', ($tutorial->meta_title) ? $tutorial->meta_title : app_name() )
@section('meta_description', $tutorial->meta_description)
@section('meta_keywords', $tutorial->meta_keywords)

@push('after-styles')
    <style>
        .leanth-tutorial.go {
            right: 0;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>

@endpush

@section('content')


    <!-- Start of tutorial details section
        ============================================= -->
    <section id="tutorial-details" class="tutorial-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="tutorial-details-item border-bottom-0 mb-0">
                        <div class="tutorial-single-pic mb30">
                            @if($tutorial->image)
                                <img src="{{asset('assets/images/tols/'.$tutorial->image->name)}}"
                                     alt="">
                            @endif
                        </div>
                        <div class="tutorial-single-text">
                            <div class="tutorial-title mt10 headline relative-position">
                                <h3><a href="{{ route('tutorials.show', [$tutorial->slug]) }}"><b>{{$tutorial->title}}</b></a>
                                    @if($tutorial->trending == 1)
                                        <span class="trend-badge text-uppercase bold-font"><i
                                                    class="fas fa-bolt"></i> @lang('labels.frontend.badges.trending')</span>
                                    @endif

                                </h3>
                            </div>
                            <div class="tutorial-details-content">
                                <p>
                                    {!! $tutorial->description !!}
                                </p>
                            </div>
                            @if($tutorial->mediaVideo && $tutorial->mediavideo->count() > 0)
                                <div class="tutorial-single-text">
                                    @if($tutorial->mediavideo != "")
                                        <div class="tutorial-details-content mt-3">
                                            <div class="video-container mb-5" data-id="{{$tutorial->mediavideo->id}}">
                                                @if($tutorial->mediavideo->type == 'youtube')


                                                    <div id="player" class="js-player" data-plyr-provider="youtube"
                                                         data-plyr-embed-id="{{$tutorial->mediavideo->file_name}}"></div>
                                                @elseif($tutorial->mediavideo->type == 'vimeo')
                                                    <div id="player" class="js-player" data-plyr-provider="vimeo"
                                                         data-plyr-embed-id="{{$tutorial->mediavideo->file_name}}"></div>
                                                @elseif($tutorial->mediavideo->type == 'upload')
                                                    <video poster="" id="player" class="js-player" playsinline controls>
                                                        <source src="{{$tutorial->mediavideo->url}}" type="video/mp4"/>
                                                    </video>
                                                @elseif($tutorial->mediavideo->type == 'embed')
                                                    {!! $tutorial->mediavideo->url !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- /tutorial-details -->

                    <div class="affiliate-market-guide mb65">

                        <div class="affiliate-market-accordion">
                            <div id="accordion" class="panel-group">

                            </div>
                        </div>
                    </div>
                    <!-- /market guide -->

                    <div class="tutorial-review">
                        <div class="section-title-2 mb20 headline text-left">
                            <h2>@lang('labels.frontend.tutorial.tutorial_reviews')</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ratting-preview">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="avrg-rating ul-li">
                                                <b>@lang('labels.frontend.tutorial.average_rating')</b>
                                                <span class="avrg-rate">{{$tutorial_rating}}</span>
                                                <ul>
                                                    @for($r=1; $r<=$tutorial_rating; $r++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                                <b>{{$total_ratings}} @lang('labels.frontend.tutorial.ratings')</b>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="avrg-rating ul-li">
                                                <span><b>@lang('labels.frontend.tutorial.details')</b></span>
                                                @for($r=5; $r>=1; $r--)
                                                    <div class="rating-overview">
                                                        <span class="start-item">{{$r}} @lang('labels.frontend.tutorial.stars')</span>
                                                        <span class="start-bar"></span>
                                                        <span class="start-count">{{$tutorial->reviews()->where('rating','=',$r)->get()->count()}}</span>
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
                            @if(count($tutorial->reviews) > 0)
                                <ul class="comment-list">
                                    @foreach($tutorial->reviews as $item)
                                        <li class="d-block">
                                            <div class="comment-avater">
                                                <img src="{{$item->user->picture}}" alt="">
                                            </div>

                                            <div class="author-name-rate">
                                                <div class="author-name float-left">
                                                    @lang('labels.frontend.tutorial.by'):
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
                                                            <a href="{{route('tutorials.review.edit',['id'=>$item->id])}}"
                                                               class="mr-2">@lang('labels.general.edit')</a>
                                                            <a href="{{route('tutorials.review.delete',['id'=>$item->id])}}"
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
                                <h4> @lang('labels.frontend.tutorial.no_reviews_yet')</h4>
                            @endif

                            @if ($purchased_tutorial)
                                @if(isset($review) || ($is_reviewed == false))
                                    <div class="reply-comment-box">
                                        <div class="review-option">
                                            <div class="section-title-2  headline text-left float-left">
                                                <h2>@lang('labels.frontend.tutorial.add_reviews')</h2>
                                            </div>
                                            <div class="review-stars-item float-right mt15">
                                                <span>@lang('labels.frontend.tutorial.your_rating'): </span>
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
                                                    $route = route('tutorials.review.update',['id'=>$review->id]);
                                                }else{
                                                    $route = route('tutorials.review',['tutorial'=>$tutorial->id]);
                                                }
                                            @endphp
                                            <form method="POST"
                                                  action="{{$route}}"
                                                  data-lead="Residential">
                                                @csrf
                                                <input type="hidden" name="rating" id="rating">
                                                <label for="review">@lang('labels.frontend.tutorial.message')</label>
                                                <textarea name="review" class="mb-2" id="review" rows="2"
                                                          cols="20">@if(isset($review)){{$review->content}} @endif</textarea>
                                                <span class="help-block text-danger">{{ $errors->first('review', ':message') }}</span>
                                                <div class="nws-button text-center  gradient-bg text-uppercase">
                                                    <button type="submit"
                                                            value="Submit">@lang('labels.frontend.tutorial.add_review_now')
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
                        <div class="tutorial-side-bar-widget">


                        @if (!$purchased_tutorial)
                                <h3>
                                     @if($tutorial->free == 1)
                                        <span> {{trans('labels.backend.tutorials.fields.free')}}</span>
                                        @else
                                        @lang('labels.frontend.tutorial.price')<span>   {{$appCurrency['symbol'].' '.$tutorial->price}}</span>
                                        @endif</h3>

                                @if(auth()->check() && (auth()->user()->hasRole('student')) && (Cart::session(auth()->user()->id)->get( $tutorial->id)))
                                    <button class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white bold-font"
                                            type="submit">@lang('labels.frontend.tutorial.added_to_cart')
                                    </button>
                                @elseif(!auth()->check())
                                    @if($tutorial->free == 1)
                                        <a id="openLoginModal"
                                           class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                           data-target="#myModal" href="#">@lang('labels.frontend.tutorial.get_now') <i
                                                    class="fas fa-caret-right"></i></a>
                                    @else
                                    <a id="openLoginModal"
                                       class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                       data-target="#myModal" href="#">@lang('labels.frontend.tutorial.buy_now') <i
                                                class="fas fa-caret-right"></i></a>

                                    <a id="openLoginModal"
                                       class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase "
                                       data-target="#myModal" href="#">@lang('labels.frontend.tutorial.add_to_cart') <i
                                                class="fa fa-shopping-bag"></i></a>
                                    @endif
                                @elseif(auth()->check() && (auth()->user()->hasRole('student')))

                                    @if($tutorial->free == 1)
                                        <form action="{{ route('cart.getnow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tutorial_id" value="{{ $tutorial->id }}"/>
                                            <input type="hidden" name="amount" value="{{($tutorial->free == 1) ? 0 : $tutorial->price}}"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#">@lang('labels.frontend.tutorial.get_now') <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('cart.checkout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tutorial_id" value="{{ $tutorial->id }}"/>
                                            <input type="hidden" name="amount" value="{{($tutorial->free == 1) ? 0 : $tutorial->price}}"/>
                                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                    href="#">@lang('labels.frontend.tutorial.buy_now') <i
                                                        class="fas fa-caret-right"></i></button>
                                        </form>
                                        <form action="{{ route('cart.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tutorial_id" value="{{ $tutorial->id }}"/>
                                            <input type="hidden" name="amount" value="{{($tutorial->free == 1) ? 0 : $tutorial->price}}"/>
                                            <button type="submit"
                                                    class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase ">
                                                @lang('labels.frontend.tutorial.add_to_cart') <i
                                                        class="fa fa-shopping-bag"></i></button>
                                        </form>
                                    @endif


                                @else
                                    <h6 class="alert alert-danger"> @lang('labels.frontend.tutorial.buy_note')</h6>
                                @endif

                            @endif

                        </div>
                        <div class="enrolled-student">
                            <div class="comment-ratting float-left ul-li">
                                <ul>
                                    @for($i=1; $i<=(int)$tutorial->rating; $i++)
                                        <li><i class="fas fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="student-number bold-font">
                                {{ $tutorial->students()->count() }}  @lang('labels.frontend.tutorial.enrolled')
                            </div>
                        </div>
                        <div class="couse-feature ul-li-block">
                            <ul>
                                {{-- <li > @lang('labels.frontend.tutorial.chapters')
                                    <span>  {{$tutorial->chapterCount()}} </span></li> --}}
                                {{--<li>Language <span>English</span></li>--}}
                                <li class="d-inline-block w-100">@lang('labels.frontend.tutorial.category')<span class="text-right"><a
                                                href="{{route('tutorials.category',['category'=>$tutorial->category->slug])}}"
                                                target="_blank">{{$tutorial->category->name}}</a> </span></li>
                                <li> @lang('labels.frontend.tutorial.author') <span>

                                        @foreach($tutorial->teachers as $key=>$teacher)
                                            @php $key++ @endphp
                                            <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                                                {{$teacher->full_name}}@if($key < count($tutorial->teachers )), @endif
                                            </a>
                                        @endforeach

                                       </span>
                                </li>
                            </ul>

                        </div>

                        @if($recent_news->count() > 0)
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize">@lang('labels.frontend.tutorial.recent_news')</h2>
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
                                        <a href="{{route('blogs.index')}}">@lang('labels.frontend.tutorial.view_all_news')
                                            <i class="fas fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of tutorial details section
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
