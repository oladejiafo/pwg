<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
    <title>PWG Client Portal</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/pwglogo.svg')); ?>">
    <meta name="keywords" content="Immigration, visa, travel,,abroad work visa consultants, affordable immigration,work permit, 188 visa,canadian immigration, UAE, POLAND, Malta, Czech, Canada, Germany">
        <!-- Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('user/extra/assets/fonts/line-icons.css')); ?>">
    <!-- Main Style -->
    <link rel="stylesheet" href="<?php echo e(asset('user/extra/assets/css/main.css')); ?>">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="<?php echo e(asset('user/extra/assets/css/responsive.css')); ?>">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

 	  <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('user/css/style.css')); ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/login.css')); ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('fonts/stylesheet.css')); ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        html, body {
            padding: 0;
            margin: 0%;
        }
        .navbar-profile-name {
          text-decoration: none !important;
          color:black !important;
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
      /* width:75%; */
      text-align: left;
      float: right;
      margin-right: 7px;
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
            width:110px;
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
    </style>		
</head>

<header>
    <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbarx">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->

          <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <picture>
            <source media="(min-width:769px)" srcset="<?php echo e(asset('images/logo.png')); ?>">

              <source media="(min-width:375px)" srcset="<?php echo e(asset('images/logo2.png')); ?>">

             <img class="logos" src="<?php echo e(asset('images/logo.png')); ?>" alt="PWG logo">
             </picture>
            <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
          </a>

          <?php if(Route::has('login')): ?>

          <?php if(auth()->guard()->check()): ?>
            <div class="d-flex align-items-center justify-content-center jobbers">
              <a class="nav-link btn create-new-button"  aria-expanded="false" href="<?php echo e(url('myapplication')); ?>">
                <span style="display:inline-block"><img alt="PWG" src="<?php echo e(asset('images/icon1.png')); ?>"></span><span class="title" style="padding-top:0px; display:inline-block"><?php echo e(__('My Application')); ?> </span>
              </a>
            </div>
          <?php else: ?>
            <!-- <div class="d-flex align-items-center justify-content-center jobber">
              <a class="nav-link btn create-new-button"  aria-expanded="false" href="<?php echo e(route('login')); ?>">
              <span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span><span style="padding-top:5px">Applicants </span>
              </a>
            </div> -->
            <div class="d-flex align-items-center justify-content-center jobbers">
              <a class="nav-link btn create-new-button" aria-expanded="false" href="<?php echo e(route('affiliate.home')); ?>">
                <span style="display:inline-block"><img alt="PWG" src="<?php echo e(asset('images/icon2.png')); ?>"></span><span class="title" style="padding-top:0px;display:inline-block">Affiliate Partner</span>
              </a>
            </div> 
          <?php endif; ?>
          <?php endif; ?>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="lni-menu"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">

            <?php if(Route::has('login')): ?>
            <?php if(auth()->guard()->check()): ?>
              <li class="nav-item d-lg-block">
                <a class="nav-link" href="#">
                  <img src="<?php echo e(asset('user/images/Search.svg')); ?>" width="30px" height="30px" alt="PWG icon3">
                </a>
              </li>
              <li class="nav-item">
                <a target="_blank" class="nav-link" href="https://wa.link/iz7ait" title="Click Here To Chat on WhatsAPP">
                  <!-- <i class="mdi mdi-email" style="width: 30px; height: 30px;"></i> -->
                  <img src="<?php echo e(asset('user/images/Chat.svg')); ?>" width="30px" height="30px" alt="PWG icon3">
                  <span class="count bg-success"></span>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link"  id="notificationDropdown" href="#" data-toggle="dropdown">
                  <!-- <i class="mdi mdi-bell" style="width: 30px; height: 30px;"></i> -->
                  <img src="<?php echo e(asset('user/images/NotificationNo.svg')); ?>" width="30px" height="30px" alt="icon3">
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" >
                  
                   <?php echo $__env->make('user.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="PWG ">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo e(Auth::user()->name); ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" style="left:-10px;  min-width: 150px;" aria-labelledby="profileDropdown">
                  
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-item-content">
                    <form method="GET" action="<?php echo e(route('profile.show')); ?>" x-data>
                           
                      <button style="border-color: #fff; padding:3px; margin:0; width:100px; background-color:#fff; shadow:none;font-weight: normal !important; font-size: inherit !important">Profile</button>
                    </form>
                      <!-- <p class="preview-subject mb-1"><a href="<?php echo e(route('profile.show')); ?>">Profile</a></p> -->
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                  
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">
                      <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                            <?php echo csrf_field(); ?>  
                      <button style="border-color: #fff; padding:3px; margin:0; width:100px; background-color:#fff; shadow:none;font-weight: normal !important; font-size: inherit !important">Log out</button>
                      </form>
                    </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <!-- <p class="p-3 mb-0 text-center">Advanced settings</p> -->
                </div>
              </li> </ul>
             <?php else: ?>
              <ul>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('login')); ?>">
                      <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                        <img class="img-xs rounded-circlex" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="PWG ">&nbsp; Login
                      </div>
                    </a>
                  </li>
              </ul>
              <?php endif; ?>
            <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav><p style="margin-bottom:70px"></p>
      <!-- Navbar End -->
    </header>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
    <script src="<?php echo e(asset('user/extra/assets/js/jquery-min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('user/extra/assets/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/extra/assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/extra/assets/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/extra/assets/js/wow.js')); ?>"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
   <?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/header.blade.php ENDPATH**/ ?>