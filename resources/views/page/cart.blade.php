<x-guest-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0" id="carttable">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                        $subtotal=0;
                        $shipping=10;
                        @endphp
                        
                        @forelse($cart_data as $cart)
                        <tr id="row_id_{{$loop->index}}">
                            <td class="align-middle"><x-img-tag img_url="{{$cart['image_name']}}" style="width: 50px;" />{{$cart['product_name']}}</td>
                            <td class="align-middle">Rs.<span class="product_ratetxt_{{$loop->index}}">{{$cart['product_rate']}}</span><input type="hidden" name="product_rate[]" class="product_rate_{{$loop->index}}" value="{{$cart['product_rate']}}"></td>
                            <input type="hidden" name="cart_id" id="cart_id_{{$loop->index}}" value="{{$cart['cart_id']}}">
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button data-rowid="{{$loop->index}}" class="btn btn-sm btn-primary btn-minus product_qty">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center product_qty_{{$loop->index}}" value="{{$cart['product_qty']}}" readonly name="product_qty[]" id="product_qty_{{$loop->index}}">
                                    <div class="input-group-btn">
                                        <button data-rowid="{{$loop->index}}" class="btn btn-sm btn-primary btn-plus product_qty">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">Rs.<span class="productlist product_value_{{$loop->index}}" id="product_value_{{$loop->index}}">{{ number_format($cart['product_rate'] * $cart['product_qty'], 2, '.', '')}}</span></td>
                            <td class="align-middle"><button data-del_id="{{$cart['cart_id']}}" data-row_id="{{$loop->index}}" class="btn btn-sm btn-primary removecart"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @php
                        $subtotal += ($cart['product_rate']*$cart['product_qty']);
                        @endphp
                        @empty
                        <tr><td colspan="5">Your Cart is Empty</td></tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <!-- <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> -->
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">Rs.<span id="spansubamt">{{number_format($subtotal,2)}}</span></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">Rs.<span id="spanshippingamt">{{number_format($shipping,2)}}</span></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rs.<span id="spantotoalamt">{{ number_format($subtotal + $shipping,2)}}</span></h5>
                        </div>
                        @auth
                        @if(isset($cart_data))
                        <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                        @else
                        <a href="{{route('home')}}" class="btn btn-block btn-primary my-3 py-3">Countiue to Shooping</a>
                        @endif
                        @else
                        <!-- <a href="{{route('login')}}" class="btn btn-block btn-primary my-3 py-3" >Login to Proceed</a> -->
                        <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.product_qty').on('click', function() {
                var rowid = $(this).data('rowid');
                var product_qty = parseFloat($('.product_qty_' + rowid).val());
                var product_rate = parseFloat($('.product_rate_' + rowid).val());
                var product_value = parseFloat(product_qty * product_rate).toFixed(2);
                $('.product_value_' + rowid).text(product_value);
                getsubtotal();
                // console.log(rowid);
                updatecart(rowid);
            });

            function getsubtotal() {
                spansubamt = 0;
                $('.productlist').each(function(i) {
                    subamt = $(this).text();
                    if (!isNaN(subamt)) spansubamt += Number(subamt);
                });

                shippingamt = parseFloat($('#spanshippingamt').text());

                $("#spansubamt").text(spansubamt.toFixed(2));
                // $("#spanshippingamt").text(shippingamt);
                $("#spantotoalamt").text((shippingamt + spansubamt).toFixed(2));
            }

            $(".removecart").on('click', function() {
                var row_id = $(this).data('row_id');
                updatecart(row_id,'remove');
                $("#row_id_" + row_id).remove();
            });

            function updatecart(rowid, update_type='update') {
                // console.log(rowid);
                var cartid = $("#cart_id_" + rowid).val();
                // console.log(cartid);
                var prod_qty = $("#product_qty_" + rowid).val();
                if (prod_qty > 0) {
                    $.ajax({
                        url: '{{route("updatecart")}}',
                        method: 'POST',
                        data: {
                            'cart_id': cartid,
                            "prod_qty": prod_qty,
                            "update_type": update_type
                        },
                        dataType: 'JSON',
                        "headers": {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#shoppingcart_count').text(response.cart_count);
                            if(response.cart_count == 0){
                                $("#carttable").append('<tr><td colspan="5">Your Cart is Empty</td></tr>');
                            }
                            getsubtotal();
                        },
                        error: function(response) {
                            if(response.status == 400){
                                $("#row_id_" + rowid).remove();
                            }
                            console.log(response);
                        }
                    });
                }
            }
        });
    </script>
    @endpush
</x-guest-layout>