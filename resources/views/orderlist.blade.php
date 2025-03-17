@inject('CommonClass', 'App\CommonClass')
<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <h4 class="font-weight-semi-bold mb-4">My Order List</h4>
                <small>
                    <a href="{{ route('page.home') }}" class="text-decoration-none">Home</a> >
                    <a href="{{ route('page.orderlist') }}" class="text-decoration-none">Order List</a>
                </small>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('SlNo') }}</th>
                                    <th>{{ __('Order Date') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Order Status') }}</th>
                                    <th>{{ __('Total Amount') }}</th>
                                    <th>{{ __('Delivey Date') }}</th>
                                    <th>{{ __('Delivey Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order_list as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>
                                        {{ $order->product_name }}
                                        <br />
                                        {{ $order->product_qty }} x {{ $order->product_price }}
                                    </td>
                                    <td>
                                        {!! html_entity_decode($CommonClass->getOrderStatus($order->order_status)) !!}
                                    </td>
                                    <td>{{ $order->total_amt }}</td>
                                    <td>{{ $order->delivey_date }}</td>
                                    <td>{{ $order->delivey_notes }}</td>
                                    <td>
                                        <a href="{{ route('page.vieworder', $order->order_master_id) }}" class="btn btn-primary">View Order</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Orders Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
