@extends('layout')

@section('title')
Cart
@endsection

@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                @if(isset($cart_items))
                    <div id="cart" class="col my-3 p-3 bg-body rounded shadow-sm">
                        <h6 class="border-bottom pb-2 mb-0">Cart</h6>
                        
                        @forelse ($products as $product)

                             @php
                                $cart_items = Session::get('cart');
                                if(isset($cart_items)){
                                    foreach($cart_items as $key => $val){
                                        if($product->id == $val['0']){
                                           $count = $val['1']; 
                                        }
                                    }
                                }
                            @endphp

                            <div class="d-flex text-muted pt-3">
                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-gray-dark">{{ $product->name }}</strong>
                                    </div>
                                    <span class="d-block">Quantity: {{ $count }}</span>
                                </div>
                            </div>
                        
                        @endforeach
                        
                        <small class="d-block text-end mt-3">
                          <button id="delete-cart" class="btn btn-danger">Delete cart</button>
                          <a href="{{ route('order.create') }}" type="button" class="btn btn-primary">Next step</a>
                        </small>
                    </div>
                @else
                    <div class="col my-3 p-3 bg-body rounded shadow-sm">
                        <p>There are no products in the cart</p>
                    </div>
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

        });

    </script>

@endsection