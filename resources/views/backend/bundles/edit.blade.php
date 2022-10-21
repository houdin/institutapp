@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.bundles.title').' | '.app_name())

@section('content')

    {!! Form::model($bundle, ['method' => 'PUT', 'route' => ['admin.bundles.update', $bundle->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('backend/labels.backend.bundles.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.bundles.index') }}"
                   class="btn btn-success">@lang('backend/labels.backend.bundles.view')</a>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('formations',trans('backend/labels.backend.bundles.fields.formations'), ['class' => 'control-label']) !!}
                    {!! Form::select('formations[]', $formations, old('teachers') ? old('teachers') : $bundle->formations->pluck('id')->toArray(), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple']) !!}
                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="{{route('admin.formations.create')}}">{{trans('backend/labels.backend.bundles.add_formations')}}</a>
                </div>
            </div>


            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('category_id',trans('backend/labels.backend.bundles.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="{{route('admin.categories.index').'?create'}}">{{trans('backend/labels.backend.bundles.add_categories')}}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('backend/labels.backend.bundles.fields.title').' *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('slug', trans('backend/labels.backend.bundles.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('backend/labels.backend.bundles.slug_placeholder')]) !!}
                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('description',trans('backend/labels.backend.bundles.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('backend/labels.backend.bundles.fields.description')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('price', trans('backend/labels.backend.bundles.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']) !!}
                    {!! Form::number('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.bundles.fields.price') ,'pattern' => "[0-9]"]) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">

                    {!! Form::label('formation_image', trans('backend/labels.backend.bundles.fields.formation_image'), ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::file('formation_image', ['class' => 'form-control']) !!}
                    {!! Form::hidden('formation_image_max_size', 8) !!}
                    {!! Form::hidden('formation_image_max_width', 4000) !!}
                    {!! Form::hidden('formation_image_max_height', 4000) !!}
                    @if ($bundle->formation_image)
                        <a href="{{ asset('storage/uploads/'.$bundle->formation_image) }}" target="_blank"><img
                                    height="50px" src="{{ asset('storage/uploads/'.$bundle->formation_image) }}" class="mt-1"></a>
                    @endif
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('start_date', trans('backend/labels.backend.bundles.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('backend/labels.backend.bundles.fields.start_date').' (Ex . 2019-01-01)']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, old('published'), []) !!}
                        {!! Form::label('published', trans('backend/labels.backend.bundles.fields.published'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('featured', 0) !!}
                        {!! Form::checkbox('featured', 1, old('featured'), []) !!}
                        {!! Form::label('featured',  trans('backend/labels.backend.bundles.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('trending', 0) !!}
                        {!! Form::checkbox('trending', 1, old('trending'), []) !!}
                        {!! Form::label('trending',  trans('backend/labels.backend.bundles.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('popular', 0) !!}
                        {!! Form::checkbox('popular', 1, old('popular'), []) !!}
                        {!! Form::label('popular',  trans('backend/labels.backend.bundles.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('free', 0) !!}
                        {!! Form::checkbox('free', 1, old('free'), []) !!}
                        {!! Form::label('free',  trans('backend/labels.backend.bundles.fields.free'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('meta_title',trans('backend/labels.backend.bundles.fields.meta_title'), ['class' => 'control-label']) !!}
                    {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.bundles.fields.meta_title')]) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_description',trans('backend/labels.backend.bundles.fields.meta_description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.bundles.fields.meta_description')]) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_keywords',trans('backend/labels.backend.bundles.fields.meta_keywords'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => trans('backend/labels.backend.bundles.fields.meta_keywords')]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('backend/strings.backend.general.app_update'), ['class' => 'btn btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('backend/labels.backend.bundles.select_category')}}",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{trans('backend/labels.backend.bundles.select_formations')}}",
            });
        });
        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })

    </script>

@endpush
