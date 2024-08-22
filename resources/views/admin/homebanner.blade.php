<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Home Page Banner Design
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
                    <form method="POST" action="{{route('savehomebanner')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="banner_name">Banner Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="banner_name"
                                        name="banner_name"
                                        placeholder="Enter Banner Name" value="{{old('banner_name') }}" />
                                    @error('banner_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="banner_desc">Banner Desc<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="banner_desc"
                                        name="banner_desc"
                                        placeholder="Enter Banner Desc" value="{{old('banner_desc') }}" />
                                    @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="banner_img">Banner Image<strong class="text-danger" style="font-size: x-large;">*</strong></label><br />
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="banner_img"
                                        id="banner_img" />
                                    <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('banner_img_1')
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
        <div class="col-md-12">
            <div class="card">
                <table class="table" aria-hidden="true" width="100%">
                    <thead>
                        <tr>
                            <td>SlNo</td>
                            <td>Banner Name</td>
                            <td>Banner Desc</td>
                            <td>Banner Img</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($homebanner_data as $homebanner)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $homebanner->banner_name }}</td>
                            <td>{{ $homebanner->banner_desc }}</td>
                            <td> <x-img-tag img_url="{{ $homebanner->banner_img }}"  style="max-width:40%;"></x-img-tag></td>
                            <td>
                                <form action="{{route('deletebanner',$homebanner->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</x-admin-layout>