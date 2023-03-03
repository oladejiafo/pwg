
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="<?php echo e(asset('css/payment-form.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/alert.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="../user/extra/css/signature-pad.css">

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
    <script>window.location = "/home";</script>
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
                                    
                                    <div class="toast-container"><div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/payment-form.blade.php ENDPATH**/ ?>