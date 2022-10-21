@if ($logged_in_user->hasRole('student'))
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(1) == 'invoices' ? 'active' : '' }}"
            href="{{ route('admin.invoices.index') }}">
            <i class="nav-icon icon-notebook"></i> <span
                class="title">@lang('backend/menus.backend.sidebar.invoices.title')</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(1) == 'certificates' ? 'active' : '' }}"
            href="{{ route('admin.certificates.index') }}">
            <i class="nav-icon icon-badge"></i> <span
                class="title">@lang('backend/menus.backend.sidebar.certificates.title')</span>
        </a>
    </li>
@endif
