<x-admin-layout>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Brand</span>
                    <span> @if(Session::has('error'))
                        <span class="text-danger" role="alert">
                            <strong>{{ Session::get('error') }} </strong>
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                        </span>
                        @endif</span>
                    <a href="{{route('newbrand')}}" class="btn btn-warning btn-sm pull-right">Add New</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table
                            id="basic-datatables"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Brand_Name</th>
                                    <th>Brand_Img</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brand_list as $list)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $list->brand_name }}</td>
                                    <td>

                                        <x-img-tag img_url="{{ $list->brand_img }}" class="imagecheck-image w-50" style="height: 15em !important" />

                                    </td>
                                    <td>
                                        <span class="badge {{ config('appstatus.brandstatus.'.$list->brand_status.'.color','badge-danger') }}">{{ config('appstatus.brandstatus.'.$list->brand_status.'.name','Inactive') }}</span>
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('editbrand', $list->id) }}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Brand"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
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
</x-admin-layout>