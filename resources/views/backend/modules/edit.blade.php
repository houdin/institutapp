@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.modules.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px;
        }

    </style>

@endpush
@section('content')
    {!! Form::model($module, ['method' => 'PUT', 'route' => ['admin.modules.update', $module->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('backend/labels.backend.modules.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.modules.index') }}"
                   class="btn btn-success">@lang('backend/labels.backend.modules.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('formation_id', trans('backend/labels.backend.modules.fields.formation'), ['class' => 'control-label']) !!}
                    {!! Form::select('formation_id', $formations, old('formation_id'), ['class' => 'form-control select2']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('backend/labels.backend.modules.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.modules.fields.title'), 'required' => '']) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('slug', trans('backend/labels.backend.modules.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.modules.slug_placeholder')]) !!}
                </div>
                @if ($module->module_image)

                    <div class="col-12 col-lg-5 form-group">

                        {!! Form::label('module_image', trans('backend/labels.backend.modules.fields.module_image').' '.trans('backend/labels.backend.modules.max_file_size'), ['class' => 'control-label']) !!}
                        {!! Form::file('module_image', ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png', 'style' => 'margin-top: 4px;']) !!}
                        {!! Form::hidden('module_image_max_size', 8) !!}
                        {!! Form::hidden('module_image_max_width', 4000) !!}
                        {!! Form::hidden('module_image_max_height', 4000) !!}
                    </div>
                    <div class="col-lg-1 col-12 form-group">
                        <a href="{{ asset('uploads/'.$module->module_image) }}" target="_blank"><img
                                    src="{{ asset('uploads/'.$module->module_image) }}" height="65px"
                                    width="65px"></a>
                    </div>
                @else
                    <div class="col-12 col-lg-6 form-group">

                        {!! Form::label('module_image', trans('backend/labels.backend.modules.fields.module_image').' '.trans('backend/labels.backend.modules.max_file_size'), ['class' => 'control-label']) !!}
                        {!! Form::file('module_image', ['class' => 'form-control']) !!}
                        {!! Form::hidden('module_image_max_size', 8) !!}
                        {!! Form::hidden('module_image_max_width', 4000) !!}
                        {!! Form::hidden('module_image_max_height', 4000) !!}
                    </div>
                @endif

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('short_text', trans('backend/labels.backend.modules.fields.short_text'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('short_text', old('short_text'), ['class' => 'form-control ', 'placeholder' => trans('backend/labels.backend.modules.short_description_placeholder')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('full_text', trans('backend/labels.backend.modules.fields.full_text'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('full_text', old('full_text'), ['class' => 'form-control editor', 'placeholder' => '','id' => 'editor']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('downloadable_files', trans('backend/labels.backend.modules.fields.downloadable_files').' '.trans('backend/labels.backend.modules.max_file_size'), ['class' => 'control-label']) !!}
                    {!! Form::file('downloadable_files[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                         'id' => 'downloadable_files',
                        'accept' => "image/jpeg,image/gif,image/png,application/msword,audio/mpeg,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint,application/pdf,video/mp4"

                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if(count($module->downloadableMedia) > 0)
                                @foreach($module->downloadableMedia as $media)
                                    <p class="form-group">
                                        <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                           target="_blank">{{ $media->name }}
                                            ({{ $media->size }} KB)</a>
                                        <a href="#" data-media-id="{{$media->id}}"
                                           class="btn btn-xs btn-danger delete remove-file">@lang('backend/labels.backend.modules.remove')</a>
                                    </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('pdf_files', trans('backend/labels.backend.modules.fields.add_pdf'), ['class' => 'control-label']) !!}
                    {!! Form::file('add_pdf', [
                        'class' => 'form-control file-upload',
                         'id' => 'add_pdf',
                        'accept' => "application/pdf"
                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if($module->mediaPDF)
                                <p class="form-group">
                                    <a href="{{ asset('storage/uploads/'.$module->mediaPDF->name) }}"
                                       target="_blank">{{ $module->mediaPDF->name }}
                                        ({{ $module->mediaPDF->size }} KB)</a>
                                    <a href="#" data-media-id="{{$module->mediaPDF->id}}"
                                       class="btn btn-xs btn-danger delete remove-file">@lang('backend/labels.backend.modules.remove')</a>
                                    <iframe src="{{asset('storage/uploads/'.$module->mediaPDF->name)}}" width="100%" height="500px">
                                    </iframe>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('pdf_files', trans('backend/labels.backend.modules.fields.add_audio'), ['class' => 'control-label']) !!}
                    {!! Form::file('add_audio', [
                        'class' => 'form-control file-upload',
                         'id' => 'add_audio',
                        'accept' => "audio/mpeg3"
                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if($module->mediaAudio)
                                <p class="form-group">
                                    <a href="{{ asset('storage/uploads/'.$module->mediaAudio->name) }}"
                                       target="_blank">{{ $module->mediaAudio->name }}
                                        ({{ $module->mediaAudio->size }} KB)</a>
                                    <a href="#" data-media-id="{{$module->mediaAudio->id}}"
                                       class="btn btn-xs btn-danger delete remove-file">@lang('backend/labels.backend.modules.remove')</a>
                                    <audio id="player" controls>
                                        <source src="{{ $module->mediaAudio->url }}" type="audio/mp3" />
                                    </audio>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! Form::label('add_video', trans('backend/labels.backend.modules.fields.add_video'), ['class' => 'control-label']) !!}
                    {!! Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],($module->mediavideo) ? $module->mediavideo->type : null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' ]) !!}


                    {!! Form::text('video', ($module->mediavideo) ? $module->mediavideo->url : null, ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('backend/labels.backend.modules.enter_video_url'),'id'=>'video'  ]) !!}

                    {!! Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('backend/labels.backend.modules.enter_video_url'),'id'=>'video_file','accept' =>'video/mp4'  ]) !!}
                    <input type="hidden" name="old_video_file"
                           value="{{($module->mediavideo && $module->mediavideo->type == 'upload') ? $module->mediavideo->url  : ""}}">


                    @if($module->mediavideo && ($module->mediavideo->type == 'upload'))
                        <video width="300" class="mt-2 d-none video-player" controls>
                            <source src="{{($module->mediavideo && $module->mediavideo->type == 'upload') ? $module->mediavideo->url  : ""}}"
                                    type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    @endif

                    @lang('backend/labels.backend.modules.video_guide')
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3  form-group">
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, old('published'), []) !!}
                    {!! Form::label('published', trans('backend/labels.backend.modules.fields.published'), ['class' => 'control-label control-label font-weight-bold']) !!}
                </div>
                <div class="col-12  text-left form-group">
                    {!! Form::submit(trans('backend/strings.backend.general.app_update'), ['class' => 'btn  btn-primary']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script>
        $('.editor').each(function () {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',

                extraPlugins: 'smiley,lineutils,widget,codesnippet,prism',
            });

        });
        $(document).ready(function () {
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var parent = $(this).parent('.form-group');
                var confirmation = confirm('{{trans('backend/strings.backend.general.are_you_sure')}}')
                if (confirmation) {
                    var media_id = $(this).data('media-id');
                    $.post('{{route('admin.media.destroy')}}', {media_id: media_id, _token: '{{csrf_token()}}'},
                        function (data, status) {
                            if (data.success) {
                                parent.remove();
                            } else {
                                alert('Something Went Wrong')
                            }
                        });
                }
            })
        });

        var uploadField = $('input[type="file"]');


        $(document).on('change', 'input[name="module_image"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        });

        @if($module->mediavideo)
        @if($module->mediavideo->type !=  'upload')
        $('#video').removeClass('d-none').attr('required', true);
        $('#video_file').addClass('d-none').attr('required', false);
        $('.video-player').addClass('d-none');
        @elseif($module->mediavideo->type == 'upload')
        $('#video').addClass('d-none').attr('required', false);
        $('#video_file').removeClass('d-none').attr('required', false);
        $('.video-player').removeClass('d-none');
        @else
        $('.video-player').addClass('d-none');
        $('#video_file').addClass('d-none').attr('required', false);
        $('#video').addClass('d-none').attr('required', false);
        @endif
        @endif

        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true);
                    $('#video_file').addClass('d-none').attr('required', false);
                    $('.video-player').addClass('d-none')
                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false);
                    $('#video_file').removeClass('d-none').attr('required', true);
                    $('.video-player').removeClass('d-none')
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false);
                $('#video').addClass('d-none').attr('required', false)
            }
        })

    </script>
@endpush
