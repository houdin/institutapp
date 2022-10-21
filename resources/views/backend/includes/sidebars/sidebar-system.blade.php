@if ($logged_in_user->isAdmin())


    <li class="nav-title">
        @lang('backend/menus.backend.sidebar.system')
    </li>

    <li class="nav-group {{ active_class(Active::checkUriPattern('user/auth*'), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
            <i class="nav-icon icon-user"></i> @lang('backend/menus.backend.access.title')

            @if ($pending_approval > 0)
                <span class="badge badge-danger">{{ $pending_approval }}</span>
            @endif
        </a>

        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('user/auth/user*')) }}"
                    href="{{ route('admin.auth.user.index') }}">
                    @lang('backend/labels.backend.access.users.management')

                    @if ($pending_approval > 0)
                        <span class="badge badge-danger">{{ $pending_approval }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('user/auth/role*')) }}"
                    href="{{ route('admin.auth.role.index') }}">
                    @lang('backend/labels.backend.access.roles.management')
                </a>
            </li>
        </ul>
    </li>


    <!--==================================================================-->
    <li class="divider"></li>

    <li class="nav-group {{ active_class(Active::checkUriPattern('user/settings/*'), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern('user/settings*')) }}" href="#">
            <i class="nav-icon icon-settings"></i> @lang('backend/menus.backend.sidebar.settings.title')
        </a>

        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('user/settings/general')) }}"
                    href="{{ route('admin.general-settings') }}">
                    @lang('backend/menus.backend.sidebar.settings.general')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('user/settings/social')) }}"
                    href="{{ route('admin.social-settings') }}">
                    @lang('backend/menus.backend.sidebar.settings.social-login')
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-group {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
            href="#">
            <i class="nav-icon icon-list"></i> @lang('backend/menus.backend.sidebar.debug-site.title')
        </a>

        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                    href="{{ route('log-viewer::dashboard') }}">
                    @lang('backend/menus.backend.log-viewer.dashboard')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                    href="{{ route('log-viewer::logs.list') }}">
                    @lang('backend/menus.backend.log-viewer.logs')
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(1) == 'translation-manager' ? 'active' : '' }}"
            href="{{ asset('user/translations') }}">
            <i class="nav-icon icon-docs"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.translations.title')</span>
        </a>
    </li>
@endif
