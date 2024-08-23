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
                            <div class="form-group">
                                <label>First Name<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="bill_firstname" id="bill_firstname" placeholder="First Name" value="{{old('bill_firstname')}}" required>
                                @error('bill_firstname')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="bill_lastname" id="bill_lastname" type="text" placeholder="Last Name" value="{{old('bill_firstname')}}">
                                @error('bill_lastname')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Contact No<span class="text-danger">*</span></label>
                                <input class="form-control" name="bill_contactno" id="bill_contactno"  type="text" placeholder="Contact No" required value="{{old('bill_contactno')}}">
                                @error('bill_contactno')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address Line 1<span class="text-danger">*</span></label>
                                <input class="form-control" name="bill_address_line1" id="bill_address_line1" type="text" placeholder="Address Line 1" required value="{{old('bill_address_line1')}}">
                                @error('bill_address_line1')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" name="bill_address_line2" id="bill_address_line2" type="text" placeholder="Address Line 2" value="{{old('bill_address_line2')}}">
                                @error('bill_address_line2')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>City<span class="text-danger">*</span></label>
                                <input class="form-control" name="bill_city" id="bill_city" type="text" placeholder="City" required value="{{old('bill_city')}}">
                                @error('bill_city')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>State<span class="text-danger">*</span></label>

                                <select class="form-control" name="bill_state" id="bill_state" required>
                                    <option value="">Select State</option>
                                    @foreach($state_list as $state )
                                    <option value="{{$state}}" {{ (old('bill_state') == $state ? "selected":"") }} >{{$state}}</option>
                                    @endforeach
                                </select>
                                @error('bill_state')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pin Code<span class="text-danger">*</span></label>
                                <input class="form-control"  name="bill_pincode" id="bill_pincode" type="text" placeholder="Pincode" required value="{{old('bill_pincode')}}">
                                @error('bill_pincode')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                                    @endphp
                                    @foreach($cart_data->cart_item_list as $cart)
                                    <div class="d-flex justify-content-between">
                                        <p>{{$cart->product_list->product_name}} <br /><small>({{$cart->product_qty}} * {{$cart->product_list->product_rate}})</small></p>
                                        <p>{{ number_format($cart->product_qty * $cart->product_list->product_rate,2)}}</p>
                                    </div>
                                    @php
                                    $subtotal += $cart->product_qty * $cart->product_list->product_rate;
                                    @endphp
                                    @endforeach
                                    <hr class="mt-0">
                                    <div class="d-flex justify-content-between mb-3 pt-1">
                                        <h6 class="font-weight-medium">Subtotal</h6>
                                        <h6 class="font-weight-medium">${{number_format($subtotal,2)}}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="font-weight-medium">Shipping</h6>
                                        <h6 class="font-weight-medium">$10.00</h6>
                                    </div>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <div class="d-flex justify-content-between mt-2">
                                        <h5 class="font-weight-bold">Total</h5>
                                        <h5 class="font-weight-bold">${{number_format($subtotal+10,2)}}</h5>
                                        <input type="hidden" name="cart_master_id" id="cart_master_id" value="{{$cart_data->id}}">
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
                                <input type="radio" class="custom-control-input" name="payment" id="gpay" required value="gpay" {{ (old('payment') == 'gpay') ? 'checked' : ''}} >
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
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
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
                            <x-img-tag img_url="img/product-1.jpg" class="w-100" />
                            <label for="gpay_ref_no">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="gpay_ref_no" id="gpay_ref_no" value="{{old('gpay_ref_no')}}"class="form-control">
                            @error('gpay_ref_no')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <div class="form-group paypaldiv" {{ (old('payment') == 'paypal') ? '' : 'style=display:none;' }} >
                            <label for=""><strong>PayPal</strong></label>
                            <p>Scan and Pay this QR Code and enter the reference no</p>
                            <x-img-tag img_url="img/product-1.jpg" class="w-100" />
                            <label for="paypal_ref_no">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="paypal_ref_no" id="paypal_ref_no" class="form-control">
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