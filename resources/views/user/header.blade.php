

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PWG Client Portal</title>

<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="../user/extra/assets/css/bootstrap.min.css" > -->
<!-- Icon -->
<link rel="stylesheet" href="{{asset('user/extra/assets/fonts/line-icons.css')}}">
<!-- Owl carousel -->
<!-- <link rel="stylesheet" href="../user/extra/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="../user/extra/assets/css/owl.theme.css"> -->

<!-- Animate -->
<!-- <link rel="stylesheet" href="../user/extra/assets/css/animate.css"> -->
<!-- Main Style -->
<link rel="stylesheet" href="{{asset('user/extra/assets/css/main.css')}}">
<!-- Responsive Style -->
<link rel="stylesheet" href="{{asset('user/extra/assets/css/responsive.css')}}">

<link rel='stylesheet' type='text/css' media='screen' href='{{asset('user/css/style.css')}}'>
<link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>
<link rel='stylesheet' type='text/css' media='screen' href='{{asset('fonts/stylesheet.css')}}'>

<style>
html, body {
  padding: 0;
  margin: 0%;
}

.navbar {
  /* margin-bottom: 100vw; */
  list-style: none;
    position:absolute;

}
.navbar .container {
  padding-left: 0px;
  padding: 5px;
  width: 100vw;
  margin: 0px;
  margin-left: 50px;
  margin-right: 50px;
  display: absolute;
}
.scrolling-navbar {
  width: 100%;
  margin: 0;
}

.navbar .jobbers a,
.navbar .jobber a {
  text-decoration: none;
  color:black;
  background-color:#e0e0e0; 
  border-radius:10px; 
  padding:5px;
  padding-top: 10px;
  padding-bottom: 10px;
  margin-top: 10px;
  margin-left: 50px;
  width:200px;
  height: 50px;
  font-family: 'TT Norms Pro';
  font-weight: 500;
  font-size: 20px;
  display: block;
  
}
.navbar .logos img {
/* content: url('../images/logo.png'); */
  /* height: 40px; */
  padding: 5px;
  align-items: left;
  align-content: flex-start;
  padding-bottom: 10px;
}

.navbar .jobbers img,
.navbar .jobber img {
  height: 40px;
  padding: 3px;
  padding-bottom: 10px;
  float: left;
}


.navbar .jobbers .title{
width:75%;
text-align: left;
float: right;
}
.nav-item {
  color: #fff;
}

@media (max-width:768px) {

  .navbar {
      padding-bottom: -10px;
      margin-bottom: 30px;
  }
  .navbar .container {
  padding-left: 0px;
  padding: 5px;
  width: 100%;
  margin: 10px;
  margin-left: 15px;
  display: cover;
}
.button{
  /* background: url(../user/images/User.svg) no-repeat; */
  cursor:pointer;
  border: none;
  float: right;
  text-align: right;
  min-width: 160px;
  background-position: 10px left;
}

.navbar .jobbers a {
  text-decoration: none;
  color:black;
  background-color:#e0e0e0; 
  border-radius:10px; 
  padding:5px;
  padding-top: 10px;
  padding-bottom: 5px;
  margin-top: 5px;
  margin-left: 20px;
  width:160px;
  height: 50px;
  font-family: 'TT Norms Pro';
  font-weight: 500;
  font-size: 14px;
  display: block;
}
.navbar .jobbers img {
width: auto;
  height: 40px;
  padding: 5px;
  padding-bottom: 10px;
}

.navbar .jobber a {
  text-decoration: none;
  color:black;
  background-color:#e0e0e0; 
  border-radius:10px; 
  padding:5px;
  padding-top: 5px;
  padding-bottom: 5px;
  margin-top: 5px;
  margin-left: 5px;
  width:100px;
  height: 35px;
  font-family: 'TT Norms Pro';
  font-weight: 500;
  font-size: 12px;
  display: block;
}
.navbar .jobber img {
width: auto;
  height: 30px;
  padding: 5px;
  padding-bottom: 10px;
}
.navbar-expand-md .navbar-brand {
  margin: 0 3px;
}
}

.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    max-width: 100% !important;
}
</style>

