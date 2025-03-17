<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark ">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                <img style="background-color:#fff; border-radius:40px;height:4rem;" src="{{ asset('assets/img/logo.png') }}" alt="logo">
                </a>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>
                    {{ $website_data_value['site_address_line1'] }}, {{ $website_data_value['site_address_line2'] }}, <br />
                    {{ $website_data_value['site_address_city'] }}, {{ $website_data_value['site_address_state'] }} - {{ $website_data_value['site_address_pincode'] }}
                </p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ $website_data_value['site_email'] }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ $website_data_value['site_mobile'] }}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="{{ route('product.list') }}"><i class="fa fa-angle-right mr-2"></i>Product List</a>
                            <a class="text-dark mb-2" target="_blank" href="{{ route('page.terms') }}"><i class="fa fa-angle-right mr-2"></i>Terms & Conditions</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <div class="d-flex flex-column justify-content-start">
                            <p>Support</p>
                            <span>Any query reach out <br /><i class="fa fa-envelope text-primary mr-2"></i>support@mrspares.in </span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-12 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">E-Cart</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://kalaiarasu.com">Kalaiarasu</a><br>
                </p>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>