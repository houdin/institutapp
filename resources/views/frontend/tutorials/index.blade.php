@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.formation.formations').' | '. app_name() )

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
            background-color: #1d1e22;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: #fdd765 ;
            border: none;

        }
     .listing-filter-form select{
            height:50px!important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
    </style>
@endpush
@section('content')



    <!-- Start of tutorial section
        ============================================= -->
    <section id="tutorial-page" class="tutorial-page-section">
        <div class="container">
            <div id="search-formation" class="search-formation-section">


                <div class="search-formation mb30 relative-position ">
                    <form action="{{route('search')}}" method="get">

                        <div class="input-group search-group">
                            <input class="formation" name="q" type="text"
                                    placeholder="@lang('labels.frontend.home.search_formation_placeholder')">
                            <select name="category" class="select form-control">
                                @if(count($categories) > 0 )
                                    <option value="">@lang('labels.frontend.formation.select_category')</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>

                                    @endforeach
                                @else
                                    <option>>@lang('labels.frontend.home.no_data_available')</option>
                                @endif

                            </select>
                            <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
                                <button type="submit"
                                        value="Submit">@lang('labels.frontend.home.search_formation')</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
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

                    </div>

                    <div class="genius-post-item">
                        <div class="tab-container">
                            <div id="tab1" class="tab-content-1 pt35">
                                <div class="best-tutorial-area best-tutorial-v2">
                                    <div class="row">
                                        @if($tutorials->count() > 0)

                                            @foreach($tutorials as $tutorial)

                                                <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
                                                    <div class="best-tutorial-pic-text relative-position">
                                                        <div class="best-tutorial-pic relative-position"
                                                             @if($tutorial->image) style="background-image: url('{{asset('assets/images/tols/'.$tutorial->image->name)}}')" @endif>

                                                            {{-- @if($tutorial->trending == 1)
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                                </div>
                                                            @endif --}}


                                                            <div class="tutorial-rate ul-li">
                                                                <ul>
                                                                    @for($i=1; $i<=(int)$tutorial->rating; $i++)
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            <div class="tutorial-details-btn">

                                                                <a href="{{ route('tutorials.show', ['slug' => $tutorial->slug] ) }}">@lang('labels.frontend.formation.formation_detail')
                                                                    <i class="fas fa-arrow-right"></i></a>

                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-tutorial-text">

                                                            <div class="tutorial-title mb20 headline relative-position">
                                                                <h3>
                                                                    <a href="{{ route('tutorials.show', ['slug' => $tutorial->slug]) }}">{{$tutorial->title}}</a>
                                                                </h3>

                                                            </div>
                                                            <div class="tutorial-meta">
                                                                <span class="tutorial-category"><a
                                                                            href="{{route('tutorials.category',['category'=>$tutorial->category->slug])}}">{{$tutorial->category->name}}</a></span>
                                                                <span class="tutorial-author"><a href="#">{{ $tutorial->students()->count() }}
                                                                        @lang('labels.frontend.formation.students')</a></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>

                                    @endif

                                    <!-- /tutorial -->

                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                            <div id="tab2" class="tab-content-1">
                                <div class="tutorial-list-view">
                                    <table>
                                        <tr class="list-head">
                                            <th>@lang('labels.frontend.formation.tutorial_name')</th>
                                            <th>@lang('labels.frontend.formation.tutorial_type')</th>
                                            <th>@lang('labels.frontend.formation.starts')</th>
                                        </tr>

                                        @if($tutorials->count() > 0)

                                            @foreach($tutorials as $tutorial)

                                                <tr>
                                                    <td>
                                                        <div class="tutorial-list-img-text">
                                                            <div class="tutorial-list-img"
                                                                 @if($tutorial->image ) style="background-image: url({{asset('assets/images/tols/'.$tutorial->image->name)}})" @endif >
                                                            </div>
                                                            <div class="tutorial-list-text">
                                                                <h3>
                                                                    <a href="{{ route('tutorials.show', [ 'slug' => $tutorial->slug]) }}">{{$tutorial->title}}</a>
                                                                </h3>
                                                                <div class="tutorial-meta">
                                                                <span class="tutorial-category bold-font"><a
                                                                            href="{{ route('tutorials.show', ['slug' => $tutorial->slug]) }}">
                                                                        @if($tutorial->free == 1)
                                                                            {{trans('labels.backend.tutorials.fields.free')}}
                                                                        @else
                                                                            {{$appCurrency['symbol'].' '.$tutorial->price}}
                                                                        @endif
                                                                    </a></span>

                                                                    <div class="tutorial-rate ul-li">
                                                                        <ul>
                                                                            @for($i=1; $i<=(int)$tutorial->rating; $i++)
                                                                                <li><i class="fas fa-star"></i></li>
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="tutorial-type-list">
                                                            <span><a href="{{route('tutorials.category',['category'=>$tutorial->category->slug])}}">{{$tutorial->category->name}}</a></span>
                                                        </div>
                                                    </td>
                                                    <td>{{\Carbon\Carbon::parse($tutorial->start_date)->format('d M Y')}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">
                                                    <h3>@lang('labels.general.no_data_available')</h3>

                                                </td>
                                            </tr>
                                        @endif

                                    </table>
                                </div>
                            </div><!-- /tab-2 -->
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            {{ $tutorials->links() }}
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- End of tutorial section
        ============================================= -->

    {{-- <!-- Start of best tutorial
   =============================================  -->
    @include('frontend.layouts.partials._browse_tutorials')
    <!-- End of best tutorial
            ============================================= --> --}}


@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('tutorials.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush
