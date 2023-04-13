<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>PWG Group</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/login.css')); ?>'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- bootstrap core css -->
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="login">
            <?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(session()->has('success')): ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" style="float:right">
                    
                </button>
                <?php echo e(session()->get('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session()->has('failed')): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" style="float:right">
                    
                </button>
                <?php echo e(session()->get('failed')); ?>

            </div>
        <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
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
  
          <?php if(Session::has('info')): ?>
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.info("<?php echo e(session('info')); ?>");
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
          <?php echo $__env->yieldPushContent('custom-scripts'); ?>

          <?php echo $__env->make('user/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/layouts/auth.blade.php ENDPATH**/ ?>