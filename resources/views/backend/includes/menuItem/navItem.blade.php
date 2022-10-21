
I
@php
    $backendMenu = array(
        // ORDER
        'order' => array(
            'parent' => false,
            'name' => 'orders',
            'label' => 'Orders'
            'segment' => 1,
            'route' => '.orders.index',
            'role' => 'normal',
            'icon' => 'icon-directions'
        ),
        // TEACHER
        'teacher' => array(
            'parent' => false,
            'name' => 'teachers',
            'label' => 'Teachers'
            'segment' => 2,
            'route' => '.teachers.index',
            'role' => 'admin',
            'icon' => 'icon-directions'
        ),
        // CATEGORIES
        'category' => array(
            'parent' => false,
            'name' => 'categories',
            'label' => 'categories'
            'segment' => 2,
            'route' => '.categories.index',
            'role' => 'normal',
            'icon' => 'icon-folder-alt'
        ),
        // PRODUCT
        'product' => array(
            'parent' => true,
            'name' => 'products',
            'label' => 'Products Management'
            'segment' => 0,
            'route' => '',
            'role' => '',
            'icon' => 'icon-handbag',
            'item_class' => '',
            'link_class' => '',
            'child' => array(
                'product' => array(
                    'parent' => false,
                    'name' => 'products',
                    'label' => 'Products'
                    'segment' => 2,
                )
            )
        ),
        // FORMATION
        'formation' => array(
            'parent' => true,
            'name' => 'formations',
            'label' => 'Formations Management'
            'segment' => 0,
            'route' => '',
            'role' => '',
            'icon' => 'icon-puzzle',
            'item_class' => ['user/formations*','user/modules*','user/tutorials*','user/tests*','user/questions*'],
            'link_class' => 'admin/*',
            'child' => array(
                'formation' => array(
                    'parent' => false,
                    'name' => 'formations',
                    'label' => 'Formations'
                    'segment' => 2,
                ),
                'module' => array(
                    'parent' => false,
                    'name' => 'modules',
                    'label' => 'Modules'
                    'segment' => 2,
                ),
                'tutorial' => array(
                    'parent' => false,
                    'name' => 'tutorials',
                    'label' => 'Tutorials'
                    'segment' => 2,
                ),
                'test' => array(
                    'parent' => false,
                    'name' => 'tests',
                    'label' => 'Tests'
                    'segment' => 2,
                ),
                'question' => array(
                    'parent' => false,
                    'name' => 'questions',
                    'label' => 'Questions'
                    'segment' => 2,
                ),
            ),
        ),
        // BUNDLE
        'bundle' => array(
            'parent' => false,
            'name' => 'bundles',
            'label' => 'Bundles'
            'segment' => 2,
            'route' => '',
            'role' => '',
            'icon' => ''
        ),
        // REPORT
        'report' => array(
            'parent' => true,
            'name' => 'reports',
            'label' => 'Reports'
            'segment' => 0,
            'route' => '',
            'role' => '',
            'icon' => '',
            'item_class' => '',
            'link_class' => '',
            'child' => array(
                'sale' => array(
                    'parent' => false,
                    'name' => 'sales',
                    'label' => 'Sales'
                    'segment' => 1,
                ),
                'student' => array(
                    'parent' => false,
                    'name' => 'students',
                    'label' => 'Students'
                    'segment' => 1,
                )

            ),
        ),
        // SITE MANAGEMENT
        'site' => array(
            'parent' => true,
            'name' => 'site-management',
            'label' => 'Site Management'
            'segment' => 0,
            'route' => '',
            'role' => '',
            'icon' => '',
            'item_class' => '',
            'link_class' => '',
            'child' => array(
                'page' => array(
                    'parent' => false,
                    'name' => 'pages',
                    'label' => 'Pages'
                    'segment' => 2,
                ),
                'blog' => array(
                    'parent' => false,
                    'name' => 'blogs',
                    'label' => 'Blogs'
                    'segment' => 2,
                ),
                'slider' => array(
                    'parent' => false,
                    'name' => 'sliders',
                    'label' => 'Hero Slider'
                    'segment' => 2,
                ),
                'forum' => array(
                    'parent' => false,
                    'name' => 'forums-category',
                    'label' => 'Forums Categories'
                    'segment' => 2,
                ),
                'faq' => array(
                    'parent' => false,
                    'name' => 'faqs',
                    'label' => 'FAQs'
                    'segment' => 2,
                ),
                'contact' => array(
                    'parent' => false,
                    'name' => 'contact',
                    'label' => 'Contact'
                    'segment' => 2,
                ),
                'newsletter' => array(
                    'parent' => false,
                    'name' => 'newsletter',
                    'label' => 'Newsletter Configuration'
                    'segment' => 2,
                ),
                'footer' => array(
                    'parent' => false,
                    'name' => 'footer',
                    'label' => 'Footer'
                    'segment' => 2,
                ),
                'sitemap' => array(
                    'parent' => false,
                    'name' => 'sitemap',
                    'label' => 'Sitemap'
                    'segment' => 2,
                ),
            ),
        ),
        // MESSAGE
        'message' => array(
            'parent' => false,
            'name' => 'messages',
            'label' => 'Messages'
            'segment' => 1,
            'route' => '',
            'role' => '',
            'icon' => ''
        ),
        // INVOICE
        'invoice' => array(
            'parent' => false,
            'name' => 'invoices',
            'label' => 'Invoices'
            'segment' => 1,
            'route' => '',
            'role' => '',
            'icon' => ''
        ),
        // CERTIFICATE
        'certificate' => array(
            'parent' => false,
            'name' => 'certificates',
            'label' => 'certificates'
            'segment' => 1,
            'route' => '',
            'role' => '',
            'icon' => ''
        ),
        // REVIEW
        'review' => array(
            'parent' => false,
            'name' => 'reviews',
            'label' => 'reviews'
            'segment' => 1,
            'route' => '',
            'role' => '',
            'icon' => ''
        ),


    );

@endphp

.<li class="nav-item ">
    <a class="nav-link {{ $request->segment(1) == 'orders' ? 'active' : '' }}"
        href="{{ route('admin.orders.index') }}">
        <i class="nav-icon icon-bag"></i>
        <span class="title">Orders</span>
    </a>
</li>

<li
    class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/formations*','user/modules*','user/tutorials*','user/tests*','user/questions*']), 'open') }}">
    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}" href="#">
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

    </ul>
</li>
