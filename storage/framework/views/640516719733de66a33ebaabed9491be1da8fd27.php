<form method="POST" action="<?php echo e(url('add_payment')); ?>">
    <?php echo csrf_field(); ?>

  

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
                <?php if($second_pay>0): ?>
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">

                        <?php if($whichPayment == 'SUBMISSION'): ?>
                            <b>Submission Payment</b>
                        <?php else: ?>
                            Submission Payment
                        <?php endif; ?>
                        
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
                <?php endif; ?>
                <?php if($third_pay>0): ?>
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
                <?php endif; ?>
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
                    
                <?php endif; ?>
                <input type="hidden" name="vats" id="vats" value="<?php echo e($vat); ?>">
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <?php if($whichPayment == 'FIRST' && (!isset($pays) || $pays->first_payment_paid == 0)): ?>
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
                                
                            <?php endif; ?>
                        </span></p>

                    <p><b>Remaining amount to be paid in 30 days</b></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="partial-total-sec">

            <?php if(isset($pays) && $pays->first_payment_paid > 0 && $pays->first_payment_remaining > 0 && $payall ==0 ): ?> 
                <h2 style="font-size: 1em;">Now you will pay the balance on first installment only
                    <b><?php echo e(number_format((floor($pends * 100)/100),2)); ?></b> AED 
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        <?php if($vat>0): ?> (VAT inclusive <?php if($discount>0): ?> ,less Discount  <?php endif; ?>) <?php endif; ?>
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e(round($payNoww, 2)); ?>">
                <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round(($payNow + $vat),2)); ?>">
                <input type="hidden" name="totalremaining" value="<?php echo e(round($pends,2)); ?>">
            <?php elseif(isset($pays) && $pays->submission_payment_paid > 0 && $pays->submission_payment_remaining > 0 && $payall ==0 && (strtolower($whichPayment) == "submission" || strtolower($whichPayment) == "balance_on_submission")): ?>
                <h2 style="font-size: 1em;">Now you will pay the balance on submission installment only
                    <b><?php echo e(number_format((floor($payNoww * 100)/100),2)); ?></b> AED 
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        <?php if($vat>0): ?> (VAT inclusive <?php if($discount>0): ?> ,less Discount  <?php endif; ?>) <?php endif; ?>
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e(round($payNoww, 2)); ?>">
                <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round(($payNow + $vat),2)); ?>">
                <input type="hidden" name="totalremaining" value="<?php echo e(round($pends,2)); ?>">
            <?php elseif(isset($pays) && $pays->second_payment_paid > 0 && $pays->second_payment_remaining > 0 && $payall ==0 && (strtolower($whichPayment) == "second" || strtolower($whichPayment) == "balance_on_second")): ?>
                <h2 style="font-size: 1em;">Now you will pay the balance on second installment only
                    <b><?php echo e(number_format((floor($payNoww * 100)/100),2)); ?></b> AED 
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
                    
                        
                        <b><span id="amountLink"> <?php echo e(((!isset($pays) || $pays->first_payment_status !="PAID") ? (($diff > 0) ? number_format((floor(((($payNoww - $discount)+ $vat))*100)/100),2) : (number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))):number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))); ?> </span></b>
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
                
                <input type="hidden" id="amountLink2" name="totalpay" value="<?php echo e((( !isset($pays) || $pays->first_payment_status !="PAID" ) ? (($diff > 0) ? (round(((($payNoww - $discount)+ $vat)),2)) : round((($payNoww - $discount)+ $vat),2)):round((($payNoww - $discount)+ $vat),2))); ?>">
                <input type="hidden" id="totaldue" name="totaldue" value="<?php echo e(round((($payNoww - $discount) + $vat),2)); ?>">
            <?php endif; ?>
        </div>
        
    </div>


    <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
    <input type="hidden" name="ppid" value="<?php echo e(isset($pdet->id) ? $pdet->id : ''); ?>">
    <input type="hidden" name="uid" value="<?php echo e(Auth::user()->id); ?>">
    <input type="hidden" name="packageType" value="<?php echo e($pdet->pricing_plan_type); ?>">
    <input type="hidden" name="whichpayment" value="<?php echo e($whichPayment ? $whichPayment : 'FIRST'); ?>">
    <input type="hidden" name="first_p" value="<?php echo e($pdet->first_payment_sub_total); ?>">
    <input type="hidden" name="second_p" value="<?php echo e($pdet->submission_payment_sub_total); ?>">
    <input type="hidden" name="third_p" value="<?php echo e($pdet->second_payment_sub_total); ?>">

    <div class="row mt4">
        <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px">
            <span>By continuing you agree to the <a href="<?php echo e(route('terms')); ?>"  style="color:#000;margin:30px 0;font-size: 15px" target="_blank"><u>Terms & Conditions</u></a></span>
        </div>
        <div class="col-lg-2 col-md-1 col-sm-12"></div>
        <div class="col-lg-4 col-md-5 col-sm-12">
            <button type="submit" class="btn btn-primary submitBtn" style="border-radius: 0px">Pay Now</button>
        </div>

    </div>
</form>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/card-payment.blade.php ENDPATH**/ ?>