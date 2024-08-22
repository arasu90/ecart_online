<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Category
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
                        <a href="{{route('admincategory')}}" class="btn btn-sm btn-warning pull-right nav-link">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('updatecategory',$category_data->id)}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Category Name<span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        placeholder="Enter Category Name" value="{{old('name', $category_data->category_name) }}" />
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Category Image</label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="imagefile"
                                        id="exampleFormControlFile1" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('imagefile')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Status</label><br />
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="status"
                                                id="activestatus" value="1" {{ ($category_data->category_status =='1') ? 'checked' : '' }} />
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
                                                 value="0" {{ ($category_data->category_status =='0') ? 'checked' : '' }} />
                                            <label
                                                class="form-check-label"
                                                for="inactivestatus">
                                                InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-img-tag img_url="{{ $category_data->category_img }}" style="max-width:40%;" />
                                </div>
                            </div>
                            <div class="card-action">
                                <x-primary-button class="btn btn-primary">{{ __('Update') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-admin-layout>