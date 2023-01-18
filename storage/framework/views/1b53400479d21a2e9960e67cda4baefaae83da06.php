

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
        <div class="forgot-password" style="height: auto;">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/Approved.svg')); ?>" alt="approved">
                </div>
                <div class="reset-heading">
                    Reset your password
                </div>
                <div class="reset-title">
                    <p>Please enter code received on your mail</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="<?php echo e(route('customize.password.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="email" value="<?php echo e(old('email', $email)); ?>">
                        <div class="mb-3">
                            <div class="inputs"> 
                                <input type="text" class="form-control" name="otp" value="<?php echo e(old('otp')); ?>" aria-describedby="emailHelp" autocomplete="off" placeholder="########" required>
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
                            <div class="inputs-icon"> 
                                <input type="password" class="form-control passwordInput" aria-describedby="emailHelp" autocomplete="off" placeholder="New password" name="password" value="<?php echo e(old('password')); ?>" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <img src="<?php echo e(asset('images/Eye_Icon.png')); ?>" alt=img class="iconImg">
                                <img src="<?php echo e(asset('images/view_password.svg')); ?>" alt=img class="viewIcon">
                            </div>            
                        </div>
                        <div class="mb-3">
                            <div class="inputs-icon"> 
                                <input type="password" class="form-control confirmation" aria-describedby="emailHelp" autocomplete="off" placeholder="Confirm password" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>"  required>
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <img src="<?php echo e(asset('images/Eye_Icon.png')); ?>" alt=img id="cofirmation">
                                <img src="<?php echo e(asset('images/view_password.svg')); ?>" alt=img class="confirmation_viewIcon">
                            </div>            
                        </div>
                        <button type="submit" class="btn btn-primary submitBtn">Reset Password</button>
                    </form>
                </div>
                <div >
                    <form action="<?php echo e(route('customize.forgot.password')); ?>" method="POST"> <?php echo csrf_field(); ?><p class="subInfo"> Haven't received the email? Check your spam folder.<br>Still not there?  <input type="hidden" name="email" value="<?php echo e(old('email', $email)); ?>" /><button class="resendemail" type="submit"><a>Resend email</a></button></p></form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
  <script>
      $(document).ready(function() {
        //password
        $('.iconImg').show();
        $('.viewIcon').hide();
        $('.iconImg, .viewIcon').on('click', function(){
            var passInput=$(".passwordInput");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
                $('.iconImg').hide();
                $('.viewIcon').show();
            }else{
              passInput.attr('type','password');
              $('.iconImg').show();
              $('.viewIcon').hide();
            }
        })
        // confirm password
        $('.confirmation_viewIcon').hide();
        $('#cofirmation').show();
        $('#cofirmation, .confirmation_viewIcon').on('click', function(){
            var passInput=$(".confirmation");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
                $('.confirmation_viewIcon').show();
                $('#cofirmation').hide();
            }else{
              passInput.attr('type','password');
              $('.confirmation_viewIcon').hide();
              $('#cofirmation').show();
            }
        })
      });
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>