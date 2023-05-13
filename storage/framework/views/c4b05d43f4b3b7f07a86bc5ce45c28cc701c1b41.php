
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="<?php echo e(asset('css/payment-form.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/alert.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="../user/extra/css/signature-pad.css">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="stylesheet" href="../user/extra/css/signature-pad.css">
<style>

    #canvas-placeholder {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 10%;
      text-align: center;
      color: rgb(196, 193, 193);
      font-size: 20px;
    }
  </style>
<?php $__env->startSection('content'); ?>

<?php

// Session::forget('packageType');
// Session::forget('myproduct_id');
// Session::forget('mypack_id');
// Session::forget('mySpouse');
// Session::forget('myKids');


$completed = DB::table('applications')
->where('client_id', '=', Auth::user()->id)
->orderBy('id','desc')
->first();
?>


<?php if($completed): ?>
    <?php
        $levels = $completed->application_stage_status;
        $app_id= $completed->id;
    ?>
<?php else: ?>
    <?php $levels=0; ?>
    
<?php endif; ?> 

<?php

if(Session::has('myproduct_id'))
{
$pid = Session::get('myproduct_id');
} else {
$pid = $app_id;
}
$vals=array(0,1,2);
?>


<?php if(Session::has('infox')): ?>
    <script type="text/javascript">
     toastr.success("<?php echo e(session('infox')); ?>", '', { closeButton: false, timeOut: 4000, progressBar: true, enableHtml: true });
    </script>
    <?php 
     Session::forget('infox');
    ?>
<?php endif; ?>


<div class="container">
    <div class="col-12">
        <!-- Check if application completed, then exclude the other processes link and allow for subsequent payments only -->
        
        
        <div class="payment-form">
            <?php if($levels == '5'): ?>
            <!-- Show Nothing -->
          <?php else: ?>
          <div class="wizard" style="margin-bottom: 30px;">
              <div class="row">
                  <div class="tabs d-flex justify-content-center">
                      <div class="wrapper">
                          <a href="<?php echo e(url('payment_form', $pid)); ?>" class="wrapper-link">
                              <div class="round-active round2 m-2">1</div>
                          </a>
                          <div class="col-2 round-title">Payment <br> Details</div>
                      </div>
                      <div class="linear"></div>
                      
                      <?php if($levels == '5' || $levels == '4' || $levels == '3' || $levels == '2'): ?>
                          <div class="wrapper">
                              <a href="<?php echo e(route('applicant.details', $pid)); ?>" class="wrapper-link">
                                  <div class="round4 m-2">2</div>
                              </a>
                              <div class="col-2 round-title">Applicant <br> Details</div>
                          </div>
                          <div class="linear"></div>
                          <div class="wrapper">
                              <a href="<?php echo e(url('applicant/review', $pid)); ?>" class="wrapper-link">
                                  <div class="round5 m-2">3</div>
                              </a>
                              <div class="col-2 round-title">Application <br> Review</div>
                          </div>
                      <?php else: ?>
                          <div class="wrapper">
                              <a href="#" onclick="toastr.error('You have to complete Payment first');" class="wrapper-link toastrDefaultError">
                                  <div class="round4 m-2">2</div>
                              </a>
                              <div class="col-2 round-title">Applicant <br> Details</div>
                          </div>
                          <div class="linear"></div>
                          <div class="wrapper">
                              <a href="#" onclick="toastr.error('You have to complete Payment first');"  class="wrapper-link toastrDefaultError">
                                  <div class="round5 m-2">3</div>
                              </a>
                              <div class="col-2 round-title">Application <br> Review</div>
                          </div>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
  
          <?php endif; ?>
            <div class="contract-signature">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="contract d-flex align-items-center justify-content-center my-col"  data-bs-toggle="modal" data-bs-target="#contractModal">
                            <div class="contractImg">
                                <img src="<?php echo e(asset('images/contract.png')); ?>" width="100%" height="100%">
                            </div>
                            <div class="contractSubHead">
                                <h6>CONTRACT</h6>
                                <p>Please review the contract carefully</p>
                            </div>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contractModal">ZOOM TO REVIEW</button>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="my-col">

                            <form enctype="multipart/form-data" id="signatureSubmit">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                                <input type="hidden" name="ppid" value="<?php echo e(isset($pdet->id) ? $pdet->id : ''); ?>">
                                <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                                <input type="hidden" name="payall" value="<?php echo e($payall); ?>">
                                <div id="signature-pad" class="signature-pad">
                                    <div class="signature-pad--body">
                                        <canvas id="sig"></canvas>
                                        <div id="canvas-placeholder">Sign Here</div>
                                    </div>
            
                                        <div class="signature-pad--actions">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary clear" id="clear" style="margin-bottom: -5px;" data-action="clear">CLEAR</button>
                                            </div>
                                            
                                        </div>
             
                                    
                                    
                                </div>
                            </form>
                     
                            <script src="../user/extra/js/signature_pad.umd.js"></script>
                            <script src="../user/extra/js/app.js"></script>
                            <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
                            <script src="<?php echo e(asset('js/alert.js')); ?>"></script>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #Fff;padding: 30px; margin-top:5px;--bs-gutter-x: 0px;margin-bottom:8%;">
                <div class="col-12">
