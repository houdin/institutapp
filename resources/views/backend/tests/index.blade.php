@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.tests.title').' | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('backend/labels.backend.tests.title')</h3>
            @can('test_create')
                <div class="float-right">
                    <a href="{{ route('admin.tests.create') }}"
                       class="btn btn-success">@lang('backend/strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('formation_id', trans('backend/labels.backend.lessons.fields.formation'), ['class' => 'control-label']) !!}
                    {!! Form::select('formation_id', $formations,  (request('formation_id')) ? request('formation_id') : old('formation_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'formation_id']) !!}
                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.tests.index',['formation_id'=>request('formation_id')]) }}"
                           style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('backend/labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="{{trashUrl(request()) }}"
                           style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('backend/labels.general.trash')}}</a>
                    </li>
                </ul>
            </div>

            @if(request('formation_id') != "" || request('show_deleted') == 1)


            <table id="myTable"
                   class="table table-bordered table-striped @can('test_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                <tr>
                    @can('test_delete')
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/>
                            </th>@endif
                    @endcan
                    <th>@lang('backend/labels.general.sr_no')</th>
                    <th>@lang('backend/labels.backend.tests.fields.formation')</th>
                    <th>@lang('backend/labels.backend.tests.fields.title')</th>
                    <th>@lang('backend/labels.backend.tests.fields.questions')</th>
                    <th>@lang('backend/labels.backend.tests.fields.published')</th>
                    @if( request('show_deleted') == 1 )
                        <th>@lang('backend/labels.general.actions')</th>

                    @else
                        <th>@lang('backend/labels.general.actions')</th>
                    @endif
                </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
            @endif
        </div>
    </div>
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.tests.get_data')}}';


            @php
                $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
                $formation_id = (request('formation_id') != "") ? request('formation_id') : 0;
            $route = route('admin.tests.get_data',['show_deleted' => $show_deleted,'formation_id' => $formation_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');

            @if(request('show_deleted') == 1 ||  request('formation_id') != "")

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
                            columns: [ 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5]
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
                    {data: "DT_RowIndex", name: 'DT_RowIndex'},
                    {data: "formation", name: 'formation'},
                    {data: "title", name: 'title'},
                    {data: "questions", name: "questions"},
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



            $(document).on('change', '#formation_id', function (e) {
                var formation_id = $(this).val();
                window.location.href = "{{route('admin.tests.index')}}" + "?formation_id=" + formation_id
            });
            @can('test_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.tests.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan

            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('backend/labels.backend.lessons.select_formation')}}",
            });

        });

    </script>

@endpush
