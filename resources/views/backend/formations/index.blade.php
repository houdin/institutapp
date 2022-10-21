@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.formations.title') . ' | ' . app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('backend/labels.backend.formations.title')</h3>
            @can('formation_create')
                <div class="float-right">
                    <a href="{{ route('admin.formations.create') }}"
                        class="btn btn-success">@lang('backend/strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('admin.formations.index') }}"
                                style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{ trans('backend/labels.general.all') }}</a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="{{ route('admin.formations.index') }}?show_deleted=1"
                                style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{ trans('backend/labels.general.trash') }}</a>
                        </li>
                    </ul>
                </div>

                <table id="myTable"
                    class="table table-bordered table-striped @can('formation_delete') @if (request('show_deleted') != 1) dt-select @endif @endcan">
                    <thead>
                        <tr>
                            @can('formation_delete')
                                @if (request('show_deleted') != 1)
                                    <th style="text-align:center;"><input type="checkbox" class="mass"
                                            id="select-all" /></th>
                                @endif
                            @endcan


                            @if (Auth::user()->isAdmin())
                                <th>@lang('backend/labels.general.sr_no')</th>
                                <th>@lang('backend/labels.backend.formations.fields.teachers')</th>
                            @else
                                <th>@lang('backend/labels.general.sr_no')</th>
                            @endif

                            <th>@lang('backend/labels.backend.formations.fields.title')</th>
                            <th>@lang('backend/labels.backend.formations.fields.category')</th>
                            <th>@lang('backend/labels.backend.formations.fields.price') <br><small>(in
                                    {{ $appCurrency['symbol'] }})</small></th>
                            <th>@lang('backend/labels.backend.formations.fields.status')</th>
                            <th>@lang('backend/labels.backend.modules.title')</th>
                            @if (request('show_deleted') == 1)
                                <th>&nbsp; @lang('backend/strings.backend.general.actions')</th>
                            @else
                                <th>&nbsp; @lang('backend/strings.backend.general.actions')</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>
        $(document).ready(function() {
            var route = '{{ route('admin.formations.get_data') }}';

            @if (request('show_deleted') == 1)
                route = '{{ route('admin.formations.get_data', ['show_deleted' => 1]) }}';
            @endif

            @if (request('teacher_id') != '')
                route = '{{ route('admin.formations.get_data', ['teacher_id' => request('teacher_id')]) }}';
            @endif

            @if (request('cat_id') != '')
                route = '{{ route('admin.formations.get_data', ['cat_id' => request('cat_id')]) }}';
            @endif

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [{
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    @if (request('show_deleted') != 1)
                        { "data": function(data){
                        return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                        }, "orderable": false, "searchable":false, "name":"id" },
                    @endif
                    @if (Auth::user()->isAdmin())
                        {data: "DT_RowIndex", name: 'DT_RowIndex',searchable: false, orderable:false},
                        {data: "teachers", name: 'teachers'},

                    @else
                        {data: "DT_RowIndex", name: 'DT_RowIndex'},

                    @endif {
                        data: "title",
                        name: 'title'
                    },
                    {
                        data: "category",
                        name: 'category'
                    },
                    {
                        data: "price",
                        name: "price"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "modules",
                        name: "modules"
                    },
                    {
                        data: "actions",
                        name: "actions"
                    }
                ],
                @if (request('show_deleted') != 1)
                    columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                    ],
                @endif

                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{ $locale_full_name }}.json",
                    buttons: {
                        colvis: '{{ trans('datatable.colvis') }}',
                        pdf: '{{ trans('datatable.pdf') }}',
                        csv: '{{ trans('datatable.csv') }}',
                    }
                }
            });
            {{-- @can('formation_delete') --}}
            {{-- @if (request('show_deleted') != 1) --}}
            {{-- $('.actions').html('<a href="' + '{{ route('admin.formations.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>'); --}}
            {{-- @endif --}}
            {{-- @endcan --}}
        });
    </script>

@endpush