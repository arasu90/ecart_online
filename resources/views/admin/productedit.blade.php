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
                                    <label for="category_name">Category Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <select name="category_name" class="form-select form-control">
                                        <option value="">Select</option>
                                        @foreach($category_list as $category)
                                            <option {{ ($product_data->category_id == $category->id) ? 'selected' : '' }}  value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                <div class="form-group">
                                    <label for="product_desc">Product Description</label>
                                    <textarea class="form-control" id="product_desc" name="product_desc" rows="3">{{ $product_data->product_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="product_detail">Product Details</label>
                                    <textarea class="form-control" id="product_detail" name="product_detail" rows="6">{{ $product_data->product_detail }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-4">
                                <div class="form-group">
                                    <label for="product_img_1">Product Image 1<strong class="text-danger" style="font-size: x-large;">*</strong></label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img_1"
                                        id="product_img_1" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img_1')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_img_2">Product Image 2</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img_2"
                                        id="product_img_2" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img_2')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_img_3">Product Image 3</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img_3"
                                        id="product_img_3" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img_3')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_img_4">Product Image 4</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img_4"
                                        id="product_img_4" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img_4')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_img_5">Product Image 5</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="product_img_5"
                                        id="product_img_5" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('product_img_5')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                            <div class="col-md-3 col-lg-4">
                                @foreach($product_data->product_img as $img)
                                <div class="form-group">
                                    <label for="product_img_1">Product Image {{$loop->index + 1}}</label><br />
                                        <x-img-tag img_url="{{ $img->image_name }}" style="max-width:40%;" />
                                        @if($img->default_img == '1')
                                        <span class='badge badge-success'>Default</span>
                                        @else
                                        <input  type="checkbox" class="checkbox" name="delete_img[]" value="{{ $img->id }}"/>Delete
                                        
                                        @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="card-action">
                                <x-primary-button class="btn btn-primary">{{ __('Submit') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-admin-layout>