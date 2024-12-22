<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Product Data
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
                    <form method="POST" action="{{route('addproductdata')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="row_title">Product Detail Data Title<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="row_title"
                                        name="row_title"
                                        placeholder="Enter Product Name" value="{{old('row_title') }}" />
                                    @error('row_title')
                                    <span class="text-danger">{{ $message }}</span>
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
                <div class="card-header">
                    <div class="card-title">Product Details Data
                        @if(Session::has('data_error'))
                        <span class="text-danger m-4" role="alert">
                            {{ Session::get('data_error') }}
                        </span>
                        @endif
                        @if(Session::has('data_success'))
                        <span class="text-success m-4" role="alert">
                            {{ Session::get('data_success') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body" id="adddata">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <table class="table mt-3 table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Data Title</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productDataTitle as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->row_title }}</td>
                                        <td>
                                            <form action="{{route('deletedatatitle')}}" method="post" onsubmit="return confirm('Are you sure you want to delete this Value?');">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="data_delete_id" value="{{ $value->id }}">
                                                <button type="submit" class="btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            $(function() {
                $('.selectpicker').selectpicker();
            });
        @endpush
</x-admin-layout>