<x-jet-form-section submit="updatePassword">


    <x-slot name="form" style="width:100%; border-color:#fff;border-style:hidden">

    <div class="col-span-12 sm:col-span-4" style="text-align:center; width:100%; margin: 0 auto;margin-bottom:20px">
     <i>{{ __('Ensure your account is using a long, random password to stay secure.') }} </i>
    </div>
        <div class="col-span-12 sm:col-span-4" style="width:70%; margin: 0 auto;margin-bottom:20px">
            <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password"/>
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-12 sm:col-span-4" style="width:70%; margin: 0 auto;margin-bottom:20px">
            <x-jet-label for="password" value="{{ __('New Password') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password"/>
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-12 sm:col-span-4" style="width:70%; margin: 0 auto;margin-bottom:20px">
            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password"/>
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>

        <div class="col-span-12 sm:col-span-4 otp-profile" style="width:70%; margin: 0 auto;margin-bottom:20px;">
            <x-jet-label for="otp" value="{{ __('OTP') }}" />
            <x-jet-input id="otp" type="password" class="mt-1 block w-full" wire:model.defer="state.otp" autocomplete="otp" />
            <x-jet-input-error for="otp" class="mt-2" />
            <i>{{ __('Please check your mail for otp.') }} </i>
        </div>
    </x-slot>

    <x-slot name="actions">
        {{-- <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message> --}}

        <x-jet-button class="updatePassword">
            {{ __('Update') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
