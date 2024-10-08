<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Address List') }}
        </h2>
    </header>
    <table class="table table-border">
        <thead>
            <tr>
                <td>Contact Name</td>
                <td>Contact Mobile</td>
                <td>Address</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($addresslist as $address)
                <tr>
                    <td>
                        <p>{{ $address->contact_name }}</p>
                        <p>
                            @if($address->make_default == 1)
                                <label class="label badge badge-success">Default</label>
                            @endif
                        </p>
                    </td>
                    <td>{{ $address->contact_mobile }}</td>
                    <td>
                        <p>{{ $address->address_line1 }}</p>
                        <p>{{ $address->address_line2 }}</p>
                        <p>{{ $address->address_city }}</p>
                        <p>{{ $address->address_state }}</p>
                        <p>{{ $address->address_pincode }}</p>
                    </td>
                    <td>
                        <form action="{{ route('profile.deletemyaddress') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="deladdress" value="{{ $address->id }}"/>
                            <button type="submit" class="btn-link btn-primary">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="4"><strong>Yet to add Address</strong></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>
