@extends('layouts.auth')

<style>
    select,
    input [type="text"] {
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }

    
</style>
@Section('content')
    <div class="container">
        <div class="forgot-password" style="height: auto;">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/Approved.svg')}}" alt="PWG Group approved">
                </div>
                <div class="reset-heading">
                    Reset your password
                </div>
                <div class="reset-title">
                    <p>Please enter code received on your mail</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{ route('customize.password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{old('email', $email)}}">
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" name="otp" value="{{old('otp')}}" aria-describedby="emailHelp" autocomplete="off" placeholder="########" required>
                                @error('otp') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs-icon"> 
                                <input type="password" class="form-control passwordInput" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password" value="{{old('password')}}" required>
                                @error('password') <span class="error">{{ $message }}</span> @enderror
                                <img src="{{asset('images/Eye_Icon.png')}}" alt="PWG Group" class="iconImg">
                                <img src="{{asset('images/view_password.svg')}}" alt="PWG Group" class="viewIcon">
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs-icon"> 
                                <input type="password" class="form-control confirmation" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation" value="{{old('password_confirmation')}}"  required>
                                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                                <img src="{{asset('images/Eye_Icon.png')}}" alt="PWG Group" id="cofirmation">
                                <img src="{{asset('images/view_password.svg')}}" alt="PWG Group" class="confirmation_viewIcon">
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary submitBtn">Reset Password</button>
                    </form>
                </div>
                <div >
                    <form action="{{ route('customize.forgot.password') }}" method="POST"> @csrf<p class="subInfo"> Haven't received the email? Check your spam folder.<br>Still not there?  <input type="hidden" name="email" value="{{old('email', $email)}}" /><button class="resendemail" type="submit"><a>Resend email</a></button></p></form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
  <script>
      $(document).ready(function() {
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
  </script>
@endpush
