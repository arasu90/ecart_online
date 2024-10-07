<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">User Details
                        @if($errors)
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                        @endif
                        <a href="{{route('userlist')}}" class="btn btn-sm btn-warning pull-right nav-link">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <h4>User Name</h4>
                                <p>{{ $user_list->name }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>Email</h4>
                                <p>{{ $user_list->email }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>Mobile No</h4>
                                <p>{{ $user_list->email }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <h4>Status</h4>
                                <p>Design</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Ordered Details
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
                                    <th>OrderID</th>
                                    <th>OrderDate</th>
                                    <th>OrderItem</th>
                                    <th>OrderValue</th>
                                    <th>OrderStatus</th>
                                    <th>PaymentStatus</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderList as $list)
                                <tr>
                                    <th scope="row">{{ $loop->index+1 }}</th>
                                    <td>{{ $list->id }}</td>
                                    <td>
                                        {{ $list->order_date }}
                                    </td>
                                    <td>
                                        {{ $list->total_order_qty }}
                                    </td>
                                    <td>
                                        Rs. {{ $list->total_amt }}
                                    </td>
                                    <td>
                                        <span class="badge {{ config('appstatus.orderstatus.'.$list->order_status.'.color','badge-danger') }}">{{ config('appstatus.orderstatus.'.$list->order_status.'.name','Inactive') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ config('appstatus.paymentstatus.'.$list->payment_status.'.color','badge-danger') }}">{{ config('appstatus.paymentstatus.'.$list->payment_status.'.name','Inactive') }}</span>
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('editorder', $list->id) }}" data-bs-toggle="tooltip" title="View Orders" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Brand"><i class="fa fa-edit"></i></a>
                                        </div>
                                    </td>
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