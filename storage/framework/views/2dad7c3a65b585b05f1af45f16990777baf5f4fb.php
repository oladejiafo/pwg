<!-- Theme style  -->
<link rel="stylesheet" href="<?php echo e(asset('user/extra/css/styled.css')); ?>">

<div class="row card">

    <div class="col-md-12">

        <div class="about-desc animate-box">
            <div class="fancy-collapse-panel">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> &nbsp;  <?php echo e($prod->name); ?> PACKAGE
                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#333;background-color:#333;">
                        <div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
                            <!-- collapse in -->
                            <div class="panel-body">


                              

                                <?php
                                $pay_id = $pays->id;
                                // $payment = $pay->payment;
                                // $amount = $pay->amount;
                                
                               
                                $ppid = $pays->id;
                                // $ptid = $pd->product_payment_id;
                                
                                ?>

                                <!-- First Begins -->
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                            First Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         <?php if($paid->first_payment_status =='PAID'): ?>
                                            Status PAID
                                         <?php elseif($paid->first_payment_status =='PARTIAL'): ?>
                                            Status PAID PARTIAL   
                                         <?php else: ?>
                                            Status PENDING
                                         <?php endif; ?>

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                        <?php if($paid->first_payment_status =='PAID'): ?>

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="<?php echo e(url('/get/invoice/First Payment')); ?>">Get Invoice</a>
                                       <?php else: ?>
                                        <?php if($paid->application_stage_status != 5): ?>
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        <?php else: ?>
                                         <form action="<?php echo e(route('payment',$prod->id)); ?>" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        <?php endif; ?>
                                       <?php endif; ?>

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                 <!-- first Ends -->

                                
                                <!-- Second Begins -->
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                           Second Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         <?php if($paid->second_payment_status =='PAID'): ?>
                                            Status PAID
                                         <?php else: ?>
                                            Status PENDING
                                         <?php endif; ?>

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>

                                           
                                        <?php if($paid->second_payment_status =='PAID'): ?>

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="<?php echo e(url('/get/invoice/Second Payment')); ?>">Get Invoice</a>
                                       <?php else: ?>
                                        <?php if($paid->application_stage_status != 5): ?>
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        <?php else: ?>
                                         <form action="<?php echo e(route('payment',$prod->id)); ?>" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        <?php endif; ?>
                                       <?php endif; ?>

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                 <!-- Second Ends -->
                                
                                <!-- Third Begins -->
                                <?php if($pays->third_payment_price > 0): ?>
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                           Third Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         <?php if($paid->third_payment_status =='PAID'): ?>
                                            Status PAID
                                         <?php else: ?>
                                            Status PENDING
                                         <?php endif; ?>

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>

                                           
                                        <?php if($paid->third_payment_status =='PAID'): ?>

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="<?php echo e(url('/get/invoice/Third Payment')); ?>">Get Invoice</a>
                                       <?php else: ?>
                                        <?php if($paid->application_stage_status != 5): ?>
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        <?php else: ?>
                                         <form action="<?php echo e(route('payment',$prod->id)); ?>" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        <?php endif; ?>

                                       <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                 <!-- Third Ends -->

                            </div>
                        </div>
                    </div>  


                    <?php if($paid->third_payment_status != 'PAID'): ?>
                    <div class="row" style="font-size:18px">
                        <div style="align-items: left; align:left; float: left; padding-left:40px;padding-right:40px" class="col-12">Your next payment is <b>

                          <?php if($paid->second_payment_status =='PAID'): ?>                    
                            <?php echo e($pays->third_payment_price); ?> AED
                            </b>, to be charged for Third Payment.
                          <?php elseif($paid->first_payment_status =='PAID'): ?>
                            <?php echo e($pays->second_payment_price); ?> AED
                            </b>, to be charged for Second Payment.
                          <?php elseif($paid->first_payment_status !='PAID' && $paid->second_payment_status !='PAID'): ?>

                           <?php if($paid->first_payment_remaining >0 && $paid->first_payment_status !='PAID'): ?>
                               <?php echo e($paid->first_payment_remaining); ?> AED
                                </b>, outstanding on First Payment.
                           <?php else: ?>
                                <?php echo e($pays->first_payment_price); ?> AED
                                </b>, to be charged for First Payment.
                           <?php endif; ?>
                          <?php endif; ?>

                        </div>
                    </div>
                    <?php endif; ?>

                </div>


            </div>
        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
</div>

<!-- jQuery -->
<script src="<?php echo e(asset('user/extra/js/jquery.min.js')); ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo e(asset('user/extra/js/bootstrap.min.js')); ?>"></script>

</body>

</html><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/paid_details.blade.php ENDPATH**/ ?>