@extends('backend.layouts.app')

@section('title', __('backend/labels.backend.access.users.management') . ' | ' . __('backend/labels.backend.access.users.deleted'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('backend/labels.backend.access.users.management')
                    <small class="text-muted">@lang('backend/labels.backend.access.users.deleted')</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('backend/labels.backend.access.users.table.last_name')</th>
                            <th>@lang('backend/labels.backend.access.users.table.first_name')</th>
                            <th>@lang('backend/labels.backend.access.users.table.email')</th>
                            <th>@lang('backend/labels.backend.access.users.table.confirmed')</th>
                            <th>@lang('backend/labels.backend.access.users.table.roles')</th>
                            <th>@lang('backend/labels.backend.access.users.table.other_permissions')</th>
                            <th>@lang('backend/labels.backend.access.users.table.social')</th>
                            <th>@lang('backend/labels.backend.access.users.table.last_updated')</th>
                            <th>@lang('backend/labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($users->count())
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $user->confirmed_label !!}</td>
                                    <td>{!! $user->roles_label !!}</td>
                                    <td>{!! $user->permissions_label !!}</td>
                                    <td>{!! $user->social_buttons !!}</td>
                                    <td>{{ $user->updated_at->diffForHumans() }}</td>
                                    <td>{!! $user->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">@lang('backend/strings.backend.access.users.no_deleted')</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $users->total() !!} {{ trans_choice('backend/labels.backend.access.users.table.total', $users->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
