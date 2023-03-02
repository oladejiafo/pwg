
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">

<style>
  .selected path {
    fill: #000;
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
        margin: 20px;
        /* width: 100%; */
        padding: 0px !important;
        /* height: 350px; */
    }
    .package-type img {
    width:100px; 
    /* height:120px; */
 }
}
</style>


<?php $__env->startSection('content'); ?>

<?php if($canadaOthers->first()): ?>

<?php 
$cSamount=0;
$cXamount=0;
?>
<?php $__currentLoopData = $canadaOthers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php if($canada->pricing_plan_type == "STUDY_PERMIT"): ?>
<?php  
  $cSname = $canada->pricing_plan_type;
  $cSamount =$cSamount + $canada->sub_total - $canada->third_payment_sub_total;
?>
<?php endif; ?>

<?php if($canada->pricing_plan_type == "EXPRESS_ENTRY"): ?>
<?php  
  $cXname = $canada->pricing_plan_type;
  $cXamount = $cXamount + $canada->sub_total - $canada->third_payment_sub_total;
?>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>

    <div class="container" style="margin-top: 120px;">
        <div class="col-12">
            <div align="center" class="package">
                <div class="header">
                    
                    <h2>CHOOSE YOUR PACKAGE</h2>
                    <div class="bottoom-title">
                        <p>To start your journey to Poland, please select the package that best suits you</p>
                    </div>
                </div>
                <br>
                <div class="row" style="margin-left:auto; margin-right:auto; text-align:center;justify-content: center; display: flex;">
                
                      <?php if($proddet->first()): ?>
                        <?php $__currentLoopData = $proddet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prdet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($loop->first): ?>
                    
                            <?php 
                            // $blue_cost = $prdet->total_price
                            // $blue_cost = $prdet->sub_total - $prdet->third_payment_sub_total
                            $blue_cost = $prdet->first_payment_sub_total
                            ?> 

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?> 
                        <?php                                   
                            $blue_cost = 0
                            ?>
                        <?php endif; ?>
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
                            .package-type .indpackage ul li::before {
                                position: absolute;
                                content: "✓";
                                display: block;
                                width: 25px;
                                height: 25px;
                                top: 5px;
                                left: 5px;
                                background: #FACB08;
                                margin-bottom: 0 !important;
                                font-weight: bold;
                                color: #000;
                            }

                            .package-type .fampackage ul li::before {
                                position: absolute;
                                content: "✓";
                                display: block;
                                width: 25px;
                                height: 25px;
                                top: 5px;
                                left: 5px;
                                background: #E10930;
                                margin-bottom: 0 !important;
                                font-weight: bold;
                                color: #000;
                            }
                            
                            </style>
                    <div class="col-sm-10 col-md-5 col-lg-5" style="display:inline-block;">
                        <img src="<?php echo e(asset('user/images/individual.png')); ?>" width="100%" alt="PWG Group">
                        <div class="package-type blue-collar" data-bs-toggle="modal" data-bs-target="#individualModal">
                            <div class="content">
                                <div>
                                    <div class="row" style="padding:0 5%">
                                        <?php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;?>
                                        <div class="col-5" align="right"><b>PROMO PRICE</b> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:18px"><?php echo e(number_format($blue_cost,0)); ?></span></b></div>
                                        <div class="col-2" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-5" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row" style="padding:0 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED <?php echo e($blue_save); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row" style="border-block: 1px solid #000;padding:5px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="indpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Respect of your rights</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free airport transfer</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                        </ul>
                                        <div style="text-align: left;margin-block:15px; margin-left: 35px"><i class="fa fa-star" style="color:#FACB08;font-size: 25px;"></i><b style="font-size: 18px;margin-left: 15px;">BONUS:</b> Salary deduction on the last payment of selected package.</div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;background: #FACB08">APPLY NOW</button>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    
                    <?php if($famdet): ?>

                    <div class="col-sm-10 col-md-5 col-lg-5" style="display:inline-block;">
                        <img src="<?php echo e(asset('user/images/family.png')); ?>" width="100%" alt="PWG Group">
                        <div class="package-type family-package" data-bs-toggle="modal" data-bs-target="#familyModal">

                            <div class="content">
                                <div>
                                    <div class="row" style="padding:0 5%">
                                        <?php if(isset($famdet)): ?> 
                                            <?php 
                                                $famdet_cost_old = $famdet['first_payment_sub_total']*1.2995; 
                                                $famdet_save= $famdet_cost_old - $famdet['first_payment_sub_total'];
                                            ?>
                                        <?php endif; ?>
                                        <div class="col-5" align="right"><b>PROMO PRICE</b> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:18px"><?php echo e(number_format($famdet['first_payment_sub_total'],0)); ?></span></b></div>
                                        <div class="col-2" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-5" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del><?php echo e(number_format($famdet_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <div class="row" style="padding:0 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED <?php echo e($famdet_save); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row" style="border-block: 1px solid #000;padding:5px; margin:15px">
                                        <div class="col"><b>FAMILY PACKAGE</b></div>
                                    </div>
                                    <div class="fampackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Access to Free Education</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Family benefits</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Respect of your rights</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free airport transfer</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Right to family reunification</div></li>
                                        </ul>
                                        <div style="text-align: left;margin-block:15px; margin-left: 35px"><i class="fa fa-star" style="color:#E10930;font-size: 25px;"></i><b style="font-size: 18px;margin-left: 15px;">BONUS:</b> Salary deduction on the last payment of selected package.</div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;background: #E10930">APPLY NOW</button>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
               
                    </div>
                                
                    <!-- Individual Modal -->
                    <div class="modal fade" id="individualModal" tabindex="-1" aria-labelledby="individualModalLabel" aria-hidden="true">
                        <div class="modal-dialog row">
                            <div class="modal-content col-4" style="border-radius: 15px">
                                <div class="modal-headerx" align="center">
                                    <div><img src="<?php echo e(asset('user/images/individual_icon.png')); ?>" width="30%" style="margin-top:25px;margin-bottom:5px" alt="PWG Group"></div>
                                    <h5 class="modal-title" id="individualModalLabel">INDIVIDUAL PACKAGE</h5>
                                    
                                </div>
                                <div class="modal-body" style="height:auto">
                                    
                                    <div class="row" style="padding:5px 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED <?php echo e($blue_save); ?></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">WHEN YOU PAY IN FULL</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="border-top:0px solid rgb(57, 127, 184)"></div>
                                    </div>
                                    <div class="row" style="padding:10px 5%">
                                        
                                        <?php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;?>
                                        <div class="col-5" align="right"><span style="font-size:10px;;color:#000"><b>PROMO PRICE</b></span> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:22px;color:#000"><?php echo e(number_format($blue_cost,0)); ?></span></b></div>
                                        <div class="col-1" align="center" style="padding:0 3px; border-left: 0px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-6" align="right" style="padding-right:15%"><span style="font-size:10px;color:#000"><b>REGULAR PRICE</b></span> <br> <span style="font-size:12px;color:#E10930">AED</span> <span style="font-size:22px;color:#E10930"><del><?php echo e(number_format($blue_cost_old,0)); ?></del></span></div>
                                    </div>
                                    <?php if(Route::has('login')): ?>
                                        <?php if(auth()->guard()->check()): ?>
                                        <form action="<?php echo e(url('contract', $data->id)); ?>" method="GET">
                                    <?php else: ?>
                                        <form action="<?php echo e(url('register')); ?>">
                                            <?php Session::put('prod_id', $data->id); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                            
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="cost" value="<?php echo e($blue_cost); ?>">
                                    <input type="hidden" name="blue_id" value="<?php echo e($prdet->id); ?>">
                                
                                    <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                    <div class="form-groupx row" style=" margin:0 auto;"> 
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary se2" id="buy" value="1" name="payall"  style="width:80%;border-radius:5px; margin-block:3px; border: 0px solid #fff; background:#FACB08">FULL PAYMENT</button>
                                            <?php
                                            if($data->full_payment_discount > 0) {
                                            ?>
                                            
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:80%; border-radius:5px;margin-block:3px">PAY INSTALLMENTS</button>
                                        </div>

                                            <p align="center" style="font-size: 11px">
                                                <i>By continuing, you have accepted our <a target="_blank" href="<?php echo e(route('terms')); ?>"  style="color:#000;margin:0;font-size: 15px"><u>Terms & Conditions</u></a></i>
                                            </p>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Individual Modal Ends -->
                    <?php if($famdet): ?>
                    <!-- Family Modal -->
                    <div class="modal fade" id="familyModal" tabindex="-1" aria-labelledby="familyModalLabel" aria-hidden="true">
                        <div class="modal-dialog row">
                            <div class="modal-content col-4" style="border-radius: 15px">
                                <div class="modal-headerx" align="center">
                                    <div><img src="<?php echo e(asset('user/images/family_icon.png')); ?>" width="30%" style="margin-top:25px;margin-bottom:5px" alt="PWG Group"></div>
                                    <h5 class="modal-title" id="familyModalLabel">FAMILY PACKAGE</h5>
                                    
                                </div>
                                <div class="modal-body" style="height:auto">
                                    <p style="font-size: 18px">Dependants Details</p>
                                    <p style="font-size: 12px;margin-top:-10px">Please add details about your Dependants</p>
                                    <?php if(Route::has('login')): ?>
                                    <?php if(auth()->guard()->check()): ?>
                                    <form action="<?php echo e(url('contract', $data->id)); ?>" method="GET">
                                    <?php else: ?>
                                    <form action="<?php echo e(url('register')); ?>">
                                        <?php Session::put('prod_id', $data->id); ?>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <input type="hidden" value="<?php echo e($data->id); ?>">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="productId" value="<?php echo e($productId); ?>">
                                    <input type="hidden" class="hiddenFamAmount" name="cost" value="<?php echo e(($famdet) ?  number_format($famdet['first_payment_sub_total']) : 0); ?>">
                                    <input type="hidden" value="FAMILY_PACKAGE" name="myPack">
                                    <input type="hidden" value="<?php echo e(($famdet) ? $famdet->id : 0); ?>" name="fam_id">

                                    <div class="partner-sec">
                                        <?php $XYZ = Session::get('mySpouse'); ?>
                                        <p style="font-size: 12px">Is your spouse/partner accompanying you?</p>
                                        <p style="height: 13px; padding: 15px 30px;font-size: 12px;margin-top:-25px; margin-bottom:25px">
                                            Yes
                                            <label class="switch">
                                                <input type="radio" id="mySpouse" name="spouse" <?php if($XYZ == 'yes' ): ?> checked="checked" <?php endif; ?>  onclick="handleClick(this);" value="yes">
                                                <span class="slider round"></span>
                                            </label>
                                            
                                            No
                                            <label class="switch">
                                                <input type="radio" id="mySpouse" name="spouse" <?php if($XYZ == 'no' || $XYZ == null): ?> checked="checked" <?php endif; ?> onclick="handleClick(this);" value="no">
                                                <span class="slider round"></span>
                                            </label>
                                        </p>
                                    </div>

                                    <?php $ABC = Session::get('myKids'); ?>

                                    <div class="children-sec">
                                        <p style="height: 13px">
                                            <p style="font-size: 12px;margin-bottom:-15px;margin-top:-10px">How many children will be accompanying you?</p>
                                            <div class=" row children">
                                                <div class="col-2">
                                                    <input type="radio" id="none" name="children" <?php if($ABC == 0 || $ABC==null ): ?> checked="checked" <?php endif; ?>  onclick="handleKids(this);" value="0"/>
                                                    <label for="none">None</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="one" name="children" <?php if($ABC == 1 || $ABC==null ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="1"/>
                                                    <label for="one">One</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="two" name="children" <?php if($ABC == 2 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="2" />
                                                    <label for="two">Two</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="three" name="children" <?php if($ABC == 3 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="3" />
                                                    <label for="three">Three</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="four" name="children" <?php if($ABC == 4 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="4" />
                                                    <label for="four">Four</label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>

                                    <div class="row" style="padding:15px 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px;">SAVE AED <span class="Famamount_save"><?php echo e($famdet_save); ?></span></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px;">WHEN YOU PAY IN FULL</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="border-top:0px solid rgb(57, 127, 184)"></div>
                                    </div>
                                    <div class="row" style="padding:10px 5%">
                                        
                                        <?php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;?>
                                        <div class="col-5" align="right"><span style="font-size:10px;;color:#000"><b>PROMO PRICE</b></span> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:22px;color:#000" class="Famamount"><?php echo e(number_format($famdet['first_payment_sub_total'],0)); ?></span></b></div>
                                        <div class="col-1" align="center" style="padding:0 3px; border-left: 0px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-6" align="right" style="padding-right:15%"><span style="font-size:10px;color:#000"><b>REGULAR PRICE</b></span> <br> <span style="font-size:12px;color:#E10930">AED</span> <del style="font-size:22px;color:#E10930"><span style="font-size:22px;color:#E10930" class="Famamount_old"><?php echo e(number_format($famdet_cost_old,0)); ?></span></del></div>
                                    </div>

                                    <div class="form-groupx row" style=" margin:0 auto;"> 
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary se2" id="buy" value="1" name="payall"  style="width:80%;border-radius:5px; margin-block:3px; border: 0px solid #fff; background:#FACB08">FULL PAYMENT</button>
                                            <?php
                                            if($data->full_payment_discount > 0) {
                                            ?>
                                            
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:80%; border-radius:5px;margin-block:3px">PAY INSTALLMENTS</button>
                                        </div>

                                            <p align="center" style="font-size: 11px">
                                                <i>By continuing, you have accepted our <a target="_blank" href="<?php echo e(route('terms')); ?>"  style="color:#000;margin:0;font-size: 15px"><u>Terms & Conditions</u></a></i>
                                            </p>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Family Modal Ends -->
                    <?php endif; ?>
            </div>
        </div>

    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<script>
    $(document).ready(function(){
            $('.blue-desc').hide();
            $('.white-desc').hide();
            $('.family-desc').hide();
            $('.study-desc').hide();
            $('.express-desc').hide();
            
            $('#blueSelect').hide()
            $('#whiteSelect').hide()
            $('#familySelect').hide()
            $('#studySelect').hide()
            $('#expressSelect').hide()

            $('.blue-collar').click(function(){
                let bluej = "BLUE_COLLAR"
                document.cookie = 'packageType='+bluej ;

                if($('.blue-desc').is(":visible"))
                {
                    $('.blue-desc').hide();
                } else {
                    $('.blue-desc').show(); 
                }
                $('.white-desc').hide();
                $('.family-desc').hide();
                $('.study-desc').hide();
                $('.express-desc').hide();

                $('#studySelect').hide()
                $('#expressSelect').hide()
                if($('#blueSelect').is(":visible"))
                {
                    $('#blueSelect').hide()
                } else {
                    $('#blueSelect').show()
                }
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.white-collar').click(function(){
                let whitej = "WHITE_COLLAR"
                document.cookie = 'packageType='+whitej ;

                $('.blue-desc').hide();
                if($('.white-desc').is(":visible"))
                {
                    $('.white-desc').hide();
                } else {
                    $('.white-desc').show();
                }
                $('.family-desc').hide();

                $('#blueSelect').hide()
                if($('#whiteSelect').is(":visible"))
                {
                    $('#whiteSelect').hide()
                } else {
                    $('#whiteSelect').show()
                }                 
                $('#familySelect').hide()
            });
            $('.family-package').click(function(){
                let famj = "FAMILY_PACKAGE"
                document.cookie = 'packageType='+famj ;

                $('.blue-desc').hide();
                $('.white-desc').hide();
                if($('.family-desc').is(":visible"))
                {
                    $('.family-desc').hide();
                } else {
                    $('.family-desc').show();
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                if($('#familySelect').is(":visible"))
                {
                    $('#familySelect').hide()
                } else {
                    $('#familySelect').show()
                }
            });

            $('.study-permit').click(function(){
                let studyj = "STUDY_PERMIT"
                document.cookie = 'packageType='+studyj ;

                if($('.study-desc').is(":visible"))
                {
                   $('.study-desc').hide();
                } else {
                    $('.study-desc').show();
                }
                $('.express-desc').hide();
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                if($('#studySelect').is(":visible"))
                {
                    $('#studySelect').hide()
                } else {
                    $('#studySelect').show()
                }
                $('#expressSelect').hide()
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.express-entry').click(function(){
                let expressj = "EXPRESS_ENTRY"
                document.cookie = 'packageType='+expressj ;
               
                $('.study-desc').hide();
                if($('.express-desc').is(":visible"))
                {
                    $('.express-desc').hide();
                } else {
                    $('.express-desc').show();
                }
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                $('#studySelect').hide()
                if($('#expressSelect').is(":visible"))
                {
                    $('#expressSelect').hide()
                } else {
                    $('#expressSelect').show()
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
        });

</script>
<?php $__env->stopPush(); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

<script src="Scripts/jquery.session.js"></script>
<script type="text/javascript">

function handleClick(spouse) {
 
    parents = spouse.value;
    kidd = $('input[name="children"]:checked').val();

    getCost(kidd,parents);
    // document.cookie = 'parents='+parents ;        
}

function handleKids(children) {
let kidd = children.value;
parents = $("input[name=spouse]:checked").val();

getCost(kidd,parents);


//  document.cookie = 'pers='+kidd ; 
//  window.location.href = "<?php echo e(route('packageType',$productId)); ?>";
}

function getCost(kidd, parents)
{
 
    $.ajax({
        type: 'GET',
        url: "<?php echo e(route('packageType',$productId)); ?>",
        data: {kid : kidd, parents: parents , response : 1}, 
        success: function (data) {
            let vallu = (data.first_payment_sub_total*1.2995)-(data.first_payment_sub_total);
            
            $('.Famamount').text(parseFloat(data.first_payment_sub_total).toLocaleString());
            $('.Famamount_old').text(parseFloat(data.first_payment_sub_total*1.2995).toLocaleString());
            $('.Famamount_save').text(parseFloat(vallu).toLocaleString());
            $('.hiddenFamAmount').val(data.first_payment_sub_total);
        },
        errror: function (error) {
        }
    });
}

</script>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/package-type.blade.php ENDPATH**/ ?>