<x-guest-layout>
    <!-- Checkout Start -->
    <form id="paymentForm">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
                @csrf
            <div class="col-lg-6">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>
                                    @php
                                        $address = explode("|", $ordermaster->billing_details);
                                        foreach($address as $key=>$value){
                                           
                                            if($key==0){
                                                echo "<strong>".$value."</strong>";
                                            }else{
                                                echo $value;
                                            }
                                            if($value !=""){
                                                echo "<br />";
                                            }
                                        }
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">TOTAL</h4>
                        <h2 class="float-right">Rs. {{ number_format($ordermaster->total_amt,2)}}</h2>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Make Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    <!-- Checkout End -->
    @push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('paymentForm').onsubmit = async function(e) {
            e.preventDefault();

            // Fetch the order creation endpoint
            const response = await fetch('/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                name: 'Kalaiarasu',
                image:'{{ getenv("PAYMENTLOGO") }}', // img url online path
                description: 'Test Transaction',
                order_id: orderData.id, // Pass the order ID generated in the previous step
                handler: function (response) {
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
                        }),
                    }).then(response => response.json()).then(data => {
                        window.location = "thankyou";
                    });
                },
                prefill: { // who make the payment that user details
                    name: 'Kalaiarasu',
                    email: 'admin@admin.com',
                    contact: '9003999590'
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
</x-guest-layout>