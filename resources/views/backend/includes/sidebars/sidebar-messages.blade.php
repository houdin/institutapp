<li class="nav-item ">
    <a class="nav-link {{ $request->segment(2) == 'messages' ? 'active' : '' }}"
        href="{{ route('admin.messages') }}">
        <i class="nav-icon icon-envelope-open"></i> <span
            class="title">@lang('backend/menus.backend.sidebar.messages.title')</span>
    </a>
</li>
