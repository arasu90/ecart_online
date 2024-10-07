<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Address Details') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.addmyaddress') }}" class="mt-6 space-y-6">
        @csrf
        <div class="row">
            <div class="col-lg-4 mt-2">
                <x-input-label for="contact_name" :value="__('Contact Name')" />
                <x-text-input id="contact_name" name="contact_name" type="text" class="mt-1 block w-full" :value="old('contact_name')" autofocus autocomplete="contact_name" />
                <x-input-error class="mt-2" :messages="$errors->get('contact_name')" />
                <input type="hidden" name="address_id" id="address_id" value="">
            </div>

            <div class="col-lg-4 mt-2">
                <x-input-label for="contact_mobile" :value="__('Contact Mobile')" />
                <x-text-input id="contact_mobile" name="contact_mobile" type="text" class="mt-1 block w-full" :value="old('contact_mobile')" autocomplete="contact_mobile" />
                <x-input-error class="mt-2" :messages="$errors->get('contact_mobile')" />
            </div>
            <div class="col-lg-4 mt-2">
                
            </div>
            <div class="col-lg-4 mt-2">
                <x-input-label for="address_line1" :value="__('Address Line 1')" />
                <x-text-input id="address_line1" name="address_line1" type="text" class="mt-1 block w-full" :value="old('address_line1')" autofocus autocomplete="address_line1" />
                <x-input-error class="mt-2" :messages="$errors->get('address_line1')" />
            </div>

            <div class="col-lg-4 mt-2">
                <x-input-label for="address_line2" :value="__('Address Line 2')" />
                <x-text-input id="address_line2" name="address_line2" type="text" class="mt-1 block w-full" :value="old('address_line2')" autocomplete="address_line2" />
                <x-input-error class="mt-2" :messages="$errors->get('address_line2')" />
            </div>
            <div class="col-lg-4 mt-2">
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" autofocus autocomplete="city" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        
            <div class="col-lg-4 mt-2">
                <x-input-label for="state" :value="__('State')" />
                <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state')" autofocus autocomplete="state" />
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
            </div>

            <div class="col-lg-4 mt-2">
                <x-input-label for="pincode" :value="__('Pincode')" />
                <x-text-input id="pincode" name="pincode" type="text" class="mt-1 block w-full" :value="old('pincode')"  autocomplete="pincode" />
                <x-input-error class="mt-2" :messages="$errors->get('pincode')" />
            </div>
            <div class="col-lg-4 mt-6">
                <br />
                <input type="checkbox" name="isdefault" id="isdefault" value="1"> {{__('Set Default')}}
                <x-input-error class="mt-2" :messages="$errors->get('isdefault')" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
