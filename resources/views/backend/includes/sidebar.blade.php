@inject('request', 'Illuminate\Http\Request')

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" src="{{ asset('assets/images/logos/' . config('app.logo_w_image')) }}"
            height="40" alt="Square Logo">
        <img class="sidebar-brand-narrow" src="{{ asset('assets/images/logos/' . config('app.logo_popup')) }}"
            height="30" alt="Square Logo">
        {{-- <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg> --}}
        {{-- <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#signet"></use>
        </svg> --}}
    </div>

    <ul class="sidebar-nav">
        <li class="nav-title">
            @lang('backend/menus.backend.sidebar.general')
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('user/dashboard')) }}"
                href="{{ route('admin.dashboard') }}">
                <i class="nav-icon icon-speedometer"></i> @lang('backend/menus.backend.sidebar.dashboard')
            </a>
        </li>

        <!--=======================Custom menus===============================-->

        @include('backend.includes.sidebars.sidebar-articles')


        @include('backend.includes.sidebars.sidebar-orders')


        @include('backend.includes.sidebars.sidebar-teachers')


        @include('backend.includes.sidebars.sidebar-categories')


        @include('backend.includes.sidebars.sidebar-medias')


        @include('backend.includes.sidebars.sidebar-formations-manager')


        @include('backend.includes.sidebars.sidebar-products-manager')


        @include('backend.includes.sidebars.sidebar-bundles')


        @include('backend.includes.sidebars.sidebar-reports')


        @include('backend.includes.sidebars.sidebar-site-manager')


        @include('backend.includes.sidebars.sidebar-messages')


        @include('backend.includes.sidebars.sidebar-students-feathers')


        @include('backend.includes.sidebars.sidebar-teachers-feathers')


        @include('backend.includes.sidebars.sidebar-admin-feathers')


        @include('backend.includes.sidebars.sidebar-account')


        @include('backend.includes.sidebars.sidebar-system')


        @include('backend.includes.sidebars.sidebar-teachers-payments')



    </ul>


    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<!--sidebar-->
