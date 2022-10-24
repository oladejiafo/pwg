@extends('layouts.auth')
@Section('content')
    <div class="container">
        <div class="forgot-password" style="width: 450px;padding-top:30px;margin-top:150px">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/Approved.svg')}}" alt="approved">
                </div>
                <div class="reset-heading">
                    Woohoo !
                </div>
                <div class="reset-title">
                    <p>Password reset successfully !</p>
                    <p>Please login with your new password</p>
                </div>
                <div class="form-sec">
                    <a href="{{route('login')}}" style="color: #606060"><button class="btn btn-primary submitBtn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection