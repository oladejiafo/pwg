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


    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('user/css/style.css')); ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/dashboard.css')); ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('fonts/stylesheet.css')); ?>'>
</head>
<div class="login">
    <div class="header-sec">
        <div class="left-sec">

        <div class="logo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('images/logo.png')); ?>" alt="logoo"></a></div>

        <?php if(Route::has('login')): ?>

        <?php if(auth()->guard()->check()): ?>
            <div class="myapplicant"><a href="<?php echo e(url('myapplication')); ?>" style="width:260px; "><span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span><span style="padding-top:5px"> My Application</span></a></div>
        <?php else: ?>
            <div class="applicant"><a href="<?php echo e(route('login')); ?>" style="width:200px; text-align:center; display:block;"><span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span> Applicants</a></div>
            <div class="affiliate "><a href="#" style="width:250px; text-align:center; display:block;"><span><img src="<?php echo e(asset('images/icon2.png')); ?>"></span> Affiliate Partner</a></div>
        <?php endif; ?>
        <?php endif; ?>

        </div>
        <div class="signin-right ">

            <?php if(Route::has('login')): ?>

            <?php if(auth()->guard()->check()): ?> 
            <div id="activity">
                <div class="divs"><a href="#"><img src="<?php echo e(asset('user/images/Search.svg')); ?>" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="<?php echo e(asset('user/images/Notification.svg')); ?>" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="<?php echo e(asset('user/images/Chat.svg')); ?>" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs dropdown">
                    <img src="../user/images/signin.svg" style="width: 80px; height: 40px;" alt="icon3"><i class="fa fa-arrow-circle-down"></i>
                    <div class="dropdown-content">
                        <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>" style="width: 105px">Profile</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                            <?php echo csrf_field(); ?>
    
                            <button type="submit" href="<?php echo e(route('logout')); ?>"
                                     @click.prevent="$root.submit();">
                                <?php echo e(__('Log Out')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php else: ?>
            
            <a href="<?php echo e(route('login')); ?>"><img src="../user/images/signin.svg" style="width: 80px; height: 40px;" alt="icon3">Sign In</a>
            <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\header-dashboard.blade.php ENDPATH**/ ?>