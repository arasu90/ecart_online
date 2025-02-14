@inject('CommonClass', 'App\CommonClass')
<x-admin-layout>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('View Orders') }}</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('View Order') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>OrderBy</h4>
                                        <p>{{ $order_master_data->users->name }}</p>
                                        <p>{{ $order_master_data->users->email }}</p>
                                        <p>{{ $order_master_data->users->mobile }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>OrderDate</h4>
                                        <p>{{ $order_master_data->order_date }}</p>
                                    </div>
                                    <div class="form-group">
                                        <h4>OrderValue</h4>
                                        <p>{{ $order_master_data->net_total_amt }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>NoOf Item/Qty</h4>
                                        <p>Total Item: {{ $total_order_item }}</p>
                                        <p>Total Qty: {{ $total_order_qty }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>OrderStatus</h4>
                                        <p>{!! html_entity_decode($CommonClass->getOrderStatus($order_master_data->order_status)) !!}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Payment Mode</h4>
                                        <p>
                                            <strong>RazorPay: </strong>
                                            <span class="text-uppercase">{{ $order_master_data->payment_mode }}</span>
                                        </p>
                                        <p><strong>RefNo: </strong> {{ $order_master_data->payment_reference_no }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Billing Address</h4>
                                        @php
                                        $decodedData = json_decode($order_master_data->billing_details, true);
                                        @endphp
                                        @if(is_array($decodedData))
                                        <p> Name : {{ $decodedData['name'] }} </p>
                                        <p> Mobile No : {{ $decodedData['phone'] }} </p>
                                        <p> Address : {{ $decodedData['address'] }} </p>
                                        <p> LandMark: {{ $decodedData['landmark'] }} </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Item Value</h4>
                                        <p>{{ $order_master_data->item_value }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Discount Amount</h4>
                                        <p>{{ $order_master_data->discount_amt }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Tax Amount</h4>
                                        <p>{{ $order_master_data->tax_amt }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>TotalAmount</h4>
                                        <p>{{ $order_master_data->total_amt }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h4>Shipping Amount</h4>
                                        <p>{{ $order_master_data->shipping_amt }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <h5>Net Total</h5>
                                        <h2>{{ $order_master_data->net_total_amt }}</h2>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-row">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title"><b>Order Item List</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ProductName</th>
                                        <th>TotalAmount</th>
                                        <th>OrderDate</th>
                                        <th>OrderStatus</th>
                                        <th>DeliveryDate</th>
                                        <th>DeliveryNote</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order_item_list as $order_list)
                                    <tr>
                                        <form method="POST" action="{{route('admin.updateorderstatus',$order_list->id)}}" enctype='multipart/form-data'>
                                            @csrf
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order_list->product_name }}</td>
                                            <td>
                                                <p>{{ $order_list->total_amt }}</p>
                                                <p>(Qty: {{ $order_list->product_qty }} x Rs. {{ $order_list->product_price }})</p>
                                            </td>
                                            <td>{{ $order_list->order_date }}</td>
                                            <td>
                                                {!! html_entity_decode($CommonClass->getOrderStatus($order_list->order_status)) !!}
                                                <select name="orderstatus" id="orderstatus" class="rowedit_{{$loop->iteration}} form-control mt-1" style="display:none">
                                                    <option value="1">Order Confirm</option>
                                                    <option value="2">Payment Success</option>
                                                    <option value="3">Yet to Shipping</option>
                                                    <option value="4">Item Dispatched</option>
                                                    <option value="5">Out for Delivery</option>
                                                    <option value="6">Item Delivered</option>
                                                    <option value="7">Order Cancelled</option>
                                                </select>
                                            </td>
                                            <td>
                                                {{ date("d-m-Y", strtotime($order_list->delivery_date)) }}
                                                <br />
                                                <input type="date" name="delivery_date" id="delivery_date" class="rowedit_{{$loop->iteration}} form-control mt-1" style="display:none">
                                            </td>
                                            <td>
                                                {{ $order_list->delivery_notes }}
                                                <br />
                                                <input type="text" name="delivery_notes" id="delivery_notes" class="rowedit_{{$loop->iteration}} form-control mt-1" style="display:none">
                                            </td>
                                            <td>
                                                <div class="editbutton_{{$loop->iteration}}">
                                                    <button type="button" data-row_id="{{$loop->iteration}}" class="btn btn-sm btn-primary rowedit">
                                                        <i class="glyphicon glyphicon-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="actionbutton_{{$loop->iteration}}" style="display:none">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="glyphicon glyphicon-ok"></i>
                                                    </button>
                                                    <button type="button" data-row_id="{{$loop->iteration}}"  class="btn btn-danger btn-sm rowhide">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10">No Orders Ordered</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(".rowedit").on('click', function(e) {
                var rowid = $(this).data('row_id');
                $(".editbutton_" + rowid).hide();
                $(".actionbutton_" + rowid).show();
                $(".rowedit_" + rowid).show();
            });
            $(".rowhide").on('click', function(e) {
                var rowid = $(this).data('row_id');
                $(".editbutton_" + rowid).show();
                $(".actionbutton_" + rowid).hide();
                $(".rowedit_" + rowid).hide();
            });

        });
    </script>
    @endpush
</x-admin-layout>