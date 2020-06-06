<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item @if(explode('/',Request::path())[0] == 'category') active @endif">
                    <a class="nav-link" href="/category/list">Kategori</a>
                </li>
                <li class="nav-item @if(explode('/',Request::path())[0] == 'product') active @endif">
                    <a class="nav-link" href="/product/list">Daftar Produk</a>
                </li>
                <li class="nav-item @if(explode('/',Request::path())[0] == 'transaction') active @endif">
                    <a class="nav-link" href="/transaction/list">Daftar Transaksi</a>
                </li>
                <li class="nav-item @if(explode('/',Request::path())[0] == 'statistic') active @endif">
                    <a class="nav-link" href="/statistic">Statistik {{config('app.name', 'laravel')}}</a>
                </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item mr-5 @if(explode('/',Request::path())[0] == 'order') active @endif">
                    <a class="nav-link align-middle" href="/order/new">
                        <span class="material-icons align-middle d-none d-md-inline">
                            add
                        </span>
                        <span class="align-middle">Mulai Transaksi</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-light dropdown-toggle mb-0" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
