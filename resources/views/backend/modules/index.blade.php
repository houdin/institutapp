@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.modules.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('backend/labels.backend.modules.title')</h3>
            @can('module_create')
                <div class="float-right">
                    <a href="{{ route('admin.modules.create') }}@if(request('formation_id')){{'?formation_id='.request('formation_id')}}@endif"
                       class="btn btn-success">@lang('backend/strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('formation_id', trans('backend/labels.backend.modules.fields.formation'), ['class' => 'control-label']) !!}
                    {!! Form::select('formation_id', $formations,  (request('formation_id')) ? request('formation_id') : old('formation_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'formation_id']) !!}
                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.modules.index',['formation_id'=>request('formation_id')]) }}"
                           style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('backend/labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="{{trashUrl(request()) }}"
                           style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('backend/labels.general.trash')}}</a>
                    </li>
                </ul>
            </div>

            @if(request('formation_id') != "" || request('show_deleted') != "")
                <div class="table-responsive">

                    <table id="myTable"
                           class="table table-bordered table-striped @can('module_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                        <tr>
                            @can('module_delete')
                                @if ( request('show_deleted') != 1 )
                                    <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/>
                                    </th>@endif
                            @endcan
                            <th>@lang('backend/labels.general.sr_no')</th>
                            <th>@lang('backend/labels.backend.modules.fields.title')</th>
                            <th>@lang('backend/labels.backend.modules.fields.published')</th>
                            @if( request('show_deleted') == 1 )
                                <th>@lang('backend/strings.backend.general.actions') &nbsp;</th>
                            @else
                                <th>@lang('backend/strings.backend.general.actions') &nbsp;</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            @endif

        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.modules.get_data')}}';


            @php
                $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
                $formation_id = (request('formation_id') != "") ? request('formation_id') : 0;
            $route = route('admin.modules.get_data',['show_deleted' => $show_deleted,'formation_id' => $formation_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');


            @if(request('formation_id') != "" || request('show_deleted') != "")

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        @if(request('show_deleted') != 1)
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        @endif
                    {
                        data: "DT_RowIndex", name: 'DT_RowIndex'
                    },
                    {data: "title", name: 'title'},
                    {data: "published", name: "published"},
                    {data: "actions", name: "actions"}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }
            });

            @endif

            @can('module_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.modules.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan


            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('backend/labels.backend.modules.select_formation')}}",
            });
            $(document).on('change', '#formation_id', function (e) {
                var formation_id = $(this).val();
                window.location.href = "{{route('admin.modules.index')}}" + "?formation_id=" + formation_id
            });
        });

    </script>
@endpush
