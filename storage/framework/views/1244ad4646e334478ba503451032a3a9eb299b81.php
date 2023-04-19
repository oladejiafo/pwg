
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">

<style>
    .package-type ul {
      list-style: none;
    }
    
    .package-type ul li {
       font-size: 14px;
       /* align-items: left; */
       position: relative;

    }
   
    .package-type ul li::marker {
      content: "";
      display: inline-block; 
    }

    ul li::before {
        position: absolute;
        content: "✓";
        display: block;
        width: 25px;
        height: 25px;
        top: 5px;
        left: 5px;
        margin-bottom: 0 !important;
        font-weight: bold;
    }

    .package-type .indpackage ul li::before {
        background: #006ACE;
        color: #fff;
    }

    .package-type .fampackage ul li::before {
        background: #E10930;
        color: #fff;
    }

    .package-type .czechIndpackage ul li::before {
        background: #84BD00;
        color: #fff;
    }

    .package-type .maltaIndpackage ul li::before {
        background: #736359;
        color: #fff;
    }

    .package-type .canadaPackage ul li::before {
        background: #820202;
        color: #fff;
    }

    .package-type .germanyIndpackage ul li::before {
        background: #000000;
        color: #fff;
    }
    
    .selected path {
        fill: #000;
    }

    .package-type .price
    {
        padding:0 5%;
    }
    .package-type .saved {
        padding:0 5%; 
        margin:3px 0 10px 0;
    }

    .polandDiv, .polandFamilyDiv, .germanyDiv, .maltaDiv{
        height:270px;
    }

    .canadaDiv {
        height: 280px;
    }

    .czechDiv {
        height: 267px;
    }

    .saved .save {
        font-size:10px;
    }

    @media (max-width: 1100px)
    {
        .package-type .price
        {
            padding:0;
        }   
        .package-type .promo {
            padding: 0px
        }
        .package-type .line {
            padding: 0px
        }
        .package-type .regular {
            padding: 0px
        }
        .package-type .saved {
            padding:0; 
            margin:3px 0 10px 0;
        }
    }


    @media (max-width:800px)
    {
        .package {
            padding: 20px 5% !important;
        }
        h3 {
            font-size: 25px !important;
            text-align: center !important;
        }
        p {
            text-align: center;
            font-size: 20px;
        }
        .package-type{
            margin: 0px 0px 50px 0px;
            /* width: 100%; */
            padding: 0px !important;
            /* height: 350px; */
        }
        .package-type img {
        width:100px; 
        /* height:120px; */
        }
    }
    @media (max-width: 600px)
    {
        .package-type .line {
            width: 2%;
        }
        .package-type .promo {
            width: 47%;
        }
        .package-type .regular {
            width: 47%;
        }                            
    }

    @media (max-width:360px) {
        .fampackage ul,
        .indpackage ul {
            padding: 0px;
        }
        .fampackage .bonus,
        .indpackage .bonus {
            padding: 0px;
            margin-left: 0px !important;
        }

        .package-type .saved .col-5,
        .package-type .saved .col-7 {
            font-size: 10px !important;            
        }
        .package {
            padding: 20px 0% !important;
            width: 100% !important;
        }

        .package .switch {
            width: 60px !important;
        }
        .children label {
            width: 40px !important;
        }

        #familymodal .price {
            padding: 10px 0px !important
        }

        #familymodal .separator {
            width: 1%;
        }
        #familymodal .promos {
            width: 47%;
        }
        #familymodal .actual {
            width: 47%;
            padding-right: 0px !important;
        }    
    }

    @media (max-width:280px) {
        .fampackage ul,
        .indpackage ul {
            padding: 0px;
        }
        .fampackage .bonus,
        .indpackage .bonus {
            padding: 0px;
            margin-left: 0px !important;
        }

        .package-type .saved .col-5,
        .package-type .saved .col-7 {
            font-size: 12px !important;            
        }
        .package {
            padding: 20px 0% !important;
            width: 100% !important;
        }
        .package-type .price {
            font-size: 12px !important;
        }
        .package .header h2 {
            font-size: 35px;
        }
        .package .header p{
            font-size: 15px !important;
        }
        .package-type {
            height: 800px !important;
            max-height: 800px !important;
            margin-bottom: 50px !important;
        }
        .btn.btn-secondary {
            width: 90% !important;
            font-size: 10px !important;
        }
        .familymodal .saved {
            padding: 0px !important; 
        }
    }

    @media (min-width: 1024px) {
        .saved .save {
            font-size:8px;
        }

        .packageHead b {
            font-size: 13px;
        }
    }

    .indpackage li {
        margin-bottom: 8.5px !important;
    }

