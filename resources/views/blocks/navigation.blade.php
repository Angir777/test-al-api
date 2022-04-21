<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('shop.index') }}">Shop Homepage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link 
                @if(Request::is('shop'))
                    active
                @endif
                " aria-current="page" href="{{ route('shop.index') }}">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('shop.index') }}">All Products</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <a href="{{ route('shop.cart') }}" class="btn btn-outline-dark" type="submit">
                    @php
                        $count = 0;
                        $cart_items = Session::get('cart');
                        if(isset($cart_items)){foreach($cart_items as $key => $val){$count += $val['1'];}}
                    @endphp
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill count">{{ $count }}</span>
                </a>
            </form>
        </div>
    </div>
</nav>

@if(Request::is('shop'))

<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop Homepage</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>

@endif
