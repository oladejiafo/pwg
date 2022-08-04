@extends('layouts.auth')
<style>
  .hiddenIcon{
    cursor: pointer;
  }
</style>
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
                  <input type="text" class="form-control w-full" id="exampleInputEmail1" name="auth" aria-describedby="emailHelp" autocomplete="off" required autofocus >
                  @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>            
              </div>
              <div class="mb-3">
                <div class="label">
                  <label for="Password" class="form-label">Password</label>
                </div>
                <div class="inputs-icon">
                  <input type="password" class="form-control passwordInput" name="password" id="exampleInputPassword1" autocomplete="off" required autofocus>
                  @error('password') <span class="error">{{ $message }}</span> @enderror
                  <img src="{{asset('images/Eye_Icon.png')}}" alt=img class="hiddenIcon">
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
@push('custom-scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $(document).ready(function() {
        $('.hiddenIcon').on('click', function(){
            var passInput=$(".passwordInput");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
            }else{
              passInput.attr('type','password');
            }
        })
      });
  </script>
@endpush