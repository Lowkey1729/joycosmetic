<header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <!-- Logo -->
    <div class="logo" style="margin-bottom: 1em;">
        @guest
        @else
        <h6>{{Auth::user()->name}}</h6>
        @endguest
        <a href="index.html"><img src="{{asset('img/core-img/logo.png')}}" alt=""></a><br><br>
        <a href="#" class="search-nav"><img src="{{asset('img/core-img/search.png')}}" alt=""> Search</a><br>
        <hr>
        <a href="{{url('/cart/client/cart')}}" class="cart-nav"><img src="{{asset('img/core-img/cart.png')}}" alt="">
            Cart<span>({{ session()->has('quantity')?session()->get('quantity'):'0' }})</span></a>
    </div>
    <!-- Amado Nav -->
    <nav class="amado-nav">
        <ul>
            <li class="active"><a href="/" style="font-weight: bold;">Home</a></li>
            @foreach($categories as $category)
            <li><a href="{{url('/shop/category/'.$category->id)}}" style="font-weight: bold;">{{$category->name}}</a>
            </li>
            @endforeach



            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ url('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif

            @else
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </li>

        </ul>
    </nav>
    <!-- Button Group -->

    <div class="amado-btn-group mt-30 mb-100">
        <a href="{{url('/shop/show-order/'.Auth::user()->id)}}" class="btn amado-btn mb-15">Orders</a>

    </div>
    @endguest

    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
        <a href="https://instagram.com/joycosmeticsandmore?igshid=kjulfcx8m1zc"><p style="color: #000;">Instagram <i class="fa fa-instagram" aria-hidden="true"></i></p></a>
    </div>
</header>