<Style>
    /* style="accent-color:#08fa30;border: 1px solid white;width: 20px;height: 20px;top: 5px;left: -3px;position:relative;" */
    input[type='radio']:after, input[type='radio']::-webkit-after, input[type='radio']::-moz-after {
        accent-color:#08fa30;
        border: 1px solid white;
        width: 20px;
        height: 20px;
        top: -2px;
        left: -7px;
        position:relative;
        background-color: #fff;
        border-radius: 50%;
        content: '';
        visibility: visible;
        display: inline-block; 
    }
        input[type='radio']:checked:after,  input[type='radio']:checked::-webkit-after, input[type='radio']:checked::-moz-after{
            accent-color:#FACB08;
        border: 5px solid white;
        width: 20px;
        visibility: visible;
        height: 20px;
        top: -2px;
        left: -7px;
        position:relative;
        background-color: #857f7f;
        content: '';
        display: inline-block;
    }

    #optTA{
        display: block;
    }
    #optTB{
        display: none;
    }

    #optCA{
        display: block;
    }
    #optCB{
        display: none;
    }

    #optDA{
        display: block;
    }
    #optDB{
        display: none;
    }
@media (max-width:1450px) {
    .payoption label {
        height: 75px;
    }
    .partner-sec .switch {
    margin: 0 12px;
    }
}

    @media (max-width:900px) {
        
    .payoption label {
        height: 75px;
    }
    #optTA{
        display: none;
    }
    #optTB{
        display: block;
    }

    #optCA{
        display: none;
    }
    #optCB{
        display: block;
    }

    #optDA{
        display: none;
    }
    #optDB{
        display: block;
    }
    }

    @media(420px) {
        #optDB{
            font-size: 9px;
        } 
    }

    .flash {
        animation-name: flash;
        animation-duration: 0.5s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        animation-play-state: running;
    }

    @keyframes  flash {
        from {
            color: black; /*rgba(255, 234, 4, 0.692)*/
        }

        to {
            color: red;
        }
    }
    #card-payment input[type='checkbox']:checked:after {
        accent-color:#FACB08;
        border: #FACB08;
        background-color: #FACB08;
    }
