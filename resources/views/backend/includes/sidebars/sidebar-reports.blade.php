@if (!$logged_in_user->hasRole('student') && ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access', 'module_access', 'test_access', 'question_access', 'bundle_access'])))
    @if ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin())
        <li class="nav-group {{ active_class(Active::checkUriPattern(['user/report*']), 'show') }}">
            <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern(['user/report*'])) }}"
                href="#">
                <i class="nav-icon icon-pie-chart"></i>@lang('backend/menus.backend.sidebar.reports.title')

            </a>
            <ul class="nav-group-items">
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(3) == 'sales' ? 'active' : '' }}"
                        href="{{ route('admin.reports.sales') }}">
                        @lang('backend/menus.backend.sidebar.reports.sales')
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(3) == 'students' ? 'active' : '' }}"
                        href="{{ route('admin.reports.students') }}">@lang('backend/menus.backend.sidebar.reports.students')
                    </a>
                </li>
            </ul>
        </li>
    @endif
@endif
