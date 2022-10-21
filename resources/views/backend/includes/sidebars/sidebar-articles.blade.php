{{-- //////// ARTICLES //////////////// --}}
@if ($logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['blog_access']))
    <li class="nav-group {{ active_class(Active::checkUriPattern(['user/faqs*', 'user/blogs']), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern(['user/faqs*', 'user/blogs'])) }}"
            href="#">
            <i class="nav-icon icon-note"></i> Articles
        </a>

        <ul class="nav-group-items">
            @can('blog_access')
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                        href="{{ route('admin.blogs.index') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.blogs.title')</span>
                    </a>
                </li>
            @endcan
            @if ($logged_in_user->isAdmin())


                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'faqs' ? 'active' : '' }}"
                        href="{{ route('admin.faqs.index') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.faqs.title')</span>
                    </a>
                </li>

            @endif

        </ul>


    </li>
@else
    @can('blog_access')
        <li class="nav-item ">
            <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                href="{{ route('admin.blogs.index') }}">
                <i class="nav-icon icon-note"></i>
                <span class="title">@lang('backend/menus.backend.sidebar.blogs.title')</span>
            </a>
        </li>
    @endcan
@endif

{{-- ///////////  END ARTICLES //////// --}}
