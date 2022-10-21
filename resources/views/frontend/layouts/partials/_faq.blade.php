
<section id="faq" class="faq-section {{isset($classes) ? $classes : '' }}">

    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">{{env('APP_NAME')}} @lang('labels.frontend.layouts.partials.faq')</span>
            <h2>@lang('labels.frontend.layouts.partials.faq_full')</span></h2>
        </div>
        @if(count($faqs)> 0)
        <div class="faq-tab">
            <div class="faq-tab-ques ul-li">
                <div class="tab-button text-center mb65 ">
                    <ul class="nav nav-tabs justify-content-center border-base-0" id="myTab" role="tablist">
                        @foreach($faqs as $key=>$faq)
                            <li class="nav-item ">
                                <a class="nav-link color-black-1 bg-base-3 {{ $key == 0 ? "active": ""}}" id="{{$faq->name}}-tab" data-toggle="tab" href="#{{$faq->name}}" role="tab" aria-controls="{{$faq->name}}" aria-selected="true">{{$faq->name}}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="tab-content tab-container" id="myTabContent">
                    @foreach($faqs as $key=>$faq)

                    <!-- tab -->
                        <div id="{{$faq->name}}" class="tab-pane fade {{ $key == 0 ? "show active": ""}} pt35" role="tabpanel" aria-labelledby="{{$faq->name}}-tab">
                            <div class="row">
                                @foreach($faq->faqs->take(4) as $item)
                                    <div class="col-md-6">
                                        <div class="ques-ans mb45 headline">
                                            <h3 class="color-base-3"> {{$item->question}}</h3>
                                            <p class="color-white-2">{{$item->answer}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <!-- #tab -->
                    @endforeach

                </div>
                <div class="view-all-btn bold-font {{isset($classes) ? 'text-white' : '' }}">
                    <a class="color-base-3" href="{{route('faqs')}}">{{trans('labels.frontend.layouts.partials.more_faqs')}} <i class="fas fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
          @else
            <h4>@lang('labels.general.no_data_available')</h4>
        @endif

    </div>
</section>
