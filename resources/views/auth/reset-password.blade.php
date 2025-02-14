<x-app-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full form-control" type="email" name="email" :value="old('email', $request->email)" placeholder="Enter Email" autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Password -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4 mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full form-control" type="password" name="password" placeholder="Enter Password" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4 mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block w-full form-control"
                    type="password"
                    name="password_confirmation" placeholder="Enter Confirm Password" autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
            </div>
        </div>

        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4">
                <x-primary-button class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                    {{ __('Reset Password') }}
                </x-primary-button>
                <a class="float-right" href="{{ route('login') }}" style>
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </form>
</x-app-layout>