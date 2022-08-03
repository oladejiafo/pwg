@extends('layouts.auth')
@Section('content')
  <div class="login">
  <div class="header-sec">  
    <div class="left-sec">
        <div class="logo"><a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt="logoo"></a></div>
        <div class="applicant"><a href="{{route('login')}}" style="width:200px; text-align:center; display:block;"><span><img src="{{asset('images/icon1.png')}}"></span> Applicants</a></div>
        <div class="affiliate "><a href="#" style="width:250px; text-align:center; display:block;"><span><img src="{{asset('images/icon2.png')}}"></span> Affiliate Partner</a></div>
    </div>
    <div class="signin-right ">
        <a href="{{route('login')}}"><img src="images/icon3.png" alt="icon3">Sign In</a>
    </div>
    </div>
    <div class="container">
      <div class="form-sec1">
        <div class="heading">
          <div class="first-heading">
            <h3>
              Let’s get you started !
            </h3>
          </div>
          <div class="bottoom-title">
            <p>Please create your account</p>
          </div>
        </div>
        <div class="tab-sec">
          <a href="{{route('register')}}" class="signupBtn">Signup</a>
          <a href="{{route('login')}}" >Login</a>
        </div>
        <div class="form-sec">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
              <div class="label"><label for="name" class="form-label">Name</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputName" name="name" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="email" class="form-label">Email</label></div>
              <div class="inputs">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="phone number" class="form-label">Phone number</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputEmail1" name="phone_number" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label">
                <label for="Password" class="form-label">Password</label>
              </div>
              <div class="inputs-icon">
                <input type="password" class="form-control passwordInput" id="exampleInputPassword1" name="password" autocomplete="off">
                <img src="{{asset('images/Eye_Icon.png')}}" alt=img class="iconImg">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="email1" class="form-label">Confirm Password</label></div>
              <div class="inputs-icon">
                <input type="password" class="form-control confirmation" name="password_confirmation" aria-describedby="emailHelp" autocomplete="off">
                <img src="{{asset('images/Eye_Icon.png')}}" alt=img id="cofirmation">
              </div>
            </div>
            <div class="mb-3">
              <div class="inputs check-box">
                <input type="checkbox">
                <p>I agree to the <a href="Terms of Service and Privacy Policy">Terms of Service and Privacy Policy"</a>
                </p>
              </div>
            </div>
            <button type="submit" class="btn btn-primary submitBtn">Signup</button>
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
        //password
        $('.iconImg').on('click', function(){
            var passInput=$(".passwordInput");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
            }else{
              passInput.attr('type','password');
            }
        })
        // confirm password
        $('#cofirmation').on('click', function(){
            var passInput=$(".confirmation");
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