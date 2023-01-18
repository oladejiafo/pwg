
<style>
  .hiddenIcon,
  .viewIcon{
    cursor: pointer;
  }
</style>
<?php $__env->startSection('content'); ?>
  <div class="container">
      <div class="form-sec1">
        <div class="heading">
          <div class="first-heading">
              <h3>
                  Welcome Back
              </h3>
          </div>
          <div class="bottoom-title">
            <p>Please login with your account</p>
          </div>
        </div>
        <div class="tab-sec">
            <a href="<?php echo e(route('register')); ?>">Signup</a>
            <a href="<?php echo e(route('login')); ?>" class="signupBtn">Login</a>
        </div>
        <div class="form-sec">
          <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <div class="label"><label for="email1" class="form-label">Email or phone number</label></div>
              <div class="inputs"> 
                <input type="text" style="padding: 10px;" class="form-control w-full" id="exampleInputEmail1" name="auth" value="<?php echo e(old('auth')); ?>" aria-describedby="emailHelp" autocomplete="off" required autofocus >
                <?php $__errorArgs = ['auth'];
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
              <div class="label">
                <label for="Password" class="form-label">Password</label>
              </div>
              <div class="inputs-icon">
                <input type="password" class="form-control passwordInput" name="password" value="<?php echo e(old('password')); ?>" id="exampleInputPassword1" autocomplete="off" required autofocus>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <img src="<?php echo e(asset('images/Eye_Icon.png')); ?>" alt=img class="hiddenIcon">
                <img src="<?php echo e(asset('images/view_password.svg')); ?>" alt=img class="viewIcon">
              </div>
            </div>
            
            <button type="submit" class="btn btn-primary submitBtn">Login</button>
            <div class="bottom-sec">
                <div class="signuplink"><a href="<?php echo e(route('register')); ?>">Signup</a></div>
                <div class="forgot"><a href="<?php echo e(route('password.request')); ?>">forgot your password?</a></div>
            </div>
          </form>
        </div>
      </div>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $(document).ready(function() {
        $('.viewIcon').hide();
        $('.hiddenIcon').show();
        $('.hiddenIcon, .viewIcon').on('click', function(){
            var passInput=$(".passwordInput");
            if(passInput.attr('type')==='password')
              {
                passInput.attr('type','text');
                $('.viewIcon').show();
                $('.hiddenIcon').hide();
            }else{
              passInput.attr('type','password');
              $('.viewIcon').hide();
              $('.hiddenIcon').show();
            }
        })
      });
  </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/auth/login.blade.php ENDPATH**/ ?>