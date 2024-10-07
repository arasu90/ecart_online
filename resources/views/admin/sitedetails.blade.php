<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Website Details
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
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('savewebsite')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="site_logo">Site Logo<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        name="site_logo"
                                        id="site_logo" />
                                    <span class="badge badge-black">Allowed type .png</span>
                                    @error('site_logo')
                                    <br /><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_desc">Site Description<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        id="site_desc"
                                        name="site_desc"
                                        placeholder="Enter Fees Value">{{ old('site_desc', $page_data->site_desc) }}</textarea>
                                    @error('site_desc')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_address">Site Address<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="site_address"
                                        name="site_address"
                                        placeholder="Enter Site Address" value="{{old('site_address',$page_data->site_address) }}" />
                                    @error('site_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_email">Site Email<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="site_email"
                                        name="site_email"
                                        placeholder="Enter Site Email" value="{{old('site_email',$page_data->site_email) }}" />
                                    @error('site_email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_mobile">Site Mobile<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="site_mobile"
                                        name="site_mobile"
                                        placeholder="Enter Fees Value" value="{{old('site_mobile',$page_data->site_mobile) }}" />
                                    @error('site_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="fees_value">Site Gpay Image<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="file"
                                        class="form-control-file mt-2"
                                        id="site_gpay_img"
                                        name="site_gpay_img"
                                        placeholder="Enter Fees Value" value="{{old('site_gpay_img') }}" />
                                        <span class="badge badge-black">Allowed type .jpeg, jpg, png</span>
                                    @error('site_gpay_img')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                <label for="" class="form-label">Site Logo</label><br><br>
                                    <x-img-tag img_url="{{ $page_data->site_logo }}" style="max-width:40%;" />
                                </div>
                                <div class="form-group">
                                <label for="" class="form-label">Gpay Image</label><br><br>
                                    <x-img-tag img_url="{{ $page_data->site_gpay_img }}" style="max-width:40%;" />
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
