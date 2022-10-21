<nav class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top" role="navigation">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('about')}}">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('contact')}}">Contact</a>
      </li>
      @if($isAdmin)
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Administrator
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('admin.user.account') }}">Dashboard</a>
          <a class="dropdown-item" href="{{ route('admin.products.index') }}">Products Page</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('admin.users') }}">Users Page</a>
        </div>
      </li>
      @endif
        <categories-navbar v-if="!show.showSideBar"
                            :categories="{{ $categories }}">
        </categories-navbar>
    </ul>
        <search-products>

        </search-products>
            <ul class="nav navbar-nav navbar-right">
                <navbar-cart :cart="cart"
                             @remove-item="removeItem"
                             @update-quantity="updateCart">

                </navbar-cart>
                @if (Auth::guest())
                    <li class="nav-item" id="">
                        <a href="{{ route('login') }}">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Login
                        </a>
                    </li>
                    <li class="nav-item" id="">
                        <a href="{{ route('register') }}">
                            <i class="fa fa-registered" aria-hidden="true"></i>
                            Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown" id="user-account">
                        <a href="#" class="nav-link dropdown-toggle"
                           role="button"
                           aria-expanded="false" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            {{ Auth::user()->name }}'s Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="user-account">
                            <a class="dropdown-item" href="{{ route('user.account') }}">My Account</a>
          <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                        </div>
                    </li>
                @endif
            </ul>

  </div>
</nav>

