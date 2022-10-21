@extends('frontend.layouts.app')

@section('title', ($portfolio->meta_title) ? $portfolio->meta_title : app_name() )
@section('meta_description', $portfolio->meta_description)
@section('meta_keywords', $portfolio->meta_keywords)

@section('content')


    <!-- Start of portfolio single content
        ============================================= -->
    <section id="portfolio-detail" class="portfolio-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portfolio-details-content">
                        <div class="post-content-details">
                            @if($portfolio->image )

                                <div class="portfolio-detail-thumbnile mb35">
                                    <img src="{{asset('assets/images/porto/'.$portfolio->image->name)}}" alt="">
                                </div>
                            @endif

                            <h2>{{$portfolio->title}}</h2>

                            <div class="date-meta text-uppercase">


                                <span><i class="fas fa-tag"><a
                                                href="{{route('portfolios.category',['category' => $portfolio->category->slug])}}"> {{$portfolio->category->name}}</a></i></span>
                            </div>
                            <p>
                                {!! $portfolio->description !!}
                            </p>


                        </div>
                        <div class="portfolio-share-tag">
                            <div class="share-text float-left">
                                @lang('labels.frontend.portfolio.share_this_news')
                            </div>

                            <div class="share-social ul-li float-right">
                                <ul>
                                    <li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" href="http://twitter.com/share?url={{url()->current()}}&text={{$portfolio->title}}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a target="_blank" href="http://www.linkedin.com/shareArticle?url={{url()->current()}}&title={{$portfolio->title}}&summary={{substr(strip_tags($portfolio->content),0,40)}}..."><i class="fab fa-linkedin"></i></a></li>
                                    <li><a target="_blank" href="https://api.whatsapp.com/send?phone=&text={{url()->current()}}"><i class="fab fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="author-comment d-inline-block p-3   h-100 d-table text-center mx-auto">
                            <div class="author-img float-none">
                                <img src="{{$portfolio->author->picture}}" alt="">
                            </div>
                            <span class="mt-2  d-table-cell align-middle">BY:  <b>{{$portfolio->author->name}}</b></span>
                        </div> --}}

                        <div class="next-prev-post">
                            @if($previous != "")
                                <div class="next-post-item float-left">
                                    <a href="{{route('portfolios.show',['slug'=>$previous->slug ])}}"><i
                                                class="fas fa-arrow-circle-left"></i>Previous Post</a>
                                </div>
                            @endif

                            @if($next != "")
                                <div class="next-post-item float-right">
                                    <a href="{{route('portfolios.show',['slug'=>$next->slug ])}}">Next Post<i
                                                class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                @endif

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- End of portfolio single content
        ============================================= -->


@endsection
