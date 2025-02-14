@props(['product_name','product_price','product_mrp','product_img','product_id','is_cart_added'])
<div class="card product-item border-0 mb-4">
    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
        <img class="img-fluid w-100 product-card-img" src="{{ asset($product_img) }}" alt="{{ $product_name }}">
    </div>
    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
        <h6 class="text-truncate mb-3">{{ $product_name }}</h6>
        <div class="d-flex justify-content-center">
            <h6>Rs. {{ $product_price }}</h6>
            <h6 class="text-muted ml-2"><del>Rs. {{ $product_mrp }}</del></h6>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between bg-light border">
        <a href="{{ route('page.showproduct', $product_id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
        @if ($is_cart_added)
        <form method="POST" action="{{route('page.removetocart', $is_cart_added)}}">
            @csrf
            <button type="submit" class="btn btn-sm p-0 text-primary">
                <i class="fas fa-check text-primary mr-1"></i>{{ __('Remove Cart') }}
            </button>
        </form>
        @else
        <form method="POST" action="{{route('page.addtocart', $product_id)}}">
            @csrf
            <button type="submit" class="btn btn-sm text-dark p-0">
                <i class="fas fa-shopping-cart text-primary mr-1"></i>{{ __('Add To Cart') }}
            </button>
        </form>
        @endif
    </div>
</div>
