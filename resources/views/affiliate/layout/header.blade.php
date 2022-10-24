

    <head>
        <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
        <title>PWG Group - Affiliate Portal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/affiliate.css')}}'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


        <header>
            <nav class="navbar navbar-expand-lg navbar-light affiliateNavLogin">
                <div class="container-fluid">
                    <div class="logoImgAffiliate">
                    @if(Session::has('loginId'))
                    <a class="navbar-brand" href="{{url('/')}}">
                        <picture>                        
                            <img class="logos" src="{{asset('images/logoo.png')}}" alt="PWG logo">
                        </picture>
                    </a>
                    @else
                    <a class="navbar-brand" href="{{url('/')}}">
                        <picture>
                        <source media="(min-width:769px)" srcset="{{asset('images/logo.png')}}">
                        <source media="(min-width:375px)" srcset="{{asset('images/logoo.png')}}">

                        <img class="logos" src="{{asset('images/logo.png')}}" alt="PWG logo">
                        </picture>
                        <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
                    </a>
                    @endif    
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    @if(Session::has('loginId'))
                    <div class="collapse navbar-collapse navItems" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button"  aria-expanded="false" href="#">
                                        <span style="padding-top:5px">NEWS </span>
                                    </a>
                                </div> 
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    INFO
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">About Us</a></li>
                                    <li><a class="dropdown-item" href="#">ToolBox</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <span class="title" style="padding-top:0px;padding-left:15px; display:inline-block">BONUS</span>
                                    </a>
                                </div> 
                            </li>
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <span class="title" style="padding-top:0px;padding-left:15px; display:inline-block">REFERRALS</span>
                                    </a>
                                </div> 
                            </li>
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <span class="title" style="padding-top:0px;padding-left:15px; display:inline-block">PWG-STORE</span>
                                    </a>
                                </div> 
                            </li>
                        </ul>
                        <ul class="navbar-nav me-autox mb-2 mb-lg-0 navbar-right-section">
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <img src="{{asset('user/images/Search.svg')}}" width="30px" height="30px" alt="PWG icon3">
                                    </a>
                                </div> 
                            </li>


                            <li class="nav-item">
                            <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="https://wa.link/iz7ait">
                                        <img src="{{asset('user/images/Chat.svg')}}" width="30px" height="30px" alt="PWG icon3">
                                    </a>
                            </div> 
                            </li>

                            <li class="nav-item dropdown border-left">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link"  id="notificationDropdown" href="#" data-toggle="dropdown">
                                    <!-- <i class="mdi mdi-bell" style="width: 30px; height: 30px;"></i> -->
                                    <img src="{{asset('user/images/NotificationNo.svg')}}" width="30px" height="30px" alt="icon3">
                                    <span class="count bg-danger"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" >
                                       @include('affiliate.notifications')
                                    </div>
                                </div>
                            </li>


                            <!-- <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <img src="{{asset('user/images/NotificationNo.svg')}}" width="30px" height="30px" alt="icon3">
                                        <span class="count bg-danger"></span>
                                    </a>
                                </div> 
                            </li>
                            <li class="nav-item">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                        <img src="{{asset('user/images/Chat.svg')}}" width="30px" height="30px" alt="PWG icon3">
                                    </a>
                                </div> 
                            </li> -->
                            <li class="nav-item">

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
                           
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </nav>
        </header>

          <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      
    <script src="{{asset('user/extra/assets/js/jquery-min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
       