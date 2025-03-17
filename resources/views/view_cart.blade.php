<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    @if(Session::has('success'))
    <x-alert-msg class_type="success" msg_text="{{ Session::get('success') }}" />
    @endif
    @if(Session::has('error'))
    <x-alert-msg class_type="danger" msg_text="{{ Session::get('error') }}" />
    @endif
    @if(Session::has('cart_success'))
    <x-alert-msg class_type="success" msg_text="{{ Session::get('cart_success') }}" />
    @endif
    @if(Session::has('cart_warning'))
    <x-alert-msg class_type="info" msg_text="{{ Session::get('cart_warning') }}" />
    @endif
    @if(Session::has('cart_danger'))
    <x-alert-msg class_type="danger" msg_text="{{ Session::get('cart_danger') }}" />
    @endif
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive">
                <h4 class="font-weight-semi-bold">My Cart</h4>
                <small>
                    <a href="{{ route('page.home') }}" class="text-decoration-none">Home</a> >
                    <a href="{{ route('page.cart') }}" class="text-decoration-none">My Cart List</a>
                </small>
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>MRP</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($cart_items as $cartkey=>$item)
                        <tr>
                            <td class="align-middle"><img src="{{ asset($item->product->defaultImg->product_img) }}" alt="" style="width: 50px;"> {{ $item->product->product_name }}</td>
                            <td class="align-middle">Rs. {{ number_format($item->product->product_mrp,2) }}</td>
                            <td class="align-middle">Rs. {{ number_format($item->product->product_price,2) }}</td>
                            <td class="align-middle">
                                <form method="POST" action="{{ route('page.addtocart', $item->product_id) }}">
                                    @csrf
                                    <select class="form-control" name="product_qty" onchange="this.form.submit()">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" @if($item->product_qty == $i) selected @endif>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </form>
                            </td>
                            <td class="align-middle">Rs. {{ number_format($item->total_value,2) }}</td>
                            <td class="align-middle">
                                <form method="POST" action="{{route('page.removetocart', $item->id)}}">
                                    @csrf
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Items In Cart</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                @auth
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                @endauth
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($cart_value as $key_value=>$value)
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">{{ $key_value }}</h6>
                            <div class="d-flex flex-column align-items-end">
                                <h6 class="font-weight-medium">Rs. {{ number_format($value,2) }}
                                </h6>
                                @if(strtoupper($key_value) == 'SHIPPING')
                                <p>
                                    <small>{{ $shipping_text }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rs. {{ number_format($total_value,2) }}</h5>
                        </div>
                        @auth
                        @if(count($cart_items))
                        <a href="{{ route('page.checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                        @else
                        <a href="{{ route('page.home') }}" class="btn btn-block btn-primary my-3 py-3">Countinue to Shopping</a>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-block btn-primary my-3 py-3">Login To Checkout</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
</x-app-layout>