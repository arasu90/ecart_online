<x-guest-layout>
    <!-- Checkout Start -->
    <form action="{{route('checkoutpayment')}}" method="post">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
                @csrf
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('profile.myaddress','backto=checkout') }}" class="btn btn-sm btn-success">Add New Address</a>
                            @error('bill_address')
                            <small class="text-danger">{{ __('Please Select Address') }}</small>
                            @enderror
                            @php
                                $counter = 7;
                            @endphp

                            @forelse ($addresslist as $address)
                                @php
                                    if($address->make_default == 0){
                                        $counter++;
                                    }
                                @endphp
                                <div class="form-group">
                                    <span>
                                        <input type="radio" class="radio" name="bill_address" id="bill_address" {{ ($address->make_default == 1 || $counter == count($addresslist))? 'checked' : '' }} value="{{ $address->id }}">
                                        {{ $address->contact_name }}
                                    </span><br />
                                    <span class="px-3">{{ $address->contact_mobile }}</span> <br />
                                    <span class="px-3">{{ $address->address_line1 }}, {{ $address->address_line2 }}</span> <br />
                                    <span class="px-3">{{ $address->address_city }}, {{ $address->address_state }} - {{ $address->address_pincode }}</span class="px-3">
                                </div>
                            @empty
                                
                            @endforelse

                        </div>
                        <div class="col-md-6 form-group">
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
                                        <p>Rs. {{ number_format($cart->product_qty * $cart->product_list->product_rate,2)}}</p>
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
                            </div>
                        </div>

                        <!-- <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Create an account</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="First Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Last Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="xxx xxxx xxxx">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="Address Line 1">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="Address Line 2">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 3</label>
                            <input class="form-control" type="text" placeholder="Address Line 3">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="City">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="State">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pin Code</label>
                            <input class="form-control" type="text" placeholder="Pincode">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="card border-secondary mt-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="gpay" required value="gpay" {{ (old('payment') == 'gpay') ? 'checked' : ''}}  >
                                <label class="custom-control-label" for="gpay">GPay </label>
                            </div>
                            @error('gpay_ref_no')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal" required value="paypal" {{ (old('payment') == 'paypal') ? 'checked' : ''}}>
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer" required value="banktransfer" {{ (old('payment') == 'banktransfer') ? 'checked' : ''}}>
                                <label class="custom-control-label" for="banktransfer">Bank Transfer/Net Banking</label>
                            </div>
                        </div>
                        @error('bill_address_line2')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="form-group gpaydiv" {{ (old('payment') == 'gpay') ? '' : 'style=display:none;' }} >
                            <label for=""><strong>Gpay</strong></label>
                            <p>Scan and Pay this QR Code and enter the reference no</p>
                            <x-img-tag img_url="{{ getGpayImg() }}" class="w-80" />
                            <label for="gpay_ref_no">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="gpay_ref_no" id="gpay_ref_no" value="{{old('gpay_ref_no')}}"class="form-control" autocomplete="gpay_ref_no">
                            @error('gpay_ref_no')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="form-group paypaldiv" {{ (old('payment') == 'paypal') ? '' : 'style=display:none;' }} >
                            <label for=""><strong>PayPal</strong></label>
                            <p>Scan and Pay this QR Code and enter the reference no</p>
                            <x-img-tag img_url="img/product-1.jpg" class="w-100" />
                            <label for="paypal_ref_no">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="paypal_ref_no" id="paypal_ref_no" class="form-control" autocomplete="paypal_ref_no">
                            @error('paypal_ref_no')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="form-group banktransferdiv" {{ (old('payment') == 'banktransfer') ? '' : 'style=display:none;' }} >
                            <label for=""><strong>Bank Details</strong></label>
                            <p>TransferMoney below bank detail and enter the reference no</p>
                            <div>
                                <p>Bank Name: xxxx</p>
                                <p>Bank Account No: xxxx</p>
                                <p>Bank IFSC Code: xxxx</p>
                                <p>Bank Branch: xxxx</p>
                            </div>
                            <label for="banktransfer_ref_no">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="banktransfer_ref_no" id="banktransfer_ref_no" class="form-control">
                            @error('banktransfer_ref_no')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
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