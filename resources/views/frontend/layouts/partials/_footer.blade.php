<!-- Start of footer area
    ============================================= -->
@php
    $footer_data = json_decode(config('footer_data'));
@endphp
@if($footer_data != "")
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">
            <div class="footer-content pb10">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-widget ">
                            <div class="footer-logo mb35">
                                <img src="{{asset("assets/images/logos/".config('app.logo_w_image'))}}" alt="logo">
                            </div>
                            @if($footer_data->short_description->status == 1)
                                <div class="footer-about-text">
                                    <p>FX institut est un studio de création multidimensionnel spécialisé dans les domaines du design, du cinéma, des arts visuels et du développement qui dispose d'un programme de formation en ligne sur les effets visuels, la post-production et l'animation graphique dirigé par des professionnels...</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($footer_data->section1->status == 1)
                        @php
                            $section_data = section_filter($footer_data->section1)
                        @endphp

                        @include('frontend.layouts.partials._footer_section',['section_data' => $section_data])
                    @endif

                    @if($footer_data->section2->status == 1)
                        @php
                            $section_data = section_filter($footer_data->section2)
                        @endphp

                        @include('frontend.layouts.partials._footer_section',['section_data' => $section_data])
                    @endif

                    <div class="footer-menu-sociality ml-0 col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-social ul-li ">
                            <h2 class="widget-title">@lang('labels.frontend.layouts.partials.social_network')</h2>
                            <ul>
                                @foreach($footer_data->social_links->links as $item)
                                    <li><a href="{{$item->link}}"><i class="{{$item->icon}}"></i></a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            @if($footer_data->bottom_footer->status == 1)
            <div class="copy-right-menu">
                <div class="row">
                    @if($footer_data->copyright_text->status == 1)
                    <div class="col-md-6">
                        <div class="copy-right-text">
                            <p>Powered By <a href="https://fxinstitut.com/" target="_blank" class="mr-4"> FXinstitut</a>  {!!  $footer_data->copyright_text->text !!}</p>
                        </div>
                    </div>
                    @endif
                    @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                    <div class="col-md-6">
                        <div class="copy-right-menu-item float-right ul-li">
                            <ul>
                                @foreach($footer_data->bottom_footer_links->links as $item)
                                <li><a href="{{$item->link}}">{{$item->label}}</a></li>
                                @endforeach
                                @if(config('show_offers'))
                                    <li><a href="{{route('frontend.offers')}}">@lang('labels.frontend.layouts.partials.offers')</a> </li>
                                @endif
                                <li><a href="{{route('frontend.certificates.getVerificationForm')}}">@lang('labels.frontend.layouts.partials.certificate_verification')</a></li>
                            </ul>
                        </div>
                    </div>
                     @endif
                </div>
            </div>
            @endif
        </div>
    </section>
</footer>
@endif
<!-- End of footer area
============================================= -->
