@if ($logged_in_user->hasRole('teacher'))
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(1) == 'reviews' ? 'active' : '' }}"
            href="{{ route('admin.reviews.index') }}">
            <i class="nav-icon icon-speech"></i> <span
                class="title">@lang('backend/menus.backend.sidebar.reviews.title')</span>
        </a>
    </li>
@endif
