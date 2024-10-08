<x-guest-layout>
    <!-- Checkout Start -->
    <form action="{{route('checkoutpayment')}}" method="post">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
                @csrf
            <div class="col-lg-4">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('profile.myaddress','backto=checkout') }}" class="btn btn-sm btn-success">Add New Address</a>
                            @error('bill_address')
                            <small class="text-danger">{{ __('Please Select Address') }}</small>
                            @enderror
                            @php
                                $counter = 0;
                            @endphp

                            @forelse ($addresslist as $address)
                                @php
                                    if($address->make_default == 0){
                                        $counter++;
                                    }
                                @endphp
                                <div class="form-group">
                                    <strong>
                                        <input type="radio" class="radio" name="bill_address" id="bill_address" {{ ($address->make_default == 1 || $counter == count($addresslist))? 'checked' : '' }} value="{{ $address->id }}">
                                        {{ $address->contact_name }}
                                    </strong>(<span>{{ $address->contact_mobile }}</span>) <br />
                                    <span class="px-3">{{ $address->address_line1 }}, {{ $address->address_line2 }}</span> <br />
                                    <span class="px-3">{{ $address->address_city }}, {{ $address->address_state }} - {{ $address->address_pincode }}</span class="px-3">
                                </div>
                            @empty
                                
                            @endforelse

                        </div>
                        <div class="col-md-6 form-group">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
            <div class="card border-secondary mb-5">
                                <div class="card-header bg-secondary border-0">
                                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                                </div>
                                <div class="card-body">
                                    <h5 class="font-weight-medium mb-3">Products</h5>
                                    @php
                                    $subtotal = 0;
                                    $total_saving = 0;
                                    @endphp
                                    @foreach($cart_data as $cart_data_list)
                                    @foreach($cart_data_list->cart_item_list as $cart)
                                    <div class="d-flex justify-content-between">
                                        <p><span style="color:black !important">{{$cart->product_list->product_name}}</span> <br /><small>(Qty:{{$cart->product_qty}} * Rs.{{$cart->product_list->product_rate}}) MRP:Rs.{{$cart->product_list->product_mrp}}</small></p>
                                        <p><strong>Rs. {{ number_format($cart->product_qty * $cart->product_list->product_rate,2)}}</strong></p>
                                    </div>
                                    @php
                                    $subtotal += $cart->product_qty * $cart->product_list->product_rate;
                                    $total_saving += $cart->product_qty * $cart->product_list->product_mrp;
                                    @endphp
                                    @endforeach
                                    @endforeach
                                    <hr class="mt-0">
                                    <div class="d-flex justify-content-between mb-3 pt-1">
                                        <h6 class="font-weight-medium">Subtotal <p><small>Total Saving: Rs: {{number_format($total_saving-$subtotal,2)}}</small></p></h6>
                                        <h6 class="font-weight-medium">Rs. {{number_format($subtotal,2)}}</h6>
                                           
                                    </div>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <div class="d-flex justify-content-between mt-2">
                                        <h5 class="font-weight-bold">Total</h5>
                                        <h5 class="font-weight-bold">Rs. {{number_format($subtotal,2)}}</h5>
                                        <input type="hidden" name="cart_master_id" id="cart_master_id" value="{{$cart_data_list->id}}">
                                    </div>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                                </div>
                            </div>
            </div>
        </div>
    </div>
</form>
    <!-- Checkout End -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#gpay').on('click', function() {
               $(".gpaydiv").show();
               $(".paypaldiv").hide();
               $(".banktransferdiv").hide();
            });
            $('#paypal').on('click', function() {
               $(".gpaydiv").hide();
               $(".paypaldiv").show();
               $(".banktransferdiv").hide();
            });
            $('#banktransfer').on('click', function() {
               $(".gpaydiv").hide();
               $(".paypaldiv").hide();
               $(".banktransferdiv").show();
            });

        });
    </script>
    @endpush
</x-guest-layout>