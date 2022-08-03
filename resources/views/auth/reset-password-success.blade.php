@extends('layouts.auth')
@Section('content')
    <div class="login">
        <div class="container">
            <div class="forgot-password" style="width: 250px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src='PWG_Client/public/images/ring.png' alt="ring" class="ring">
                        <img src='PWG_Client/public/images/tick.png' alt="ring" class="tick">
                    </div>
                    <div class="reset-heading">
                        Woohoo !
                    </div>
                    <div class="reset-title">
                        <p>Password reset successfully !</p>
                        <p>Please login with your new password</p>
                    </div>
                    <div class="form-sec">
                        <button class="btn btn-primary submitBtn">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection