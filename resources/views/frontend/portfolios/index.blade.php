@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.portfolio.portfolios').' | '. app_name() )


@section('content')

        <!-- Start of portfolio section
            ============================================= -->
    <section id="portfolio-page" class="portfolio-page-section">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="short-filter-tab">
                        <div class="shorting-filter w-50 d-inline float-left mr-3">
                            <span>@lang('labels.frontend.portfolio.sort_by')</span>
                            <select id="sortBy" class="form-control d-inline w-50">
                                <option value="">@lang('labels.frontend.portfolio.none')</option>
                                <option value="popular">@lang('labels.frontend.portfolio.popular')</option>
                                <option value="trending">@lang('labels.frontend.portfolio.trending')</option>
                                <option value="featured">@lang('labels.frontend.portfolio.featured')</option>
                            </select>
                        </div>

                        {{-- <div class="tab-button blog-button ul-li text-center float-right">
                            <ul class="product-tab">
                                <li class="active" rel="tab1"><i class="fas fa-th"></i></li>
                                <li rel="tab2"><i class="fas fa-list"></i></li>
                            </ul>
                        </div> --}}

                    </div>

                    <div class="genius-post-item">
                        <div class="tab-container">
                            <div id="tab1" class="tab-content-1 pt35">
                                <div class="best-portfolio-area best-portfolio-v2">
                                    <div class="row">
                                        @if($portfolios->count() > 0)

                                        @foreach($portfolios as $portfolio)
                                        <div class="col-md-4 col-sm-6 px-1">
                                            <div class="best-portfolio-pic-text relative-position pt-2">

                                                    <div class="best-portfolio-pic relative-position"

                                                             @if($portfolio->image ) style="background-image: url('{{asset('assets/images/porto/'.$portfolio->image->name)}}')" @endif>


                                                            <div class="portfolio-rate ul-li">
                                                                <ul>
                                                                    @for($i=1; $i<=(int)$portfolio->rating; $i++)
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            <div class="portfolio-details-btn">

                                                                <a href="{{ route('portfolios.show', ['slug' => $portfolio->slug] ) }}">{{ $portfolio->title }}
                                                                    <i class="fas fa-arrow-right"></i></a>

                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                    </div>


                                            </div>
                                        </div>
                                        @endforeach

                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>

                                    @endif

                                    <!-- /portfolio -->

                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                        </div>
                        {{-- <div class="couse-pagination text-center ul-li">
                            {{ $portfolios->links() }}
                        </div> --}}
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- End of portfolio section
        ============================================= -->

    {{-- <!-- Start of best portfolio--}}
   {{-- =============================================  --> --}}
    {{-- @include('frontend.layouts.partials._browse_portfolios') --}}
    {{-- <!-- End of best portfolio --}}
    {{-- ============================================= --> --}}



@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('portfolios.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush
