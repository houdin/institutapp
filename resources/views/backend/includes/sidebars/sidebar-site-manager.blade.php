@if ($logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['blog_access', 'page_access']))
    <li
        class="nav-group {{ active_class(Active::checkUriPattern(['user/contact', 'user/faqs*', 'user/footer*', 'user/blogs', 'user/sitemap*']), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern(['user/contact', 'user/faqs*', 'user/footer*', 'user/blogs', 'user/sitemap*'])) }}"
            href="#">
            <i class="nav-icon icon-note"></i> @lang('backend/menus.backend.sidebar.site-management.title')
        </a>

        <ul class="nav-group-items">

            @if ($logged_in_user->isAdmin())


                <li class="nav-item ">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('user/sliders*')) }}"
                        href="{{ route('admin.sliders.index') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.hero-slider.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'forums-category' ? 'active' : '' }}"
                        href="{{ route('admin.forums-category.index') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.forums-category.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'contact' ? 'active' : '' }}"
                        href="{{ route('admin.contact-settings') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.contact.title')</span>
                    </a>
                </li>
                {{-- <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'newsletter' ? 'active' : '' }}"
                                   href="{{ route('admin.newsletter-settings') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.newsletter-configuration.title')</span>
                                </a>
                            </li> --}}
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'footer' ? 'active' : '' }}"
                        href="{{ route('admin.footer-settings') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.footer.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'sitemap' ? 'active' : '' }}"
                        href="{{ route('admin.sitemap.index') }}">
                        <span class="title">@lang('backend/menus.backend.sidebar.sitemap.title')</span>
                    </a>
                </li>
            @endif

        </ul>


    </li>

@endif
