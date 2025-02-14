<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary font-weight-bold my-3 py-3', 'onclick'=>'return confirm("Are you sure!, you want to permanently delete your account?")']) }}>
    {{ $slot }}
</button>
