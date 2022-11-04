

<style>
    select,
    input [type="text"] {
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }

    .link-button {
    background: none;
    border: none;
    color: blue;
    text-decoration: none;
    cursor: pointer;
    }
    .link-button:focus {
    outline: none;
    }
    .link-button:active {
    color:red;
    }
</style>
<?php  $email = Session::get('email'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="forgot-password" style="height: auto;padding-top:30px;margin-top:100px">
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
                    <form method="POST" action="<?php echo e(route('affiliate.passwordUpdate')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="email" value="<?php echo e(old('email',$email)); ?>">
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

                        <form method="POST" action="<?php echo e(route('affiliate.PasswordRequest')); ?>">
                        <?php echo csrf_field(); ?>
                        <p class="subInfo"> 

                        <input type="hidden" name="email" value="<?php echo e(Session::get('email')); ?>">
                        Haven't received the email? Check your spam folder.<br>
                        Still not there?<button type="submit" name="submit_param" value="submit_value" class="link-button">Resend email</button>
                        </p>                        
                        </form>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\affiliate\auth\reset-password.blade.php ENDPATH**/ ?>