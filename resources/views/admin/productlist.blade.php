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
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('Product') }}</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ Session::get('success') }}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ Session::get('error') }}
                </div>
                @endif
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Product List</b>
                            <a href="{{ route('admin.productnew') }}" class="btn btn-sm btn-success">Add New</a>
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
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Product MRP</th>
                                        <th>Product Price</th>
                                        <th>Product Tax</th>
                                        <th>Product Stock</th>
                                        <th>Product Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_list as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.productedit',$list->id) }}">
                                                {{ ucfirst($list->product_name) }}
                                            </a>
                                        </td>
                                        <td>
                                            <x-img-tag image_url="{{ $list->defaultImg->product_img }}" img_alt="Product Image" />
                                        </td>
                                        <td>{{ $list->product_mrp }}</td>
                                        <td>{{ $list->product_price }}</td>
                                        <td>{{ $list->product_tax }} %</td>
                                        <td>
                                            @if($list->product_stock)
                                                <strong>{{ $list->product_stock }}</strong>
                                            @else
                                                <span class="badge badge-danger">out of stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            {!! html_entity_decode($CommonClass->getStatus($list->product_status)) !!}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.productedit',$list->id) }}" class="btn btn-sm btn-primary">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.productdelete',$list->id) }}" class="btn btn-sm btn-danger">
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
