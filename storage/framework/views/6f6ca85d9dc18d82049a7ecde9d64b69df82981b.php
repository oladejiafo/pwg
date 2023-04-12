
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/> -->

<style>
  .checkcolor {
  accent-color: #f9bf29;

}

select,
textarea,
input [type="text"],
input [type="number"],
input [type="password"],
input [type="date"],
input [type="email"],
input [type="phone"]
{
  padding: 10px;
}
</style>

<?php
// $agents = DB::table('employees')
// ->select('name','sur_name')
// ->where('is_active', '=', 1)
// ->whereRaw('name != ""')
// ->whereIn('designation_id', [1,33,35])
// ->orderBy('id','asc')
// ->get();
?>
<?php if(isset($_REQUEST['pid'])): ?>
<?php 
session_start(); 
  Session::put('prod_id', $_REQUEST['pid']);
?>
<?php else: ?>
<?php   Session::forget('prod_id'); ?>                         
<?php endif; ?>
<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="form-sec1">
      <div class="heading">
        <div class="first-heading">
          <h3>
            Let's get you started!
          </h3>
        </div>
        <div class="bottoom-title">
          <p>Please create your account</p>
        </div>
      </div>
      <div class="tab-sec">
        <a href="<?php echo e(route('register')); ?>" class="signupBtn">Signup</a>
        
      </div>
      <div class="form-sec">
        <form method="POST" action="<?php echo e(route('register')); ?>">
          <?php echo csrf_field(); ?>
          <div class="mb-3">
            <div class="label"><label for="name" class="form-label">Name</label></div>
            <div class="inputs">
              <input type="text" style="padding: 10px;" class="form-control" id="exampleInputName" name="name" aria-describedby="emailHelp" autocomplete="off" required value="<?php echo e(old('name')); ?>">
            </div>
          </div>
          <div class="mb-3">
            <div class="label"><label for="email" class="form-label">Email</label></div>
            <div class="inputs">
              <input type="email" style="padding: 10px;" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" autocomplete="off" required value="<?php echo e(old('email')); ?>">
              <?php $__errorArgs = ['email'];
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
            <div class="label"><label for="phone number" class="form-label">Phone number</label></div>
            <div class="inputs">
              
              <input type="tel" style="paddingx: 10px;" class="form-control phone_number" id="phone_number" name="phone_number" aria-describedby="emailHelp" autocomplete="off" required value="<?php echo e(old('phone_number')); ?>" required="">
              <?php $__errorArgs = ['phone_number'];
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
              <input type="password" class="form-control passwordInput" id="exampleInputPassword1" name="password" autocomplete="off" required>
              <img src="<?php echo e(asset('images/Eye_Icon.png')); ?>" alt="pwg img" class="iconImg">
              <img src="<?php echo e(asset('images/view_password.svg')); ?>" alt="pwg img" class="viewIcon">
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
            <div class="label"><label for="email1" class="form-label">Confirm Password</label></div>
            <div class="inputs-icon">
              <input type="password" class="form-control confirmation" name="password_confirmation" aria-describedby="emailHelp" autocomplete="off" required>
              <img src="<?php echo e(asset('images/Eye_Icon.png')); ?>" alt="pwg img" id="cofirmation">
              <img src="<?php echo e(asset('images/view_password.svg')); ?>" alt="pwg img" class="confirmation_viewIcon">
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
            <div class="label">
              <label for="Agent" class="form-label">Your Agent Name/Partner Code</label>
            </div>
            <div class="inputs-iconx">
              <input  name="agent" class="agent form-control" type="text" autocomplete="off" placeholder="Type Your Agent/Partner Code" required="">
              
              <?php $__errorArgs = ['agent'];
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
            <span>By continuing you agree to the <a style="margin-left:0px" href="<?php echo e(route('terms')); ?>" target="_blank"><u>Terms & Conditions</u></a></span>
            
          </div>
          <button type="submit" class="btn btn-primary submitBtn">Signup</button>
          <div class="bottom-sec">
            <div class="signuplink">If you already registered, <a style="font-weight:700; margin-left:0px" href="<?php echo e(route('login')); ?>">Login</a> now</div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
      // $(function () {
      //       var code = "+91"; // Assigning value from model.
      //       const phoneInputField = document.querySelector("#phone_number").val(code);
      //       const phoneInput = window.intlTelInput(phoneInputField, {
      //           initialCountry: "ae",
      //           utilsScript:
      //               "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      //           z
      //       });

      // $('#phone_number').val(code);
      // $('#phone_number').intlTelInput({
      //     autoHideDialCode: true,
      //     autoPlaceholder: "ON",
      //     dropdownContainer: document.body,
      //     formatOnDisplay: true,
      //     hiddenInput: "full_number",
      //     initialCountry: "auto",
      //     nationalMode: true,
      //     placeholderNumberType: "MOBILE",
      //     preferredCountries: ['US'],
      //     separateDialCode: true,
      //     utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
      // });
            
      var phone_number = window.intlTelInput(document.querySelector("#phone_number"), {
        separateDialCode: false,
        preferredCountries:["ae"],
        nationalMode: false,
        hiddenInput: "full",
        autoHideDialCode: false,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
      });

    $("form").submit(function() {
      var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
      $("input[id='phone_number'").val(full_number);
    });

      // $('#submitBtn').on('click', function () {
      //     var code = $("#phone_number").intlTelInput("getSelectedCountryData").dialCode;
      //     var phoneNumber = $('#phone_number').val();
      //     var name = $("#phone_number").intlTelInput("getSelectedCountryData").name;
      //     alert('Country Code : ' + code + '\nPhone Number : ' + phoneNumber + '\nCountry Name : ' + name);
      // });
        // });
  </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/auth/register.blade.php ENDPATH**/ ?>