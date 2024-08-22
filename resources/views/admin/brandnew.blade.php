<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add New Brand
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
                        <a href="{{route('brandlist')}}" class="btn btn-sm btn-warning pull-right">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('savebrand')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name<span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="brand_name"
                                        name="brand_name"
                                        placeholder="Enter Brand Name" value="{{old('brand_name') }}" />
                                    @error('brand_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="brand_img">Brand Image</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="brand_img"
                                        id="brand_img" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('brand_img')
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