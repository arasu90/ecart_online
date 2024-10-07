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
                    <span class="card-title">User List</span>
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
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table
                            id="basic-datatables"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>UserName</th>
                                    <th>Email</th>
                                    <th>MobileNo</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_list as $list)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @if($list->type == 'admin')
                                            <span class="badge badge-warning">{{ $list->name }}</span>
                                        @else
                                            {{ $list->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $list->email }}
                                    </td>
                                    <td>
                                        {{ $list->mobileno }}
                                    </td>
                                    <td>
                                        @php
                                            $daa = ($list->deleted_at) ? 0 : 1;
                                        @endphp
                                        <span class="badge {{ config('appstatus.userstatus.'.$daa.'.color','badge-danger') }}">{{ config('appstatus.userstatus.'.$daa.'.name','Inactive') }}</span>
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('useredit',$list->id) }}" data-bs-toggle="tooltip" title="View Users" class="btn btn-link btn-primary btn-lg" data-original-title="View User"><i class="fa fa-edit"></i></a>
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