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
</head>

<header>
    <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbarx">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
              <picture>
                <source media="(min-width:769px)" srcset="<?php echo e(asset('images/logo.png')); ?>">

                  <source media="(min-width:260px)" srcset="<?php echo e(asset('images/logo2.png')); ?>">

                <img class="logos" src="<?php echo e(asset('images/logo.png')); ?>" alt="PWG logo">
              </picture>
              <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
            </a>

          <?php if(Route::has('login')): ?>

            <?php if(auth()->guard()->check()): ?>
              <div class="d-flex align-items-center justify-content-center jobbers">
                <a class="nav-link btn create-new-button"  aria-expanded="false" href="<?php echo e(url('myapplication')); ?>">
                  <span style="display:inline-block"><img alt="PWG" src="<?php echo e(asset('images/icon1.png')); ?>"></span><span class="title"><?php echo e(__('My Application')); ?> </span>
                </a>
              </div>
            <?php else: ?>
              <!-- <div class="d-flex align-items-center justify-content-center jobber">
                <a class="nav-link btn create-new-button"  aria-expanded="false" href="<?php echo e(route('login')); ?>">
                <span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span><span style="padding-top:5px">Applicants </span>
                </a>
              </div> -->
              <!-- <div class="d-flex align-items-center justify-content-center jobbers">
                <a class="nav-link btn create-new-button" aria-expanded="false" href="<?php echo e(route('affiliate.home')); ?>">
                  <span style="display:inline-block"><img alt="PWG" src="<?php echo e(asset('images/icon2.png')); ?>"></span><span class="title" style="padding-top:0px;display:inline-block">Affiliate Partner</span>
                </a>
              </div>  -->
            <?php endif; ?>
          <?php endif; ?>

          <?php if(Route::has('login')): ?>
            <?php if(auth()->guard()->check()): ?>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni-menu"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <?php else: ?>
                  <div class="collapsexx navbar-collapsexx" id="navbarCollapse">
            <?php endif; ?> 
          <?php endif; ?>
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
                    <img class="img-xs rounded-circle" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 30px; height: 30px;" alt="PWG ">
                    
                    
                    <i class="fa-solid fa-caret-down"></i>
                  </div>
                </a>
                
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" style="left:-10px;  min-width: 150px;" aria-labelledby="profileDropdown">
                  
                  
                  <div class="userName">
                    <a class="dropdown-item preview-item">
                      <div class="preview-item-content">
                        <p style="font-size:16px;"><b><?php echo e(Auth::user()->name); ?></b></p>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-item-content">
                      <form method="GET" action="<?php echo e(route('profile.show')); ?>" x-data>     
                        <button>Profile</button>
                      </form>
                      <!-- <p class="preview-subject mb-1"><a href="<?php echo e(route('profile.show')); ?>">Profile</a></p> -->
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-item-content">
                      <px class="preview-subject mb-1">
                      <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                        <?php echo csrf_field(); ?>  
                        <button>Logout</button>
                      </form>
                    </px>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <!-- <p class="p-3 mb-0 text-center">Advanced settings</p> -->
                </div>
              </li> 
             <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('login')); ?>">
                  <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                    <img class="img-xs rounded-circlex" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="PWG ">&nbsp; Login
                  </div>
                </a>
              </li>
             <?php endif; ?>
            <?php endif; ?>
          </ul>
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
   <?php /**PATH C:\Users\shakun\Desktop\myGit\PWG\resources\views/user/header.blade.php ENDPATH**/ ?>