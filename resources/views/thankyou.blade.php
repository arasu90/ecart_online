<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>

    <div class="row">
        <div class="offset-md-3 col-md-6 text-white bg-info mb-3">
            <p>Thank you for your purchase! We appreciate your business and are excited to process your order.</p>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-3 col-md-6 text-white bg-info mb-5">
            <span>You will be redirected shortly <span id="countdown">10</span> seconds...</span>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function() { // Redirect after 10 seconds

            // Update the countdown every second
            setInterval(updateCountdown, 1000);

            // setTimeout(function() {
            //     window.location.href = "{{ env('APP_URL') }}";
            // }, 10000); // 10000 milliseconds = 10 seconds

            let countdownTime = 10;

            // Function to update the countdown display
            function updateCountdown() {
                const countdownElement = document.getElementById('countdown');
                countdownElement.textContent = countdownTime;

                // Decrease the countdown time
                countdownTime--;

                // Check if the countdown has reached zero
                if (countdownTime < 0) {
                    // Redirect to the specified URL
                    window.location.href = "{{ env('APP_URL') }}";
                }
            }
        });
    </script>
    @endpush
</x-app-layout>