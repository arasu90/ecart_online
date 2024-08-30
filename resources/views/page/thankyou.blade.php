<div>
@if(Session::has('error'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('error') }}
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('success') }}
                        </span>
                        @endif
</div>

<x-guest-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <!-- <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> -->
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0 text-center">
                        <h4 class="font-weight-semi-bold m-0">Thank You</h4>
                    </div>
                    <div class="card-body ">
                        <div class="text-center justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Your order placed successfully <small> <a href="">Click here</a> to cotiunue to shooping</small></h6>
                        </div>
                    </div>
                    <div class="text-center card-footer border-secondary bg-transparent">
                        <small>You will redirect to home page automatically 10sec</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
