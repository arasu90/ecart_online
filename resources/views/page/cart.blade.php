<x-guest-layout>
     <!-- Cart Start -->
     <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
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
                        @foreach($cart_data->cart_item_list as $cart)
                        <tr id="row_id_{{$loop->index}}">
                            <td class="align-middle"><x-img-tag img_url="img/product-1.jpg" style="width: 50px;" />{{$cart->product_list->product_name}}</td>
                            <td class="align-middle">$ <span class="product_ratetxt_{{$loop->index}}">{{$cart->product_list->product_rate}}</span><input type="hidden" name="product_rate[]" class="product_rate_{{$loop->index}}" value="{{$cart->product_list->product_rate}}"></td>
                            <input type="hidden" name="cart_id" id="cart_id_{{$loop->index}}" value="{{$cart->id}}">
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button data-rowid="{{$loop->index}}" class="btn btn-sm btn-primary btn-minus product_qty" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center product_qty_{{$loop->index}}" value="{{$cart->product_qty}}" readonly name="product_qty[]" id="product_qty_{{$loop->index}}">
                                    <div class="input-group-btn">
                                        <button data-rowid="{{$loop->index}}" class="btn btn-sm btn-primary btn-plus product_qty">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$ <span class="productlist product_value_{{$loop->index}}" id="product_value_{{$loop->index}}">{{ number_format($cart->product_list->product_rate * $cart->product_qty,2)}}</span></td>
                            <td class="align-middle"><button data-del_id="{{$cart->id}}" data-row_id="{{$loop->index}}" class="btn btn-sm btn-primary removecart"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @php
                        $subtotal += ($cart->product_list->product_rate*$cart->product_qty);
                        @endphp
                        @endforeach
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
                            <h6 class="font-weight-medium">$<span id="spansubamt">{{number_format($subtotal,2)}}</span></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$<span id="spanshippingamt">{{number_format($shipping,2)}}</span></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$<span id="spantotoalamt" >{{ number_format($subtotal + $shipping,2)}}</span></h5>
                        </div>
                        @auth
                        <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
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
            $('.product_qty').on('click', function(){
                var rowid = $(this).data('rowid');
                var product_qty = parseFloat($('.product_qty_'+rowid).val());
                var product_rate = parseFloat($('.product_rate_'+rowid).val());
                var product_value = parseFloat(product_qty * product_rate).toFixed(2);
                $('.product_value_'+rowid).text(product_value);
                getsubtotal();
                console.log(rowid);
                updatecart(rowid);
            });

            function getsubtotal(){
                spansubamt=0;
                $('.productlist').each(function(i){
                    subamt = $(this).text();
                    if(!isNaN(subamt)) spansubamt += Number(subamt);
                });

                shippingamt = parseFloat($('#spanshippingamt').text());
                
                $("#spansubamt").text(spansubamt.toFixed(2));
                // $("#spanshippingamt").text(shippingamt);
                $("#spantotoalamt").text((shippingamt+spansubamt).toFixed(2));
            }

            $(".removecart").on('click', function(){
                var cartid = $(this).data('del_id');
                var row_id = $(this).data('row_id');
                // $("#row_id_"+row_id).remove();
                $.ajax({
                    url: '{{route("removetocart")}}',
                    method: 'POST',
                    data: {
                        'cart_id': cartid,
                    },
                    dataType: 'JSON',
                    "headers": {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    success:function(response)
                    {
                        $("#row_id_"+row_id).remove();
                        getsubtotal();
                    },
                    error: function(response)
                    {
                        console.log(response);
                    }
                });
            });

           function updatecart(rowid){
            // console.log(rowid);
            var cartid = $("#cart_id_"+rowid).val();
            // console.log(cartid);
                var prod_qty = $("#product_qty_"+rowid).val();
                if(prod_qty > 0){
                $.ajax({
                    url: '{{route("updatecart")}}',
                    method: 'POST',
                    data: {
                        'cart_id': cartid,
                        "prod_qty": prod_qty
                    },
                    dataType: 'JSON',
                    "headers": {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    success:function(response)
                    {
                        $("#row_id_"+row_id).remove();
                        getsubtotal();
                    },
                    error: function(response)
                    {
                        console.log(response);
                    }
                });
            }
        }
        });
    </script>
     @endpush
</x-guest-layout>