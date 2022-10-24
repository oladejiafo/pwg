

    <head>
        <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
        <title>PWG Group - Affiliate Portal</title>
        <link rel="icon" type="image/png" href="{{asset('/images/affiliate/affiliatelogin.svg')}}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/affiliate.css')}}'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- @if(Route::has('login'))
    @auth --}}
        <header>  
            <nav class="navbar navbar-expand-lg navbar-light affiliateNavLogin">
                <div class="container-fluid">
                    <div class="logoImgAffiliate">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <picture>
                                <img class="logos" src="{{asset('images/affiliate/affiliatelogin.svg')}}" alt="PWG logo">
                            </picture>
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navItems" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link btn create-new-button"  aria-expanded="false" href="#">
                                    <span style="padding-top:5px">NEWS </span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1" role="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false">
                                    INFO
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">About Us</a></li>
                                    <li><a class="dropdown-item" href="#">ToolBox</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <span class="title" >BONUS</span>
                                    </a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <span class="title" >REFERRALS</span>
                                    </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                    <span class="title" >PWG-STORE</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-right-section">
                            <li class="nav-item">
                                <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                    <img src="{{asset('user/images/Search.svg')}}" width="30px" height="30px" alt="PWG icon3">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                    <img src="{{asset('user/images/NotificationNo.svg')}}" width="30px" height="30px" alt="icon3">
                                    <span class="count bg-danger"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                    <img src="{{asset('user/images/Chat.svg')}}" width="30px" height="30px" alt="PWG icon3">
                                </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{route('login')}}">
                                <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                                    <img class="img-xs rounded-circle" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="PWG ">
                                </div>
                              </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    {{-- @endauth --}}
    {{-- @else
        <header>
        <nav class="navbar navbar-expand-lg navbar-light affiliateNav">
            <div class="container-fluid">
                <div class="logoImg">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <picture>
                            <img class="logos" src="{{asset('images/logo.png')}}" alt="PWG logo">
                        </picture>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"> --}}
                    {{-- <li class="nav-item">
                        <div class="d-flex align-items-center justify-content-center jobber">
                            <a class="nav-link btn create-new-button"  aria-expanded="false" href="{{route('login')}}">
                                <span><img src="{{asset('images/icon1.png')}}"></span><span style="padding-top:5px">Applicants </span>
                            </a>
                        </div> 
                    </li>
                    <li class="nav-item">
                        <div class="d-flex align-items-center justify-content-center jobbers">
                            <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                              <span style="display:inline-block"><img alt="PWG" src="{{asset('images/icon2.png')}}"></span><span class="title" style="padding-top:0px;padding-left:15px; display:inline-block">Affiliate Partner</span>
                            </a>
                        </div> 
                    </li> --}}
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> --}}
                    {{-- </ul>
                    <ul style="list-style-type:none;">
                        <li class="nav-item">
                        @if(Session::has('loginId'))
 
                          <a class="nav-link" href="{{route('affiliate.logout')}}">
                            <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                              <img class="img-xs rounded-circlex" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="PWG ">
                              &nbsp; Sign Out
                             </div>
                          </a>
                          @else
                          <a class="nav-link" href="{{route('affiliate.login')}}">
                            <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                              <img class="img-xs rounded-circlex" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="PWG ">
                              &nbsp; Affiliate Sign In
                             </div>
                          </a>
                          @endif

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @endif --}}
          <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      
    <script src="{{asset('user/extra/assets/js/jquery-min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       