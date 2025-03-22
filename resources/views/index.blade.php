<x-app-layout>
    <x-slot name="carousel">
        @include('include.carousel')
    </x-slot>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <!-- Featured Start -->
    <div class="container-fluid bg-secondary">
        <div class="row px-xl-5">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4 padding-30px">
                    <h2 class="fa fa-check text-primary m-0 mr-3"></h2>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4 padding-30px">
                    <h2 class="fa fa-shipping-fast text-primary m-0 mr-2"></h2>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4 padding-30px">
                    <h2 class="fas fa-exchange-alt text-primary m-0 mr-3"></h2>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4 padding-30px">
                    <h2 class="fa fa-phone-volume text-primary m-0 mr-3"></h2>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Category</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($category_list as $category)
            @if(count($category->product))
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">{{ count($category->product) }} Products</p>
                    <a href="{{ route('product.list',[$category->url_category_name,'cid'=>$category->cid]) }}" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid category-img" src="{{ asset($category->category_img) }}" alt="category">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">{{ $category->category_name }}</h5>
                </div>
            </div>
            @endif
            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 pb-1">
                <div class='text-right'>
                    <a href="{{ route('product.list') }}">View More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($trandy_product as $trand_product)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <x-product-card
                    product_name="{{ $trand_product->product_name }}"
                    url_product_name="{{ $trand_product->url_product_name }}"
                    product_img="{{ $trand_product->defaultImg->product_img }}"
                    product_mrp="{{ $trand_product->product_mrp }}"
                    product_price="{{ $trand_product->product_price }}"
                    product_id="{{ $trand_product->pid }}"
                    is_cart_added="{{ $trand_product->cart_item->cid ?? 0 }}"
                    />
            </div>
            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 pb-1">
                <div class='text-right'>
                    <a href="{{ route('product.list') }}">View More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($newly_product as $new_product)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <x-product-card
                    product_name="{{ $new_product->product_name }}"
                    url_product_name="{{ $new_product->url_product_name }}"
                    product_img="{{ $new_product->defaultImg->product_img }}"
                    product_mrp="{{ $new_product->product_mrp }}"
                    product_price="{{ $new_product->product_price }}"
                    product_id="{{ $new_product->pid }}"
                    is_cart_added="{{ $new_product->cart_item->cid ?? 0 }}" />
            </div>
            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 pb-1">
                <div class='text-right'>
                    <a href="{{ route('product.list') }}">View More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Vendor Start -->
    @if(count($brand_list))
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Brand</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach ($brand_list as $brand)
                    <div class="vendor-item border p-4">
                        <a href="{{ route('product.list',['brand'=>1]) }}">
                            <img src="{{ asset($brand->brand_img) }}" style="height:10rem;" alt="">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Vendor End -->

</x-app-layout>
