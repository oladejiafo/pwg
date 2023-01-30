<!DOCTYPE html>

<html>

<?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- bootstrap core css -->
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="<?php echo e(asset('user/css/myapplication.css')); ?>" rel="stylesheet">

<body>

    <!-- Start Product Section -->
    <div class="paid-section">
     <?php if(Route::has('login')): ?>

      <?php if(isset($pays) && isset($paid)): ?>

            <?php if( $paid->destination_id > 0 && $paid->destination_id != null): ?>
              <?php echo $__env->make('user.paid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo $__env->make('user.paid_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
            <?php else: ?>
              <?php echo $__env->make('user.noapplication', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
      <?php else: ?> 
       <?php echo $__env->make('user.noapplication', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

     <?php endif; ?>

    </div>

    <?php echo $__env->make('user/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- End Product Section -->


    <script>
        <?php if(Session::has('message')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("<?php echo e(session('message')); ?>");
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>

        <?php if(Session::has('warning')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.warning("<?php echo e(session('warning')); ?>");
        <?php endif; ?>
    </script>
</body>
</html>


<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/myapplication.blade.php ENDPATH**/ ?>