<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('backend/menus.backend.access.users.main')</a>

            <div class="dropdown-menu" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.auth.user.index') }}">@lang('backend/menus.backend.access.users.all')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.create') }}">@lang('backend/menus.backend.access.users.create')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.deactivated') }}">@lang('backend/menus.backend.access.users.deactivated')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.deleted') }}">@lang('backend/menus.backend.access.users.deleted')</a>
            </div>
        </div><!--dropdown-->

        <!--<a class="btn" href="#">Static Link</a>-->
    </div><!--btn-group-->
</li>
