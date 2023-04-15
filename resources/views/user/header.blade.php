<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
    <meta http-equiv="Content-Security-Policy: default-src data: 'self' https://*.bootstrap.com https://*.jsdelivr.net https://*.fontawesome.com https://fonts.googleapis.com https://fonts.gstatic.com https://code.jquery.com; form-action 'self'; style-src 'self' 'unsafe-inline' 'unsafe-eval'; upgrade-insecure-requests"> 
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
    <title>PWG Client Portal</title>
    <link rel="icon" type="image/png" href="{{asset('images/pwglogo.svg')}}">
    <meta name="keywords" content="Immigration, visa, travel,abroad work visa consultants, affordable immigration,work permit, 188 visa,canadian immigration, UAE, POLAND, Malta, Czech, Canada, Germany">
        <!-- Icon -->
    <link rel="stylesheet" href="{{asset('user/extra/assets/fonts/line-icons.css')}}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('user/extra/assets/css/main.css')}}">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="{{asset('user/extra/assets/css/responsive.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

 	  <link rel='stylesheet' type='text/css' media='screen' href='{{asset('user/css/style.css')}}'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('fonts/stylesheet.css')}}'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">		

    <style>
       .titled {
          font-size: 11px;
        }
        @media (max-width:1024px) {
          .titled {
          font-size: 9px;
         }
        }
        @media (max-width:850px) {
          .titled {
           font-size: 9px;
          }
          .navbar-expand-md .navbar-nav .nav-link {
              padding-right: 10px !important;
              padding-left: 10px !important;
          }
        }

        .network .title{
          font-size: 18px !important;
        }

    </style>
</head>

<header>
    <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbarx">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="{{url('/')}}">
              <picture>
                <source media="(min-width:1025px)" srcset="{{asset('images/logo.png')}}">
                <source media="(min-width:260px)" srcset="{{asset('images/logo2.png')}}">
                <img class="logos" src="{{asset('images/logo.png')}}" alt="PWG logo">
              </picture>
              <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
            </a>

          @if(Route::has('login'))

            @auth
              <div class="d-flex align-items-center justify-content-center jobbers">
                <a class="nav-link btn create-new-button"  aria-expanded="false" href="{{url('myapplication')}}">
                  <span style="display:inline-block"><img alt="PWG" src="{{asset('images/icon1.png')}}"></span><span class="title">{{ __('My Application') }} </span>
                </a>
              </div>
              <div class="d-flex align-items-center justify-content-center jobbers">
                <a class="nav-link btn create-new-button network" aria-expanded="false" href="{{route('newtork.partner')}}">
                  <span style="display:inline-block"><img alt="PWG" src="{{asset('images/icon2.png')}}"></span><span class="title" style="padding-top:0px;display:inline-block">Network Partner</span>
                </a>
              </div>
            @else
              <!-- <div class="d-flex align-items-center justify-content-center jobber">
                <a class="nav-link btn create-new-button"  aria-expanded="false" href="{{route('login')}}">
                <span><img src="{{asset('images/icon1.png')}}"></span><span style="padding-top:5px">Applicants </span>
                </a>
              </div> -->
              {{-- <div class="d-flex align-items-center justify-content-center jobbers">
                <a class="nav-link btn create-new-button" aria-expanded="false" href="{{route('affiliate.home')}}">
                  <span style="display:inline-block"><img alt="PWG" src="{{asset('images/icon2.png')}}"></span><span class="title" style="padding-top:0px;display:inline-block">Affiliate Partner</span>
                </a>
              </div> --}}
            @endauth
          @endif

          @if(Route::has('login'))
            @auth
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni-menu"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                @else
                  <div class="collapsexx navbar-collapsexx" id="navbarCollapse">
            @endauth 
          @endif
          <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">

            @if(Route::has('login'))
             @auth
              {{-- <li class="nav-item d-lg-block">
                <a class="nav-link" href="#">
                  <img src="{{asset('user/images/Search.svg')}}" width="30px" height="30px" alt="PWG icon3">
                </a>
              </li> --}}
              <li class="nav-item">
                <a target="_blank" class="nav-link" href="https://wa.link/16s7s9" title="Click Here To Chat on WhatsAPP">
                  <!-- <i class="mdi mdi-email" style="width: 30px; height: 30px;"></i> -->
                  <img src="{{asset('user/images/chat_new.svg')}}" width="35px" height="35px" alt="PWG icon3"> <span class="titled"> Chat</span>
                  <span class="count bg-success"></span>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link"  id="notificationDropdown" href="#" data-toggle="dropdown">
                  <!-- <i class="mdi mdi-bell" style="width: 30px; height: 30px;"></i> -->
                  <img src="{{asset('user/images/notification_new.svg')}}" width="35px" height="35px" alt="icon3"> <span class="titled"> Notifications</span>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list notificationSec" aria-labelledby="notificationDropdown" >
                  
                   @include('user.notifications')
       
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="{{asset('user/images/profile_new.svg')}}" style="width: 35px; height: 35px;" alt="PWG "> <span class="titled"> My Profile</span>
                    {{-- <img src="{{asset('images/dropdown.png')}}" width="3%"> --}}
                    {{-- <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}</p> --}}
                    <i class="fa-solid fa-caret-down"></i>
                  </div>
                </a>
                
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" style="left:-10px;  min-width: 150px;" aria-labelledby="profileDropdown">
                  
                  {{-- <div class="dropdown-divider"></div> --}}
                  <div class="userName">
                    <a class="dropdown-item preview-item">
                      <div class="preview-item-content">
                        <p style="font-size:16px;"><b>{{ Auth::user()->name }}</b></p>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-item-content">
                      <form method="GET" action="{{ route('profile.show') }}" x-data>     
                        <button>Profile</button>
                      </form>
                      <!-- <p class="preview-subject mb-1"><a href="{{ route('profile.show') }}">Profile</a></p> -->
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-item-content">
                      <px class="preview-subject mb-1">
                      <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf  
                        <button>Logout</button>
                      </form>
                    </px>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <!-- <p class="p-3 mb-0 text-center">Advanced settings</p> -->
                </div>
              </li> 
             @else
              <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">
                  <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                    <img class="img-xs rounded-circlex" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="PWG ">&nbsp; Login
                  </div>
                </a>
              </li>
             @endauth
            @endif
          </ul>
        </div>
      </nav><p style="margin-bottom:70px"></p>
      <!-- Navbar End -->
    </header>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
    <script src="{{asset('user/extra/assets/js/jquery-min.js')}}"></script>
    
    <script src="{{asset('user/extra/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/wow.js')}}"></script>
    {{-- <script src="{{asset('user/extra/assets/js/main.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   {{-- <script src="{{asset('user/extra/assets/js/jquery.nav.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/scrolling-nav.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/jquery.easing.min.js')}}"></script> 
    <script src="{{asset('user/extra/assets/js/form-validator.min.js')}}"></script>
    <script src="{{asset('user/extra/assets/js/contact-form-script.min.js')}}"></script> --}}

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
   