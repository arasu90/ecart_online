<x-admin-layout>
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('Edit Product') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" method="post" action="{{ route('admin.productupdate', $product_data->id)}}" role="form" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Brand</label>
                                        <div class="col-md-6">
                                            <select name="brand_id" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="">Select</option>
                                                @foreach ($brand_list as $brand)
                                                <option value="{{ $brand->id }}" @if($product_data->brand_id == $brand->id) selected @endif>{{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Category</label>
                                        <div class="col-md-6">
                                            <select name="category_id" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="">Select</option>
                                                @foreach ($category_list as $category)
                                                <option value="{{ $category->id }}" @if($product_data->category_id == $category->id) selected @endif >{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Name</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Product Name" id="product_name" class="form-control" name="product_name" value="{{ $product_data->product_name }}">
                                            @error('product_name')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Details</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="product_detail" placeholder="Product Detail">{{ $product_data->product_detail }}</textarea>
                                            @error('product_detail')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product MRP</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Product MRP" id="product_mrp" class="form-control" name="product_mrp" value="{{ $product_data->product_mrp }}">
                                            @error('product_mrp')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Price</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Product Price" id="product_price" class="form-control" name="product_price" value="{{ $product_data->product_price }}">
                                            @error('product_price')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Tax</label>
                                        <div class="col-md-6">
                                            <select name="product_tax" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="0" @if($product_data->product_tax == 0) selected @endif >0%</option>
                                                <option value="5" @if($product_data->product_tax == 5) selected @endif>5%</option>
                                                <option value="12" @if($product_data->product_tax == 12) selected @endif>12%</option>
                                                <option value="18" @if($product_data->product_tax == 18) selected @endif>18%</option>
                                                <option value="28" @if($product_data->product_tax == 28) selected @endif>28%</option>
                                            </select>
                                            @error('product_tax')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Stock</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Product Stock" class="form-control" name="product_stock" value="{{ $product_data->product_stock }}">
                                            @error('product_stock')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Product Status</label>
                                        <div class="col-md-6">
                                            <select name="product_status" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="1" @if($product_data->product_status == 1) selected @endif >Active</option>
                                                <option value="0" @if($product_data->product_status == 0) selected @endif>Inactive</option>
                                            </select>
                                            @error('product_status')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button class="btn btn-success" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('Add Product Image') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" method="post" action="{{ route('admin.addproductimg', $product_data->id)}}" role="form" class="form-horizontal" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="description">Product Image</label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img">
                                    <p class="help-block">Please select image</p>
                                    <div class="checkbox">
                                        <input type="checkbox" name="default_img" id="flat-checkbox-1">
                                        <label for="flat-checkbox-1">{{ __('  Is Default') }}</label>
                                    </div>
                                    @error('product_img')
                                    <span class="text-danger" role="alert">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($product_img_list as $img_list)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                            @if($img_list->default_img ==1)
                                            <span class="badge badge-success">{{ __('Is Default') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <x-img-tag image_url="{{ $img_list->product_img }}" />
                                        </td>
                                        <td>
                                            <a href="{{ $img_list->id }}" class="btn btn-sm btn-danger">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No Records Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-row">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('Add Product Data Fields') }}</b>
                        <a href="{{route('admin.prodDataList')}}" class="btn btn-sm btn-primary float-right">Add Fields</a>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" method="post" action="{{ route('admin.productfield', $product_data->id)}}" role="form" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Product Data Field Name</label>
                                        <div class="col-md-6">
                                            <select name="product_data_field_id" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                @forelse ($product_field_list as $field_list)
                                                <option value="{{ $field_list->id }}">{{ $field_list->field_name }}</option>
                                                @empty
                                                <option value="">Select</option>
                                                @endforelse
                                            </select>
                                            @error('product_data_field_id')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Product Data Field Value</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Field Value" class="form-control" name="product_data_field_value">
                                            @error('product_data_field_value')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button class="btn btn-warning float-right" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Field Name</th>
                                        <th>Field Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($product_field_value_list as $field_value_list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $field_value_list->product_data->field_name }}</td>
                                        <td>{{ $field_value_list->field_value }}</td>
                                        <td>
                                            <a href="{{ $field_value_list->id }}" class="btn btn-sm btn-danger">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No Records Found</td>
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