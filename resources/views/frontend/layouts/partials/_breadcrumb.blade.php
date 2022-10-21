<section id="breadcrumb" class="breadcrumb-section relative-position background-style">
    <div class="blakish-overlay"></div>
    <div class="container">
        <div class="page-breadcrumb-content text-center">
            <div class="page-breadcrumb-title">
                <h2 class="breadcrumb-head black bold">
                    <span>
                        @if ( count(Request::segments()) == 1 )
                        @if (Request::segment(1) == 'contact')
                        {{ env('APP_NAME') ." ". Request::segment(1) }}

                        @elseif (Request::segment(1) == 'contct')

                        @else
                        {{ Request::segment(1) }}

                        @endif
                        @elseif ( count(Request::segments()) == 2)
                        {{ Request::segment(1) . ' > ' . Request::segment(2)}}
                        @elseif ( isset($category))
                        {{ $category->name }}
                        @elseif ( isset($q))
                        {{ ".$q." }}
                        @elseif ( isset($teacher))
                        {{ $teacher->full_name }}
                        @endif

                    </span>
                </h2>
            </div>
        </div>
    </div>
</section>
