<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>PWG Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="../user/css/style.css" rel="stylesheet">
  </head>
<body>
  <div class="login">
      <div class="container">
          {{-- <div class="header-sec">  
            <div class="left-sec">
                <div class="logo"><a href="#"><img src="{{asset('images/logo.png')}}" alt="logoo"></a></div>
                <div class="applicant"><a href="#"><span><img src="{{asset('images/icon1.png')}}"></span>Applicants</a></div>
                <div class="affiliate "><a href="#"><span><img src="{{asset('images/icon2.png')}}"></span>Affiliate Partner</a></div>
            </div>
            <div class="signin-right ">
              <a href="#"><img src="images/icon3.png" alt="icon3">Sign In</a>
            </div>
          </div> --}}
          @include('user/header');
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
                <a href="">Login</a>
            </div>
            <div class="form-sec">
              <form>
                <div class="mb-3">
                    <div class="label"><label for="email1" class="form-label">Email or phone number</label></div>
                  <div class="inputs"> 
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>            
                </div>
                <div class="mb-3">
                    <div class="label">
                  <label for="Password" class="form-label">Password</label></div>
                  <div class="inputs"> 
                  <input type="password" class="form-control" id="exampleInputPassword1"></div>
                </div>
                
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="bottom-sec">
                    <div class="signuplink"><a href="">Signup</a></div>
                    <div class="forgot"><a href="">forgot your password ?</a></div>
                </div>
              </form>
            </div>
          </div>
      </div>
  </div>  
</body>
</html>