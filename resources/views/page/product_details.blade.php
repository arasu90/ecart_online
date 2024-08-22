<x-guest-layout>
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5 ">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach($product_data->product_img as $key=>$product)
                        <div class="carousel-item {{ ($key==0) ? 'active' : '' }} ">
                            <x-img-tag img_url="{{ $product->image_name }}" class="w-100 h-75" id="current" />
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product_data->product_name }}</h3>
                <div class="d-flex mb-3">
                    <x-rating-tag rating="{{ $averageRating }}" />
                    <small class="pt-1">({{ count($product_data->product_review) }} Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">${{ number_format($product_data->product_rate,2) }} <del class="text-muted ml-2 small">${{ number_format($product_data->product_mrp,2) }}</del></h3>
                <p class="mb-4">{{ $product_data->product_desc }}</p>
                <!-- <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            <label class="custom-control-label" for="size-1">XS</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-2" name="size">
                            <label class="custom-control-label" for="size-2">S</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-3" name="size">
                            <label class="custom-control-label" for="size-3">M</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-4" name="size">
                            <label class="custom-control-label" for="size-4">L</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-5" name="size">
                            <label class="custom-control-label" for="size-5">XL</label>
                        </div>
                    </form>
                </div> -->
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    <form>
                        @foreach($product_data->product_colors as $key=>$color_data)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-{{$key}}" name="color" value="{{ $color_data->colors->id }}">
                            <label class="custom-control-label" for="color-{{$key}}">{{ $color_data->colors->color_name}}</label>
                        </div>
                        @endforeach
                    </form>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
                <!-- <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{ count($product_data->product_review) }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product_data->product_detail }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">

                                <h4 class="mb-4">{{ count($product_data->product_review) }} review for "Colorful Stylish Shirt"</h4>
                                @foreach($product_data->product_review as $review)
                                <div class="media mb-4">
                                    <img src="{{ asset('img/user.jpg') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>{{ $review->users->name }}<small> - <i>{{ $review->created_at->format('d M Y'); }}</i></small></h6>
                                        <x-rating-tag rating="{{ $review->review_rating }}" />
                                        <p>{{ $review->review_comment }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                @auth
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <x-rating-tag rating="0" />
                                </div>
                                <form method="POST" action="{{ route('savereview') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea name="review_comment" cols="30" rows="5" class="form-control" ></textarea>
                                        <input type="hidden" value="{{$product_data->id}}" name="product_id" />
                                        @error('review_comment')
                                        <span class="text-danger" role="alert">{{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                    @if(Session::has('success'))
                                    <span class="text-success" role="alert">
                                        <strong>{{ Session::get('success') }}</strong>
                                    </span>
                                    @endif
                                </form>
                                @else
                                <small>Review your comment after login <a href="{{route('login')}}" class="link" >Click Here</a></small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach($trand_product as $product)
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <a href="{{route('productdetail',$product->id)}}">
                                <x-img-tag img_url="{{$product->defaultImg->image_name}}" class="w-100" /> </a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{$product->product_name}}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>${{$product->product_rate}}.00</h6>
                                <h6 class="text-muted ml-2"><del>${{$product->product_rate}}.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{route('productdetail',$product->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- 
    <div class="container item-details">
    <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="img/product-1.jpg"  alt="#">
                                </div>
                                <div class="images">
                                    <img src="img/product-6.jpg" class="img" alt="#">
                                    <img src="img/product-5.jpg" class="img" alt="#">
                                    <img src="img/product-4.jpg" class="img" alt="#">
                                    <img src="img/product-3.jpg" class="img" alt="#">
                                    <img src="img/product-2.jpg" class="img" alt="#">
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">GoPro Karma Camera Drone</h2>
                            <p class="category"><i class="lni lni-tag"></i> Drones:<a href="javascript:void(0)">Action
                                    cameras</a></p>
                            <h3 class="price">$850<span>$945</span></h3>
                            <p class="info-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt
                                ut labore et dolore magna aliqua.</p>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group color-option">
                                        <label class="title-label" for="size">Choose color</label>
                                        <div class="single-checkbox checkbox-style-1">
                                            <input type="checkbox" id="checkbox-1" checked>
                                            <label for="checkbox-1"><span></span></label>
                                        </div>
                                        <div class="single-checkbox checkbox-style-2">
                                            <input type="checkbox" id="checkbox-2">
                                            <label for="checkbox-2"><span></span></label>
                                        </div>
                                        <div class="single-checkbox checkbox-style-3">
                                            <input type="checkbox" id="checkbox-3">
                                            <label for="checkbox-3"><span></span></label>
                                        </div>
                                        <div class="single-checkbox checkbox-style-4">
                                            <input type="checkbox" id="checkbox-4">
                                            <label for="checkbox-4"><span></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="color">Battery capacity</label>
                                        <select class="form-control" id="color">
                                            <option>5100 mAh</option>
                                            <option>6200 mAh</option>
                                            <option>8000 mAh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group quantity">
                                        <label for="color">Quantity</label>
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-content">
                                <div class="row align-items-end">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="button cart-button">
                                            <button class="btn" style="width: 100%;">Add to Cart</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="wish-button">
                                            <button class="btn"><i class="lni lni-reload"></i> Compare</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="wish-button">
                                            <button class="btn"><i class="lni lni-heart"></i> To Wishlist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
-->
    <!-- Products End -->
</x-guest-layout>