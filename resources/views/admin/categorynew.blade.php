<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add New Category
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
                        <a href="{{route('admincategory')}}" class="btn btn-sm btn-warning pull-right">List</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('savecategory')}}" enctype='multipart/form-data'>
                        @csrf


                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="name">Category Name<span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        placeholder="Enter Category Name" value="{{old('name') }}" />
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
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
                            <div class="card-action">
                                <x-primary-button class="btn btn-primary">{{ __('Submit') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-admin-layout>