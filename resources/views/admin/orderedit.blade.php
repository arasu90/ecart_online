<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Order Master
                        @if($errors)
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                        @endif
                        <a href="{{route('orderlist')}}" class="btn btn-sm btn-warning pull-right nav-link">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <h4>OrderDate</h4>
                                <p>{{ $orderMaster->order_date }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>OrderValue</h4>
                                <p>Rs. {{ $orderMaster->total_amt }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>NoOfQty</h4>
                                <p>Qty: {{ $orderMaster->total_order_qty }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>OrderBy</h4>
                                <p>{{ $orderMaster->getuserName->name }}</p>
                                <p>{{ $orderMaster->getuserName->email }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>OrderStatus</h4>
                                <p><span class="badge {{ config('appstatus.orderstatus.'.$orderMaster->order_status.'.color','badge-danger') }}">{{ config('appstatus.orderstatus.'.$orderMaster->order_status.'.name','Inactive') }}</span></p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>PaymentStatus</h4>
                                <p><span class="badge {{ config('appstatus.paymentstatus.'.$orderMaster->payment_status.'.color','badge-danger') }}">{{ config('appstatus.paymentstatus.'.$orderMaster->payment_status.'.name','Inactive') }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <h4>Payment Mode</h4>
                                <p><strong class="text-uppercase">{{ $orderMaster->payment_mode }}</strong></p>
                                <p><strong>RefNo::</strong> {{ $orderMaster->payment_reference_no }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>Billing Address</h4>
                                <p>
                                    @php
                                        $address = explode("|",$orderMaster->billing_details);
                                        foreach ($address as $key=>$detail ){
                                            switch($key){
                                                case(0):
                                                    echo "<strong>First Name: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(1):
                                                    echo "<strong>Last Name: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(2):
                                                    echo "<strong>Mobile No: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(3):
                                                    echo "<strong>Address Line 1: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(4):
                                                    echo "<strong>Address Line 2: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(5):
                                                    echo "<strong>City: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(6):
                                                    echo "<strong>State: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                case(7):
                                                    echo "<strong>PinCode: </strong>".$detail;
                                                    echo "</br>";
                                                    break;
                                                default;
                                            }
                                        }
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Ordered Items
                        @if(Session::has('failed'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('failed') }}
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('success') }}
                        </span>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <div class="card-sub">
                        Create responsive tables by wrapping any table with
                        <code class="highlighter-rouge">.table-responsive</code>
                        <code class="highlighter-rouge">DIV</code> to make them
                        scroll horizontally on small devices
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-bordered-bd-info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ProductName</th>
                                    <th>ProductValue</th>
                                    <th>TotalAmt</th>
                                    <th>DeliveryDate</th>
                                    <th>DeliveryNotes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $items)
                                <tr>
                                    <form method="POST" action="{{route('updateorderitem',$items->id)}}" enctype='multipart/form-data'>
                                        @csrf
                                        <th scope="row">{{ $loop->index+1 }}</th>
                                        <td>
                                            <p>{{ $items->product_name }}</p>
                                            <p>(MRP: {{ $items->product_mrp }})
                                                <input type="hidden" name="orderitemid" id="orderitemid" value="{{ $items->id }}">
                                            </p>
                                        </td>
                                        <td>
                                            <p>{{ $items->sub_total }}</p>
                                            <p>(Qty: {{ $items->product_qty }} x Rs. {{ $items->product_rate }})</p>
                                        </td>
                                        <td>{{ $items->total_amt }}</td>
                                        <td>
                                            {{ (!is_null($items->delivery_date) ? date("d-m-Y", strtotime($items->delivery_date)) : "") }}
                                            <p><input type="text" name="delivery_date" id="delivery_date_{{$loop->index+1}}" class="delivery_date" style="display:none" placeholder="YYYY-MM-DD" /></p>
                                        </td>
                                        <td>
                                            {{ $items->delivery_notes }}
                                            <p><input type="text" name="delivery_notes" id="delivery_notes_{{$loop->index+1}}" class="delivery_notes" style="display:none" /></p>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-link btn-primary btn-sm rowedit" id="editbtn_{{$loop->index+1}}" data-row_id="{{$loop->index+1}}"><i class="fas fa-edit"></i></button>
                                            <span style="display:none" id="actionbtn_{{$loop->index+1}}">
                                                <button type="submit" class="btn btn-link btn-success btn-sm" data-row_id="{{$loop->index+1}}"><i class="fas fa-check"></i></button>
                                                <button type="button" class="btn btn-link btn-danger btn-sm hiderow" data-row_id="{{$loop->index+1}}"><i class="fas fa-times"></i></button>
                                            </span>
                                        </td>
                                    </form>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
            $(document).ready(function() {
                $(".rowedit").on('click', function(e) {
                    var rowid = $(this).data('row_id');
                    $("#delivery_date_" + rowid).show();
                    $("#delivery_notes_" + rowid).show();
                    $("#actionbtn_" + rowid).show();
                    $("#editbtn_" + rowid).hide();
                });
                $(".hiderow").on('click', function(e) {
                    var rowid = $(this).data('row_id');
                    console.log("rowid " + rowid);
                    $("#delivery_date_" + rowid).val('');
                    $("#delivery_notes_" + rowid).val('');
                    $("#delivery_date_" + rowid).hide();
                    $("#delivery_notes_" + rowid).hide();
                    $("#actionbtn_" + rowid).hide();
                    $("#editbtn_" + rowid).show();
                });

            });
        </script>
        @endpush
</x-admin-layout>