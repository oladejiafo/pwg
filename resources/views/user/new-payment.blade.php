@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">
<link href="{{asset('css/alert.css')}}" rel="stylesheet">

@section('content')
<div class="payment-form">
    <div id="mount-id"></div>
    <button onclick="createSession()" class="checkoutButton">
        Check out
    </button>
</div>
@endsection
@push('custom-scripts')
<script src="https://paypage.sandbox.ngenius-payments.com/hosted-sessions/sdk.js"></script>
<script>
    /* Method call to mount the card input on your website */
    "use strict";
    window.NI.mountCardInput('mount-id'
    /* the mount id*/
    , {
    //   style: style,
      // Style configuration you can pass to customize the UI
      apiKey: "MmM2ODJiOGMtOGFmNS00NzUyLTg2MjUtM2Y5MTg3OWU5YjRlOjViMzhjM2I5LTUyMDItNDBmZi1hNzAyLTFlYTIwZDkwYjhiMQ==",
      // API Key for WEB SDK from the portal
      outletRef: "15d885ec-682a-4398-89d9-247254d71c18",
      // outlet reference from the portal
    //   onSuccess: onSuccess,
      // Success callback if apiKey validation succeeds
    //   onFail: onFail, // Fail callback if apiKey validation fails
      onChangeValidStatus: (function (_ref) {
            var isCVVValid = _ref.isCVVValid,
        isExpiryValid = _ref.isExpiryValid,
        isNameValid = _ref.isNameValid,
        isPanValid = _ref.isPanValid;
            console.log(isCVVValid, isExpiryValid, isNameValid, isPanValid);
            })
    });
    let sessionId;
    async function createSession() {
        try {
            const response = await window.NI.generateSessionId();
            sessionId = response.session_id;
        } catch (err) {
            console.error(err);
        }
    }
  </script>
@endpush