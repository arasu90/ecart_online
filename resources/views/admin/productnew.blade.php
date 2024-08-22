<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add New Product
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
                    <form method="POST" action="{{route('saveproduct')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name</label>
                                    <select name="brand_name" class="form-select form-control">
                                        <option value="">Select</option>
                                        @foreach($brand_list as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
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
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                        placeholder="Enter Product Name" value="{{old('product_name') }}" />
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
                                        placeholder="Enter Product MRP" value="{{old('product_mrp') }}" />
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
                                        placeholder="Enter Product Rate" value="{{old('product_rate') }}" />
                                    @error('product_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_desc">Product Description</label>
                                    <textarea class="form-control" id="product_desc" name="product_desc" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="product_detail">Product Details</label>
                                    <textarea class="form-control" id="product_detail" name="product_detail" rows="6"></textarea>
                                </div>

                                <div class="form-group form-check">
                                    <label for="product_detail">Product Varient</label>
                                    <div>
                                        <p>
                                            <input type="checkbox" name="color_set" value="1" class="form-check-input"/> Colors <small>(ex: white,black)</small>
                                        <div class="form-group">
                                            @foreach($colors_list as $colors)
                                            <p> <input type="checkbox" class="form-check-input" name="color_value[]" id="{{ $colors->id }}" value="{{ $colors->id }}" /> {{ $colors->color_name }} <input type="color" name="" id="" value="{{ $colors->color_value }}" disabled></p>
                                            @endforeach
                                        </div>
                                        </p>
                                        <!-- <p>
                                            <input type="checkbox" name="size_set" value="1" /> Size <small>(ex: 6GB,8GB)</small>
                                        <div class="form-group">
                                            <label for="size_name">Size Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="size_name"
                                                name="size_name"
                                                placeholder="Enter Size Name" value="{{old('size_name') }}" />
                                            @error('size_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="size_mrp">MRP<span class="text-danger" style="font-size: x-large;">*</span></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="size_mrp"
                                                name="size_mrp"
                                                placeholder="Enter Size MRP" value="{{old('size_mrp') }}" />
                                            @error('size_mrp')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="size_rate">Price<span class="text-danger" style="font-size: x-large;">*</span></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="size_rate"
                                                name="size_rate"
                                                placeholder="Enter Size Rate" value="{{old('size_rate') }}" />
                                            @error('size_rate')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            @foreach($colors_list as $key=>$colors)
                                            <p> <input type="radio" name="size_color_name" id="{{$key}}" value="{{ $colors->id }}" />{{ $colors->color_name }} </p>
                                            @endforeach
                                        </div>
                                        </p>
                                        <p>
                                            <input type="checkbox" name="type_set" value="1" /> Cable Type <small>(ex: 3mm,USB)</small>

                                        <div class="form-group">
                                            <p> <input type="radio" name="cable_type" id="1" value="1" />3MM</p>
                                            <p> <input type="radio" name="cable_type" id="2" value="2" />USB</p>
                                        </div>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
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