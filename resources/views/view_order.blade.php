@inject('CommonFun', 'App\CommonClass')
<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-12">
                        <h4 class="font-weight-semi-bold mb-4">View Order</h4>
                        <small>
                            <a href="{{ route('page.home') }}" class="text-decoration-none">Home</a> >
                            <a href="{{ route('page.orderlist') }}" class="text-decoration-none">Order List</a> >
                            <span>View Order</span>
                        </small>
                        <div class="row pt-4">
                            <div class="col-md-6">
                                <h1>Billing Details</h1>
                                <p>
                                    @php
                                    $orderMaster->billing_details = json_decode($orderMaster->billing_details, true)
                                    @endphp
                                    {{ $orderMaster->billing_details['name'] }} <br />
                                    {{ $orderMaster->billing_details['phone'] }} <br />
                                    {{ $orderMaster->billing_details['address'] }} <br />
                                    @if($orderMaster->billing_details['landmark'])
                                    Landmark : {{ $orderMaster->billing_details['landmark'] }} <br />
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h1>Order Details</h1>
                                <p>
                                    Order Date : {{ $orderMaster->order_date }} <br />
                                    Payment Mode  : {{ $orderMaster->payment_mode }} <br />
                                    Reference ID : {{ $orderMaster->payment_reference_no }} <br />
                                    Order Status : <td>
                                        {!! html_entity_decode($CommonFun->getOrderStatus($orderMaster->order_status)) !!}
                                    </td> <br />
                                </p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sl.No') }}</th>
                                            <th>{{ __('Product Name') }}</th>
                                            <th>{{ __('MRP') }}</th>
                                            <th>{{ __('Qty') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Total Amount') }}</th>
                                            <th>{{ __('Order Status') }}</th>
                                            <th>{{ __('Delivery Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $items)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $items->product_name }}</td>
                                                <td>{{ $items->product_mrp }}</td>
                                                <td>{{ $items->product_qty }}</td>
                                                <td>{{ $items->product_price }}</td>
                                                <td>{{ $items->total_amt }}</td>
                                                <td>
                                        {!! html_entity_decode($CommonFun->getOrderStatus($items->order_status)) !!}
                                    </td>
                                                <td>{{ $items->delivery_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 text-right offset-md-8">
                                <p>
                                    sub total : {{ $orderMaster->sub_total }} <br />
                                    Tax : {{ $orderMaster->tax_amt }} <br />
                                    <b>Total Amount : {{ $orderMaster->total_amt }} <br /></b>
                                    Delivery Charges : {{ $orderMaster->shipping_amt }} <br />
                                    <h4>Total Amount : {{ $orderMaster->net_total_amt }} </h4><br />

                                </p>
                            </div>
                        </div>
                </div>
            </div>
    </div>
</x-app-layout>
