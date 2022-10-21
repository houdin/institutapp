@inject('request', 'Illuminate\Http\Request')

<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('backend/menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('backend/menus.backend.sidebar.dashboard')
                </a>
            </li>

            <!--=======================Custom menus===============================-->
            @can('order_access')
                .<li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'orders' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">
                        <i class="nav-icon icon-bag"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.orders.title')</span>
                    </a>
                </li>
            @endcan
            @if ($logged_in_user->isAdmin())
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'teachers' ? 'active' : '' }}"
                       href="{{ route('admin.teachers.index') }}">
                        <i class="nav-icon icon-directions"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.teachers.title')</span>
                    </a>
                </li>
            @endif

            @can('category_access')
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'categories' ? 'active' : '' }}"
                       href="{{ route('admin.categories.index') }}">
                        <i class="nav-icon icon-folder-alt"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.categories.title')</span>
                    </a>
                </li>
            @endcan
            @if((!$logged_in_user->hasRole('student')) && ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access','module_access','test_access','question_access','bundle_access'])))
                {{--@if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access','module_access','test_access','question_access','bundle_access']))--}}

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/formations*','user/modules*','user/tutorials*','user/tests*','user/questions*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                        <i class="nav-icon icon-puzzle"></i> @lang('backend/menus.backend.sidebar.formations.management')


                    </a>

                    <ul class="nav-dropdown-items">

                        @can('formation_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'formations' ? 'active' : '' }}"
                                   href="{{ route('admin.formations.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.formations.title')</span>
                                </a>
                            </li>
                        @endcan

                        @can('module_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'modules' ? 'active' : '' }}"
                                   href="{{ route('admin.modules.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.modules.title')</span>
                                </a>
                            </li>
                        @endcan

                        @can('tutorial_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'tutorials' ? 'active' : '' }}"
                                   href="{{ route('admin.tutorials.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.tutorials.title')</span>
                                </a>
                            </li>
                        @endcan

                        @can('test_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'tests' ? 'active' : '' }}"
                                   href="{{ route('admin.tests.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.tests.title')</span>
                                </a>
                            </li>
                        @endcan


                        @can('question_access')
                            <li class="nav-item">
                                <a class="nav-link {{ $request->segment(2) == 'questions' ? 'active' : '' }}"
                                   href="{{ route('admin.questions.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.questions.title')</span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
                @can('bundle_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                           href="{{ route('admin.bundles.index') }}">
                            <i class="nav-icon icon-layers"></i>
                            <span class="title">@lang('backend/menus.backend.sidebar.bundles.title')</span>
                        </a>
                    </li>
                @endcan
                @if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin())
                    <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                        <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                           href="#">
                            <i class="nav-icon icon-pie-chart"></i>@lang('backend/menus.backend.sidebar.reports.title')

                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                                   href="{{ route('admin.reports.sales') }}">
                                    @lang('backend/menus.backend.sidebar.reports.sales')
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                                   href="{{ route('admin.reports.students') }}">@lang('backend/menus.backend.sidebar.reports.students')
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
            {{-- PRODUCT MANAGER --}}
            @if( ($logged_in_user->hasRole('seller') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['product_access'])))
                {{--@if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access','module_access','test_access','question_access','bundle_access']))--}}

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/products*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                        <i class="nav-icon icon-puzzle"></i> Products Management


                    </a>

                    <ul class="nav-dropdown-items">

                        @can('product_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'products' ? 'active' : '' }}"
                                   href="{{ route('admin.products.index') }}">
                                    <span class="title">Products</span>
                                </a>
                            </li>
                        @endcan

                        @can('module_access')

                        @endcan

                        @can('tutorial_access')

                        @endcan

                        @can('test_access')

                        @endcan


                        @can('question_access')

                        @endcan

                    </ul>
                </li>
                @can('bundle_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                           href="{{ route('admin.bundles.index') }}">
                            <i class="nav-icon icon-layers"></i>
                            <span class="title">@lang('backend/menus.backend.sidebar.bundles.title')</span>
                        </a>
                    </li>
                @endcan
                @if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin())
                    <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                        <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                           href="#">
                            <i class="nav-icon icon-pie-chart"></i>@lang('backend/menus.backend.sidebar.reports.title')

                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                                   href="{{ route('admin.reports.sales') }}">
                                    @lang('backend/menus.backend.sidebar.reports.sales')
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                                   href="{{ route('admin.reports.students') }}">@lang('backend/menus.backend.sidebar.reports.students')
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif




            @if ($logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['blog_access','page_access']))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/contact','user/faqs*','user/footer*','user/blogs','user/sitemap*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                        <i class="nav-icon icon-note"></i> @lang('backend/menus.backend.sidebar.site-management.title')
                    </a>

                    <ul class="nav-dropdown-items">
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
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sliders*')) }}"
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
                                <a class="nav-link {{ $request->segment(2) == 'faqs' ? 'active' : '' }}"
                                   href="{{ route('admin.faqs.index') }}">
                                    <span class="title">@lang('backend/menus.backend.sidebar.faqs.title')</span>
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

            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'messages' ? 'active' : '' }}"
                   href="{{ route('admin.messages') }}">
                    <i class="nav-icon icon-envelope-open"></i> <span
                            class="title">@lang('backend/menus.backend.sidebar.messages.title')</span>
                </a>
            </li>
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
            @if ($logged_in_user->hasRole('teacher'))
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'reviews' ? 'active' : '' }}"
                       href="{{ route('admin.reviews.index') }}">
                        <i class="nav-icon icon-speech"></i> <span
                                class="title">@lang('backend/menus.backend.sidebar.reviews.title')</span>
                    </a>
                </li>
            @endif

            @if ($logged_in_user->isAdmin())
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.contact-requests.index') }}">
                        <i class="nav-icon icon-envelope-letter"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.contacts.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.coupons.index') }}">
                        <i class="nav-icon icon-star"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.coupons.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.tax.index') }}">
                        <i class="nav-icon icon-credit-card"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.tax.title')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.payments.requests') }}">
                        <i class="nav-icon icon-people"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.payments_requests.title')</span>
                    </a>
                </li>
            @endif
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'account' ? 'active' : '' }}"
                   href="{{ route('admin.account') }}">
                    <i class="nav-icon icon-key"></i>
                    <span class="title">@lang('backend/menus.backend.sidebar.account.title')</span>
                </a>
            </li>
            @if ($logged_in_user->isAdmin())


                <li class="nav-title">
                    @lang('backend/menus.backend.sidebar.system')
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> @lang('backend/menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                               href="{{ route('admin.auth.user.index') }}">
                                @lang('backend/labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                               href="{{ route('admin.auth.role.index') }}">
                                @lang('backend/labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>


                <!--==================================================================-->
                <li class="divider"></li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/settings*')) }}"
                       href="#">
                        <i class="nav-icon icon-settings"></i> @lang('backend/menus.backend.sidebar.settings.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings')) }}"
                               href="{{ route('admin.general-settings') }}">
                                @lang('backend/menus.backend.sidebar.settings.general')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('admin.social-settings') }}">
                                @lang('backend/menus.backend.sidebar.settings.social-login')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
                       href="#">
                        <i class="nav-icon icon-list"></i> @lang('backend/menus.backend.sidebar.debug-site.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                               href="{{ route('log-viewer::dashboard') }}">
                                @lang('backend/menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('log-viewer::logs.list') }}">
                                @lang('backend/menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'translation-manager' ? 'active' : '' }}"
                       href="{{ asset('user/translations') }}">
                        <i class="nav-icon icon-docs"></i>
                        <span class="title">@lang('backend/menus.backend.sidebar.translations.title')</span>
                    </a>
                </li>
            @endif

            @if ($logged_in_user->hasRole('teacher'))
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'payments' ? 'active' : '' }}"
                    href="{{ route('admin.payments') }}">
                    <i class="nav-icon icon-wallet"></i>
                    <span class="title">@lang('backend/menus.backend.sidebar.payments.title')</span>
                </a>
            </li>
            @endif

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
