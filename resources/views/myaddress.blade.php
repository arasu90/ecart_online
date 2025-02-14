<x-app-layout>
    <x-slot name="cart_count">
        {{ request('cart_count') }}
    </x-slot>
    <div class="container-fluid">
        <h3>My Address Book</h3>
        <small>
            <a href="{{ route('page.home') }}" class="text-decoration-none">Home</a> >
            <span>My Address</span>
        </small>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Billing Address</h5>
                    </div>
                    <form action="{{ route('address.add') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger" role="alert">{{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                                        @error('phone')
                                        <span class="text-danger" role="alert">{{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" >{{ old('address') }}</textarea>
                                        @error('address')
                                        <span class="text-danger" role="alert">{{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address">Landmark</label>
                                        <input type="text" name="landmark" id="landmark" class="form-control" value="{{ old('landmark') }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="is_default" id="is_default" class=""> {{ __('Set as default') }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                    <button type="submit" class="btn btn-success float-right">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Address Book List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>SlNo</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($myaddress_list as $address)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>
                                        {{ $address->name }}
                                        @if($address->is_default)
                                        <p><span class="badge badge-success">{{ __('Default') }}</span></p>
                                        @endif
                                    </td>
                                    <td>{{ $address->phone }}</td>
                                    <td>
                                        {{ $address->address }}
                                        @if ($address->landmark)
                                        <p>Landmark: {{ $address->landmark }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('address.delete', $address->id) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Address Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
