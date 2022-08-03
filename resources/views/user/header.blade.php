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

</head>
<div class="login">
<div class="header-sec">  
    <div class="left-sec">
        <div class="logo"><a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt="logoo"></a></div>
        <div class="applicant"><a href="{{route('login')}}" style="width:200px; text-align:center; display:block;"><span><img src="{{asset('images/icon1.png')}}"></span> Applicants</a></div>
        <div class="affiliate "><a href="#" style="width:250px; text-align:center; display:block;"><span><img src="{{asset('images/icon2.png')}}"></span> Affiliate Partner</a></div>
    </div>
    <div class="signin-right ">
        <a href="{{route('login')}}"><img src="{{asset('images/icon3.png')}}" alt="icon3">Sign In</a>
    </div>
</div>
</div>
