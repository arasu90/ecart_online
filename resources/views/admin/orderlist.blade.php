@inject('CommonClass', 'App\CommonClass')
<x-admin-layout>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>
    @endpush
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('Order Master List') }}</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b>Order List</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OrderID</th>
                                        <th>OrderDate</th>
                                        <th>UserName</th>
                                        <th>TotalItem</th>
                                        <th>OrderValue</th>
                                        <th>OrderStatus</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_master_list as $order_list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order_list->id }}</td>
                                        <td>{{ $order_list->order_date }}</td>
                                        <td>{{ ucfirst($order_list->users->name) }}</td>
                                        <td>{{ $order_list->total_order_item }}</td>
                                        <td>{{ $order_list->net_total_amt }}</td>
                                        <td>
                                            {!! html_entity_decode($CommonClass->getOrderStatus($order_list->order_status)) !!}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orderview',$order_list->id) }}" class="btn btn-sm btn-primary">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
</x-admin-layout>