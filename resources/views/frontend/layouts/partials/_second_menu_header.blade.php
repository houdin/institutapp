<div class="second-menu shadow nav-menu position-relative" style="z-index: 10">
    <div class="container">
        <div class="second-menu-nav float-left pt-1">
            <ul id="menu-sub-menu" class="nav ml-3">
                {{-- @dd( $value) --}}
                @foreach($second_menus as $label => $item)
                @include('frontend.layouts.partials._dropdown-second', [$label, $item])
                @endforeach

            </ul>
        </div>
        <div class="header-search-wrap float-right mr-4">
            <search-header></search-header>
            {{-- <form role="search" method="get" class="search_form" action="https://fxinstitut.com/">
                                <div class="searchBox">
                                    <input class="searchInput search-field" type="search" name="s" placeholder="Rechercher…" value="">
                                    <a href="#" class="header-search-trigger searchButton"><span><i class="fas fa-search"></i></span></a>
                                </div>
                            </form> --}}
        </div>
    </div>

</div>
