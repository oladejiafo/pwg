@extends('layouts.auth')
@Section('content')
    <div class="login">
        <div class="container">
            <div class="forgot-password" style="height: 837px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/Approved.svg')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Reset your password
                    </div>
                    <div class="reset-title">
                        <p>Please enter code received on email/phone</p>
                    </div>
                    <div class="form-sec">
                        <form method="POST" action="{{ route('password.email') }}">
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{old('email', $request->email)}}">
                            <div class="mb-3">
                                <div class="inputs"> 
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="########">
                                </div>            
                            </div>
                            <div class="mb-3">
                                <div class="inputs"> 
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password">
                                </div>            
                            </div>
                            <div class="mb-3">
                                <div class="inputs"> 
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation">
                                </div>            
                            </div>
                            <button type="submit" class="btn btn-primary submitBtn">Reset Password</button>
                        </form>
                    </div>
                    <div >
                        <p class="subInfo"> Haven't received the email? Check your spam folder.
                            Still not there? Then try this: <a href="#">Resend email</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection