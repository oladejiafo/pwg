@extends('layouts.auth')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/> -->
<link href="{{asset('user/css/select2.min.css') }}" rel="stylesheet" />


<style>
  .checkcolor {
  accent-color: #f9bf29;

}

select,
textarea,
input [type="text"],
input [type="number"],
input [type="password"],
input [type="date"],
input [type="email"],
input [type="phone"]
{
  padding: 10px;
}
</style>

@php
$agents = DB::table('employees')
->select('name','sur_name')
->where('is_active', '=', 1)
->whereRaw('name != ""')
->whereIn('designation_id', [1,33,35])
->orderBy('id','asc')
->get();
@endphp

@Section('content')
  <div class="container">
    <div class="form-sec1">
      <div class="heading">
        <div class="first-heading">
          <h3>
            Let's get you started!
          </h3>
        </div>
        <div class="bottoom-title">
          <p>Please create your account</p>
        </div>
      </div>
      <div class="tab-sec">
        <a href="{{route('register')}}" class="signupBtn">Signup</a>
        <a href="{{route('login')}}" >Login</a>
      </div>
      <div class="form-sec">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="mb-3">
            <div class="label"><label for="name" class="form-label">Name</label></div>
            <div class="inputs">
              <input type="text" style="padding: 10px;" class="form-control" id="exampleInputName" name="name" aria-describedby="emailHelp" autocomplete="off" required value="{{ old('name') }}">
            </div>
          </div>
          <div class="mb-3">
            <div class="label"><label for="email" class="form-label">Email</label></div>
            <div class="inputs">
              <input type="email" style="padding: 10px;" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" autocomplete="off" required value="{{ old('email') }}">
              @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="label"><label for="phone number" class="form-label">Phone number</label></div>
            <div class="inputs">
              {{-- <input name="form-control" type="text" id="txtCountryCode" class="c-input-telephone__country error" pattern="^[+]\d{1,3}$" maxlength="4" required="" value="+971" aria-invalid="true"> --}}
              <input type="tel" style="paddingx: 10px;" class="form-control phone_number" id="phone_number" name="phone_number" aria-describedby="emailHelp" autocomplete="off" required value="{{ old('phone_number') }}" required="">
              @error('phone_number') <span class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="label">
              <label for="Password" class="form-label">Password</label>
            </div>
            <div class="inputs-icon">
              <input type="password" class="form-control passwordInput" id="exampleInputPassword1" name="password" autocomplete="off" required>
              <img src="{{asset('images/Eye_Icon.png')}}" alt=img class="iconImg">
              <img src="{{asset('images/view_password.svg')}}" alt=img class="viewIcon">
              @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="label"><label for="email1" class="form-label">Confirm Password</label></div>
            <div class="inputs-icon">
              <input type="password" class="form-control confirmation" name="password_confirmation" aria-describedby="emailHelp" autocomplete="off" required>
              <img src="{{asset('images/Eye_Icon.png')}}" alt=img id="cofirmation">
              <img src="{{asset('images/view_password.svg')}}" alt=img class="confirmation_viewIcon">
              @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="label">
              <label for="Agent" class="form-label">Your Agent Name</label>
            </div>
            <div class="inputs-iconx">

              <select name="agent" class="form-control agentInput" id="exampleInputAgent">
                @if(old('agent'))
                <option selected>{{old('agent')}}</option>
                @else
                <option selected disabled>--Select Your Agent--</option>
                @endif
                @foreach ($agents as $agent)
                    <option>{{ucfirst(strtolower($agent->name))}} {{ucfirst(strtolower($agent->sur_name))}}</option>
                @endforeach
                <option>N/A</option>
              </select>
              @error('agent') <span class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="inputs check-box">
              <input type="checkbox" class="checkcolor agree" name="terms" required>
                <p  style="padding-top: 10px;padding-left:10px"> I agree to the <a target="_blank" href="{{route('terms')}}" >Terms and Policy"</a>
              </p>
            </div>
          </div>
          <button type="submit" class="btn btn-primary submitBtn">Signup</button>
        </form>
      </div>
    </div>
  </div>
@endsection
@push('custom-scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $(document).ready(function() {
        $('#exampleInputAgent').select2();

        //password
        $('.iconImg').show();
        $('.viewIcon').hide();
        $('.iconImg, .viewIcon').on('click', function(){
            var passInput=$(".passwordInput");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
                $('.iconImg').hide();
                $('.viewIcon').show();
            }else{
              passInput.attr('type','password');
              $('.iconImg').show();
              $('.viewIcon').hide();
            }
        })
        // confirm password
        $('.confirmation_viewIcon').hide();
        $('#cofirmation').show();
        $('#cofirmation, .confirmation_viewIcon').on('click', function(){
            var passInput=$(".confirmation");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
                $('.confirmation_viewIcon').show();
                $('#cofirmation').hide();
            }else{
              passInput.attr('type','password');
              $('.confirmation_viewIcon').hide();
              $('#cofirmation').show();
            }
        })
      });
      // $(function () {
      //       var code = "+91"; // Assigning value from model.
      //       const phoneInputField = document.querySelector("#phone_number").val(code);
      //       const phoneInput = window.intlTelInput(phoneInputField, {
      //           initialCountry: "ae",
      //           utilsScript:
      //               "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      //           z
      //       });

      // $('#phone_number').val(code);
      // $('#phone_number').intlTelInput({
      //     autoHideDialCode: true,
      //     autoPlaceholder: "ON",
      //     dropdownContainer: document.body,
      //     formatOnDisplay: true,
      //     hiddenInput: "full_number",
      //     initialCountry: "auto",
      //     nationalMode: true,
      //     placeholderNumberType: "MOBILE",
      //     preferredCountries: ['US'],
      //     separateDialCode: true,
      //     utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
      // });
            
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

      // $('#submitBtn').on('click', function () {
      //     var code = $("#phone_number").intlTelInput("getSelectedCountryData").dialCode;
      //     var phoneNumber = $('#phone_number').val();
      //     var name = $("#phone_number").intlTelInput("getSelectedCountryData").name;
      //     alert('Country Code : ' + code + '\nPhone Number : ' + phoneNumber + '\nCountry Name : ' + name);
      // });
        // });
  </script>
@endpush