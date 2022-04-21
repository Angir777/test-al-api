@extends('layout')

@section('title')
Shop Homepage
@endsection

@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                
                @forelse ($products as $product)

                    @php
                        $description = $product->description;
                    @endphp

                    <div class="col mb-5">
                        <div class="card h-100">
                            <div class="badge 
                            @php
                                if ($product->availability < env('WARNING_LEVEL')) {
                                    echo ' bg-danger ';
                                }else{
                                    echo ' bg-dark ';
                                }
                            @endphp
                            text-white position-absolute" style="top: 0.5rem; right: 0.5rem">{{ $product->availability }} szt.</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    {{ \Illuminate\Support\Str::limit($description, 100, $end='...') }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <button class="btn btn-outline-dark mt-auto add-to-cart" data-id="{{ $product->id }}">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty

                    <p>No rezults</p>

                @endforelse

            </div>

            @if(!empty($products))

            <div class="row">
                <div class="col">
                    {!! $products->links() !!}
                </div>
            </div>

            @endif

        </div>
    </section>
@endsection

@section('scripts')

    <script>
       
        $(document).ready(function(){

            $('.add-to-cart').click(function(){

                $this = $(this);
                var id = $this.attr('data-id');

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                    url: "{{ route('shop.addCart') }}",
                    data: {
                        id:id,
                        _token: CSRF_TOKEN
                    },
                    cache: false,
                    success: function(data) {
                        $('.count').html(data.cart_count);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });

            });
        });
 
    </script>

@endsection