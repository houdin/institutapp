.<li class="nav-item ">
    <a class="nav-link {{ $request->segment(1) == 'orders' ? 'active' : '' }}"
        href="{{ route('admin.orders.index') }}">
        <i class="nav-icon icon-bag"></i>
        <span class="title">@lang('backend/menus.backend.sidebar.orders.title')</span>
    </a>
</li>
