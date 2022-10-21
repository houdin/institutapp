@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.formation.formations').' | '. app_name() )


@section('content')



        <!-- Start of formation section
            ============================================= -->
    <section id="formation-page" class="formation-page-section">
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
                                        @if($formations->count() > 0)

                                        @foreach($formations as $formation)

                                                <div class="col-md-4">
                                                    <div class="best-formation-pic-text relative-position">
                                                        <div class="best-formation-pic relative-position"

                                                             @if( $formation->image ) style="background-image: url('{{ $formation->featured_image_url(4) }}')" @endif>

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
                                                            <div class="formation-price text-center gradient-bg">
                                                                @if($formation->free == 1)
                                                                    <span>{{trans('labels.backend.formations.fields.free')}}</span>
                                                                @else
                                                                    <span> {{$appCurrency['symbol'].' '.$formation->price}}</span>
                                                                @endif
                                                            </div>

                                                            <div class="formation-rate ul-li">
                                                                <ul>
                                                                    @for($i=1; $i<=(int)$formation->rating; $i++)
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            <div class="formation-details-btn">

                                                                <a href="{{ route('formations.show', ['slug' => $formation->slug] ) }}">@lang('labels.frontend.formation.formation_detail')
                                                                    <i class="fas fa-arrow-right"></i></a>

                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-formation-text">
                                                            <div class="formation-title mb20 headline relative-position">
                                                                <h3>
                                                                    <a href="{{ route('formations.show', ['slug' => $formation->slug]) }}">{{$formation->title}}</a>
                                                                </h3>

                                                            </div>
                                                            <div class="formation-meta">
                                                                <span class="formation-category"><a
                                                                            href="{{route('formations.category',['category'=>$formation->category->slug])}}">{{$formation->category->name}}</a></span>
                                                                <span class="formation-author"><a href="#">{{ $formation->students()->count() }}
                                                                        @lang('labels.frontend.formation.students')</a></span>
                                                            </div>

                                                            <add-cart-icon :product_id="'{{ $formation->id }}'" @add-to-cart="addToCart" type="product">

                                                        </add-cart-icon>
                                                        <div class="ratings">
                                                            <p class="pull-right"><small class="text-muted">{{ $formation->reviews()->count() }} reviews</small></p>
                                                            <review-stars :stars="'{{ round($formation->reviews()->avg('rating'), PHP_ROUND_HALF_UP) }}'">

                                                            </review-stars>
                                                        </div><!-- /.rating -->
                                                    </div>{{-- best-formation-text  --}}
                                                    </div>
                                                </div>
                                            @endforeach

                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>

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

                                        @if($formations->count() > 0)

                                            @foreach($formations as $formation)

                                                <tr>
                                                    <td>
                                                        <div class="formation-list-img-text">
                                                            <div class="formation-list-img"
                                                                 @if($formation->image ) style="background-image: url({{asset('storage/uploads/fmts/'.$formation->image->name)}})" @endif >
                                                            </div>
                                                            <div class="formation-list-text">
                                                                <h3>
                                                                    <a href="{{ route('formations.show', [ 'slug' => $formation->slug]) }}">{{$formation->title}}</a>
                                                                </h3>
                                                                <div class="formation-meta">
                                                                <span class="formation-category bold-font"><a
                                                                            href="{{ route('formations.show', ['slug' => $formation->slug]) }}">
                                                                        @if($formation->free == 1)
                                                                            {{trans('labels.backend.formations.fields.free')}}
                                                                        @else
                                                                            {{$appCurrency['symbol'].' '.$formation->price}}
                                                                        @endif
                                                                    </a></span>

                                                                    <div class="formation-rate ul-li">
                                                                        <ul>
                                                                            @for($i=1; $i<=(int)$formation->rating; $i++)
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
                                                            <span><a href="{{route('formations.category',['category'=>$formation->category->slug])}}">{{$formation->category->name}}</a></span>
                                                        </div>
                                                    </td>
                                                    <td>{{\Carbon\Carbon::parse($formation->start_date)->format('d M Y')}}</td>
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
                            </div><!-- /tab-2 --> --}}
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            {{-- {{ $formations->links() }} --}}
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- End of formation section
        ============================================= -->

    {{-- <!-- Start of best formation--}}
   {{-- =============================================  --> --}}
    {{-- @include('frontend.layouts.partials._browse_formations') --}}
    {{-- <!-- End of best formation --}}
    {{-- ============================================= --> --}}



@endsection

{{-- @push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('formations.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush --}}
