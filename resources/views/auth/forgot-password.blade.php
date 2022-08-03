@extends('layouts.auth')
@Section('content')
    <div class="login">
        <div class="container">
            <div class="forgot-password ">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/ring.png')}}" alt="ring" class="ring">
                        <img src="{{asset('images/question_mark.png')}}" alt="ring" class="questionMark">
                    </div>
                    <div class="reset-heading">
                        It’s okay to reset your password
                    </div>
                    <div class="reset-title">
                        <p>Please login with your account</p>
                    </div>
                    <div class="form-sec">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="inputs"> 
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="Email or phone number" name="email" :value="old('email')" required autofocus>
                                </div>            
                            </div>
                            <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection