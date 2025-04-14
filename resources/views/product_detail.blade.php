<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @forelse($product_data->product_img as $key=>$image_data)
                        <div class="carousel-item {{ ($key==0) ? 'active' : '' }} ">
                            <x-img-tag image_url="{{ $image_data->product_img }}" img_alt="{{$product_data->url_product_name}}" />
                        </div>
                        @empty
                        <div class="carousel-item active">
                            <x-img-tag image_url="img/default_image.jpg" img_alt="{{$product_data->url_product_name}}" />
                        </div>
                        @endforelse
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
                <h3 class="font-weight-semi-bold">{{ $product_data->product_name }} </h3>
                <div class="d-flex mb-3">
                    <x-rating-tag rating="{{ $averageRating }}" />
                    <small class="pt-1">({{ count($product_data->product_review) }} Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">Rs.{{ number_format($product_data->product_price,2) }} <del class="text-muted ml-2 small">Rs.{{ number_format($product_data->product_mrp,2) }}</del></h3>

                <p class="mb-4">{{ $product_data->product_detail }}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    @isset($product_data->cart_item->id)
                    <form method="POST" action="{{route('page.removetocart', ['cartid'=>$product_data->cart_item->cid])}}">
                        @csrf
                        <button class="btn btn-primary px-3"><i class="fa fa-check mr-1"></i>{{ __('Remove Cart') }}</button>
                    </form>
                    @else
                    <form method="POST" action="{{route('page.addtocart', ['pid'=>$product_data->pid])}}">
                        @csrf
                        <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                    </form>
                    @endisset

                    @php
                        $productName = $product_data->product_name ?? 'Awesome Product';
                        $shareUrl = request()->fullUrl();
                        $shareText = "🛒 MRSPARES Check out this product: *$productName* 🔗 $shareUrl";
                    @endphp

                    <a class="share-option" href="https://wa.me/?text={{ urlencode($shareText) }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="30" viewBox="0 0 512 512">
                            <path fill="#25B7D3" d="M7.9,256C7.9,119,119,7.9,256,7.9C393,7.9,504.1,119,504.1,256c0,137-111.1,248.1-248.1,248.1C119,504.1,7.9,393,7.9,256z"></path>
                            <path fill="#FFF" d="M154.4 203.09999999999997A53.8 53.8 0 1 0 154.4 310.7 53.8 53.8 0 1 0 154.4 203.09999999999997zM318.7 107.39999999999999A53.8 53.8 0 1 0 318.7 215 53.8 53.8 0 1 0 318.7 107.39999999999999zM318.7 297A53.8 53.8 0 1 0 318.7 404.6 53.8 53.8 0 1 0 318.7 297z"></path>
                            <g>
                                <path fill="#FFF" d="M222.1 112.2H251V302.3H222.1z" transform="rotate(59.786 236.552 207.272)"></path>
                            </g>
                            <g>
                                <path fill="#FFF" d="M141.5 288.5H331.6V317.4H141.5z" transform="rotate(30.214 236.576 302.965)"></path>
                            </g>
                        </svg>
                    </a>
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
                    <a class="nav-item nav-link @if (!$errors->any()) active @endif" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link @if ($errors->any()) active @endif " data-toggle="tab" href="#tab-pane-2">Reviews ({{ count($product_data->product_review) }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade @if (!$errors->any()) show active @endif" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Features</th>
                                <th>Description</th>
                            </tr>
                            @foreach ($product_data->product_field_data as $fied_data)
                            <tr>
                                <td>{{ ucfirst($fied_data->field_name) }}</td>
                                <td>{{ ucfirst($fied_data->product_field_value->field_value) }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="tab-pane fade @if ($errors->any()) show active @endif" id="tab-pane-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ count($product_data->product_review) }} review</h4>
                                @forelse($product_data->product_review as $review)
                                <div class="media mb-4">
                                    <img src="{{ asset('assets/img/user2.png') }}" alt="carousel items" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>{{ $review->users->name }}<small> - <i>{{ $review->created_at->format('d M Y'); }}</i></small></h6>
                                        <x-rating-tag rating="{{ $review->review_rating }}" />
                                        <p>{{ $review->review_comment }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="media mb-4">
                                    Yet to review this product
                                </div>
                                @endforelse
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                @auth
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2 text-black">Your Rating * :</p>
                                    <x-rating-tag rating="0" style="cursor:pointer" starclass="star" />
                                    @error('review_rating')
                                    <span class="text-danger" role="alert">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <form method="POST" action="{{ route('submit.review') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message" class="text-black">Your Review *</label>
                                        <textarea name="review_comment" cols="30" rows="5" class="form-control"></textarea>
                                        <input type="hidden" name="product_id" value="{{$product_data->id}}" />
                                        <input type="hidden" name="review_rating" id="review_rating">
                                        @error('review_comment')
                                        <span class="text-danger" role="alert">{{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Submit Your Review" class="btn btn-secondary px-3">
                                    </div>

                                </form>
                                @else
                                <small>Review your comment after login <a href="{{route('login')}}" class="link">Click Here</a></small>
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
                    @foreach ($related_product_list as $related_product)
                    <x-product-card
                        product_name="{{ $related_product->product_name }}"
                        url_product_name="{{ $related_product->url_product_name }}"
                        product_img="{{ $related_product->defaultImg->product_img }}"
                        product_mrp="{{ $related_product->product_mrp }}"
                        product_price="{{ $related_product->product_price }}"
                        product_id="{{ $related_product->pid }}"
                        is_cart_added="{{ $related_product->cart_item->cid ?? 0 }}" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star');
            let selectedRating = 0;

            stars.forEach(star => {
                star.addEventListener('mouseover', () => {
                    const value = star.getAttribute('data-value');
                    updateStars(value);
                });

                star.addEventListener('mouseout', () => {
                    updateStars(selectedRating);
                });

                star.addEventListener('click', () => {
                    selectedRating = star.getAttribute('data-value');
                    $("#review_rating").val(selectedRating);
                    updateStars(selectedRating);
                });
            });

            function updateStars(rating) {
                stars.forEach(star => {
                    var value = star.getAttribute('data-value');
                    if (value <= rating) {
                        star.classList.add('fas');
                        star.classList.remove('far');
                    } else {
                        star.classList.remove('fas');
                        star.classList.add('far');
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>