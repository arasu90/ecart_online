<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Cart Page Fees Details
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
                    <form method="POST" action="{{route('savefeesdetails')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="fees_name">Fees Name<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fees_name"
                                        name="fees_name"
                                        placeholder="Enter Fees Name" value="{{old('fees_name') }}" />
                                    @error('fees_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="fees_value">Fees Value<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fees_value"
                                        name="fees_value"
                                        placeholder="Enter Fees Value" value="{{old('fees_value') }}" />
                                    @error('fees_value')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                       <div class="form-group mt-5">

                                       <x-primary-button class="btn btn-primary">{{ __('Submit') }}</x-primary-button>
                                </div>     
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
                            <td>Fees Name</td>
                            <td>Fees Value</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($page_data as $pagedata)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $pagedata->fees_name }}</td>
                            <td>{{ $pagedata->fees_value }}</td>
                            <td>
                                <form action="{{route('deletefeesdetails',$pagedata->id)}}" method="post">
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