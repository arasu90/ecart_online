<x-admin-layout>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">All OrderList</span>
                    <span> @if(Session::has('error'))
                        <span class="text-danger" role="alert">
                            <strong>{{ Session::get('error') }} </strong>
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                        </span>
                        @endif</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="basic-datatables"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>OrderID</th>
                                    <th>OrderDate</th>
                                    <th>OrderUser</th>
                                    <th>OrderItem</th>
                                    <th>OrderValue</th>
                                    <th>OrderStatus</th>
                                    <th>PaymentMode</th>
                                    <th>PaymentStatus</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderList as $list)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $list->id }}</td>
                                    <td>
                                        {{ $list->order_date }}
                                    </td>
                                    <td>
                                        {{ $list->getuserName->name }}
                                    </td>
                                    <td>
                                        {{ $list->total_order_qty }}
                                    </td>
                                    <td>
                                        Rs. {{ $list->total_amt }}
                                    </td>
                                    </td>
                                    <td>
                                        <span class="badge {{ config('appstatus.orderstatus.'.$list->order_status.'.color','badge-danger') }}">{{ config('appstatus.orderstatus.'.$list->order_status.'.name','Inactive') }}</span>
                                    </td>
                                    <td>
                                        {{ strtoupper($list->payment_mode) }}
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
    </div>
</x-admin-layout>