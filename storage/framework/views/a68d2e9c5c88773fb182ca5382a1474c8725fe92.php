

<head>
    
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
  .btn {
    height: 60px;
    color: #000;
    font-size: 20px;
    width:80%;
  }
</style>
</head>

<?php $__env->startSection('content'); ?>
    <div class="login">
        <div class="container">
            <div class="forgot-password" >
                <div class="reset">
                    <div class="resetImage">
                        <img src="<?php echo e(asset('images/reminder.png')); ?>" width="100% " alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment need to be confirmed!
                    </div>
                    <div class="subConfirm">Your payment will be verified and you will be notified</div>
                    <div class="subConfirm">You can continue with application submission</div>
                    <div class="sig">
                        <form action="<?php echo e(url('applicant/details',$id)); ?>" method="GET">
                                <input type="hidden" name="pid" value="<?php echo e($id); ?>">
                                <button class="btn btn-primary ose">APPLICATION DETAILS</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/payment-confirm.blade.php ENDPATH**/ ?>