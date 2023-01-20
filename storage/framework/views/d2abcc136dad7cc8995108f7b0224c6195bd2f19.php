<!DOCTYPE html>
<html>

<?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- bootstrap core css -->
    <link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/LineIcons.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/style.css">
    <link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">
    <style>
        .banner_bg {
        width: 100%;
        float: left;
        background-image: url(../user/images/v1_17125.png) !important;
        background-color: rgba(6, 45, 83, 0.7);
        /* height: 480px;    */
        padding-top: 30px;
        background-size: 100%;
        background-repeat: no-repeat;
        }
        .col-4 {
            width: 100% !important;
        }

        @media (min-width:601px) and (max-width:768px) {
            .banner_bg {
                width: 100%;
                float: left;
                background-size: 100%;
                background-repeat: no-repeat !important;
                background-position: center left !important;
                object-fit: contain;
            }
        }
        @media (min-width:280px) and (max-width:600px) {
            .banner_bg {
                width: 100%;
                float: left;
                background-size: 100%;
                background-repeat: no-repeat !important;
                background-position: center top !important;
                object-fit: contain;
            }
        }
    </style>

<body>

<?php if(Route::has('login')): ?>


        <?php if(auth()->guard()->check()): ?>
        <?php else: ?>
    <!-- Start Hero Section -->
    <div class="hero banner_bg layerd" style="padding-top: 80px; ">

        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-md-12">
                    <div class="intro-excerpt">
                        <h1 id="headerTitle">Your Migration Journey Starts Here</h1>
                        <p id="headerText" class="mb-4">Get your Europe & Canada Visa from any part of the world.</p>
                        <p><a href="<?php echo e(route('login')); ?>" id="headerBtn" class="btn btn-hero">START NOW</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Hero Section -->
