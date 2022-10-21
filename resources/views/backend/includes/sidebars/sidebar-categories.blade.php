@can('category_access')
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'categories' ? 'active' : '' }}"
            href="{{ route('admin.categories.index') }}">
            <i class="nav-icon icon-folder-alt"></i>
            <span class="title">@lang('backend/menus.backend.sidebar.categories.title')</span>
        </a>
    </li>
@endcan
