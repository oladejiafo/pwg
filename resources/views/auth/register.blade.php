<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>

</head>

<body>
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
          <form>
            <div class="mb-3">
              <div class="label"><label for="email1" class="form-label">Name</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>


            </div>
            <div class="mb-3">
              <div class="label"><label for="email1" class="form-label">Phone number</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>


            </div>

            <div class="mb-3">
              <div class="label">
                <label for="Password" class="form-label">Password</label>
              </div>
              <div class="inputs">
                <input type="password" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
            <div class="mb-3">
              <div class="label"><label for="email1" class="form-label">Confirm Password</label></div>
              <div class="inputs">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
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



</body>

</html>