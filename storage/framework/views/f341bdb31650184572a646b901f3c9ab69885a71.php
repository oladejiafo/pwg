
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="forgot-password">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/Approved.svg')); ?>" alt="approved">
                </div>
                <div class="reset-heading">
                Check your mailbox !
                </div>
                <div class="subConfirm">to confirm this email belongs to you</div>
                <div class="reset-title">
                    <p>we have sent a confirmation email to your inbox for response please ensure to check your spam box incase you cannot find in your inbox.</p>
                </div>
                <div class="form-sec">
                    <a href="<?php echo e(route('login')); ?>" style="color: #606060"><button class="btn btn-primary submitBtn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>