@include('user.header')

<!-- bootstrap core css -->


<link rel="stylesheet" href="{{asset('user/extra/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
  .cards {
    margin-right:25%;
    margin-left:25%;
    margin-top: 60px;
  }
</style>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>


<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Profile') }}
    </h2>
</x-slot>


<div class="row card" style="border-radius:10px">

    <div class="col-12 cards">
        <div class="about-desc animate-box">
            <div class="fancy-collapse-panel">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <!-- Tab One -->
                    <div class="panel panel-default" style="border-radius: 10px;">
                        <div class="ppanel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title" style="margin-left:10%">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    &nbsp; {{ __('Profile Information') }} |
                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">

                               
                                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                @livewire('profile.update-profile-information-form')

                                <x-jet-section-border />
                                @endif
                       
                            </div>
                        </div>
                    </div><p style="margin-top: 10px;"> &nbsp; </p>

                    <!-- Tab Two -->
                    <div class="panel panel-default" style="border-radius: 10px;">
                        <div class="ppanel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title" style="margin-left:11%">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    &nbsp; {{ __('Update Password') }} |

                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">

                                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.update-password-form')
                                </div>

                                <x-jet-section-border />
                                @endif


                            </div>
                        </div>
                    </div><p style="margin-top: 10px;"> &nbsp; </p>

                    <!-- Tab Three -->
                    <div class="panel panel-default" style="border-radius: 10px;">
                        <div class="ppanel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title" style="margin-left:14%">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    &nbsp; {{ __('Authentication') }} |

                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">

                                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.two-factor-authentication-form')
                                </div>

                                <x-jet-section-border />
                                @endif

                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.logout-other-browser-sessions-form')
                                </div>

                            </div>
                        </div>
                    </div><p style="margin-top: 10px;"> &nbsp; </p>

                    <!-- Tab Four -->
                    <div class="panel panel-default" style="border-radius: 10px;">
                        <div class="ppanel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title" style="margin-left:13%">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    &nbsp; {{ __('Delete Account') }} |

                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">


                                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                <x-jet-section-border />

                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.delete-user-form')
                                </div>
                                @endif

                            </div>
                        </div>
                    </div><p style="margin-top: 10px;"> &nbsp; </p>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
</div>

<!-- jQuery -->
<script src="{{asset('user/extra/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('user/extra/js/bootstrap.min.js')}}"></script>

@livewireScripts