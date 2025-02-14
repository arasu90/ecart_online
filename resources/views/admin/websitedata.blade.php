<x-admin-layout>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>{{ __('Website Data') }}</h3>
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
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title"><b>{{ __('Website Data') }}</b>
                        </div>
                        <div class="panel-options">
                            <a class="bg" data-target="#sample-modal-dialog-1" data-toggle="modal" href="#sample-modal"><i class="entypo-cog"></i></a>
                            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
                            <a data-rel="close" href="#!/tasks" ui-sref="Tasks"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form novalidate="" method="post" action="{{ route('admin.websitedataupdate')}}" role="form" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Logo</label>
                                        <div class="col-md-8">
                                            <input type="file" name="site_logo">
                                            <p class="help-block">Please select image</p>
                                            @error('site_logo')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Name</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Website Name" class="form-control" name="site_name" value="{{ old('site_name',$website_data->site_name) }}">
                                            @error('site_name')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Email</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Website Email" class="form-control" name="site_email" value="{{ old('site_email',$website_data->site_email) }}">
                                            @error('site_email')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Mobile</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Website Mobile" class="form-control" name="site_mobile" value="{{ old('site_mobile', $website_data->site_mobile) }}">
                                            @error('site_mobile')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Details</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="site_detail" placeholder="Product Details">{{ old('site_detail',$website_data->site_desc) }}</textarea>
                                            @error('site_detail')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Address Line 1</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Address Line 1" class="form-control" name="address_line_1" value="{{ old('address_line_1',$website_data->site_address_line1) }}">
                                            @error('address_line_1')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Address Line 2</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Address Line 2" class="form-control" name="address_line_2" value="{{ old('address_line_2',$website_data->site_address_line2) }}">
                                            @error('address_line_2')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Address City</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Address City" class="form-control" name="address_city" value="{{ old('address_city',$website_data->site_address_city) }}">
                                            @error('address_city')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Address State</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Address State" class="form-control" name="address_state" value="{{ old('address_state',$website_data->site_address_state) }}">
                                            @error('address_state')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Address Pincode</label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Enter Address Pincode" class="form-control" name="address_pincode" value="{{ old('address_pincode',$website_data->site_address_pincode) }}">
                                            @error('address_pincode')
                                            <span class="text-danger" role="alert">{{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button class="btn btn-info" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
</x-admin-layout>