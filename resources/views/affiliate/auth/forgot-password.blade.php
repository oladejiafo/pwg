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
        <div class="forgot-password ">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/forgot_password.svg')}}" alt="forgot password">
                </div>
                <div class="reset-heading">
                    It's okay to reset your password
                </div>
                <div class="reset-title">
                    <p>Please login with your affiliate account</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{ route('affiliate.PasswordRequest') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" style="padding: 10px;text-align:left; font-size:16px" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="Email" name="email" value="{{old('email')}}" required autofocus>
                                @error('email') <span class="error" style="padding: 86px;text-align:left; font-size:16px">{{ $message }}</span> @enderror
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
