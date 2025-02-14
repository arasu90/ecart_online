<x-app-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full form-control" type="text" name="name" :value="old('name')" autofocus autocomplete="name" placeholder="Enter Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" autocomplete="email" placeholder="Enter Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Mobile Address -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="mobile" :value="__('Mobile')" />
                <x-text-input id="mobile" class="block mt-1 w-full form-control" type="text" name="mobile" :value="old('mobile')" autocomplete="mobile" placeholder="Enter Mobile" />
                <x-input-error :messages="$errors->get('mobile')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Password -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full form-control"
                    type="password"
                    name="password"
                    autocomplete="new-password" placeholder="Enter Password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full form-control"
                    type="password"
                    name="password_confirmation" autocomplete="new-password" placeholder="Enter Confirm Password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
            </div>
        </div>

        <div class="row">
            <div class="col col-md-3 offset-md-4 form-group px-4">
                <x-primary-button class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                    {{ __('Register') }}
                </x-primary-button>

                <a class="float-right" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </div>
    </form>
</x-app-layout>