<head>

    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />

    <title>PWG Client Portal</title>


    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('user/css/style.css')}}'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('fonts/stylesheet.css')}}'>

    <style>
        .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}
    </style>
</head>
<div class="login">
    <div class="header-sec">
        <div class="left-sec">

        <div class="logo"><a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt="logoo"></a></div>

        @if(Route::has('login'))

        @auth
            <div class="myapplicant"><a href="{{url('myapplication')}}" style="width:260px; "><span><img src="{{asset('images/icon1.png')}}"></span><span style="padding-top:5px"> My Application</span></a></div>
        @else
            <div class="applicant"><a href="{{route('login')}}" style="width:200px; text-align:center; display:block;"><span><img src="{{asset('images/icon1.png')}}"></span> Applicants</a></div>
            <div class="affiliate "><a href="#" style="width:250px; text-align:center; display:block;"><span><img src="{{asset('images/icon2.png')}}"></span> Affiliate Partner</a></div>
        @endauth
        @endif

        </div>
        <div class="signin-right ">

            @if(Route::has('login'))

            @auth 
            <div id="activity">
                <div class="divs"><a href="#"><img src="../user/images/Search.svg" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="../user/images/Notification.svg" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="../user/images/Chat.svg" width="30px" height="30px" alt="icon3"></a></div>
                {{-- <div class="dropdown">
                    <img src="../user/images/signin.svg" style="width: 80px; height: 40px;" alt="icon3">
                    <div class="dropdown-content">
                        <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </div> --}}
                <x-app-layout>
            
                </x-app-layout>
            </div>
            @else
            
            <a href="{{route('login')}}"><img src="../user/images/signin.svg" style="width: 80px; height: 40px;" alt="icon3">Sign In</a>
            @endauth
            @endif

        </div>
    </div>
</div>