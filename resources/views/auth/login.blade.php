<x-app-layout>
    <!-- Session Status -->
    <div class="row">
    <div class="col col-md-3 offset-md-4 form-group px-4">
    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
    </div>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" autofocus autocomplete="username" placeholder="Enter Email" />

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
        </div>
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full form-control"
                    type="password"
                    name="password"
                    autocomplete="current-password" placeholder="Enter Password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
            </div>
        </div>
        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-3 offset-md-4 px-4">
                <div class="flex items-center justify-end mt-4">

                    <x-primary-button class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                    @if (Route::has('register'))
                    <a class="float-right" href="{{ route('register') }}" style>
                        {{ __('New User Register?') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</x-app-layout>