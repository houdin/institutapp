
<!-- Start popular formation
       ============================================= -->
@if(count($portfolios) > 0)
    <section id="popular-portfolio" class="popular-portfolio-section pb-5 {{isset($class) ? $class : ''}}">
        <div class="container">
            <div class="section-title mb20 headline text-left ">
                <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.view_all_news'){{--Visualiser--}}</span>
                <h2>@lang('labels.frontend.layouts.partials.view_all_news'){{--Notre <span>Galerie.</span>--}}</h2>
            </div>
            <div id="portfolio-slide-item" class="portfolio-slide owl-carousel owl-theme owl-responsive-1000">
                @foreach($portfolios as $item)
                    <div class="portfolio-item-pic-text ">
                        <div class="portfolio-pic relative-position mb25" @if($item->image)  style="background-image: url({{asset('storage/uploads/porto/'.$item->image->name)}})" @endif>

                            <div class="overlay"></div>
                            <div class="portfolio-details-btn">
                                <a class="text-uppercase" href="{{ route('formations.show', [$item->slug]) }}">{{$item->title}}<i
                                            class="fas fa-arrow-right"></i></a>
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