</head>
<body>
<nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbarx">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->

    <a class="navbar-brand" href="{{url('/')}}">
      <picture>
      <source media="(min-width:769px)" srcset="{{asset('images/logo.png')}}">

        <source media="(min-width:260px)" srcset="{{asset('images/logo2.png')}}">

       <img class="logos" src="{{asset('images/logo.png')}}" alt="logo">
       </picture>
      <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
    </a>       

    @if(Route::has('login'))

@auth
<div class="d-flex align-items-center justify-content-center jobbers">
<a class="nav-link btn create-new-button"  aria-expanded="false" href="{{url('myapplication')}}">
 <span style="display:inline-block"><img src="{{asset('images/icon1.png')}}"></span><span class="title" style="padding-top:0px; display:inline-block">My Application </span>
</a>
</div>
@else
<div class="d-flex align-items-center justify-content-center jobber">
<a class="nav-link btn create-new-button"  aria-expanded="false" href="{{route('login')}}">
<span><img src="{{asset('images/icon1.png')}}"></span><span style="padding-top:5px">Applicants </span>
</a>
</div>
<div class="d-flex align-items-center justify-content-center jobber">
<a class="nav-link btn create-new-button" aria-expanded="false" href="#">
<span><img src="{{asset('images/icon2.png')}}"></span><span style="padding-top:5px">Affiliates</span>
</a>
</div>
@endauth
@endif

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <i class="lni-menu"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">

      @if(Route::has('login'))
      @auth
        <li class="nav-item d-lg-block">
          <a class="nav-link" href="#">
            <img src="../user/images/Search.svg" width="30px" height="30px" alt="icon3">
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <!-- <i class="mdi mdi-email" style="width: 30px; height: 30px;"></i> -->
            <img src="../user/images/Chat.svg" width="30px" height="30px" alt="icon3">
            <span class="count bg-success"></span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <!-- <i class="mdi mdi-bell" style="width: 30px; height: 30px;"></i> -->
            <img src="../user/images/Notification.svg" width="30px" height="30px" alt="icon3">
            <span class="count bg-danger"></span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
            <div class="navbar-profile">
              <img class="img-xs rounded-circle" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="">
              <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}</p>
              <i class="mdi mdi-menu-down d-none d-sm-block"></i>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-item-content">
              <form method="GET" action="{{ route('profile.show') }}" x-data>
                      @csrf  
                <button style="border-color: #fff; padding:3px; margin:0; width:100px; background-color:#fff; shadow:none;">Profile</button>
                </form>
                <!-- <p class="preview-subject mb-1"><a href="{{ route('profile.show') }}">Profile</a></p> -->
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
            
              <div class="preview-item-content">
                <p class="preview-subject mb-1">
                <form method="POST" action="{{ route('logout') }}" x-data>
                      @csrf  
                <button style="border-color: #fff; padding:3px; margin:0; width:100px; background-color:#fff; shadow:none;">Log out</button>
                </form>
              </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <!-- <p class="p-3 mb-0 text-center">Advanced settings</p> -->
          </div>
        </li> </ul>
       @else
<ul>
        <li class="nav-item">
          <a class="nav-link" href="{{route('login')}}">
            <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
              <img class="img-xs rounded-circlex" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="">&nbsp; Sign In
            </div>
          </a>
        </li>
</ul>
        @endauth
      @endif
      </ul>
    </div>
  </div>
</nav><p style="margin-bottom:70px"></p>
<!-- Navbar End -->
</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../user/extra/assets/js/jquery-min.js"></script>
<script src="../user/extra/assets/js/popper.min.js"></script>
<script src="../user/extra/assets/js/bootstrap.min.js"></script>
<script src="../user/extra/assets/js/owl.carousel.min.js"></script>
<script src="../user/extra/assets/js/wow.js"></script>
<!-- <script src="../user/extra/assets/js/jquery.nav.js"></script>
<script src="../user/extra/assets/js/scrolling-nav.js"></script>
<script src="../user/extra/assets/js/jquery.easing.min.js"></script>  -->
<script src="../user/extra/assets/js/main.js"></script>
<!-- <script src="../user/extra/assets/js/form-validator.min.js"></script>
<script src="../user/extra/assets/js/contact-form-script.min.js"></script>
 -->