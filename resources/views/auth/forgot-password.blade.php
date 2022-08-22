@extends('layouts.auth')

<style>
    @media (min-width: 375px) and (max-width: 768px)
    {
        .btn {
            margin: 0 0 0 0px;
            padding: 0;
            width:100%;
            align-self: center;

        }
    }
</style>
@Section('content')
    <div class="container">
        <div class="forgot-password " style="padding-top:30px;margin-top:150px">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/forgot_password.svg')}}" alt="forgot password">
                </div>
                <div class="reset-heading">
                    It’s okay to reset your password
                </div>
                <div class="reset-title">
                    <p>Please login with your account</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{ route('customize.forgot.password') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" style="padding: 10px;text-align:left; font-size:16px" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="Email" name="email" :value="old('email')" required autofocus>
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
