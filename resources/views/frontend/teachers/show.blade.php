@extends('frontend.layouts.app')
@push('after-styles')
    <style>
        .section-title-2 h2:after {
            background: #ffffff;
            bottom: 0px;
            position: relative;
        }
         .couse-pagination li.active {
             color: #333333!important;
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
            background-color:white;
            border:none;

        }
        ul.pagination{
            display: inline;
            text-align: center;
        }
    </style>
@endpush
@section('content')


    <!-- Start of teacher details area
        ============================================= -->
    <section id="teacher-details" class="teacher-details-area">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="teacher-details-content mb45">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="teacher-details-img">
                                    <img style="height: 100px" src="{{$teacher->picture}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="teacher-details-text">
                                    <div class="section-title-2 mb-2  headline text-left">
                                        <h2>{{$teacher->first_name}} <span>{{$teacher->last_name}}</span></h2>

                                    </div>

                                    <div class="teacher-address">
                                        <div class="address-details ul-li-block">
                                            <ul class="d-inline-block w-100">
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <span>{{$teacher->email}}</span>
                                                    </div>
                                                </li>
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-comments"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <a href="{{route('admin.messages',['teacher_id' => $teacher->id])}}"><span> @lang('labels.frontend.teacher.send_now') <i
                                                                        class="fa fa-arrow-right text-primary"></i></span></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-teacher mb45">
                        <div class="section-title-2  mb-0 headline text-left">
                            <h2>@lang('labels.frontend.teacher.formations_by_teacher')</h2>
                        </div>
                        @if(count($formations) > 0)
                            <div class="row">
                                @foreach($formations as $item)
                                    <div class="col-md-4">
                                        <div class="best-formation-pic-text relative-position ">
                                            <div class="best-formation-pic relative-position"
                                                 @if($item->formation_image) style="background-image:url({{asset('storage/uploads/'.$item->formation_image)}}) " @endif >

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.frontend.badges.trending')</span>
                                                    </div>
                                                @endif
                                                    @if($item->free == 1)
                                                        <div class="trend-badge-3 text-center text-uppercase">
                                                            <i class="fas fa-bolt"></i>
                                                            <span>@lang('labels.backend.formations.fields.free')</span>
                                                        </div>
                                                    @endif
                                                <div class="formation-price text-center gradient-bg">
                                                    @if($item->free == 1)
                                                        <span> {{trans('labels.backend.formations.fields.free')}}</span>
                                                    @else
                                                       <span>{{$appCurrency['symbol'].' '.$item->price}}</span>
                                                    @endif
                                                </div>
                                                <div class="formation-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                                <div class="formation-details-btn">
                                                    <a class="text-uppercase"
                                                       href="{{ route('formations.show', [$item->slug]) }}">@lang('labels.frontend.teacher.formation_detail')
                                                        <i
                                                                class="fas fa-arrow-right"></i></a>
                                                </div>
                                                <div class="blakish-overlay"></div>
                                            </div>
                                            <div class="best-formation-text">
                                                <div class="formation-title mb20 headline relative-position">
                                                    <h3>
                                                        <a href="{{ route('formations.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h3>
                                                </div>
                                                <div class="formation-meta">
                                            <span class="formation-category"><a
                                                        href="#">{{$item->category->name}}</a></span>
                                                    <span class="formation-author">
                                                <a href="#">
                                                    {{ $item->students()->count() }}
                                                    @lang('labels.frontend.teacher.students')</a>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                            <div class="couse-pagination text-center ul-li">
                                {{ $formations->links() }}
                            </div>

                        @else
                            <p>@lang('labels.general.no_data_available')</p>
                        @endif
                    </div>


                </div>

                @include('frontend.layouts.partials._right-sidebar')

            </div>
        </div>
    </section>
    <!-- End  of teacher details area
        ============================================= -->

@endsection
