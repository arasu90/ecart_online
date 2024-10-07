<x-guest-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0" id="carttable">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Total</th>
                            <th>OrderDate</th>
                            <th>OrderStatus</th>
                            <th>DeliveryDate</th>
                            <th>DeliveryNote</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                        $subtotal=0;
                        @endphp 
                        @forelse($orderItems as $cart)
                        <tr id="row_id_{{$loop->index}}">
                            <td class="align-middle text-left" width="25%">
                                <a href="{{route('productdetail',$cart['product_id'])}}" >{{$cart['product_name']}}</a>
                                <p>Qty: {{$cart['product_qty']}} x Rs. {{$cart['product_rate']}} ( MRP : Rs. {{$cart['product_mrp']}} )</p>
                            </td>
                            <td class="align-middle text-left" width="10%">Rs. <span class="productlist product_value_{{$loop->index}}" id="product_value_{{$loop->index}}">{{ number_format($cart['product_rate'] * $cart['product_qty'], 2, '.', '')}}</span></td>
                            <td class="align-middle" >
                                <span class="product_ratetxt_{{$loop->index}}">{{ date("d-M-Y", strtotime($cart['created_at']))}}</span>
                            </td>
                            <td class="align-middle">
                                <span class="product_ratetxt_{{$loop->index}}">
                                {{ config('appstatus.orderstatus.'.$cart['order_status'].'.name','Inactive') }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <span class="product_ratetxt_{{$loop->index}}">{{ ($cart['delivery_date']) ? date("d-M-Y", strtotime($cart['delivery_date'])) : '' }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="product_ratetxt_{{$loop->index}}">{{ ($cart['delivery_notes']) }}</span>
                            </td>
                        </tr>
                        @php
                        $subtotal += ($cart['product_rate']*$cart['product_qty']);
                        @endphp
                        @empty
                        <tr><td colspan="6">Your not yet Ordered Items</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    @push('scripts')
    @endpush
</x-guest-layout>