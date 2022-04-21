@extends('layout')

@section('title')
Zamówienie
@endsection

@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                @if(isset($cart_items))
                    <div id="cart" class="col my-3 p-3 bg-body rounded shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3">Purchaser data</h6>
                        <form id="form">
                            
                            @csrf

                            @php
                                $cart_items = Session::get('cart');
                                $cart = 0;
                                if(isset($cart_items)){$cart = 1;}
                            @endphp
                            <input type="hidden" name="_cart" id="_cart" value="{{ $cart }}">
                            @error('_cart')
                                <div style="color: red;">There are no products in the cart</div>
                            @enderror

                            <div class="row">
                                <div class="col-md-6 p-2">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Name*" required>
                                    @error('name')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 p-2">
                                    <input type="text" name="surname" id="surname"  value="{{ old('surname') }}" class="form-control" placeholder="Surname*" required>
                                    @error('surname')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 p-2"> 
                                    <input type="email" name="email" id="email"  value="{{ old('email') }}" class="form-control" placeholder="Email*" required>
                                    @error('email')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <small class="d-block text-end mt-3">
                              <a href="{{ route('shop.cart') }}" type="button" class="btn btn-primary">Back</a>
                              <button type="submit" class="btn btn-success">Buy</button>
                            </small>
                            
                        </form>
                    </div>
                @else
                    <script>window.location = "/shop";</script>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script>
       
        $(document).ready(function(){

            $('#delete-cart').click(function(){

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                    url: "{{ route('shop.deleteCart') }}",
                    data: {
                        _token: CSRF_TOKEN
                    },
                    cache: false,
                    success: function(data) {
                        $('.count').html(data.cart_count);
                        $('#cart').html('<p>There are no products in the cart</p>');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });

            });

            $('#form').on('submit', function(e) {

                e.preventDefault();

                let _cart = $('#_cart').val();
                let name = $('#name').val();
                let surname = $('#surname').val();
                let email = $('#email').val();

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                    url: "{{ route('order.store') }}",
                    data: {
                        _cart: _cart,
                        name: name,
                        surname: surname,
                        email: email,
                        _token: CSRF_TOKEN
                    },
                    cache: false,
                    success: function(data) {
                        $('#form').text("The order has been "+data.orderStatus);
                        $("#form")[0].reset();
                        $('.count').html(0);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });

                return false;

            });

        });

    </script>

@endsection