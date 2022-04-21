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
                        <form>
                            
                            <div class="row">
                                <div class="col-md-6 p-2">
                                    <input type="text" class="form-control" placeholder="First name*" required>
                                </div>
                                <div class="col-md-6 p-2">
                                    <input type="text" class="form-control" placeholder="Last name*" required>
                                </div>
                                <div class="col-md-12 p-2"> 
                                    <input type="email" class="form-control" placeholder="Email*" required>
                                </div>
                            </div>
                        
                            <small class="d-block text-end mt-3">
                              <a href="{{ route('shop.cart') }}" type="button" class="btn btn-primary">Back</a>
                              <button type="submit" class="btn btn-success">Buy</button>
                            </small>
                            
                        </form>
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