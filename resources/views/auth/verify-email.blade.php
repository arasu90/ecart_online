<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-6">
            <h2 class="h3 mt-6">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </h2>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 h5">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div>
                        <x-primary-button class="btn-primary">
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="float-right">
                    @csrf
                    <x-secondary-button class="mb-5" type="submit">
                        {{ __('Log Out') }}
                    </x-secondary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
