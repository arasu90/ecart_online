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
                    <span class="card-title">Products</span>
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
                    <a href="{{route('newproduct')}}" class="btn btn-warning btn-sm pull-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="basic-datatables"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Product_Name</th>
                                    <th>Category</th>
                                    <th>Product_MRP</th>
                                    <th>Product_Rate</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product_list as $list)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $list->product_name }}</td>
                                    <td>{{ $list->category->category_name }}</td>
                                    <td>{{ $list->product_mrp }}</td>
                                    <td>{{ $list->product_rate }}</td>
                                    <td>
                                        @if($list->product_status == 1)
                                        <span class="badge badge-secondary">Active</span>
                                        @else
                                        <span class="badge badge-danger">In Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('editproduct', $list->id) }}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Product"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
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