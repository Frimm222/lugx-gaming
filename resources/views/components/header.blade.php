<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{route('home')}}" class="logo">
                        <img src="{{asset('images/logo.png')}}" alt="" style="width: 158px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="{{route('home')}}" @if(Request::routeIs('home')) class="active" @endif>Главная</a></li>
                        <li><a href="{{route('games.index')}}" @if(Request::routeIs('games.index')) class="active" @endif>Игры</a></li>
                        <li>
                            <div class="cart-icon position-relative">
                                <a href="{{ route('cart.show') }}" class="text-decoration-none">
                                    <i class="bi bi-cart3 fs-4"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ app(\App\Services\CartService::class)->count() }}
                                    </span>
                                </a>
                            </div>
                        </li>

                            @if (auth()->check())
                            <li>
                                <a href="{{ route('profile.show') }}" >Привет, {{ auth()->user()->display_name }}</a>
                            </li>
                            <li style="width: 100px">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" style="display: inline-block; background-color: #ee626b; color: #fff; font-size: 15px; text-transform: uppercase; font-weight: 500; padding: 0 25px; border: none; border-radius: 25px; position: absolute; right: 0; top: 0; transition: all .3s;">Выйти</button>
                                </form>
                            </li>
                            @else
                            <li >
                                <a href="{{ route('login') }}" >Войти</a>
                            </li>
                            <li >
                                <a href="{{ route('register') }}" >Регистрация</a>
                            </li>
                            @endif
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->
