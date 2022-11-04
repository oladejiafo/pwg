

<style>
    @media (min-width: 375px) and (max-width: 768px)
    {
        .btn {
            margin: 0 0 0 0px;
            padding: 0;
            width:100%;
            align-self: center;

        }
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="forgot-password " style="padding-top:30px;margin-top:150px">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/forgot_password.svg')); ?>" alt="forgot password">
                </div>
                <div class="reset-heading">
                    It’s okay to reset your password
                </div>
                <div class="reset-title">
                    <p>Please login with your account</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="<?php echo e(route('customize.forgot.password')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" style="padding: 10px;text-align:left; font-size:16px" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" placeholder="Email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error" style="padding: 86px;text-align:left; font-size:16px"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>