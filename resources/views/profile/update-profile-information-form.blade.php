
<x-jet-form-section submit="updateProfileInformation">
    <!-- <x-slot name="title">
      {{--  {{ __('Profile Information') }}  --}}
    </x-slot> -->
    <style>
    .cols {
        width:50%; 
        margin-left: 0 auto;
    }

    button {
        width: 350px !important;
        height:60px !important; 
        text-align:center; 
        color:#000; 
        font-family:'TT Norms Pro'; 
        font-weight:700;
        
        margin: 0 auto;

    }

    @media (min-width:375px) and (max-width:768px){
        .cols {
        width:70%; 
        margin-left: 0 auto;
    }
    }
</style>

    <x-slot name="form" style="width:100%; border-color:#fff;border-style:hidden">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">

                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }} PWG Group" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif


        <!-- Name -->
        <div class="cols col-span-12 sm:col-span-12" style="width:70%; margin: 0 auto; margin-bottom:20px">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <!-- Surname -->
        <div class="cols col-span-12 sm:col-span-12" style="width:70%; margin: 0 auto; margin-bottom:20px">
            <x-jet-label for="surname" value="{{ __('Surname') }}" />
            <x-jet-input id="sur_name" type="text" class="mt-1 block w-full" wire:model.defer="state.sur_name" autocomplete="surname" />
            <x-jet-input-error for="surname" class="mt-2" />
        </div>
        <!-- Phone -->
        <div class="cols col-span-12 sm:col-span-12" style="width:70%; margin: 0 auto; margin-bottom:20px">
            <x-jet-label for="phone" value="{{ __('Phone') }}" />
            <x-jet-input id="phone_number" name="phone_number" type="tel" onkeypress="return isNumberKey(event)" class="mt-1 block w-full" wire:model.defer="state.phone_number" autocomplete="phone" />
            <x-jet-input-error for="phone" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="cols col-span-12 sm:col-span-12" style="width:70%; margin: 0 auto">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                  {{--  {{ __('Your email address is unverified.') }}  --}}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900" wire:click.prevent="sendEmailVerification">
                     {{--   {{ __('Click here to re-send the verification email.') }} --}}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                       {{--  {{ __('A new verification link has been sent to your email address.') }} --}}
                    </p>
                @endif
            @endif
        </div>

        {{-- Agent Name --}}
        <div class="cols col-span-12 sm:col-span-12" style="width:70%; margin: 25px auto">
            <label for="Agent_Name">Agent Name</label>
            <x-jet-input id="Agent_Name"  value="{{Auth::user()->sales_agent_name_by_client}}"  type="text" class="mt-1 block w-full"  aria-readonly="" readonly/>
        </div>
 
        <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
    </x-slot>


</x-jet-form-section>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-latest.min.js"></script> -->
<!-- <script src="{{ asset('user/js/intlTelInput-jquery.min.js') }}"></script> -->
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !=43)
            return false;
        return true;
    }
</script>
<script>

// var phone_number = document.querySelector("#phone_number");
//     window.intlTelInput(phone_number, {
//        allowDropdown: true,
//        autoHideDialCode: true,
//        autoPlaceholder: "off",
//       // dropdownContainer: document.body,
//       // excludeCountries: ["us"],
//       // formatOnDisplay: false,
//       geoIpLookup: function(callback) {
//         $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
//           var countryCode = (resp && resp.country) ? resp.country : "";
//           callback(countryCode);
//         });
//       },
//     //    hiddenInput: "full",
//     //    initialCountry: "ae",
//        localizedCountries: { 'de': 'Deutschland' },
//        nationalMode: false,
//       // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
//       // placeholderNumberType: "MOBILE",
//        preferredCountries: ['ae'],
//        separateDialCode: true,
//       utilsScript: "../user/js/utils.js",
//     });

var phone_number = window.intlTelInput(document.querySelector("#phone_number"), {
  separateDialCode: false,
  preferredCountries:["ae"],
  nationalMode: false,
  hiddenInput: "full",
  autoHideDialCode: false,
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});

$("form").submit(function() {
  var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);

  $("input[id='phone_number'").val(full_number);
    
});
</script>