</style>


<?php $__env->startSection('content'); ?>

    <div class="container" style="margin-top: 100px; margin-bottom: 85px;">
        <div class="col-12">
            <div align="center" class="package">
                <div class="header">
                    <h2>CHOOSE YOUR PACKAGE</h2>
                    <div class="bottoom-title">
                        <p>To start your journey, please select the package that best suits you</p>
                    </div>
                </div>
                <br>
                <div class="row" style="margin-left:auto; margin-right:auto; text-align:center;justify-content: center; display: flex;">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="polandDiv">
                            <img src="<?php echo e(asset('user/images/polandIndividual.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['poland_indi']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['poland_indi']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['poland_indi']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7 days" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="indpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free accomodation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Passport after 5 years</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['poland_indi']->destination_id )); ?>" method="GET">
                                        <?php else: ?>
                                            <form action="<?php echo e(url('apply/now/poland/'.$pricingPlan['poland_indi']->destination_id.'/individual')); ?>">
                                                <?php Session::put('prod_id', $pricingPlan['poland_indi']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['poland_indi']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['poland_indi']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['poland_indi']->destination_id); ?>">
                                        
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                            <?php if(isset($started) && $pricingPlan['poland_indi']->destination_id == $started->destination_id && $pricingPlan['poland_indi']->id == $started->pricing_plan_id): ?>
                                                <a class="btn btn-primary" style="width: 100%;font-size: 14px;" href="<?php echo e(route('myapplication')); ?>"><span class="done">Already Applied</span><i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #006ACE; border-color:#006ACE; color:#fff;" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="maltaDiv">
                            <img src="<?php echo e(asset('user/images/maltapackage.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['malta_indi']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['malta_indi']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['malta_indi']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff;font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="maltaIndpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive rental market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Ease of transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Possibility of getting passport by investment</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['malta_indi']->destination_id )); ?>" method="GET">
                                        <?php else: ?>
                                            <form action="<?php echo e(url('apply/now/malta/'.$pricingPlan['malta_indi']->destination_id.'/individual')); ?>">
                                            <?php Session::put('prod_id', $pricingPlan['malta_indi']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['malta_indi']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['malta_indi']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['malta_indi']->destination_id); ?>">
                                        
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                            <?php if(isset($started) && $pricingPlan['malta_indi']->destination_id == $started->destination_id): ?>
                                                <a class="btn btn-secondary" href="<?php echo e(route('myapplication')); ?>" style="width: 100%;font-size: 14px;"><span class="done">Already Applied</span> <i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #736359;color:#fff" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="czechDiv">
                            <img src="<?php echo e(asset('user/images/czechpackage.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['czech_indi']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['czech_indi']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['czech_indi']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff;font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="czechIndpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Ease of transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive rental market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Excellent medicine and health care system.</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['czech_indi']->destination_id )); ?>" method="GET">
                                        <?php else: ?>
                                            <form action="<?php echo e(url('apply/now/czech/'.$pricingPlan['czech_indi']->destination_id.'/individual')); ?>">
                                                <?php Session::put('prod_id', $pricingPlan['czech_indi']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['czech_indi']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['czech_indi']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['czech_indi']->destination_id); ?>">
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">

                                            <?php if(isset($started) && $pricingPlan['czech_indi']->destination_id == $started->destination_id): ?>
                                                <a class="btn btn-primary" style="width: 100%;font-size: 14px;" href="<?php echo e(route('myapplication')); ?>" style="font-size:14px;" ><span class="done">Already Applied</span><i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #84BD00; color:#fff" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="polandFamilyDiv">
                            <img src="<?php echo e(asset('user/images/polandFamily.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['poland_family']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['poland_family']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['poland_family']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff;font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>FAMILY PACKAGE</b></div>
                                    </div>
                                    <div class="fampackage ">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free accomodation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Passport after 5 years</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['poland_family']->destination_id )); ?>" method="GET">
                                            <?php else: ?>
                                                <form action="<?php echo e(url('apply/now/poland/'.$pricingPlan['poland_family']->destination_id.'/family')); ?>">
                                                <?php Session::put('prod_id', $pricingPlan['poland_family']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['poland_family']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['poland_family']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['poland_family']->destination_id); ?>">
                                        
                                            <input type="hidden" value="FAMILY_PACKAGE" name="myPack">
                                            <input type="hidden" value="<?php echo e($pricingPlan['poland_family']->id); ?>" name="fam_id" class="fam_id">

                                            <?php if(isset($started) && $pricingPlan['poland_family']->destination_id == $started->destination_id && $pricingPlan['poland_family']->id == $started->pricing_plan_id): ?>
                                                <a class="btn btn-primary" style="width: 100%;font-size: 14px;" href="<?php echo e(route('myapplication')); ?>"><span class="done">Already Applied</span><i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #E10930; color:#fff" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="canadaDiv">
                            <img src="<?php echo e(asset('user/images/canadaPackage.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content" style="margin-top: -10px;">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['canada_indi']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['canada_indi']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['canada_indi']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff;font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="canadaPackage ">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Ease of transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive rental market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Family friendly</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Freedom to move residence</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['canada_indi']->destination_id )); ?>" method="GET">
                                        <?php else: ?>
                                        <form action="<?php echo e(url('apply/now/canada/'.$pricingPlan['canada_indi']->destination_id.'/individual')); ?>">
                                            <?php Session::put('prod_id', $pricingPlan['canada_indi']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['canada_indi']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['canada_indi']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['canada_indi']->destination_id); ?>">
                                        
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                            <?php if(isset($started) && $pricingPlan['canada_indi']->destination_id == $started->destination_id): ?>
                                                <a class="btn btn-secondary" href="<?php echo e(route('myapplication')); ?>" style="width: 100%;font-size: 14px;"><span class="done">Already Applied</span> <i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #820202; color:#fff" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="display:inline-block;padding-bottom:25px;">
                        <div class="germanyDiv">
                            <img src="<?php echo e(asset('user/images/germanypackage.png')); ?>" width="100%" alt="PWG Group" height="100%">
                        </div>
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        <?php $blue_cost_old = $pricingPlan['germany_indi']->first_payment_sub_total*1.2995; $blue_save= $blue_cost_old - $pricingPlan['germany_indi']->first_payment_sub_total;?>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right">
                                            <b>PROMO PRICE</b> <br> 
                                            <b>
                                                <span style="font-size:12px">AED</span>
                                                <span style="font-size:18px"><?php echo e(number_format($pricingPlan['germany_indi']->first_payment_sub_total,0)); ?></span>
                                            </b>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5 save" style="background: #000; border-radius:30px 0 0 30px;color:#fff;font-weight:600; padding-block: 5px">SAVE AED <?php echo e(number_format($blue_save,0)); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row packageHead" style="border-block: 1px solid #000;padding:10px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="germanyIndpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Ease of accomodation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive rental market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Job Security</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Comprehensive Welfare System</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        
                                    </div>
                                    <div>
                                        <?php if(Route::has('login')): ?>
                                            <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(url('/payment_form/'. $pricingPlan['germany_indi']->destination_id )); ?>" method="GET">
                                        <?php else: ?>
                                            <form action="<?php echo e(url('apply/now/germany/'.$pricingPlan['germany_indi']->destination_id.'/individual')); ?>">
                                                <?php Session::put('prod_id', $pricingPlan['germany_indi']->destination_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo csrf_field(); ?>
                                            <input type="hidden" name="cost" value="<?php echo e($pricingPlan['germany_indi']->first_payment_sub_total); ?>">
                                            <input type="hidden" name="blue_id" value="<?php echo e($pricingPlan['germany_indi']->id); ?>">
                                            <input type="hidden" name="pr_id" value="<?php echo e($pricingPlan['germany_indi']->destination_id); ?>">
                                        
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                            <?php if(isset($started) && $pricingPlan['germany_indi']->destination_id == $started->destination_id): ?>
                                                <a class="btn btn-secondary" href="<?php echo e(route('myapplication')); ?>" style="width: 100%;font-size: 14px;"><span class="done">Already Applied</span><i class="fa fa-check-circle" style="font-size:14px; color:green"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-primary" style="width: 100%;font-size: 24px;background: #000; color:#fff" <?php if(isset($started->destination_id)): ?> onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" type="button" <?php else: ?> type="submit" <?php endif; ?>>APPLY NOW</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<script>
<script>
<?php $__env->stopPush(); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/user/home.blade.php ENDPATH**/ ?>