@extends('layouts.auth')
<style>
  .passwordInput {
      box-sizing: border-box;
      padding-left: 10px;  
      vertical-align: top;
    }

    .passwordInput:focus {
      outline: none;
    }

    img {
      position: absolute;
      top: 12px;
      right: 25px;  
    }

  .inputs-icon {
    position: relative;
  }
</style>
@Section('content')
  <div class="login">
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
                <input type="text" class="form-control" id="exampleInputName" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="email" class="form-label">Email</label></div>
              <div class="inputs">
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="phone number" class="form-label">Phone number</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
              </div>
            </div>
            <div class="mb-3">
              <div class="label">
                <label for="Password" class="form-label">Password</label>
              </div>
              <div class="inputs-icon">
                <input type="password" class="form-control passwordInput" id="exampleInputPassword1" autocomplete="off">
                <a href="#"><img src="{{asset('images/Eye_Icon.png')}}" alt=img></a>
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="email1" class="form-label">Confirm Password</label></div>
              <div class="inputs-icon">
                <input type="password" class="form-control passwordInput" id="exampleInputEmail1 " aria-describedby="emailHelp" autocomplete="off">
                <a href="#"><img src="{{asset('images/Eye_Icon.png')}}" alt=img></a>
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