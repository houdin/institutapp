@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.modules.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('backend/labels.backend.modules.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.formation')</th>
                            <td>{{ $module->formation->title or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.title')</th>
                            <td>{{ $module->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.slug')</th>
                            <td>{{ $module->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.module_image')</th>
                            <td>@if($module->module_image)<a href="{{ asset('storage/uploads/' . $module->module_image) }}" target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $module->module_image) }}" height="100px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.short_text')</th>
                            <td>{!! $module->short_text !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.full_text')</th>
                            <td>{!! $module->full_text !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.position')</th>
                            <td>{{ $module->position }}</td>
                        </tr>

                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.media_pdf')</th>
                            <td>
                                @if($module->mediaPDF != null )
                                <p class="form-group">
                                    <a href="{{$module->mediaPDF->url}}" target="_blank">{{$module->mediaPDF->url}}</a>
                                </p>
                                @else
                                    <p>No PDF</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.media_audio')</th>
                            <td>
                                @if($module->mediaAudio != null )
                                <p class="form-group">
                                    <a href="{{$module->mediaAudio->url}}" target="_blank">{{$module->mediaAudio->url}}</a>
                                </p>
                                @else
                                    <p>No Audio</p>
                                @endif
                            </td>
                        </tr>

                        <tr>

                            <th>@lang('backend/labels.backend.modules.fields.downloadable_files')</th>
                            <td>
                                @if(count($module->downloadableMedia) > 0 )
                                    @foreach($module->downloadableMedia as $media)
                                        <p class="form-group">
                                            <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                               target="_blank">{{ $media->name }}
                                                ({{ $media->size }} KB)</a>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No Files</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.media_video')</th>
                            <td>
                                @if($module->mediaVideo !=  null )
                                        <p class="form-group">
                                           <a href="{{$module->mediaVideo->url}}" target="_blank">{{$module->mediaVideo->url}}</a>
                                        </p>
                                @else
                                    <p>No Videos</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('backend/labels.backend.modules.fields.published')</th>
                            <td>{{ Form::checkbox("published", 1, $module->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->



            <a href="{{ route('admin.modules.index') }}"
               class="btn btn-default border">@lang('backend/strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop
