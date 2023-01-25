@component('mail::message')
<div class="mailHeadImage" style="width: 400px;height: 250px;display: block;margin: 30px auto;">
    <img src="{{asset('images/verifyemail.png')}}" alt="" width="100%" height="100%">
</div>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Email Verification')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}

@lang('Thank you'),<br>The <b style="font-weight: bold">PWG Group Team</b>

{{-- Subcopy --}}

@endcomponent
