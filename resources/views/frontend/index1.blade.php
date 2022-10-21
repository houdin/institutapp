@extends('frontend.layouts.app')

@section('title', trans('labels.frontend.home.title') . ' | ' . app_name())
@section('meta_description', '')
@section('meta_keywords', '')


@push('after-styles')
    <style>
        /*.address-details.ul-li-block{*/
        /*line-height: 60px;*/
        /*}*/
        .teacher-img-content .teacher-social-name {
            max-width: 67px;
        }

        .my-alert {
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }
    </style>
@endpush

@section('content')

    <!-- Start of slider section
                ============================================= -->
    @if (session()->has('alert'))
        <div class="alert alert-light alert-dismissible fade my-alert show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ session('alert') }}</strong>
        </div>
    @endif

    <section id="home-slider-container">
        <div class="container">
            <div class="row slider-section postion-relative" style="z-index: -1">

                <div class="col-lg-2 pr-0 d-none d-md-none d-sm-none d-lg-block">
                    @include('frontend.layouts.partials._home_download')
                </div>

                <div class="col-md-8 col-lg-7">
                    @include('frontend.layouts.partials._slider')
                </div>

                <div class="col-md-4 col-lg-3 pl-0">
                    {{-- //////  HEADER PRODUCT /////// --}}
                    <div class="slide-product">
                        @if ($product_head->image)
                            <img src="{{ asset('assets/images/pdts/' . $product_head->image->name) }}" alt=""
                                height="100%" width="auto">
                        @endif
                        <div class="mx-auto">
                            <span class="text-center">{{ $product_head->title }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    @if ($sections->latest_news->status == 1)
        <!-- Start latest section
            ============================================= -->
        @include('frontend.layouts.partials._latest_news')
        <!-- End latest section
                ============================================= -->
    @endif


    {{--
    @if ($sections->popular_formations->status == 1)
        @include('frontend.layouts.partials._popular_formations')
    @endif --}}

    @if ($sections->portfolio->status == 1)
        <!-- Start of gallery
            ============================================= -->
        @include('frontend.layouts.partials._gallery_home')
        <!-- End of gallery
                ============================================= -->
    @endif



    @if ($sections->premium->status == 1)
        <!-- Start of premium
            ============================================= -->
        @include('frontend.layouts.partials._premium_home')
        <!-- End of premium
                ============================================= -->
    @endif


    @if ($sections->faq->status == 1)
        <!-- Start FAQ section
            ============================================= -->
        @include('frontend.layouts.partials._faq')
        <!-- End FAQ section
                ============================================= -->
    @endif

@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
@endpush
