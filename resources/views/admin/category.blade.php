@inject('CommonClass', 'App\CommonClass')
<x-admin-layout>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('Category') }}</h3>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @isset($category_data)
                        <div class="panel-title"><b>{{ __('Edit Category') }}</b>
                            <a href="{{ route('admin.categorylist') }}" class="btn btn-sm btn-primary">Add New</a>
                        </div>
                        @else
                        <div class="panel-title"><b>{{ __('Add Category') }}</b>
                        </div>
                        @endisset
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        @isset($category_data)
                        <form novalidate="" action="{{ route('admin.updatecategory', $category_data->id)}}" method="post" role="form" class="form-horizontal" enctype='multipart/form-data'>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Category Name</label>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Enter Category Name" id="category_name" class="form-control" name="category_name" value="{{ $category_data->category_name }}">
                                            @error('category_name')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Category Img</label>
                                        <div class="col-md-8">
                                            <input type="file" name="category_image">
                                            <p class="help-block">Please select image</p>
                                            @error('category_image')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="description">Category Status</label>
                                        <div class="col-md-8">
                                            <select name="category_status" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                                <option value="1" @if($category_data->category_status == 1) selected @endif >Active</option>
                                                <option value="0" @if($category_data->category_status == 0) selected @endif>Inactive</option>
                                            </select>
                                            @error('category_status')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-10">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class=" col-md-8">
                                            <img src="{{ asset($category_data->category_img) }}" alt="Category Image" class="width-25">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @else
                        <form novalidate="" method="post" action="{{ route('admin.addcategory')}}" role="form" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-2 control-label">Category Name</label>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Enter Category Name" id="category_name" class="form-control" name="category_name">
                                    @error('category_name')
                                    <span class="text-danger" role="alert">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Category Image</label>
                                <div class="col-md-3">
                                    <input type="file" name="category_image">
                                    <p class="help-block">Please select image</p>
                                    @error('category_image')
                                    <span class="text-danger" role="alert">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="description">Category Status</label>
                                <div class="col-md-3">
                                    <select name="category_status" class="selecter_3" data-selecter-options='{"cover":"true"}'>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('category_status')
                                    <span class="text-danger" role="alert">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button class="btn btn-info" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="content-row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title"><b>Category List</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="bs-example">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Category Image</th>
                                        <th>Category Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($category_list as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($list->category_name) }}</td>
                                        <td>
                                            <x-img-tag image_url="{{ $list->category_img }}" />
                                        </td>
                                        <td>
                                            {!! html_entity_decode($CommonClass->getStatus($list->category_status)) !!}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categorylist',['category_id'=>$list->id]) }}" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a href="{{ $list->id }}" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
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