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

    <style type="text/css">
    .button{
        /* background: url(../user/images/User.svg) no-repeat; */
        cursor:pointer;
        border: none;
        float: right;
        text-align: right;
        min-width: 250px;
        background-position: 20px left;
    }
</style>
</head>
<div class="login">
    <div class="header-sec">
        <div class="left-sec">

        <div class="logo"><a href="{{url('/')}}"><img class="logo" alt="logoo"></a></div>

        @if(Route::has('login'))

        @auth
            <div class="myapplicant"><a href="{{url('myapplication')}}" style=" "><span><img src="{{asset('images/icon1.png')}}"></span><span style="padding-top:5px"> My Application</span></a></div>
        @else
            <div class="applicant"><a href="{{route('login')}}"><span><img src="{{asset('images/icon1.png')}}"></span> Applicants</a></div>
            <div class="affiliate "><a href="#"><span><img src="{{asset('images/icon2.png')}}"></span> Affiliate</a></div>
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
                <div class="divsx dropdown">
                    <img src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="icon3">
                    <div class="dropdown-content">
                        <a class="dropdown-item" style="margin-left:0px" href="{{ route('profile.show') }}">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
    
                            <button type="submit" style="min-width:120px" href="{{ route('logout') }}"
                                     @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            
            <a class="logg" href="#"><a href="{{route('login')}}"><img src="{{asset('user/images/signin.svg')}}" style="width: 80px; height: 40px;" alt="icon3">Sign In</a>
            @endauth
            @endif

        </div>
    </div>
</div>