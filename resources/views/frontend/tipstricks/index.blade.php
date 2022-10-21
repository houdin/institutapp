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

                    </div>

                    <div class="genius-post-item">
                        <div class="tab-container">

                            <div id="tab2" class="tab-content-1">
                                <div class="formation-list-view">


                                        @if($tipstricks->count() > 0)

                                        <ul class="list-group">
                                            @foreach($tipstricks as $tipstrick)

                                                    <li class="list-group-item bg-black-1 mb-3 rounded-lg">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h3>
                                                                <a href="{{ route('tipstrick.show', [ 'slug' => $tipstrick->slug]) }}">{{$tipstrick->title}}</a>
                                                                </h3>
                                                                <div class="formation-list-text">
                                                                    <h3>
                                                                        <a href="{{ route('tipstrick.show', [ 'slug' => $tipstrick->slug]) }}">{{$tipstrick->title}}</a>
                                                                    </h3>
                                                                    <div class="formation-meta">

                                                                        <div class="formation-rate ul-li">
                                                                            <ul>
                                                                                @for($i=1; $i<=(int)$tipstrick->rating; $i++)
                                                                                    <li><i class="fas fa-star"></i></li>
                                                                                    @endfor
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="formation-type-list">
                                                                    <span><a
                                                                            href="{{route('formations.category',['category'=>$tipstrick->category->slug])}}">{{$tipstrick->category->name}}</a></span>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                {{\Carbon\Carbon::parse($tipstrick->start_date)->format('d M Y')}}
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                        @else
                                            <ul class="list-group">
                                                <li class="list-group-item rounded-lg">
                                                    <h3>@lang('labels.general.no_data_available')</h3>

                                                </li>
                                            </ul>
                                        @endif

                                </div>
                            </div><!-- /tab-2 -->
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            {{ $tipstricks->links() }}
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

@push('after-scripts')
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
@endpush
