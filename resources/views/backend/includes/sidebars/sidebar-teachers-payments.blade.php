@if ($logged_in_user->hasRole('teacher'))
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'payments' ? 'active' : '' }}"
            href="{{ route('admin.payments') }}">
            <i class="nav-icon icon-wallet"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.payments.title')</span>
        </a>
    </li>
@endif
