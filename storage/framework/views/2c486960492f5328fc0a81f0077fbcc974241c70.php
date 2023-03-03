 
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="<?php echo e(asset('css/payment-form.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/alert.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="../user/extra/css/signature-pad.css">

<?php $__env->startSection('content'); ?>
<?php 
    $completed = DB::table('applications')
        ->where('client_id', '=', Auth::user()->id)
        ->orderBy('id','desc')
        ->first();
    if(Session::has('myproduct_id'))
    {
        $pid = Session::get('myproduct_id');
    } else {
        $pid = $app_id;
    }
    $vals=array(0,1,2);
?>

<?php if($completed): ?>
    <?php
        $levels = $completed->application_stage_status;
        $app_id= $completed->id;
    ?>
<?php else: ?>
    <?php $levels=0; ?>
    
<?php endif; ?> 

<div class="container">
    <div class="col-12">        
        <?php if($levels == '5'): ?>
          <!-- Show Nothing -->
        <?php else: ?>
            <div class="wizard">
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
        <div class="payment-form">
            <div class="contract-signature">
                <div class="row">
                    <div class="col-6">
                        <div class="contract d-flex align-items-center justify-content-center my-col">
                            <div class="contractImg">
                                <img src="<?php echo e(asset('images/contract.png')); ?>" width="100%" height="100%">
                            </div>
                            <div class="contractSubHead">
                                <h6>CONTRACT</h6>
                                <p>Please review the contract carefully</p>
                            </div>
                        </div>
                        <button class="btn btn-primary ">ZOOM TO REVIEW</button>
                    </div>
                    <div class="col-6">
                        <div class="my-col">
                            <form enctype="multipart/form-data" id="signatureSubmit">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                                <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                                <input type="hidden" name="payall" value="<?php echo e($payall); ?>">
                                <div id="signature-pad" class="signature-pad">
                                    <div class="signature-pad--body">
                                        <canvas id="sig"></canvas>
                                    </div>
                
                                    <div class="signature-pad--footer">                              
                                        <div class="signature-pad--actions">
                                            <div class="col-6">

                                                <button type="button" class="btn btn-primary clear" id="clear" data-action="clear">CLEAR</button>
                                            </div>
                                            <div class="col-6">
                                                <!-- <button type="submit" id="sigBtn" data-action="savePNG" class="btn btn-primary">SUBMIT</button> -->
                                                <button type="button" id="sigBtn" data-action="save-png" class="btn btn-primary button save">SUBMIT</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="toast-container"></div>
                                </div>
                            </form>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        
                            <div class="heading">
                                <div class="first-heading">
                                    <h3>
                                        Payment Details
                                    </h3><br>
            
                                </div>
                                <!-- <div class="bottom-title">
                                    <p style="color: #C4C4C4; text-align: center;">If you have a dicount code, enter it here.</p>
                                </div> -->
                            </div>
                            <div classx="form-sec discountForm">
                            <form method="POST" action="<?php echo e(url('add_payment')); ?>">
                                <?php echo csrf_field(); ?>
                                <!-- col-lg-6 col-md-6 col-12 offset-md-3 offset-lg-3 -->
            
                                    <div align="center" style="background-color: #F0F3F4;padding: 30px">
                                        <div><b style="color:black">Choose a Payment Method:</b></div>
                                        <ul align="center" class="payoption" style="display:inline; margin:0 auto; margin-bottomx: -30px;margin-top:10px">
                                            <li style="margin:10px;">
                                                <input type="radio" id="card" name="payoption" checked value="Card" required> 
                                                <label for="card"><i class="fa fa-credit-card ico"></i> Card Payment</label>
                                            </li>
                                            <li style="margin:10px">
                                                <input type="radio" id="transfer" name="payoption" value="Transfer" required> 
                                                <label for="transfer"><i class="fa fa-exchange"></i> Bank Transfer</label>
                                            </li>
                                            <li style="margin:10px">
                                                <input type="radio" id="deposit" name="payoption" value="Deposit" required> 
                                                <label for="deposit"><i class="far fa-money-bill-alt" aria-hidden="true"></i> Bank Deposit</label>
                                            </li>
                                        </ul>
            
                                    </div>
            
                                    <?php if(session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon')==1): ?>
                                        <?php                               
                                            $promo = session()->get('myDiscount')
                                        ?>
                                    <?php else: ?>
                                        <?php
                                            $promo =0
                                        ?>
                                    <?php endif; ?>
                                  
                                    <?php if(isset($pdet)): ?>
                                        <?php
                                            // $first_pay = $pdet->first_payment_price;
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
                                        $diff = ($pays) ? $pays->first_payment_remaining : 0;  //$pays->first_payment_price - $pays->first_payment_paid
                                    ?>
            
                                    <?php if($diff > 0): ?>
                                        <?php
                                            $pends = ($pays) ? $pays->first_payment_remaining : 0 ;
                                        ?>
                                    <?php elseif($diff < 0): ?> 
                                        <?php
                                            $pends= ($pays) ? $pays->first_payment_paid - $pays->first_payment_sub_total : 0;
                                        ?>
                                    <?php else: ?>
                                        <?php
                                            $pends=0;
                                        ?>
                                    <?php endif; ?>
            
            
                                        <?php
                                        
                                            $outsec= ($pays) ? $pays->second_payment_price - $pays->second_payment_paid : 0;
                                            $outsub= ($pays) ? $pays->submission_payment_price - $pays->submission_payment_paid : 0;
                                            if ($payall == 0 || empty($payall)) {
            
                                             if(!isset($pays) || ($pays->first_payment_status !="PAID" || $pays->first_payment_status ==null)){
                                                //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
                                               $whichPayment =  "FIRST";
                                               $outsub=0;
                                               $outsec=0;
                                          
                                                $payNow = $pdet->first_payment_sub_total;
                                                // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
                                                if($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)){
                                                    
                                                    $pendMsg = "You have " . $pends . " balance on first payment.";
                                                    $payNoww = $pends;
                                                    $whichPayment =  "BALANCE_ON_FIRST";
            
                                                } else {
                                                    $pendMsg = "";
                                                    $payNoww = $pdet->first_payment_sub_total;
                                                }
            
                                             }
                                             elseif(isset($pays) && $pays->first_payment_status =="PAID" && $pays->submission_payment_status !="PAID"){
            
                                                $outsub= $pays->submission_payment_price - $pays->submission_payment_paid;
                                                $outsec=0;
            
                                                $whichPayment =  "SUBMISSION";
                                                    if ($diff > 0 && $pays->is_first_payment_partially_paid == 1) {
                                                        $payNow = $pdet->submission_payment_sub_total;
                                                        $payNoww = $pdet->submission_payment_sub_total + $pends;
                                                        $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                                    } elseif ($diff < 0 && $pays->is_first_payment_partially_paid == 1) {
                                                        $payNow = $pdet->submission_payment_sub_total;
                                                        $payNoww = $pdet->submission_payment_sub_total - $pends;
                                                        $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                                    } else {
                                                        $payNow = $pdet->submission_payment_sub_total;
                                                        $payNoww = $pdet->submission_payment_sub_total;
                                                        $pendMsg = "";
                                                    }
                                             }
                                             elseif(isset($pays) && $pays->first_payment_status =="PAID" && $pays->submission_payment_status =="PAID" && $outsub > 0){
                                                $outsub= $pays->submission_payment_price - $pays->submission_payment_paid;
                                                $outsec=0;
            
                                                    $pendMsg = "You have " . $outsub . " balance on submission payment.";
                                                    $payNow = $outsub; //$pdet->submission_payment_sub_total;
                                                    $payNoww = $outsub;
                                                    $whichPayment =  "SUBMISSION";
                                            }
                                             elseif(isset($pays) && $pays->submission_payment_status =="PAID" && $pays->second_payment_status !="PAID"){
            
                                                $outsec= $pays->second_payment_price - $pays->second_payment_paid;
                                                $outsub=0;
            
                                                $whichPayment =  "SECOND";
                                                if ($diff > 0 && $pays->is_submission_payment_partially_paid == 1) {
                                                    $payNow = $pdet->second_payment_sub_total;
                                                    $payNoww = $pdet->second_payment_sub_total + $pends;
                                                    $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                                } elseif ($diff < 0 && $pays->is_submission_payment_partially_paid == 1) {
                                                    $payNow = $pdet->second_payment_sub_total;
                                                    $payNoww = $pdet->second_payment_sub_total - $pends;
                                                    $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                                } else {
                                                    $payNow = $pdet->second_payment_sub_total;
                                                    $payNoww = $pdet->second_payment_sub_total;
                                                    $pendMsg = "";
                                                }
                                                
                                            }
                                            elseif(isset($pays) && $pays->submission_payment_status =="PAID" && $pays->second_payment_status =="PAID" && $outsec > 0){
                                                    $pendMsg = "You have " . $outsec . " balance on second payment.";
                                                    $payNow = $outsec; //$pdet->submission_payment_sub_total;
                                                    $payNoww = $outsec;
                                                    $whichPayment =  "SECOND";
            
                                             }else {
                                                $whichPayment =  "FIRST";
                                                $payNow = $pdet->first_payment_sub_total;
                                                $payNoww = $pdet->first_payment_sub_total;
                                                $pendMsg = "";
                                             }
                                             $discount=0;
                                            } else {
                                                $discount=0;
                                                $discountPercent = 0;
                                                    if(isset($pays) && $pays->first_payment_status =="PENDING" && $pays->submission_payment_status =="PENDING" & $pays->second_payment_status =="PENDING") {
                                                        $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
                                                        $payNoww = $payNow;
                                                        $pendMsg = "Full Payment";
                                                        if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                                                            $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
            
                                                            // $discountPercent = '5%';
                                                            // $discount = ($payNow * 5 / 100);
                                                            $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0; //product discount fetch
                                                        }
                                                        $whichPayment =  "Full-Outstanding Payment";
                                                    } elseif(isset($pays) && $pays->first_payment_status !="PAID"){
                                                        if(is_null($pdet->second_payment_price) OR empty($pdet->second_payment_price) ) {
                                                            $payNow = $pdet->submission_payment_sub_total;
                                                            $payNoww = $payNow;
                                                            if($diff > 0){
                                                            $pendMsg = "Part Paid already";
                                                            } else {
                                                                $pendMsg="";
                                                            }
                                                            $discountPercent = '';
                                                            $discount = 0;
                                                        }elseif($diff > 0) {
                                                            // $payNow = $pdet->total_price-$pays->first_payment_paid;
                                                            // $payNoww = $pdet->total_price-$pays->first_payment_paid;
                                                            $payNow = $pdet->sub_total-$pdet->first_payment_sub_total-$pdet->third_payment_sub_total;
                                                            $payNoww = $pdet->sub_total-$pdet->first_payment_sub_total-$pdet->third_payment_sub_total;
                                                            $pendMsg = "Part Paid already";
                                                            if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                                                                $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                                                                // $discountPercent =  '5%'; //$data->full_payment_discount
                                                                // $discount = ($payNow * 5 / 100);
                                                                $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0; //product discount fetch
                                                            }
                                                        } else {
                                                            $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
                                                            $payNoww = $pdet->sub_total - $pdet->third_payment_sub_total;
                                                            $pendMsg = "Full Payment";
                                                            if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                                                                // $discountPercent = '5%';
                                                                // $discount = ($payNow * 5 / 100);
                                                                $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                                                                $discount =($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0; //product discount fetch
                                                            }
                                                        }
                                                        $whichPayment =  "Full-Outstanding Payment";
                                                    } elseif(isset($pays) && $pays->first_payment_status =="PAID" && $pays->submission_payment_status =="PENDING"){
                                                        if($pdet->second_payment_price != null || $pdet->second_payment_price != 0){
                                                            $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
                                                            $payNoww = $payNow;
                                                            $pendMsg = "Full Outstanding Payment";
                                                            if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                                                                $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                                                                $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0;
                                                            }
                                                            $whichPayment =  "Full-Outstanding Payment";
                                                        } else {
                                                            $payNow = $pdet->submission_payment_sub_total;
                                                            $payNoww = $payNow;
                                                            $pendMsg = "";
                                                            $discountPercent = '';
                                                            $discount = 0;
                                                            $whichPayment =  "SUBMISSION";
                                                        }
                                                        // $payNow = $pdet->total_price - $pdet->first_payment_price;
                                                        // $payNoww = $payNow;
                                                        // $pendMsg = "Full Outstanding Payment";
            
                                                        // $discountPercent = '5%';
                                                        // $discount = ($payNow * 5 / 100);
                                                    } elseif (isset($pays) && $pays->first_payment_status =="PAID" && $pays->submission_payment_status =="PAID" && $pays->second_payment_status =="PENDING") {
                                                        $payNow = $pdet->second_payment_sub_total;
                                                        $payNoww = $payNow;
                                                        $pendMsg = "";
                                                        $discountPercent = '';
                                                        $discount = 0;
                                                    }else{
                                                        $payNow = 0;
                                                        $payNoww = $payNow;
                                                        $pendMsg = "";
                                                        $discountPercent = '';
                                                        $discount = 0;
                                                    }
                                                
            
                                                $whichPayment =  "Full-Outstanding Payment";
                                                // $discountPercent = $data->full_payment_discount . '%';
                                                // $discount = ($pdet->total_price * $data->full_payment_discount / 100);
                                            }
                                            // $payNow = 0;
                                            $vatPercent = '5%';
            
                                            // if(Auth::user()->country_of_residence == "United Arab Emirates" || Auth::user()->country_of_residence ==null)
                                            // {
                                            //   $vat = (($payNow - $discount) * 5) / 100;
                                            // } else {
                                            //     $vat = 0;
                                            // }
                                            $vat = (($payNow - $discount) * 5) / 100;
            
                                            $totalPay = round((($payNow - $discount) + $vat),2);
                                            // $payNoww = $payNow =$second_pay = 10;
                                            // list($which, $zzz) = explode(' ', $whichPayment);
                                        ?>
                                                           
                                            <div class="row payament-sec">
                                                <div class="col-lg-6 col-md-12" style="padding-right:20px">
                                                    <div class="total">
                                                        <div class="total-sec row mt-3">
                                                            <div class="left-section col-6">
            
                                                                <?php if($whichPayment  == "FIRST"): ?>
            
                                                                <b>First Payment</b> 
                                                                <?php else: ?>
                                                                First Payment
            
                                                                <?php endif; ?>
                                                                <span style="font-size:11px" class="vtt"><?php if($vat>0): ?>(+ 5% VAT)<?php endif; ?></span>
                                                                <?php if($pends>1): ?> 
                                                                <br>
                                                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i>  <?php echo e($pendMsg); ?> </font> 
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="right-section col-6" align="right">
                                                                <?php if($whichPayment == "FIRST"): ?>
                                                              
                                                                <b><?php echo e(number_format($first_pay,2)); ?></b>
            
                                                                <?php else: ?>
                                                                <?php echo e(number_format($first_pay,2)); ?>

                                                                <?php endif; ?>
                                                                <span style="font-size:11px">AED</span>
                                                            </div>
                                                        </div>
                                                        <div class="total-sec row mt-3">
                                                            <div class="left-section col-6">
            
                                                                <?php if( $whichPayment == "SUBMISSION"): ?>
                                                                <b>Submission Payment</b> 
                                                                
                                                                <?php else: ?>
                                                                Submission Payment
                                                                <?php endif; ?>
                                                                <span style="font-size:11px" class="vtt"><?php if($vat>0): ?>(+ 5% VAT)<?php endif; ?></span>
                                                                <?php if($outsub>1): ?> 
                                                                <br>
                                                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i>  <?php echo e($pendMsg); ?> </font> 
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="right-section col-6" align="right">
            
                                                                <?php if( $whichPayment ==  "SUBMISSION"): ?>
                                                                
                                                                <b><?php echo e(number_format($second_pay,2)); ?></b>
            
                                                                <?php else: ?>
                                                                <?php echo e(number_format($second_pay,2)); ?>

                                                                <?php endif; ?>
                                                                <span style="font-size:11px">AED</span>
            
                                                            </div>
                                                        </div>
                                                        <div class="total-sec row mt-3">
                                                            <div class="left-section col-6">
                                                                <?php if( $whichPayment ==  "SECOND"): ?>
                                                                
                                                                <b>Second Payment</b> <?php if(strlen($pendMsg)>1): ?> <br>
            
                                                                <font style='font-size:11px;color:red'><i fa fa-arrow-up></i> </font> <?php endif; ?>
                                                                <?php else: ?>
                                                                Second Payment
                                                                <?php endif; ?>
                                                                <span style="font-size:11px" class="vtt"><?php if($vat>0): ?>(+ 5% VAT)<?php endif; ?></span>
                                                                <?php if($outsec>1): ?> 
                                                                <br>
                                                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i>  <?php echo e($pendMsg); ?> </font> 
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="right-section col-6" align="right">
                                                                <?php if( $whichPayment ==  "SECOND"): ?>
                                                                
                                                                <b><?php echo e(number_format($third_pay,2)); ?></b>
            
                                                                <?php else: ?>
                                                                <?php echo e(number_format($third_pay,2)); ?>

                                                                <?php endif; ?>
                                                                <span style="font-size:11px">AED</span>
                                                            </div>
                                                        </div>
                                                        <hr>
                
                                                        <div class="total-sec row mt-3">
                                                            <div class="left-section col-6">
                                                                Total Payment
                                                            </div>
                                                            <div class="right-section col-6 " align="right">
                                                                <?php 
            
                                                                //    $totalCost = Session::get('totalCost');  
                                                                   if(isset($tot_pay)) {
                                                                    if (is_numeric($tot_pay))
                                                                    {
                                                                       $ttot = number_format($tot_pay,2);
                                                                    } else {
                                                                        $ttot = $tot_pay; //$totalCost;
                                                                    }
                                                                  } else {
                                                                    $ttot =Session::get('totalCost');
                                                                  }
                                                                ?> 
                                                               
            
                                                                <?php if(isset($ttot) && $ttot > 0): ?>
                                                                <?php echo e($ttot); ?>

                                                                <?php else: ?>
                                                                <?php echo e(isset($tot_pay) ? number_format($tot_pay,2) : ''); ?>

                                                                
                                                                <?php endif; ?>
                                                                <span style="font-size:11px">AED</span>
                                                            </div>
                                                        </div>
            
                                                        <?php if($payall==1 && isset($discount) && $discount>0): ?>
                                                        <div class="total-sec row mt-3 showDiscount">
                                                            <div class="left-section col-6">
                                                                 Full Payment Discount (<span id="discountPercent">-<?php echo e(($discountPercent) ? $discountPercent : ''); ?></span>)
                                                            </div>
                                                            <div class="right-section col-6" align="right">
                                                          
                                                                <span id="discountValue"><?php echo e(number_format($discount,2)); ?> </span>
                                                                <span style="font-size:11px" id="discountVal">AED</span>
                                                                <input type="hidden" name="discount" id="myDiscount" value="<?php echo e($discount); ?>">
                                                                <input type="hidden" name="discountCode" id="myDiscountCode" value="">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="total-sec row mt-3 showDiscount" id ="showDiscount">
                                                            <div class="left-section col-6">
                                                           
                                                                  Discount (<span id="discountPercent"><?php echo e((isset($discountPercent)) ? $discountPercent : ''); ?> </span>)
                                                                
                                                            </div>
                                                            <div class="right-section col-6" align="right">
                                                          
                                                                <span id="discountValue"><?php echo e(number_format($discount,2)); ?> </span>
                                                                <span style="font-size:11px" id="discountVal">AED</span>
                                                                <input type="hidden" name="discount" id="myDiscount" value="<?php echo e($discount); ?>">
                                                                <input type="hidden" name="discountCode" id="myDiscountCode" value="">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if(isset($vat) && $vat>0): ?>
                                                        <div class="total-sec row mt-3 showVat" id="showVat">
                                                            <div class="left-section col-6">
                                                                 VAT (+ 5% of <?php echo e($whichPayment); ?>)
                                                            </div>
                                                            <div class="right-section col-6" align="right">
                                                                <span id="vatt"><?php echo e(number_format($vat,2)); ?> </span>
                                                                <span style="font-size:11px">AED</span>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <input type="hidden" name="vats" id="vats" value="<?php echo e($vat); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <?php if($whichPayment =="FIRST" && ($diff == 0 || empty($diff))): ?>
                                                      <div class="partial" style="height: 100%;">
                                                        <p>Pay <?php echo e(strtolower($whichPayment)); ?> installment in partial</p>
                                                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter partial payment" style="text-align:left !important" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                                        
                                                        <?php if($errors->has('amount')): ?>
                                                          <div class="error"><?php echo e($errors->first('amount')); ?></div>
                                                        <?php endif; ?> 
                                                        <p>Minimum amount of <b> 1,000 AED</b><span style="font-size:11px" class="vtt"> <?php if($vat>0): ?>(+ 5% VAT)<?php endif; ?></span></p>
                                                    
                                                        <p><b>Remaining amount to be paid in 7 days</b></p>
                                                      </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="partial-total-sec">
            
                                                    <?php if($diff > 0 && $payall ==0): ?> 
                                                        <h2 style="font-size: 1em;">Now you will pay the balance on first installment only 
                                                            <b><?php echo e(number_format((floor($pends * 100)/100),2)); ?></b> AED 
                                                            <span style="font-size:11px;opacity:0.6" id="amountText">
                                                                <?php if($vat>0): ?> (VAT inclusive <?php if($discount>0): ?> ,less Discount  <?php endif; ?>) <?php endif; ?>
                                                            </span>
                                                        </h2>
                                                        <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e(round($payNoww, 2)); ?>">
                                                        <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round(($payNow + $vat),2)); ?>">
                                                        <input type="hidden" name="totalremaining" value="<?php echo e(round($pends,2)); ?>">
                                                    <?php else: ?>
                                                        <h2 style="font-size: 1em;">Now you will pay <?php echo e(strtolower($whichPayment)); ?> installment only 
                                                            <span id="amountLink">
                                                               
                                                                
                                                                <b><span id="amountLink"> <?php echo e(((isset($pays) && $pays->first_payment_status !="PAID") ? (($diff > 0) ? number_format((floor(((($payNoww - $discount)+ $vat)+$pays->first_payment_remaining)*100)/100),2) : (number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))):number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))); ?> </span></b>
                                                            </span> AED 
                                                            <span style="font-size:11px;opacity:0.6"  id="amountText">
                                                                <?php if($vat>0): ?> 
                                                                 (<span id="vt">VAT inclusive</span> <?php if($discount>0): ?> ,less Discount  <?php endif; ?>) 
                                                                <?php else: ?> 
                                                                 <?php if($discount>0): ?> 
                                                                  (less Discount)  
                                                                 <?php endif; ?> 
                                                                <?php endif; ?>
                                                            </span>
                                                        </h2>
                                                        
                                                        <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e(((isset($pays) && $pays->first_payment_status !="PAID") ? (($diff > 0) ? (round(((($payNoww - $discount)+ $vat)+$pays->first_payment_remaining),2)) : round((($payNoww - $discount)+ $vat),2)):round((($payNoww - $discount)+ $vat),2))); ?>">
                                                        <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round((($payNoww - $discount) + $vat),2)); ?>">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
            
                                    <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="ppid" value="<?php echo e((isset($pdet->id))?$pdet->id:''); ?>">
                                    <input type="hidden" name="uid" value="<?php echo e(Auth::user()->id); ?>">
                                    <input type="hidden" name="whichpayment" value="<?php echo e(($whichPayment) ? $whichPayment : 'FIRST'); ?>">
                                    <input type="hidden" name="first_p" value="<?php echo e($pdet->first_payment_sub_total); ?>">
                                    <input type="hidden" name="second_p" value="<?php echo e($pdet->submission_payment_sub_total); ?>">
                                    <input type="hidden" name="third_p" value="<?php echo e($pdet->second_payment_sub_total); ?>">
            
                                    <div class="form-group row mt-4" style="margin-bottom: 70px">
                                        <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                            <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                            <p style="font-size:11px; text-align:center;color:green">You will be redirected to a secured payment page!</p>
                                        </div>
                                    </div>
                                </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>