</Style>
                    <div classx="form-sec discountForm">
                            <div align="left" style="background-color: #Fff;padding: 30px 0px">
                                <div><b style="color:black;font-size: 16px; margin-left:15px">Choose a Payment Method:</b></div>
                                <div align="left" class="row payoption" style="--bs-gutter-x:0px;display:fles; width:100%; margin:0 auto; margin-bottomx: -30px;margin-topx:10px">
                                    <div class="col-4" style="margin-left:-10px;display:inline-block;" align: left> 
                                        <input type="radio" id="card" name="payoption" checked value="Card" required> 
                                        <label for="card"><img src="<?php echo e(asset('user/images/card_pay.png')); ?>" height="30px"> <span class="brk"><span id="optCA">Card Payment</span><span id="optCB">Card Payment</span></span></label>
                                    </div>
                                    <div class="col-4" style="margin-left:0px;display:inline-block;">
                                        <input type="radio" id="transfer" name="payoption" value="Transfer" required> 
                                        <label for="transfer"><img src="<?php echo e(asset('user/images/transfer_pay.png')); ?>" height="30px"> <span class="brk"><span id="optTA">Bank Transfer/Exchange</span><span id="optTB">Bank Transfer</span></span></label>
                                    </div>
                                    <div class="col-4" style="margin-left:0px;display:inline-block;">
                                        <input type="radio" id="deposit" name="payoption" value="Deposit" required> 
                                        <label for="deposit"><img src="<?php echo e(asset('user/images/deposit_pay.png')); ?>" height="30px"> <span class="brk"><span id="optDA">ATM Deposit</span><span id="optDB">ATM Deposit</span></span></label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <?php if((!isset($pays)) || ((isset($pays)) && ($pays->first_payment_status == "PENDING"))): ?>
                                    <div class="col-md-6">
                                        <hr style="border: 2px solid #ccc;margin:0">
                                        <div align="left" style="background-color: #Fff;padding: 10px 0px">
                                            <div>
                                                <b style="color:black;font-size: 14px; margin-leftx:15px">Choose your payment type:</b> &ensp;&ensp;&ensp;&ensp;
                                                <span class="flash" style="font-size: 11px;font-weight:600;">
                                                    <?php $disc=($pdet->sub_total-$pdet->third_payment_sub_total)/10; ?>
                                                    (Save additional <?php echo e($disc); ?>AED when you make full payment)
                                                </span>
                                            </div>
                                            <div class="row" style=" margin:0 auto;"> 

                                                <div class="col-lg-12 col-md-4 col-sm-4" style="max-width:200px;display:inline-block;border-radius:5px; margin-block:3px; padding-block:10px; border: 0px solid #fff; background:#FACB08">
                                                    <input type="radio" name="payall" id="partial" checked value="1" required> 
                                                    <label><b>PAY INSTALLMENTS</b></label>
                                                </div> &ensp;
                                                <div class="col-lg-12 col-md-4 col-sm-4" style="max-width:200px;display:inline-block;border-radius:5px; margin-block:3px; padding-block:10px; border: 0px solid #fff; background:#FACB08">
                                                    <input type="radio" name="payall" id="full" value="0" required> 
                                                    <label><b>FULL PAYMENT</b></label>
                                                </div>&ensp;
                                                
                                            </div>
                                        </div> 
                                    </div>
                                    <?php if(Auth::user()->created_at >= "2023-03-22"): ?>
                                        <div class="col-md-6 coupon" style="margin-top: 4%;">
                                            <div class="row">
                                                <div class="form-floating col-lg-8 col-md-8 col-sm-12 mt-2">
                                                    <input type="text" class="form-control" name="coupon" id="discount_code" placeholder="Enter coupon code" autocomplete="off" />
                                                    <label for="discount_code">Enter coupon code</label>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                                    <button type="button" class="btn btn-primary dicountBtn" id="dicountBtn" style="font-size:18px;border-color: #FACB08;">APPLY CODE</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($myPack == "FAMILY_PACKAGE"): ?>
                            <link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">
                            <style>
                               
                                .partner-sec .switch {
                                    margin: 0 25px;
                                }
                                .partner-sec {
                                    width:25%;
                                }
                                .children-sec {
                                    width:30%;
                                }
                                .partner-sec .status{
                                    height: 50px; 
                                    padding: 15px;
                                    font-size: 12px;
                                    margin-top:-17px; 
                                    margin-bottom:25px;
                                    background-color: #FACB08;
                                    width:80%;
                                }
                                @media(max-width:1024px){
                                    .partner-sec .status {
                                        width: 90% !important;
                                    }
                                    .partner-sec .switch {
                                    margin: 0 12px;
                                }
                                }
                                @media(max-width:950px) {
                                 .partner-sec {
                                    width:100% !important;
                                }
                                .children-sec {
                                    width:100% !important;
                                }
                                .partner-sec .status{
                                    width:100%;
                                }
                                }
                            </style>
                           
                            <div id="family" class="row" style="--bs-gutter-x: 0px;">
                            
                            <p style="font-size: 14px">Dependants Details </p>
                            <div class="partner-sec  col-md-5 col-lg-5 col-sm-12" >
                                <?php $XYZ = (Session::has('mySpouse')) ? Session::get('mySpouse') : 'no'; ?>
                                <p style="font-size: 12px">Is your spouse/partner accompanying you?</p>
                                <p class="status">
                                    Yes
                                    <label class="switch">
                                        <input type="radio" id="yesmySpouse" name="spouse" <?php if($XYZ == 'yes' ): ?> checked="checked" <?php endif; ?>   value="yes">
                                        <span class="slider round"></span>
                                    </label>
                                    
                                    No
                                    <label class="switch">
                                        <input type="radio" id="mySpouse" name="spouse" <?php if($XYZ == 'no' || $XYZ == null): ?> checked="checked" <?php endif; ?>  value="no">
                                        <span class="slider round"></span>
                                    </label>
                                </p>
                            </div>

                            <?php $ABC = Session::get('myKids'); ?>
                           
                            <div class="children-sec col-md-6 col-lg-6 col-sm-12">
                                
                                    <p style="font-size: 12px;margin-bottom:-15px;margin-top:3px">How many children will be accompanying you?</p>
                                    <div class=" row children" style="widthx:35%">
                                        <div class="col-2">
                                            <input type="radio" id="none" name="children" class="kids" <?php if($ABC == 0 || $ABC==null ): ?> checked="checked" <?php endif; ?>   value="0"/>
                                            <label for="none">None</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="one" name="children" class="kids" <?php if($ABC == 1 || $ABC==null ): ?> checked="checked" <?php endif; ?>  value="1"/>
                                            <label for="one">One</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="two" name="children" class="kids" <?php if($ABC == 2 ): ?> checked="checked" <?php endif; ?>  value="2" />
                                            <label for="two">Two</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="three" name="children" class="kids" <?php if($ABC == 3 ): ?> checked="checked" <?php endif; ?>  value="3" />
                                            <label for="three">Three</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="four" name="children" <?php if($ABC == 4 ): ?> checked="checked" <?php endif; ?>  value="4" />
                                            <label for="four">Four</label>
                                        </div>
                                    </div>
                              
                            </div>
                        </div>
                        <hr style="border: 2px solid #ccc;margin:0">
                        <?php endif; ?>

                        <div id="paymain">
                            
                            <div id='card-payment'>
                                <?php echo $__env->make('user.card-payment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div id='bank-payment'>
                                <?php echo $__env->make('user.bank-payment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>


                            
<?php
// if(Session::has('payall'))
// {
//     $payall = Session::get('payall');
// } elseif(isset($_REQUEST['payall'])) {
//     $payall = $_REQUEST['payall'];
// } else {
//     $payall = 0;
// }
// Session::forget('payall');
?>
<?php if(session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon') == 1): ?>
<?php
    $promo = session()->get('myDiscount');
?>
<?php else: ?>
<?php
    $promo = 0;
?>
<?php endif; ?>

<?php if(isset($pdet)): ?>
<?php

    $first_pay = $pdet->first_payment_sub_total;
    $second_pay = $pdet->submission_payment_sub_total;
    $third_pay = $pdet->second_payment_sub_total;
    
    $tot_pay = $first_pay + $second_pay + $third_pay;
?>
<?php else: ?>
<?php
    $first_pay = 0;
    $second_pay = 0;
    $third_pay = 0;
    
    $tot_pay = 0;
?>
<?php endif; ?>

<?php
$diff = $pays ? $pays->first_payment_remaining : 0; //$pays->first_payment_price - $pays->first_payment_paid
?>

<?php if($diff > 0): ?>
<?php
    $pends = $pays ? $pays->first_payment_remaining : 0;
?>
<?php elseif($diff < 0): ?>
<?php
    $pends = $pays ? $pays->first_payment_paid - $pays->first_payment_sub_total : 0;
?>
<?php else: ?>
<?php
    $pends = 0;
?>
<?php endif; ?>


<?php

// $outsec = $pays ? $pays->second_payment_price - $pays->second_payment_paid : 0;
// $outsub = $pays ? $pays->submission_payment_price - $pays->submission_payment_paid : 0;
$outsec = $pays ? $pays->second_payment_remaining : 0;
$outsub= $pays ? $pays->submission_payment_remaining : 0;
if ($payall == 0 || empty($payall)) {
if (!isset($pays) || ($pays->first_payment_status != 'PAID' || $pays->first_payment_status == null)) {
    //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
    $whichPayment = 'FIRST';
    $outsub = 0;
    $outsec = 0;

    $payNow = $pdet->first_payment_sub_total;
    // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
    // if ($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)) {
    if(isset($pays) &&  $pays->first_payment_paid > 0){
        $pendMsg = 'You have ' . $pends . ' balance on first payment.';
        $payNoww = $pends;
        $whichPayment = 'BALANCE_ON_FIRST';
    } else {
        $pendMsg = '';
        $payNoww = $pdet->first_payment_sub_total;
    }
} elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status != 'PAID' && $pdet->submission_payment_sub_total>0) {
    $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
    $outsec = 0;

    $whichPayment = 'SUBMISSION';
    if ($pays->submission_payment_remaining > 0 && $pays->submission_payment_status == 'PARTIALLY_PAID') {
        $pendMsg = 'You have ' . $pays->submission_payment_remaining . ' balance on submisssion payment.';
        $payNoww = $pays->submission_payment_remaining;
        $payNow = $pdet->submission_payment_sub_total;
        $whichPayment = 'BALANCE_ON_SUBMISSION';
    } else {
        if ($diff > 0 && $pays->is_first_payment_partially_paid == 1) {
            $payNow = $pdet->submission_payment_sub_total;
            $payNoww = $pdet->submission_payment_sub_total + $pends;
            $pendMsg = ' + ' . $pends . ' carried over from previous payment';
        } elseif ($diff < 0 && $pays->is_first_payment_partially_paid == 1) {
            $payNow = $pdet->submission_payment_sub_total;
            $payNoww = $pdet->submission_payment_sub_total - $pends;
            $pendMsg = ' - ' . $pends . ' over paid from previous payment';
        } else {
            $payNow = $pdet->submission_payment_sub_total;
            $payNoww = $pdet->submission_payment_sub_total;
            $pendMsg = '';
        }
    }
} elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0 && $pdet->submission_payment_sub_total>0) {
    $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
    $outsec = 0;

    $pendMsg = 'You have ' . $outsub . ' balance on submission payment.';
    $payNow = $outsub; //$pdet->submission_payment_sub_total;
    $payNoww = $outsub;
    $whichPayment = 'SUBMISSION';
} elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && empty($pdet->submission_payment_sub_total)) {
    $outsec = $pays->second_payment_price - $pays->second_payment_paid;
    $outsub = 0;

    $whichPayment = 'SECOND';
    if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
        $vat_2 = $pays->second_payment_remaining * (5 / 100);
        $pendMsg = 'You have ' . ($pays->second_payment_remaining) . ' balance on second payment.';
        $payNoww = $pays->second_payment_remaining;
        $payNow = $pdet->second_payment_sub_total;
        $whichPayment = 'BALANCE_ON_SECOND';
    } else {
        
        if ($diff > 0 && $pays->is_submission_payment_partially_paid == 1) {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pdet->second_payment_sub_total + $pends;
            $pendMsg = ' + ' . $pends . ' carried over from previous payment';
        } elseif ($diff < 0 && $pays->is_submission_payment_partially_paid == 1) {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pdet->second_payment_sub_total - $pends;
            $pendMsg = ' - ' . $pends . ' over paid from previous payment';
        } else {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pays->second_payment_remaining;
            $pendMsg = '';
        }
    }
} elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && $pdet->second_payment_sub_total>0) {
    $outsec = $pays->second_payment_price - $pays->second_payment_paid;
    $outsub = 0;

    $whichPayment = 'SECOND';
    if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
        $vat_2 = $pays->second_payment_remaining * (5 / 100);
        $pendMsg = 'You have ' . ($pays->second_payment_remaining) . ' balance on second payment.';
        $payNoww = $pays->second_payment_remaining;
        $payNow = $pays->second_payment_remaining;
        $whichPayment = 'BALANCE_ON_SECOND';
    } else {
        if ($diff > 0 && $pays->is_submission_payment_partially_paid == 1) {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pdet->second_payment_sub_total + $pends;
            $pendMsg = ' + ' . $pends . ' carried over from previous payment';
        } elseif ($diff < 0 && $pays->is_submission_payment_partially_paid == 1) {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pdet->second_payment_sub_total - $pends;
            $pendMsg = ' - ' . $pends . ' over paid from previous payment';
        } else {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pdet->second_payment_sub_total;
            $pendMsg = '';
        }
    }
} elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PAID' && $outsec > 0 && $pdet->second_payment_sub_total>0) {
    $pendMsg = 'You have ' . $outsec . ' balance on second payment.';
    $payNow = $outsec; //$pdet->submission_payment_sub_total;
    $payNoww = $outsec;
    $whichPayment = 'SECOND';
} else {
    $whichPayment = 'FIRST';
    $payNow = $pdet->first_payment_sub_total;
    $payNoww = $pdet->first_payment_sub_total;
    $pendMsg = '';
}
$discount = 0;
} else {

$discount = 0;
$discountPercent = 0;
if(!isset($pays)){
    $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
    $payNoww = $payNow;
    $pendMsg = 'Full Payment';
    if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
        $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

        // $discountPercent = '5%';
        // $discount = ($payNow * 5 / 100);
        $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
    }
    $whichPayment = 'Full-Outstanding Payment';
}elseif (isset($pays) && $pays->first_payment_status == 'PENDING' && ($pays->submission_payment_status == 'PENDING') & ($pays->second_payment_status == 'PENDING')) {
    $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
    $payNoww = $payNow;
    $pendMsg = 'Full Payment';
    if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
        $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

        // $discountPercent = '5%';
        // $discount = ($payNow * 5 / 100);
        $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
    }
    $whichPayment = 'Full-Outstanding Payment';
} elseif (isset($pays) && $pays->first_payment_status != 'PAID') {
    if (is_null($pdet->second_payment_price) or empty($pdet->second_payment_price)) {
        $payNow = $pdet->submission_payment_sub_total;
        $payNoww = $payNow;
        if ($diff > 0) {
            $pendMsg = 'Part Paid already';
        } else {
            $pendMsg = '';
        }
        $discountPercent = '';
        $discount = 0;
    } elseif ($diff > 0) {
        $payNow = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
        $payNoww = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
        $pendMsg = 'Part Paid already';
        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
            $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

            $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
        }
    } else {
        $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
        $payNoww = $pdet->sub_total - $pdet->third_payment_sub_total;
        $pendMsg = 'Full Payment';
        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {

            $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
            $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
        }
    }
    $whichPayment = 'Full-Outstanding Payment';
// } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PENDING') {
} elseif(isset($pays) && $pays->first_payment_status =="PAID"){
    if ($pdet->second_payment_price != null || $pdet->second_payment_price != 0) {

        if($pays->submission_payment_status =="PENDING"){
            $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
            $payNoww = $payNow;
            if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0;
            }
        } else if($pays->submission_payment_status =="PARTIALLY_PAID") {
            $payNow = $pdet->second_payment_sub_total;
            $payNoww = $pays->submission_payment_remaining + $payNow;
            if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                $discount = ($data->full_payment_discount > 0) ? ($pdet->second_payment_sub_total * $data->full_payment_discount / 100) : 0;
            }
        }
        $pendMsg = "Full Outstanding Payment";
        $whichPayment = 'Full-Outstanding Payment';
    } else {
        $payNow = $pdet->submission_payment_sub_total;
        $payNoww = $payNow;
        $pendMsg = '';
        $discountPercent = '';
        $discount = 0;
        $whichPayment = 'SUBMISSION';
    }

} elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && ($pays->second_payment_status =="PENDING" || $pays->second_payment_status == 'PARTIALLY_PAID' )) {
    $payNow = $pdet->second_payment_sub_total;
    $payNoww = $payNow;
    $pendMsg = '';
    $discountPercent = '';
    $discount = 0;
} else {
    $payNow = 0;
    $payNoww = $payNow;
    $pendMsg = '';
    $discountPercent = '';
    $discount = 0;
}

