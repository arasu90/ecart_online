<x-admin-layout>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('View User') }}</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('View User') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" role="form" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-2 control-label">User Name</label>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Enter User Name" class="form-control" value="{{ $user_data->name }}" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">User E-Mail</label>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Enter User E-Mail" class="form-control" value="{{ $user_data->email }}" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Mobile No</label>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Mobile No" class="form-control" value="{{ $user_data->email }}" disabled />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title"><b>User Order List</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="bs-example">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OrderID</th>
                                        <th>OrderDate</th>
                                        <th>OrderStatus</th>
                                        <th>TotalItem</th>
                                        <th>OrderValue</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($user_order_list as $order_list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order_list->id }}</td>
                                        <td>{{ $order_list->order_date }}</td>
                                        <td>{{ $order_list->order_status }}</td>
                                        <td>{{ $order_list->total_order_item }}</td>
                                        <td>{{ $order_list->net_total_amt }}</td>
                                        <td>
                                            <a href="{{ route('admin.userview',$order_list->id) }}" class="btn btn-sm btn-primary">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">No Orders Ordered</td>
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
</x-admin-layout>