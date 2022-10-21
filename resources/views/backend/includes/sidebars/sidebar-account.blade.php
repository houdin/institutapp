<li class="nav-item ">
    <a class="nav-link {{ $request->segment(2) == 'account' ? 'active' : '' }}" href="{{ route('admin.account') }}">
        <i class="nav-icon icon-key"></i>
        <span class="title">@lang('backend/menus.backend.sidebar.account.title')</span>
    </a>
</li>
