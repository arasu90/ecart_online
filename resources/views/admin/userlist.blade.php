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
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('User List') }}</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>User List</b>
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
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_list as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($list->user_type == 'admin')
                                                <span class="badge badge-info">{{ ucfirst($list->name) }}</span>
                                            @else
                                                {{ ucfirst($list->name) }}
                                            @endif</td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->mobile }}</td>
                                        <td>
                                            <a href="{{ route('admin.userview',$list->id) }}" class="btn btn-sm btn-primary">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            <a href="{{ $list->id }}" class="btn btn-sm btn-danger">
                                                <i class="glyphicon glyphicon-trash"></i>
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