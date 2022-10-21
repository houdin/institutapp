@if ($logged_in_user->isAdmin())
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'contact-requests' ? 'active' : '' }}"
            href="{{ route('admin.contact-requests.index') }}">
            <i class="nav-icon icon-envelope-letter"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.contacts.title')</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'coupons' ? 'active' : '' }}"
            href="{{ route('admin.coupons.index') }}">
            <i class="nav-icon icon-star"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.coupons.title')</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'tax' ? 'active' : '' }}"
            href="{{ route('admin.tax.index') }}">
            <i class="nav-icon icon-credit-card"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.tax.title')</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'payments-requests' ? 'active' : '' }}"
            href="{{ route('admin.payments.requests') }}">
            <i class="nav-icon icon-people"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.payments_requests.title')</span>
        </a>
    </li>
@endif