<script>
    $(document).ready(function(){

        $('#showDiscount').hide();
        $('#discount').hide();
        $('#promoDiscount').hide();
        // document.getElementById("amountLink2").value = $(this).val();
        // let ax = $('#amountLink').text(($('#totaldue').val()));

        $('#amount').keyup(function() {
            if($('#amount').val()){
                if($('.current_location').val() =='United Arab Emirates'){
                    var aVat =($('#amount').val()*5)/100;
                    let vval = parseInt($('#amount').val()) + parseInt(($('#amount').val()*5)/100);

                    // document.getElementById("amountLink2").value = $(this).val();
                    document.getElementById("amountLink2").value = vval;
                    let ax = $('#amountLink').text(parseInt(vval).toLocaleString());
                } else {
                    // if('<?php echo e(Auth::user()->country_of_residence); ?>' == "United Arab Emirates"){
                    //     var aVat =($('#amount').val()*5)/100;
                    //     let vval = parseInt($('#amount').val()) + parseInt(($('#amount').val()*5)/100);

                    //     // document.getElementById("amountLink2").value = $(this).val();
                    //     document.getElementById("amountLink2").value = vval;
                    //     let ax = $('#amountLink').text(parseInt(vval).toLocaleString());
                    // } else {
                    //     document.getElementById("amountLink2").value = $(this).val();
                    //     let ax = $('#amountLink').text(parseInt($(this).val()).toLocaleString());
                    // }

                    var aVat =($('#amount').val()*5)/100;
                    let vval = parseInt($('#amount').val()) + parseInt(($('#amount').val()*5)/100);

                    document.getElementById("amountLink2").value = vval;
                    let ax = $('#amountLink').text(parseInt(vval).toLocaleString());
                }                
                
            } else {
                document.getElementById("amountLink2").value = $('#totaldue').val();
                let ax = $('#amountLink').text(parseInt($('#totaldue').val()).toLocaleString());
            }
        });

        $('.dicountBtn').click(function(){
            var paynow = <?php echo $payNoww; ?>;     
            var vat = $('#vats').val();
            var $this = $(this); 
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
            
                if (response.status == true) {
                    // alert(response.myDiscount);
                    // alert(response.status);
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
                    // alert(response.topaynow.toFixed(2));
                    $('#amountLink2').val(totalValueNotRounding);
                    $('#totaldue').val(totalValueNotRounding);

                    // document.getElementById("amountLink2").value = response.topaynow;

                    document.getElementById("vats").value = Math.floor(response.vatNow * 100)/100;
                    // document.getElementById("myDiscount").value = response.discountamt;
                    document.getElementById("myDiscount").value = Math.floor(discountAmt * 100)/100;

                    document.getElementById("myDiscountCode").value = $('#discount_code').val();
                    // document.getElementById("totaldue").value = response.topaynow;
                    // $('#amountLink2').html(response.topaynow);
                    // $('#totaldue').html(response.topaynow);
                    $('#showDiscount').show();
                    toastr.success('Discount Applied Successfully !');

                } else {
                    let preAmt = $('#totaldue').val();
                    $('#amountLink').html(preAmt);
                    
                    $('#showDiscount').hide();
                    toastr.error('Invalid Discount Code');
                }
            });
        });

        $('.current_location').change(function(){
            var $this = $(this);
            var paynow = <?php echo $payNoww; ?>;            
            var discount = '<?php echo e($discount); ?>';
            var amtx = (paynow - discount);
            var vt =(amtx*5)/100;
            $('#amount').val('');
            if($this.val()=='United Arab Emirates')
            {
              document.getElementById("amountLink2").value = Math.floor((amtx + (amtx*5/100)) *100)/100;
              $('#amountLink').text(parseFloat(Math.floor((amtx + (amtx*5/100)) * 100)/100).toLocaleString('en')); //= amtx + (amtx*5/100);
              document.getElementById("totaldue").value = Math.floor((amtx + (amtx*5/100)) *100)/100;

              var nf = Intl.NumberFormat(); 
              $('#vatt').html(nf.format(vt));
              // $('#vats').val(vt.toFixed(2));
              $('#vats').val(Math.floor(vt * 100)/100);
              $('#showVat').show();
              $('#vt').text("VAT Inclusive");
              $('.vtt').text("(+ 5% VAT)");
            } else {
                
            //   document.getElementById("amountLink2").value = amtx.toFixed(2);
            //   $('#amountLink').text(parseFloat(Math.floor(amtx *100)/100).toLocaleString('en')); //= amtx;
            //   document.getElementById("totaldue").value = Math.floor(amtx * 100)/100;
            //   $('#showVat').hide();
            //   //   $('#vt').hide();
            //   $('#vatt').html(0);
            //   $('#vats').val(0);
            //   $('#vt').text("No VAT");
            //   $('.vtt').text("");


              document.getElementById("amountLink2").value = Math.floor((amtx + (amtx*5/100)) *100)/100;
              $('#amountLink').text(parseFloat(Math.floor((amtx + (amtx*5/100)) * 100)/100).toLocaleString('en')); //= amtx + (amtx*5/100);
              document.getElementById("totaldue").value = Math.floor((amtx + (amtx*5/100)) *100)/100;

              var nf = Intl.NumberFormat(); 
              $('#vatt').html(nf.format(vt));
 
              $('#vats').val(Math.floor(vt * 100)/100);
              $('#showVat').show();
              $('#vt').text("VAT Inclusive");
              $('.vtt').text("(+ 5% VAT)");
            }

        });
        $('.embassy_appearance').change(function(){

            var $this = $(this); 
            $.ajax({ 
                url: '<?php echo e(route("checkPromo")); ?> ',
                method: 'POST',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "embassy_appearance" : $('#embassy_appearance').val()
                }
            }).done( function (response) {

                if (response.status) {
                    // alert(response.status);
                        $('#discount').show();
                    // $('#target-div').html(response.status); 
                } else {
                    $('#discount').hide();
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/payment-form.blade.php ENDPATH**/ ?>