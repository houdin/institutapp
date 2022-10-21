@can('media_access')
    <li class="nav-item ">
        <a class="nav-link {{ $request->segment(2) == 'medias' ? 'active' : '' }}"
            href="{{ route('admin.medias.index') }}">
            <i class="nav-icon icon-folder-alt"></i>
            <span class="title">Medias</span>
        </a>
    </li>
@endcan
