@extends('layouts.auth')
@Section('content')
    <div class="container">
        <div class="forgot-password">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/Approved.svg')}}" alt="PWG Group approved">
                </div>
                <div class="reset-heading">
                Check your mailbox !
                </div>
                <div class="subConfirm">to confirm this email belongs to you</div>
                <div class="reset-title">
                    <p>we have sent a confirmation email to your inbox for response please ensure to check your spam box incase you cannot find in your inbox.<br><a href="{{route('resend.verification', $id)}}">Resend verification email</a></p>
                </div>
                <div class="form-sec">
                    <a href="{{route('login')}}" style="color: #606060"><button class="btn btn-primary submitBtn">Login</button></a>
                </div>
            </div>
        </div>
    </div>

@endsection