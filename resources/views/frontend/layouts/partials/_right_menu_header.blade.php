<ul class="nav nav-right justify-content-end h-100">
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
    </li> --}}

    <navbar-cart @remove-item="removeItem" @update-quantity="updateCart">

    </navbar-cart>

    @if(auth()->check())
    <li class="nav-item menu-item-has-children ul-li-block">
        <div class="log-in">
            <a href="#!">{{ auth()->user()->first_name }}<span class="ml-2 d-inline-block border border-warning rounded-circle"
                style="width:30px; height:30px; padding-top:3px"><i class="fas fa-user ml-2"></i></span>
            </a>
            <ul class="sub-menu">
                @can('view backend')
                <li >
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                @endcan
                <li><router-link to="/user/user-account">My account</router-link></li>
                <li><router-link to="/user/user-account">Factures</router-link></li>

                <li>
                    {{-- <a href="#" @logout-app="logout-app">Se Deconnecter</a> --}}
                    {{-- <a href="{{ route('frontend.auth.logout') }}" >Se Deconnecter</a> --}}

                    <a href="" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Se Deconnecter</a>

                    <form action="{{ route('frontend.auth.logout') }}" method="POST" id="logoutform" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </li>
    @else

    <li class="nav-item">

        <div class="log-out ml-3">
            <router-link :to="{ name: 'login.tab'}">Se Connecter</router-link>
            <router-link :to="{ name: 'register.tab'}">S'inscrire</router-link>
        </div>
    </li>
    @endif


</ul>
