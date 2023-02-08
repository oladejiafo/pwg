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
{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span><br><br>
@lang('Thank you'),<br>The <b style="font-weight: bold">PWG Group Team</b>
<hr style="margin-left: -33px; margin-right:-33px !important;color:#383838;height:0.25px">

<div style="display: block; margin-top:50px;text-align: center;">
    <div style="width:65%; display:inline-block;margin:auto;">
        <div style="float:right; height: 20%">
            <img src="{{asset('images/mailfooter.png')}}" alt="" width="100%" height="100%">
        </div>
    </div>
</div>
@endslot
@endisset

{{-- @lang('Thank you'),<br>The <b style="font-weight: bold">PWG Group Team</b> --}}

{{-- Subcopy --}}

@endcomponent
