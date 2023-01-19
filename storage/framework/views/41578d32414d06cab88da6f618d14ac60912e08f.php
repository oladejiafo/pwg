
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="forgot-password" style="width: 450px;">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/Approved.svg')); ?>" alt="approved">
                </div>
                <div class="reset-heading">
                    Woohoo !
                </div>
                <div class="reset-title">
                    <p>Password reset successfully !</p>
                    <p>Please login with your new password</p>
                </div>
                <div class="form-sec">
                    <a href="<?php echo e(route('login')); ?>" style="color: #606060"><button class="btn btn-primary submitBtn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/auth/reset-password-success.blade.php ENDPATH**/ ?>