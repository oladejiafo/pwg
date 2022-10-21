{{-- <!DOCTYPE html>
<html lang="en"> --}}

    <head>
        <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
        <title>PWG Group - Affiliate Portal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/affiliate.css')}}'>
	
    </head>
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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    </ul>
                    <ul style="list-style-type:none;">
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('login')}}">
                            <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                              <img class="img-xs rounded-circlex" src="{{asset('user/images/signin.svg')}}" style="width: 40px; height: 40px;" alt="PWG ">&nbsp;Affiliate Sign In
                            </div>
                          </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
          <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      
    <script src="{{asset('user/extra/assets/js/jquery-min.js')}}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
       