

<style>
    select,
    input [type="text"] {
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }

    
</style>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="forgot-password" style="height: 837px;">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/Approved.svg')); ?>" alt="approved">
                </div>
                <div class="reset-heading">
                    Reset your password
                </div>
                <div class="reset-title">
                    <p>Please enter code received</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="<?php echo e(route('customize.password.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="email" value="<?php echo e(old('email', $email)); ?>">
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" name="otp" aria-describedby="emailHelp" autocomplete="off" placeholder="########" required>
                                <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation" required>
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary submitBtn">Reset Password</button>
                    </form>
                </div>
                <div >
                    <p class="subInfo"> Haven't received the email? Check your spam folder.
                        <br>Still not there? <a href="<?php echo e(route('password.request')); ?>">Resend email</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>