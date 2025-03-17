<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <!-- Checkout Start -->
    <div class="container-fluid pb-3 pl-5">
        <small>
            <a href="{{ route('page.home') }}" class="text-decoration-none">Home</a> >
            <a href="{{ route('page.cart') }}" class="text-decoration-none">My Cart List</a> >
            <span>Checkout Page</span>
        </small>
    </div>
    <div class="container-fluid">
        <form id="makepayment_form">
            <div class="row px-xl-5">
                <div class="col-lg-4">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-2">Billing Address</h4>
                        <span class="text-danger" style="display:none" id="address_error" role="alert">{{ __('Please select any address') }} <br />
                        </span>
                        <a href="{{ route('address.list') }}" class="btn btn-sm btn-success">Add New</a>
                        <div class="row">
                            <div class="col-md-12">
                                @forelse ($address_list as $key=>$address)
                                    <div class="form-group">
                                        <strong>
                                            @if ($address->is_default)
                                            <input type="radio" class="radio addresslist" name="bill_address" id="bill_address_{{ $key }}" checked value="{{ $address->id }}">
                                            @else
                                            <input type="radio" class="radio addresslist" name="bill_address" id="bill_address_{{ $key }}" value="{{ $address->id }}">
                                            @endif
                                            
                                            {{ $address->name }}
                                        </strong>
                                        (<span>{{ $address->phone }}</span>) <br />
                                        <span class="px-3">{{ $address->address }}</span> <br />
                                        @if($address->landmark)
                                        <span class="px-3">Landmark: {{ $address->landmark }}</span>
                                        @endif
                                    </div>
                                    @empty
                                    <div class="form-group">
                                        <span>No Address Found</span>
                                    </div>
                                @endforelse
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
                            @foreach ($cart_items as $item)
                            <div class="d-flex justify-content-between">
                                <p>
                                    {{ $item->product->product_name }}<br />
                                    <small>(Qty:{{$item->product_qty}} * Rs.{{$item->product->product_price}}) MRP:Rs.{{$item->product->product_mrp}}</small>
                                </p>
                                <p>Rs. {{ number_format($item->total_value,2) }}</p>
                            </div>
                            @endforeach
                            <hr class="mt-0">
                            @foreach ($cart_value as $key_value=>$value)
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">{{ $key_value }}</h6>
                                <div class="d-flex flex-column align-items-end">
                                    <h6 class="font-weight-medium">Rs. {{ number_format($value,2) }}</h6>
                                @if(strtoupper($key_value) == 'SHIPPING')
                                <p>
                                    <small>{{ $shipping_text }}</small>
                                </p>
                                @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">Rs. {{ number_format($total_value,2) }}</h5>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-footer border-secondary bg-transparent">
                            <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->
    @push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('makepayment_form').onsubmit = async function(e) {
            e.preventDefault();
            $("#address_error").hide();
            var address_id=0;
            $(".addresslist").each(function() {
                if ($(this).is(":checked")) {
                    address_id = $(this).val();
                }
            });
            if(address_id == 0){
                alert("Please select any one address");
                $("#address_error").show();
                return; // Don't submit the form if validation fails
            }
            // console.log('address_id 2'+address_id);
            // Fetch the order creation endpoint
            const response = await fetch('/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'address_id': address_id,
                },
                body: {
                    'order_items': 'test',
                    'address_id': '098',
                }
            });

            // Check if the response is ok and handle errors
            if (!response.ok) {
                const errorData = await response.json();
                alert('Error creating order: ' + errorData.error);
                return;
            }

            const orderData = await response.json();

            // Set up Razorpay payment options
            var options = {
                key: '{{ getenv("RAYZORPAY_API_KEY_ID") }}', // Use the correct key ID
                amount: orderData.amount, // Amount is in currency subunits (in paise)
                currency: orderData.currency,
                name: 'MRSPARES', // user name
                image: '{{ asset(getenv("PAYMENTLOGO")) }}', // img url online path
                description: 'Test Transaction',
                order_id: orderData.id, // Pass the order ID generated in the previous step
                handler: function(response) {
                    // Handle the payment success here
                    fetch('/payment-callback', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            amount: orderData.amount, // Amount is in currency subunits (in paise)
                            currency: orderData.currency,
                            image: '{{ getenv("PAYMENTLOGO") }}', // img url online path
                            description: 'Buy Orders',
                            order_id: orderData.id, // Pass the order ID generated in the previous step
                            receipt: orderData.receipt,
                            'address_id': address_id,
                        }),
                    }).then(response => response.json()).then(data => {
                        console.log(data);
                        window.location = "thankyou";
                    });
                },
                prefill: { // who make the payment that user details
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                    contact: '{{ Auth::user()->mobile }}'
                },
                theme: {
                    color: '#F37254'
                }
            };

            // Open the Razorpay payment modal
            const rzp = new Razorpay(options);
            rzp.open();
        };
    </script>
    @endpush
</x-app-layout>
