

<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self'"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="This is PWG Group client portal. PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.">
    <title>PWG Group - Affiliate Portal</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/affiliate/affiliatelogin.svg')); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/affiliate.css')); ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light affiliateNavLogin">
            <div class="container-fluid">
                <div class="logoImgAffiliate">
                <?php if(Session::has('loginId')): ?>
                <a class="navbar-brand" href="<?php echo e(url('/affiliate')); ?>">
                    <picture>                        
                        <img class="logos" src="<?php echo e(asset('/images/affiliate/affiliatelogin.svg')); ?>" alt="PWG logo">
                    </picture>
                </a>
                <?php else: ?>
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <picture>
                    <source media="(min-width:769px)" srcset="<?php echo e(asset('images/logo.png')); ?>">
                    <source media="(min-width:375px)" srcset="<?php echo e(asset('images/logoo.png')); ?>">
                    <source media="(min-width:320px)" srcset="<?php echo e(asset('images/logoo.png')); ?>">

                    <img class="logos" src="<?php echo e(asset('images/logo.png')); ?>" alt="PWG logo">
                    </picture>
                    <!-- <img class="logos" src="../images/logo.png" data-device-pixel-ratio-1="../images/logo2.png" alt="logo"> -->
                </a>
                <?php endif; ?>    
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php if(Session::has('loginId')): ?>
                <div class="collapse navbar-collapse navItems" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link btn create-new-button"  aria-expanded="false" href="<?php echo e(route('affiliate.news')); ?>">
                                <span style="padding-top:5px">NEWS </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1" role="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false">
                                INFO
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="<?php echo e(route('affiliate.about')); ?>">About Us</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('affiliate.toolbox')); ?>">ToolBox</a></li>
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
                    <ul class="navbar-nav me-autox mb-2 mb-lg-0 navbar-right-section">
                        <li class="nav-item">
                            <a class="nav-link btn create-new-button" aria-expanded="false" href="#">
                                <img src="<?php echo e(asset('user/images/Search.svg')); ?>" width="30px" height="30px" alt="PWG icon3">
                            </a>
                        </li>


                        <li class="nav-item">

                        <div class="d-flex align-items-center justify-content-center">
                                <a class="nav-link btn create-new-button" aria-expanded="false" href="https://wa.link/iz7ait">
                                    <img src="<?php echo e(asset('user/images/Chat.svg')); ?>" width="30px" height="30px" alt="PWG icon3">
                                </a>
                        </div> 
                        </li>

                        <li class="nav-item dropdown border-left">
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="nav-link"  id="notificationDropdown" href="#" data-toggle="dropdown">
                                <!-- <i class="mdi mdi-bell" style="width: 30px; height: 30px;"></i> -->
                                <img src="<?php echo e(asset('user/images/NotificationNo.svg')); ?>" width="30px" height="30px" alt="icon3">
                                <span class="count bg-danger"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" >
                                    <?php echo $__env->make('affiliate.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('affiliate.logout')); ?>">
                                <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                                    <img class="img-xs rounded-circlex" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="PWG ">
                                    &nbsp; Sign Out
                                </div>
                            </a>
                            <?php else: ?>
                            <a class="nav-link" href="<?php echo e(route('affiliate.login')); ?>">
                                <div class="navbar-profile" style="font-family:'TT Norms Pro'; font-size: 18px; font-weight:500">
                                    <img class="img-xs rounded-circlex" src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="PWG ">
                                    &nbsp; Affiliate Sign In
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</head>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/layout/header.blade.php ENDPATH**/ ?>