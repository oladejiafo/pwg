@component('mail::layout')
{{-- Header --}}
@slot('header')
<div style="margin-bottom: 30px"></div>

@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
<hr style="margin-left: -33px; margin-right:-33px !important;color:#383838;height:0.25px">

<div style="display: block; margin-top:50px;text-align: center;">
    <div style="width:65%; display:inline-block;margin:auto;">
        <div style="float:right; height: 20%">
            <img src="{{asset('images/mailfooter.png')}}" alt="" width="100%" height="100%">
        </div>
    </div>
</div>
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{-- © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.') --}}
@endcomponent
@endslot
@endcomponent
