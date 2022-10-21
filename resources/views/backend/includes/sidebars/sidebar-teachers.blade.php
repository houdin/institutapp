@if ($logged_in_user->isAdmin())
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'teachers' ? 'active' : '' }}"
            href="{{ route('admin.teachers.index') }}">
            <i class="nav-icon icon-directions"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.teachers.title')</span>
        </a>
    </li>
@endif
