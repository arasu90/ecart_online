<x-app-layout>
    <div class="row">
        <div class="col col-md-3 offset-md-4 form-group px-4">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <div class="row">
    <div class="col col-md-3 offset-md-4 form-group px-4">
    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
    </div>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" placeholder="Enter Email" autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
        </div>

        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-primary-button class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
                <a class="float-right" href="{{ route('login') }}" style>
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </form>
</x-app-layout>