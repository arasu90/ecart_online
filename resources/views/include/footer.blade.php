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
                @if ($website_data_value['whats_app_no'])
                <p class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1.2rem" class="mr-3"><path fill="#a268e1" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>{{ $website_data_value['whats_app_no'] }}</p>
                @endif
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