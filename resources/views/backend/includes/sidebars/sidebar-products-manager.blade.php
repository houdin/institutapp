{{-- PRODUCT MANAGER --}}
@if ($logged_in_user->hasRole('seller') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['product_access']))
    {{-- @if ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access', 'module_access', 'test_access', 'question_access', 'bundle_access'])) --}}

    <li class="nav-group {{ active_class(Active::checkUriPattern(['user/products*']), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern(['user/products*'])) }}" href="#">
            <i class="nav-icon icon-puzzle"></i> Products Management


        </a>

        <ul class="nav-group-items">

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


@endif
