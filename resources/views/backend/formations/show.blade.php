@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.formations.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
            width: 70%;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }

        @media screen and (max-width: 768px) {

            ul.sorter li > span .btn {
                width: 30%;
            }

            ul.sorter li > span .title {
                padding-left: 15px;
                width: 70%;
                float: left;
                margin: 0 !important;
            }

        }


    </style>
@endpush

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title mb-0">@lang('backend/labels.backend.formations.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.teachers')</th>
                            <td>
                                @foreach ($formation->teachers as $singleTeachers)
                                    <span class="label label-info label-many">{{ $singleTeachers->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.title')</th>
                            <td>
                                @if($formation->published == 1)
                                    <a target="_blank"
                                       href="{{ route('formations.show', [$formation->slug]) }}">{{ $formation->title }}</a>
                                @else
                                    {{ $formation->title }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.slug')</th>
                            <td>{{ $formation->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.category')</th>
                            <td>{{ $formation->category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.description')</th>
                            <td>{!! $formation->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.price')</th>
                            <td>{{ ($formation->free == 1) ? trans('backend/labels.backend.formations.fields.free') : $formation->price.' '.$appCurrency['symbol'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.formation_image')</th>
                            <td>@if($formation->image)<a
                                        href="{{ $formation->image->featuredImageUrl(1) }}"
                                        target="_blank"><img
                                            src="{{ $formation->image->featuredImageUrl(1) }}"
                                            height="50px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.media_video')</th>
                            <td>
                                @if($formation->mediaVideo !=  null )
                                    <p class="form-group mb-0">
                                        <a href="{{$formation->mediaVideo->url}}"
                                           target="_blank">{{$formation->mediaVideo->url}}</a>
                                    </p>
                                @else
                                    <p>No Videos</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.start_date')</th>
                            <td>{{ $formation->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.published')</th>
                            <td>{{ Form::checkbox("published", 1, $formation->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>

                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.meta_title')</th>
                            <td>{{ $formation->meta_title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.meta_description')</th>
                            <td>{{ $formation->meta_description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.formations.fields.meta_keywords')</th>
                            <td>{{ $formation->meta_keywords }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            @if(count($formationTimeline) > 0)
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12  ">
                        <h4 class="">@lang('backend/labels.backend.formations.formation_timeline')</h4>
                        <p class="mb-0">@lang('backend/labels.backend.formations.listing_note')</p>
                        <p class="">@lang('backend/labels.backend.formations.timeline_description')</p>
                        <ul class="sorter d-inline-block">

                            @foreach($formationTimeline as $key=>$item)

                                @if(isset($item->model) && $item->model->published == 1)

                                    <li>
                                        <span data-id="{{$item->id}}" data-sequence="{{$item->sequence}}">
                                    @if($item->model_type == 'App\Models\Test')
                                        <p class="d-inline-block mb-0 btn btn-primary">
                                            @lang('backend/labels.backend.formations.test')
                                         </p>
                                    @elseif($item->model_type == 'App\Models\Module')
                                      <p class="d-inline-block mb-0 btn btn-success">
                                        @lang('backend/labels.backend.formations.module')
                                     </p>
                                     @endif
                                    @if($item->model)
                                    <p class="title d-inline ml-2">{{$item->model->title}}</p>
                                    @endif
                                     </span>

                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.formations.index') }}"
                           class="btn btn-default border float-left">@lang('backend/strings.backend.general.app_back_to_list')</a>

                        <a href="#" id="save_timeline"
                           class="btn btn-primary float-right">@lang('backend/labels.backend.formations.save_timeline')</a>

                    </div>

                </div>
            @endif
        </div>
    </div>
@stop

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>
    <script>
        $(function () {
            $('ul.sorter').amigoSorter({
                li_helper: "li_helper",
                li_empty: "empty",
            });
            $(document).on('click', '#save_timeline', function (e) {
                e.preventDefault();
                var list = [];
                $('ul.sorter li').each(function (key, value) {
                    key++;
                    var val = $(value).find('span').data('id');
                    list.push({id: val, sequence: key});
                });

                $.ajax({
                    method: 'POST',
                    url: "{{route('admin.formations.saveSequence')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        list: list
                    }
                }).done(function () {
                    location.reload();
                });
            })
        });

    </script>
@endpush
