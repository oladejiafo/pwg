

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
            <div class="forgot-password">
                <div class="reset">
                    <div class="resetImage">
                        <img src="<?php echo e(asset('images/Failed_Mark.svg')); ?>" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment unsuccessful !
                    </div>
                    <div class="subConfirm">We are unable to complete the transaction</div>
                    <?php if(Session::has('paymentError')): ?>
                    <div class="subConfirm"><?php echo e(Session::get('paymentError')); ?></div>
                    <?php endif; ?>
                    <div class="sig">
                        <form action="<?php echo e(route('payment',$id)); ?>" method="GET">
                            <input type="hidden" name="pid" value="<?php echo e($id); ?>">
                            <button  style="font-size:20px;" class="btn btn-primary ose">TRY AGAIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/payment-fail.blade.php ENDPATH**/ ?>