$whichPayment = 'Full-Outstanding Payment';
}

$vatPercent = '5%';

$vat = (($payNow - $discount) * 5) / 100;

$totalPay = round($payNow - $discount + $vat, 2);
// echo $payall= $_COOKIE['payallx'];
?>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
            <!-- Contract Modal -->
            <div class="modal fade" id="contractModal" tabindex="-1" aria-labelledby="contractModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg row" style="height:80%">
                    <div class="modal-content col-4" style="border-radius: 15px">
                        <div class="modal-headerx" align="center">
                            <button type="button" style="float:right; font-size:16px; width:40px;height:40px" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body contractFileUrl" style="height:100%">
                            <?php if(Session::has('contractFileUrl')): ?>
                                <embed src="<?php echo e(Session::get('contractFileUrl')); ?>#toolbar=0&navpanes=0&pagemode=none" width="100%" height="100%" view="fit" type="application/pdf" />
                            <?php else: ?> 
                                <embed src="<?php echo e($fileUrl); ?>#toolbar=0&navpanes=0&pagemode=none" width="100%" height="100%" view="fit" type="application/pdf" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contract Modal Ends -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>

<script>

    $(document).ready(function(){

        $('.coupon').show();
        $('#showDiscount').hide();
        $('#card').prop('checked', true);
        $('#mySpouse').prop('checked', true);
        $('#one').prop('checked', true);
        // let ppyall=<?php echo SESSION::get('ppyall')?>;
        var Signed = '<?php echo e(is_object($pays) ? $pays->contract_1st_signature_status : null); ?>';
        var pays = '<?php echo e(is_object($pays)); ?>';
        if(pays == 1 && Signed == "SIGNED")
        {
            $('.contract-signature').hide();    
        } else {
            $('.contract-signature').show();    
        }

        $('#bank-payment').hide();

        $('#transfer').click(function(){
            $('#bank-payment').show();
            $('#card-payment').hide();
        });
        $('#deposit').click(function(){
            $('#bank-payment').show();
            $('#card-payment').hide();
        });
        $('#card').click(function(){
            $('#bank-payment').hide();
            $('#card-payment').show();
        });
     

        $('#showDiscount').hide();
        $('#discount').hide();
        $('#promoDiscount').hide();

        $('#amount').keyup(function() {
            if($('#amount').val()){
                    var aVat =($('#amount').val()*5)/100;
                    let vval = parseInt($('#amount').val()) + parseInt(($('#amount').val()*5)/100);

                    document.getElementById("amountLink2").value = vval;
                    let ax = $('#amountLink').text(parseInt(vval).toLocaleString());
                
            } else {
                document.getElementById("amountLink2").value = $('#totaldue').val();
                let ax = $('#amountLink').text(parseInt($('#totaldue').val()).toLocaleString());
            }
        });

        $('.dicountBtn').click(function(){
            var paynow = <?php echo $payNoww; ?>;     
            var vat = $('#vats').val();
            var $this = $(this); 
            var totalPay = '<?php echo e($totalPay); ?>';
            $('#transAmount').empty();
            $.ajax({ 
                url: '<?php echo e(route("getPromo")); ?> ',
                method: 'POST',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "discount_code" : $('#discount_code').val(),
                    "totaldue" : $('#totaldue').val(),
                    'paynow' : paynow,
                    'vat' : vat
                }
            }).done( function (response) {
                var coupon = JSON.stringify(response.coupon);
                if (response.status == true) {
                    $('#amountLink2').val(0);
                    $('#totaldue').val(0);
                    // $('#discountValue').html(0);
                    // $('#discountValue').text(0);
                    // $('#myDiscount').val(0);
         
                    var nf = Intl.NumberFormat(); 
                    // let amtNow = response.topaynow;
                    let amtNow = Math.floor(response.topaynow * 100)/100;

                    // let amtNoww = nf.format(amtNow);
                    let amtNoww = nf.format(Math.floor(response.topaynow *100)/100);

                    let discountAmt = response.discountamt;
                    let discountAmtt = nf.format(discountAmt);
              
                    let vatNow = Math.floor(response.vatNow * 100)/100;
                    let totalValueNotRounding = Math.floor(response.topaynow *100)/100;

                    // $('#promoDiscount #discountValue').html(discountAmtt);
                    // $('#promoDiscount #discountValue').text(discountAmtt);
                    $('#discountValue').html(discountAmtt);
                    $('#discountPercent').html(response.discountPercent);

                    $('#amountLink').html(amtNoww);
                    $('#vatt').html(vatNow);
                    $('#amountLink2').val(totalValueNotRounding);
                    $('#totaldue').val(totalValueNotRounding);

                    // document.getElementById("amountLink2").value = response.topaynow;

                    document.getElementById("vats").value = Math.floor(response.vatNow * 100)/100;
                    // document.getElementById("myDiscount").value = response.discountamt;
                    document.getElementById("myDiscount").value = Math.floor(discountAmt * 100)/100;
                    $('#transAmount').text(amtNoww)
                    document.getElementById("myDiscountCode").value = $('#discount_code').val();
                    $('.couponDetails').val(coupon);
                    $(".code").val($('#discount_code').val());
                    $('.couponApplyDetails').val(coupon);
                    // document.getElementById("totaldue").value = response.topaynow;
                    // $('#amountLink2').html(response.topaynow);
                    // $('#totaldue').html(response.topaynow);
                    $('#showDiscount').show();
                    toastr.success('Discount Applied Successfully !');

                } else {
                    let preAmt = $('#totaldue').val();
                    $('#amountLink').html(preAmt);
                    $('#transAmount').text(totalPay);
                    $('#amountLink').html(totalPay);
                    $('#amountLink2').val(totalPay);
                    $('#totaldue').val(totalPay);
                    $('#showDiscount').hide();
                    toastr.error(response.message);
                }
            });
        });
    });


</script>
<?php $__env->stopPush(); ?>
<script src="<?php echo e(asset('js/alert.js')); ?>"></script>
<script type="text/javascript" src="/path/to/toastr.js"></script>

<script>
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
    <?php endif; ?>

    <?php if(Session::has('warning')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
            toastr.warning("<?php echo e(session('warning')); ?>");
    <?php endif; ?>

</script>
<?php if(!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)): ?> 
<script>
    //Disable right click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
        return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
        // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
        if (
            event.keyCode === 123 ||
            ctrlShiftKey(e, 'I') ||
            ctrlShiftKey(e, 'J') ||
            ctrlShiftKey(e, 'C') ||
            (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
        )
        return false;
    };

</script>
<?php endif; ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/user/payment-form.blade.php ENDPATH**/ ?>