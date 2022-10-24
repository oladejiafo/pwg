@extends('layouts.auth')

<style>
    select,
    input [type="text"] {
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }

    .link-button {
    background: none;
    border: none;
    color: blue;
    text-decoration: none;
    cursor: pointer;
    }
    .link-button:focus {
    outline: none;
    }
    .link-button:active {
    color:red;
    }
</style>
<?php  $email = Session::get('email'); ?>

@Section('content')
    <div class="container">
        <div class="forgot-password" style="height: auto;padding-top:30px;margin-top:100px">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/Approved.svg')}}" alt="approved">
                </div>
                <div class="reset-heading">
                    Reset your password
                </div>
                <div class="reset-title">
                    <p>Please enter code received</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{ route('affiliate.passwordUpdate') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{old('email',$email)}}">
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" name="otp" aria-describedby="emailHelp" autocomplete="off" placeholder="########" required>
                                @error('otp') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password" required>
                                @error('password') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation" required>
                                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary submitBtn">Reset Password</button>
                    </form>
                </div>
                <div >

                        <form method="POST" action="{{ route('affiliate.PasswordRequest') }}">
                        @csrf
                        <p class="subInfo"> 

                        <input type="hidden" name="email" value="{{Session::get('email')}}">
                        Haven't received the email? Check your spam folder.<br>
                        Still not there?<button type="submit" name="submit_param" value="submit_value" class="link-button">Resend email</button>
                        </p>                        
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
