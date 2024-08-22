<x-guest-layout>
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($banner_data as $key=>$banner_value)
            <div class="carousel-item {{ ($key == 0) ? 'active' : '' }} " style="height: 410px;">
                <x-img-tag img_url="{{ $banner_value->banner_img }}" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">{{ $banner_value->banner_desc }}</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">{{ $banner_value->banner_name }}</h3>
                        <a href="product" class="btn btn-light py-2 px-3">Shop Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if(count($banner_data)>0)
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
        @endif
    </div>
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
    <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2"> Product Category</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach($product_category as $category)
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">{{$category->category_to->count()}} Products</p>
                    <a href="{{route('product')}}" class="cat-img position-relative overflow-hidden mb-3">
                        <x-img-tag img_url="{{$category->category_img}}" />
                    </a>
                    <h5 class="font-weight-semi-bold m-0">{{$category->category_name}}</h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    <!--  <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
        <div class=" owl-carousel related-carousel " >
            @foreach($trand_product as $trand)
            @php
            
            @endphp
            <div class="col-lg-12 col-md-12 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="{{route('productdetail',$trand->id)}}" ><x-img-tag img_url="{{ $trand->defaultImg->image_name }}" class="w-100" /></a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $trand->product_name }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>${{ $trand->product_rate }}.00</h6>
                            <h6 class="text-muted ml-2"><del>${{ $trand->product_mrp }}.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('productdetail',$trand->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <button data-prod_id="{{ $trand->id }}" onclick="addtocart('{{ $trand->id }}')" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <!-- <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class=" owl-carousel related-carousel " >
            @foreach($new_product as $newproduct)
            <!-- <div class="col-lg-12 col-md-12 col-sm-12 pb-1"> -->
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <a href="{{route('productdetail',$newproduct->id)}}" >
                        <x-img-tag img_url="{{ $newproduct->defaultImg->image_name }}" class="w-100" />
                    </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $newproduct->product_name }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>${{ $newproduct->product_rate }}.00</h6>
                            <h6 class="text-muted ml-2"><del>${{ $newproduct->product_mrp }}.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('productdetail',$newproduct->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <button data-prod_id="{{ $trand->id }}" onclick="addtocart('{{ $newproduct->id }}')" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</button>
                    </div>
                </div>
            <!-- </div> -->
            @endforeach
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach($brand_list as $brand)
                    <div class="vendor-item border p-4">
                        <x-img-tag img_url="{{ $brand->brand_img }}" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->

</x-guest-layout>