<?php endif; ?> 
<?php endif; ?>

    <!-- Start Product Section -->
    <div class="product-section">

        <?php if(Route::has('login')): ?>
        <?php if(auth()->guard()->check()): ?>
       <div class="carousel" id="carouselThree"  data-ride="carousel" style="margin-block:20px ;">

          <div class="outer  scroll-pane" id="container">
            <div class="container-fluid text-center">
                <div class="row" >

                    <ul>
                        <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($promo->first()): ?>
                                <?php $__currentLoopData = $promo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if($prom->discount_percent >0 && $prom->product_id == $offer->id)
                                        { 
                                            $icon = 'fa fa-minus-circle';
                                            $offer_discount_msg = 'Promo Offer: ' .$prom->discount_percent .'% off !';
                                        } else {
                                            $icon = '';
                                            $offer_discount_msg = '-';
                                        }
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?> 
                                <?php
                                    $icon = '';
                                    $offer_discount_msg = '-'; 
                                ?>
                            <?php endif; ?>

                        <!-- Start Column  -->
                        <li>
                            <div class="col-4 cellContainer" style="margin-top:10%">
                                <span class="product-item item-hints" href="#">
                                    <span class="positionAnchor hint"  data-position="1">

                                        <!-- <img src="../user/images/<?php echo e($offer->image); ?>" style="height:458px" class="img-fluid product-thumbnail home_img" alt="PWG Group"> -->

                                        
                                            <img src="../user/images/<?php echo e($offer->image); ?>" width="100%" class="img-fluid product-thumbnail home_img" alt="PWG Group">
                                        

                                        <div class="hint-content do--split-children">
                                            <p><?php echo e($offer->description); ?></p>
                                        </div>
                                        <span class="bottom">
                                            <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue"><?php echo e(ucfirst($offer->name)); ?></h3>
                                            <p style="font-size:20px"><?php echo e($offer->slogan); ?></p>
                                        </span>
                                        <p style="font-size:12px">Starting from </p>

                                        <strong class="product-price">  <?php echo e(number_format($offer->unit_price,2)); ?> <?php echo e($offer->currency); ?></strong>
                                        <p> 
                                            <i class="<?php echo e($icon); ?>"></i> <?php echo e($offer_discount_msg); ?>

                                        </p>
                                        <p>
                                            
                                            <?php if(isset($started) && $offer->id == $started->destination_id): ?>
                                            <a class="btn btn-secondary" href="#"><span class="done">Already Applied</span><span class="doned">Applied</span> <i class="fa fa-check-circle" style="font-size:18px; color:green"></i></a>
                                            
                                            <?php else: ?>
                                            
                                            <a class="btn btn-secondary" <?php if(isset($started->destination_id)): ?> onclick="return confirm('You have an active application already. Still want to proceed?');" <?php endif; ?> href="<?php echo e(url('package/type', $offer->id)); ?>">Apply Now</a>
                                            <?php endif; ?>
                                        </p>
                                    </span>
                                </span>
                            </div>
                        </li>
                        <!-- End Column  -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                </div>
            </div>
            <div class="nextprev">
                <a class="carousel-control-prev" alt="PWG" id="slideBack" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="prev" aria-label="Navigate Back">
                    <i class="lni lni-arrow-left"></i>
                </a>
                <a class="carousel-control-next" alt="PWG" id="slide" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="next" aria-label="Navigate forward">
                    <i class="lni lni-arrow-right"></i>
                </a>
            </div>
 
        </div>

       </div>
        <!-- <?php echo $__env->make('user.earning', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->

        <?php else: ?>

        <div class="container-fluid text-center">

            <div class="row">
              <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($promo->first()): ?>
                    <?php $__currentLoopData = $promo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php

                            if($prom->discount_percent >0 && $prom->product_id == $offer->id)
                            { 
                            $icon = 'fa fa-minus-circle';
                            $offer_discount_msg = 'Promo Offer: ' .$prom->discount_percent .'% off !';
        
                            } else {
                            $icon = '';
                            $offer_discount_msg = '-';
                            }
                                                
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php else: ?> 
                    <?php
                        $icon = '';
                        $offer_discount_msg = '-'; 
                    ?>
                <?php endif; ?>
                <!-- Start Column  -->
                <div class="col-sm-12 col-xs-12 col-lg-4 cellContainer destinationView">
                    <span class="product-item item-hints" href="#">
                        <span class="positionAnchor hint"  data-position="1">

                            <!-- <img src="../user/images/<?php echo e($offer->image); ?>" style="height:458px" class="img-fluid product-thumbnail home_img" alt="PWG Group"> -->

                            
                                <img src="../user/images/<?php echo e($offer->image); ?>" width="100%"  class="img-fluid product-thumbnail home_img" alt="PWG Group">
                            

                            <div class="hint-content do--split-children">
                              <p><?php echo e($offer->description); ?></p>
                            </div>
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue"><?php echo e(ucfirst($offer->name)); ?></h3>
                                <p style="font-size:20px"><?php echo e($offer->slogan); ?></p>
                            </span>
                            <p style="font-size:12px">Starting from </p>
                            <strong class="product-price"><?php echo e(number_format($offer->unit_price,2)); ?> <?php echo e($offer->currency); ?></strong>

                            <p>
                                <i class="<?php echo e($icon); ?>"></i> <?php echo e($offer_discount_msg); ?> 
                            </p>
                            <p>
                                <a class="btn btn-secondary" href="<?php echo e(url('package/type', $offer->id)); ?>">Apply Now</a>
                            </p>
                        </span>
                    </span>
                </div>
                <!-- End Column  -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 cellContainer">
                    <span class="product-itemx" href="#">
                        <span class="positionAnchorx" data-position="1">
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue"></h3>
                                <p style="font-size:20px"></p>
                            </span>
                            <strong class="product-price"></strong>
                            <p></p>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

    </div>
    <!-- End Product Section -->


    <!--====== Jquery js ======-->
    <script src="../user/assets/js/vendor/jquery-1.12.4.min.js"></script>

  </body>

</html>

<script>
var button = document.getElementById('slide');
button.onclick = function () {
    var container = document.getElementById('container');
    sideScroll(container,'right',25,100,10);
};

var back = document.getElementById('slideBack');
back.onclick = function () {
    var container = document.getElementById('container');
    sideScroll(container,'left',25,100,10);
};

function sideScroll(element,direction,speed,distance,step){
    scrollAmount = 0;
    var slideTimer = setInterval(function(){
        if(direction == 'left'){
            element.scrollLeft -= step;
        } else {
            element.scrollLeft += step;
        }
        scrollAmount += step;
        if(scrollAmount >= distance){
            window.clearInterval(slideTimer);
        }
    }, speed);
}
</script>
<script>
    $(document).ready(function() {
    <?php if(Session::has('message')): ?>
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.success("<?php echo e(session('message')); ?>");
    <?php endif; ?>
    
    <?php if(Session::has('error')): ?>
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.error("<?php echo e(session('error')); ?>");
    <?php Session::forget('error'); ?>
    <?php endif; ?>
    
    <?php if(Session::has('info')): ?>
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.info("<?php echo e(session('info')); ?>");
    <?php endif; ?>
    
    <?php if(Session::has('warning')): ?>
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.warning("<?php echo e(session('warning')); ?>");
    <?php endif; ?>
    }); 
   </script><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/home.blade.php ENDPATH**/ ?>