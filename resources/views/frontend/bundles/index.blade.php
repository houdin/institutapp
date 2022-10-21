@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.formation.bundles').' | '. app_name() )

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
        .listing-filter-form select{
            height:50px!important;
        }

        .best-formation-pic-text .best-formation-text {
            padding: 20px;
        }
    </style>
@endpush
@section('content')


    <!-- Start of formation section
        ============================================= -->
    <section id="formation-page" class="formation-page-section">
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
                            <span>@lang('labels.frontend.formation.sort_by')</span>
                            <select id="sortBy" class="form-control d-inline w-50">
                                <option value="">@lang('labels.frontend.formation.none')</option>
                                <option value="popular">@lang('labels.frontend.formation.popular')</option>
                                <option value="trending">@lang('labels.frontend.formation.trending')</option>
                                <option value="featured">@lang('labels.frontend.formation.featured')</option>
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
                                <div class="best-formation-area best-formation-v2">
                                    <div class="row">
                                        @if(count($bundles) > 0 )
                                        @foreach($bundles as $bundle)

                                            <div class="col-md-4">
                                                <div class="best-formation-pic-text relative-position">
                                                    <div class="best-formation-pic relative-position"
                                                         @if($bundle->formation_image != "") style="background-image: url('{{asset('storage/uploads/'.$bundle->formation_image)}}')" @endif>

                                                        @if($bundle->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.frontend.badges.trending')</span>
                                                            </div>
                                                        @endif
                                                            @if($bundle->free == 1)
                                                                <div class="trend-badge-3 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span>@lang('labels.backend.formations.fields.free')</span>
                                                                </div>
                                                            @endif
                                                        <div class="formation-price text-center gradient-bg">

                                                            @if($bundle->free == 1)
                                                                <span>{{trans('labels.backend.bundles.fields.free')}}</span>
                                                            @else
                                                                <span> {{$appCurrency['symbol'].' '.$bundle->price}}</span>
                                                            @endif
                                                        </div>
                                                        <div class="formation-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$bundle->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                        <div class="formation-details-btn">
                                                            <a href="{{ route('bundles.show', [$bundle->slug]) }}">@lang('labels.frontend.formation.bundle_detail')
                                                                <i class="fas fa-arrow-right"></i></a>
                                                        </div>
                                                        <div class="blakish-overlay"></div>
                                                    </div>
                                                    <div class="best-formation-text">
                                                        <div class="formation-title mb20 headline relative-position">
                                                            <h3>
                                                                <a href="{{ route('bundles.show', [$bundle->slug]) }}">{{$bundle->title}}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="formation-meta">
                                                            <span class="formation-category"><a
                                                                        href="{{route('formations.category',['category'=>$bundle->category->slug])}}">{{$bundle->category->name}}</a></span>
                                                            <span class="formation-author"><a href="#">{{ $bundle->students()->count() }}
                                                                    @lang('labels.frontend.formation.students')</a></span>
                                                            <span class="formation-author mr-0">{{ $bundle->formations()->count() }}

                                                                @if($bundle->formations()->count() > 1 )
                                                                    @lang('labels.frontend.formation.formations')
                                                                @else
                                                                    @lang('labels.frontend.formation.formation')
                                                                @endif   </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                        @else
                                            <div class="col-12">
                                            <h4>@lang('labels.general.no_data_available')</h4>
                                            </div>
                                        @endif

                                    <!-- /formation -->
                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                            {{-- <div id="tab2" class="tab-content-1">
                                <div class="formation-list-view">
                                    <table>
                                        <tr class="list-head">
                                            <th>@lang('labels.frontend.formation.formation_name')</th>
                                            <th>@lang('labels.frontend.formation.formation_type')</th>
                                            <th>@lang('labels.frontend.formation.starts')</th>
                                        </tr>
                                        @if(count($bundles) > 0 )
                                            @foreach($bundles as $bundle)

                                                <tr>
                                                    <td>
                                                        <div class="formation-list-img-text">
                                                            <div class="formation-list-img"
                                                                 @if($bundle->formation_image != "") style="background-image: url({{asset('storage/uploads/'.$bundle->formation_image)}})" @endif >
                                                            </div>
                                                            <div class="formation-list-text">
                                                                <h3>
                                                                    <a href="{{ route('bundles.show', [$bundle->slug]) }}">{{$bundle->title}}</a>
                                                                </h3>
                                                                <div class="formation-meta">
                                                                <span class="formation-category bold-font"><a
                                                                            href="{{ route('bundles.show', [$bundle->slug]) }}">

                                                                         @if($bundle->free == 1)
                                                                            {{trans('labels.backend.bundles.fields.free')}}
                                                                        @else
                                                                            {{$appCurrency['symbol'].' '.$bundle->price}}
                                                                        @endif
                                                                    </a></span>

                                                                    <div class="formation-rate ul-li">
                                                                        <ul>
                                                                            @for($i=1; $i<=(int)$bundle->rating; $i++)
                                                                                <li><i class="fas fa-star"></i></li>
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="formation-type-list">
                                                            <span><a href="{{route('formations.category',['category'=>$bundle->category->slug])}}">{{$bundle->category->name}}</a></span>
                                                        </div>
                                                    </td>
                                                    <td>{{\Carbon\Carbon::parse($bundle->start_date)->format('d M Y')}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">
                                                    <h4>@lang('labels.general.no_data_available')</h4>

                                                </td>
                                            </tr>

                                        @endif


                                    </table>
                                </div>
                            </div><!-- /tab-2 --> --}}
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            {{ $bundles->links() }}
                        </div>
                    </div>


                </div>

                {{-- <div class="col-md-3">
                    <div class="side-bar">

                        <div class="side-bar-widget  first-widget">
                            <h2 class="widget-title text-capitalize">@lang('labels.frontend.formation.find_your_bundle')</h2>
                            <div class="listing-filter-form pb30">
                                <form action="{{route('search-bundle')}}" method="get">

                                    <div class="filter-search mb20">
                                        <label class="text-uppercase">@lang('labels.frontend.formation.category')</label>
                                        <select name="category" class="form-control listing-filter-form select">
                                            <option value="">@lang('labels.frontend.formation.select_category')</option>
                                            @if(count($categories) > 0)
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                                @endforeach
                                            @endif

                                        </select>
                                    </div>


                                    <div class="filter-search mb20">
                                        <label>@lang('labels.frontend.formation.full_text')</label>
                                        <input type="text" class="" name="q" placeholder="{{trans('labels.frontend.formation.looking_for')}}">
                                    </div>
                                    <button class="genius-btn gradient-bg text-center text-uppercase btn-block text-white font-weight-bold"
                                            type="submit">@lang('labels.frontend.formation.find_formations') <i
                                                class="fas fa-caret-right"></i></button>
                                </form>

                            </div>
                        </div>

                        @if($recent_news->count() > 0)
                            <div class="side-bar-widget">
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
                                            <i class="fas fa-chevron-circle-right"></i></a>
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
                </div> --}}
            </div>
        </div>
    </section>
    <!-- End of formation section
        ============================================= -->

    <!-- Start of best formation
   =============================================  -->
    @include('frontend.layouts.partials._browse_formations')
    <!-- End of best formation
            ============================================= -->


@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('bundles.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush
