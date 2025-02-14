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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('Add Product') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" method="post" action="{{ route('admin.productadd')}}" role="form" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Brand</label>
                                        <div class="col-md-6">
                                            <select name="brand_id" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="">Select</option>
                                                @foreach ($brand_list as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
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
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                            <input type="text" placeholder="Enter Product Name" id="product_name" class="form-control" name="product_name">
                                            @error('product_name')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Details</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="product_detail" placeholder="Product Details"></textarea>
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
                                            <input type="text" placeholder="Enter Product MRP" id="product_mrp" class="form-control" name="product_mrp">
                                            @error('product_mrp')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Price</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Product Price" id="product_price" class="form-control" name="product_price">
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
                                                <option value="0">0%</option>
                                                <option value="5">5%</option>
                                                <option value="12">12%</option>
                                                <option value="18">18%</option>
                                                <option value="28">28%</option>
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
                                            <input type="text" placeholder="Enter Product Stock" class="form-control" name="product_stock">
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
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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
                                    <button class="btn btn-info" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
</x-admin-layout>