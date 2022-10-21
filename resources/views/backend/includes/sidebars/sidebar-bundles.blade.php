@if (!$logged_in_user->hasRole('student') && ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access', 'module_access', 'test_access', 'question_access', 'bundle_access'])))
    @can('bundle_access')
        <li class="nav-item ">
            <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                href="{{ route('admin.bundles.index') }}">
                <i class="nav-icon icon-layers"></i>
                <span class="title">@lang('backend/menus.backend.sidebar.bundles.title')</span>
            </a>
        </li>
    @endcan
@endif
