@extends('layouts.auth')
@Section('content')
  <div class="login">
    @include('layouts/auth-header')
    <div class="container">
        <div class="form-sec1">
          <div class="heading">
            <div class="first-heading">
                <h3>
                    Welcome Back
                </h3>
            </div>
            <div class="bottoom-title">
              <p>Please login with your account</p>
            </div>
          </div>
          <div class="tab-sec">
              <a href="{{route('register')}}">Signup</a>
              <a href="{{route('login')}}" class="signupBtn">Login</a>
          </div>
          <div class="form-sec">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                  <div class="label"><label for="email1" class="form-label">Email or phone number</label></div>
                <div class="inputs"> 
                  <input type="text" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" autocomplete="off">
                </div>            
              </div>
              <div class="mb-3">
                <div class="label">
                  <label for="Password" class="form-label">Password</label>
                </div>
                <div class="inputs-icon">
                  <input type="password" class="form-control passwordInput" name="password" id="exampleInputPassword1" autocomplete="off">
                  <a href="#"><img src="{{asset('images/Eye_Icon.png')}}" alt=img class="hiddenIcon"></a>
                </div>
              </div>
              
              <button type="submit" class="btn btn-primary submitBtn">Login</button>
              <div class="bottom-sec">
                  <div class="signuplink"><a href="{{route('register')}}">Signup</a></div>
                  <div class="forgot"><a href="{{route('password.request')}}">forgot your password ?</a></div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>  
@endsection