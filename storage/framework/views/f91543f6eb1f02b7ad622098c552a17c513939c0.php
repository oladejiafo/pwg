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
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/login.css')); ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('fonts/stylesheet.css')); ?>'>

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

        <div class="logo"><a href="<?php echo e(url('/')); ?>"><img class="logo" alt="logoo"></a></div>

        <?php if(Route::has('login')): ?>

        <?php if(auth()->guard()->check()): ?>
            <div class="myapplicant"><a href="<?php echo e(url('myapplication')); ?>" style=" "><span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span><span style="padding-top:5px"> My Application</span></a></div>
        <?php else: ?>
            <div class="applicant"><a href="<?php echo e(route('login')); ?>"><span><img src="<?php echo e(asset('images/icon1.png')); ?>"></span> Applicants</a></div>
            <div class="affiliate "><a href="#"><span><img src="<?php echo e(asset('images/icon2.png')); ?>"></span> Affiliate</a></div>
        <?php endif; ?>
        <?php endif; ?>

        </div>
        <div class="signin-right ">

            <?php if(Route::has('login')): ?>

            <?php if(auth()->guard()->check()): ?> 
            <div id="activity">
                <div class="divs"><a href="#"><img src="../user/images/Search.svg" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="../user/images/Notification.svg" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divs"><a href="#"><img src="../user/images/Chat.svg" width="30px" height="30px" alt="icon3"></a></div>
                <div class="divsx dropdown">
                    <img src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 40px; height: 40px;" alt="icon3">
                    <div class="dropdown-content">
                        <a class="dropdown-item" style="margin-left:0px" href="<?php echo e(route('profile.show')); ?>">Profile</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                            <?php echo csrf_field(); ?>
    
                            <button type="submit" style="min-width:120px" href="<?php echo e(route('logout')); ?>"
                                     @click.prevent="$root.submit();">
                                <?php echo e(__('Log Out')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php else: ?>
            
            <a class="logg" href="#"><a href="<?php echo e(route('login')); ?>"><img src="<?php echo e(asset('user/images/signin.svg')); ?>" style="width: 80px; height: 40px;" alt="icon3">Sign In</a>
            <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\header_old.blade.php ENDPATH**/ ?>