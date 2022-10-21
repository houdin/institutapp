@if (!$logged_in_user->hasRole('student') && ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access', 'module_access', 'test_access', 'question_access', 'bundle_access'])))
    {{-- @if ($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['formation_access', 'module_access', 'test_access', 'question_access', 'bundle_access'])) --}}

    <li
        class="nav-group {{ active_class(Active::checkUriPattern(['user/formations*', 'user/modules*', 'user/tutorials*', 'user/tests*', 'user/questions*']), 'show') }}">
        <a class="nav-link nav-group-toggle {{ active_class(Active::checkUriPattern(['user/formations*', 'user/modules*', 'user/tutorials*', 'user/tests*', 'user/questions*'])) }}"
            href="#">
            <i class="nav-icon icon-puzzle"></i> @lang('backend/menus.backend.sidebar.formations.management')


        </a>

        <ul class="nav-group-items">

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


@endif
