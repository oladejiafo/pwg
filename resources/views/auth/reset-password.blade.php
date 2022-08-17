@extends('layouts.auth')

<style>
    select,
    input [type="text"] {
        font-size: 18px;
        text-align: left;
        padding: 10px;
        width:100%;
    }

    
</style>
@Section('content')
    <div class="container">
        <div class="forgot-password" style="height: 837px;padding-top:50px;margin-top:150px">
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
                    <form method="POST" action="{{ route('customize.password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{old('email', $email)}}">
                        <div class="mb-3">
                            <div class="inputsx"> 
                                <input type="text" class="form-control" name="otp" aria-describedby="emailHelp" autocomplete="off" placeholder="########" required>
                                @error('otp') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputsx"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password" required>
                                @error('password') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputsx"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation" required>
                                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary submitBtnx">Reset Password</button>
                    </form>
                </div>
                <div >
                    <p class="subInfo"> Haven't received the email? Check your spam folder.
                        <br>Still not there? <a href="{{route('password.request')}}">Resend email</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection



