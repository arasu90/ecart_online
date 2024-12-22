<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Product
                        @if(Session::has('error'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('error') }}
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('success') }}
                        </span>
                        @endif
                        <a href="{{route('productlist')}}" class="btn btn-sm btn-warning pull-right">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('updateproduct', $product_data->id)}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name</label>
                                    <select name="brand_name" class="form-select form-control">
                                        <option value="">Select</option>
                                        @foreach($brand_list as $brand)
                                        <option {{ ($product_data->brand_id == $brand->id) ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_name">Category Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <select name="category_name" class="form-select form-control">
                                        <option value="">Select</option>
                                        @foreach($category_list as $category)
                                        <option {{ ($product_data->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    id="product_name"
                                    name="product_name"
                                    placeholder="Enter Product Name" value="{{old('product_name', $product_data->product_name) }}" />
                                    @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="product_mrp">Product MRP<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="product_mrp"
                                        name="product_mrp"
                                        placeholder="Enter Product MRP" value="{{old('product_mrp', $product_data->product_mrp) }}" />
                                    @error('product_mrp')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_rate">Product Rate<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="product_rate"
                                        name="product_rate"
                                        placeholder="Enter Product Rate" value="{{old('product_rate',$product_data->product_rate) }}" />
                                    @error('product_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="product_desc">Product Description</label>
                                    <textarea class="form-control" id="product_desc" name="product_desc" rows="3">{{ $product_data->product_desc }}</textarea>
                                </div>
                                <div class="form-check">
                                    <div class="form-group">
                                        <label>Status</label><br />
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="status"
                                                    id="activestatus" value="1" {{ ($product_data->product_status =='1') ? 'checked' : '' }} />
                                                <label
                                                    class="form-check-label"
                                                    for="activestatus">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="status"
                                                    id="inactivestatus"
                                                    value="0" {{ ($product_data->product_status =='0') ? 'checked' : '' }} />
                                                <label
                                                    class="form-check-label"
                                                    for="inactivestatus">
                                                    InActive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <x-primary-button class="btn btn-primary">{{ __('Submit') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Product Image
                        @if(Session::has('img_success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('img_success') }}
                        </span>
                        @endif
                        @if(Session::has('img_error'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('img_error') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body" id="adddata">
                    <form method="POST" action="{{route('addproductimage', $product_data->id)}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img"
                                        id="product_img" required/>
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="default_set" id="default_set" value="1">&nbsp;Set Default
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mt-2">
                                    <x-primary-button class="btn btn-primary">{{ __('Add Image') }}</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <hr />
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <table class="table mt-3 table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">ViewImage</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productImageData as $ImageData)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ $ImageData->image_name}}" alt="" width="70px"></td>
                                        <td><a href="{{ $ImageData->image_name}}" target="_blank">Click to view</a>
                                        @if($ImageData->default_img == 1)
                                        <p>
                                            <span class="badge badge-success">
                                                default
                                            </span>
                                        </p>
                                        @endif
                                        </td>
                                        <td>
                                            <form action="{{route('deleteImage')}}" method="post" onsubmit="return confirm('Are you sure you want to delete this data?');">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="data_delete_id" value="{{ $ImageData->id }}">
                                                <button type="submit" class="btn-sm btn-danger">Delete</button>
                                            </form>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Product Details Data
                        @if(Session::has('data_error'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('data_error') }}
                        </span>
                        @endif
                        @if(Session::has('data_success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('data_success') }}
                        </span>
                        @endif
                        <a href="{{route('addproductdata',$product_data->id)}}" class="btn btn-sm btn-warning pull-right">Add More Details</a>
                    </div>
                </div>
                <div class="card-body" id="adddata">
                    <form method="POST" action="{{route('addproductdetails', $product_data->id)}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="product_data_id">Product Data Title<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <select name="product_data_id" class="form-control select2" data-live-search="true">
                                        <option value="">Select</option>
                                        @foreach($productDataTitle as $title_value)
                                            <option value="{{ $title_value->id }}">{{ $title_value->row_title }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_data_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="product_data_value">Product Title Value<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        id="product_data_value"
                                        name="product_data_value"
                                        placeholder="Enter Value">{{ old('product_data_value') }}</textarea>
                                    @error('product_data_value')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mt-5">
                                    <x-primary-button class="btn btn-primary">{{ __('Submit') }}</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <hr />
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <table class="table mt-3 table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Row Data</th>
                                        <th scope="col">Row Value</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productDataValue as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->product_data->row_title }}</td>
                                        <td>{{ $value->product_data_value }}</td>
                                        <td>
                                            <form action="{{route('deletedatavalue')}}" method="post" onsubmit="return confirm('Are you sure you want to delete this data?');">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="data_delete_id" value="{{ $value->id }}">
                                                <button type="submit" class="btn-sm btn-danger">Delete</button>
                                            </form>
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
        @push('scripts')
            $(function() {
                $('.selectpicker').selectpicker();
            });
        @endpush
</x-admin-layout>