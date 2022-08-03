@extends('layouts.auth')
@Section('content')
    <div class="login">
        <div class="container">
            <div class="forgot-password">
                <div class="reset">
                    <div class="resetImage">
                        <img src='PWG_Client/public/images/ring.png' alt="ring" class="ring">
                        <img src='PWG_Client/public/images/tick.png' alt="ring" class="tick">
                    </div>
                    <div class="reset-heading">
                    Check your mailbox !
                    </div>
                    <div class="subConfirm">to confirm this email belongs to you</div>
                    <div class="reset-title">
                        <p>we have sent a confirmation email to your inbox for response please ensure to check your spam box incase you cannot find in your inbox.</p>
                    </div>
                    <div class="form-sec">
                        <button class="btn btn-primary submitBtn">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection