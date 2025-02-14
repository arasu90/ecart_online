@if(Session::has('success'))
    <x-alert-msg class_type="success" msg_text="{{ Session::get('success') }}" />
@endif

@if(Session::has('error'))
    <x-alert-msg class_type="danger" msg_text="{{ Session::get('error') }}" />
@endif

@if(Session::has('cart_success'))
    <x-alert-msg class_type="success" msg_text="{{ Session::get('cart_success') }}" />
@endif

@if(Session::has('cart_warning'))
    <x-alert-msg class_type="info" msg_text="{{ Session::get('cart_warning') }}" />
@endif

@if(Session::has('cart_danger'))
    <x-alert-msg class_type="danger" msg_text="{{ Session::get('cart_danger') }}" />
@endif