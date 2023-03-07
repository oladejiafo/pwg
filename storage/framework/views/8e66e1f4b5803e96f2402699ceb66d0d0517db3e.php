<form method="POST" action="<?php echo e(url('add_payment')); ?>">
    <?php echo csrf_field(); ?>

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
    
    $outsec = $pays ? $pays->second_payment_price - $pays->second_payment_paid : 0;
    $outsub = $pays ? $pays->submission_payment_price - $pays->submission_payment_paid : 0;
    if ($payall == 0 || empty($payall)) {
        if (!isset($pays) || ($pays->first_payment_status != 'PAID' || $pays->first_payment_status == null)) {
            //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
            $whichPayment = 'FIRST';
            $outsub = 0;
            $outsec = 0;
    
            $payNow = $pdet->first_payment_sub_total;
            // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
            if ($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)) {
                $pendMsg = 'You have ' . $pends . ' balance on first payment.';
                $payNoww = $pends;
                $whichPayment = 'BALANCE_ON_FIRST';
            } else {
                $pendMsg = '';
                $payNoww = $pdet->first_payment_sub_total;
            }
        } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status != 'PAID') {
            $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
            $outsec = 0;
    
            $whichPayment = 'SUBMISSION';
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
        } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0) {
            $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
            $outsec = 0;
    
            $pendMsg = 'You have ' . $outsub . ' balance on submission payment.';
            $payNow = $outsub; //$pdet->submission_payment_sub_total;
            $payNoww = $outsub;
            $whichPayment = 'SUBMISSION';
        } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status != 'PAID') {
            $outsec = $pays->second_payment_price - $pays->second_payment_paid;
            $outsub = 0;
    
            $whichPayment = 'SECOND';
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
        } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PAID' && $outsec > 0) {
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
        if (isset($pays) && $pays->first_payment_status == 'PENDING' && ($pays->submission_payment_status == 'PENDING') & ($pays->second_payment_status == 'PENDING')) {
            $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
            $payNoww = $payNow;
            $pendMsg = 'Full Payment';
            if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
    
                // $discountPercent = '5%';
                // $discount = ($payNow * 5 / 100);
                $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
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
                // $payNow = $pdet->total_price-$pays->first_payment_paid;
                // $payNoww = $pdet->total_price-$pays->first_payment_paid;
                $payNow = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
                $payNoww = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
                $pendMsg = 'Part Paid already';
                if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                    $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                    // $discountPercent =  '5%'; //$data->full_payment_discount
                    // $discount = ($payNow * 5 / 100);
                    $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
                }
            } else {
                $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
                $payNoww = $pdet->sub_total - $pdet->third_payment_sub_total;
                $pendMsg = 'Full Payment';
                if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                    // $discountPercent = '5%';
                    // $discount = ($payNow * 5 / 100);
                    $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                    $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
                }
            }
            $whichPayment = 'Full-Outstanding Payment';
        } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PENDING') {
            if ($pdet->second_payment_price != null || $pdet->second_payment_price != 0) {
                $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
                $payNoww = $payNow;
                $pendMsg = 'Full Outstanding Payment';
                if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                    $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                    $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0;
                }
                $whichPayment = 'Full-Outstanding Payment';
            } else {
                $payNow = $pdet->submission_payment_sub_total;
                $payNoww = $payNow;
                $pendMsg = '';
                $discountPercent = '';
                $discount = 0;
                $whichPayment = 'SUBMISSION';
            }
            // $payNow = $pdet->total_price - $pdet->first_payment_price;
            // $payNoww = $payNow;
            // $pendMsg = "Full Outstanding Payment";
    
            // $discountPercent = '5%';
            // $discount = ($payNow * 5 / 100);
        } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PENDING') {
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
    
    $totalPay = round($payNow - $discount + $vat, 2);
    // $payNoww = $payNow =$second_pay = 10;
    // list($which, $zzz) = explode(' ', $whichPayment);
    ?>

    <div class="row payament-sec">
        <div class="col-lg-6 col-md-12" style="padding-right:20px">
            <div class="total">
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">

                        <?php if($whichPayment == 'FIRST'): ?>
                            <b>First Payment</b>
                        <?php else: ?>
                            First Payment
                        <?php endif; ?>
                        <span style="font-size:11px" class="vtt">
                            <?php if($vat > 0): ?>
                                (+ 5% VAT)
                            <?php endif; ?>
                        </span>
                        <?php if($pends > 1): ?>
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> <?php echo e($pendMsg); ?> </font>
                        <?php endif; ?>
                    </div>
                    <div class="right-section col-6" align="right">
                        <?php if($whichPayment == 'FIRST'): ?>
                            <b><?php echo e(number_format($first_pay, 2)); ?></b>
                        <?php else: ?>
                            <?php echo e(number_format($first_pay, 2)); ?>

                        <?php endif; ?>
                        <span style="font-size:11px">AED</span>
                    </div>
                </div>
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">

                        <?php if($whichPayment == 'SUBMISSION'): ?>
                            <b>Submission Payment</b>
                        <?php else: ?>
                            Submission Payment
                        <?php endif; ?>
                        <span style="font-size:11px" class="vtt">
                            <?php if($vat > 0): ?>
                                (+ 5% VAT)
                            <?php endif; ?>
                        </span>
                        <?php if($outsub > 1): ?>
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> <?php echo e($pendMsg); ?> </font>
                        <?php endif; ?>
                    </div>
                    <div class="right-section col-6" align="right">

                        <?php if($whichPayment == 'SUBMISSION'): ?>
                            <b><?php echo e(number_format($second_pay, 2)); ?></b>
                        <?php else: ?>
                            <?php echo e(number_format($second_pay, 2)); ?>

                        <?php endif; ?>
                        <span style="font-size:11px">AED</span>

                    </div>
                </div>
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">
                        <?php if($whichPayment == 'SECOND'): ?>

                            <b>Second Payment</b>
                            <?php if(strlen($pendMsg) > 1): ?>
                                <br>

                                <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>
                                </font>
                            <?php endif; ?>
                        <?php else: ?>
                            Second Payment
                        <?php endif; ?>
                        <span style="font-size:11px" class="vtt">
                            <?php if($vat > 0): ?>
                                (+ 5% VAT)
                            <?php endif; ?>
                        </span>
                        <?php if($outsec > 1): ?>
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> <?php echo e($pendMsg); ?> </font>
                        <?php endif; ?>
                    </div>
                    <div class="right-section col-6" align="right">
                        <?php if($whichPayment == 'SECOND'): ?>
                            <b><?php echo e(number_format($third_pay, 2)); ?></b>
                        <?php else: ?>
                            <?php echo e(number_format($third_pay, 2)); ?>

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
                        if (isset($tot_pay)) {
                            if (is_numeric($tot_pay)) {
                                $ttot = number_format($tot_pay, 2);
                            } else {
                                $ttot = $tot_pay; //$totalCost;
                            }
                        } else {
                            $ttot = Session::get('totalCost');
                        }
                        ?>


                        <?php if(isset($ttot) && $ttot > 0): ?>
                            <?php echo e($ttot); ?>

                        <?php else: ?>
                            <?php echo e(isset($tot_pay) ? number_format($tot_pay, 2) : ''); ?>

                            
                        <?php endif; ?>
                        <span style="font-size:11px">AED</span>
                    </div>
                </div>

                <?php if($payall == 1 && isset($discount) && $discount > 0): ?>
                    <div class="total-sec row mt-3 showDiscount">
                        <div class="left-section col-6">
                            Full Payment Discount (<span
                                id="discountPercent">-<?php echo e($discountPercent ? $discountPercent : ''); ?></span>)
                        </div>
                        <div class="right-section col-6" align="right">

                            <span id="discountValue"><?php echo e(number_format($discount, 2)); ?> </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="discount" id="myDiscount" value="<?php echo e($discount); ?>">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">

                        </div>

                    </div>
                <?php else: ?>
                    <div class="total-sec row mt-3 showDiscount" id="showDiscount">
                        <div class="left-section col-6">

                            Discount (<span
                                id="discountPercent"><?php echo e(isset($discountPercent) ? $discountPercent : ''); ?> </span>)

                        </div>
                        <div class="right-section col-6" align="right">

                            <span id="discountValue"><?php echo e(number_format($discount, 2)); ?> </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="discount" id="myDiscount" value="<?php echo e($discount); ?>">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">

                        </div>

                    </div>
                <?php endif; ?>
                <?php if(isset($vat) && $vat > 0): ?>
                    <div class="total-sec row mt-3 showVat" id="showVat">
                        <div class="left-section col-6">
                            VAT (+ 5% of <?php echo e($whichPayment); ?>)
                        </div>
                        <div class="right-section col-6" align="right">
                            <span id="vatt"><?php echo e(number_format($vat, 2)); ?> </span>
                            <span style="font-size:11px">AED</span>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="vats" id="vats" value="<?php echo e($vat); ?>">
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <?php if($whichPayment == 'FIRST' && ($diff == 0 || empty($diff))): ?>
                <div class="partial" style="height: 100%;">
                    <p>Pay <?php echo e(strtolower($whichPayment)); ?> installment in partial</p>
                    <input type="text" class="form-control" name="amount" id="amount"
                        placeholder="Enter partial payment" style="text-align:left !important"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                    
                    <?php if($errors->has('amount')): ?>
                        <div class="error"><?php echo e($errors->first('amount')); ?></div>
                    <?php endif; ?>
                    <p>Minimum amount of <b> 1,000 AED</b><span style="font-size:11px" class="vtt">
                            <?php if($vat > 0): ?>
                                (+ 5% VAT)
                            <?php endif; ?>
                        </span></p>

                    <p><b>Remaining amount to be paid in 7 days</b></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="partial-total-sec">

            <?php if($diff > 0 && $payall == 0): ?>
                <h2 style="font-size: 1em;">Now you will pay the balance on first installment only
                    <b><?php echo e(number_format(floor($pends * 100) / 100, 2)); ?></b> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        <?php if($vat > 0): ?> (VAT inclusive <?php if($discount > 0): ?>
                                ,less Discount
                            <?php endif; ?>) <?php endif; ?>
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e(round($payNoww, 2)); ?>">
                <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round($payNow + $vat, 2)); ?>">
                <input type="hidden" name="totalremaining" value="<?php echo e(round($pends, 2)); ?>">
            <?php else: ?>
                <h2 style="font-size: 1em;">Now you will pay <?php echo e(strtolower($whichPayment)); ?> installment only
                    <span id="amountLink">

                        
                        <b><span id="amountLink">
                                <?php echo e(isset($pays) && $pays->first_payment_status != 'PAID' ? ($diff > 0 ? number_format(floor(($payNoww - $discount + $vat + $pays->first_payment_remaining) * 100) / 100, 2) : number_format(floor(($payNoww - $discount + $vat) * 100) / 100, 2)) : number_format(floor(($payNoww - $discount + $vat) * 100) / 100, 2)); ?>

                            </span></b>
                    </span> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        <?php if($vat > 0): ?>
                            (<span id="vt">VAT inclusive</span>
                            <?php if($discount > 0): ?>
                                ,less Discount
                            <?php endif; ?>)
                        <?php else: ?>
                            <?php if($discount > 0): ?>
                                (less Discount)
                            <?php endif; ?>
                        <?php endif; ?>
                    </span>
                </h2>
                
                <input type="hidden" id="amountLink2" name="totalpay"
                    value="<?php echo e(isset($pays) && $pays->first_payment_status != 'PAID' ? ($diff > 0 ? round($payNoww - $discount + $vat + $pays->first_payment_remaining, 2) : round($payNoww - $discount + $vat, 2)) : round($payNoww - $discount + $vat, 2)); ?>">
                <input type="hidden" id="totaldue" name="totaldue"
                    value="<?php echo e(round($payNoww - $discount + $vat, 2)); ?>">
            <?php endif; ?>
        </div>
    </div>


    <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
    <input type="hidden" name="ppid" value="<?php echo e(isset($pdet->id) ? $pdet->id : ''); ?>">
    <input type="hidden" name="uid" value="<?php echo e(Auth::user()->id); ?>">
    <input type="hidden" name="whichpayment" value="<?php echo e($whichPayment ? $whichPayment : 'FIRST'); ?>">
    <input type="hidden" name="first_p" value="<?php echo e($pdet->first_payment_sub_total); ?>">
    <input type="hidden" name="second_p" value="<?php echo e($pdet->submission_payment_sub_total); ?>">
    <input type="hidden" name="third_p" value="<?php echo e($pdet->second_payment_sub_total); ?>">

    <div class="row mt4">
        <div class="col-md-4 col-sm-12" style="margin-top: 30px">
            <span>By continuing you agree to the <a href="<?php echo e(route('terms')); ?>"  style="color:#000;margin:30px 0;font-size: 15px" target="_blank"><u>Terms & Conditions</u></a></span>
        </div>
        <div class="col-md-4 col-sm-12"></div>
        <div class="col-md-4 col-sm-12">
            <button type="submit" class="btn btn-primary submitBtn" style="border-radius: 0px">Pay Now</button>
        </div>

    </div>
</form>
<?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/card-payment.blade.php ENDPATH**/ ?>