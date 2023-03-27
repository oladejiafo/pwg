<!DOCTYPE html>
<html lang="en">
    <?php echo $__env->make('affiliate.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <body>
        <?php echo $__env->yieldContent('content'); ?>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo e(asset('user/extra/assets/js/jquery-min.js')); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <?php echo $__env->yieldPushContent('affiliate-scripts'); ?>
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

            <?php if(Session::has('loginId')): ?>
            <?php else: ?>
                $(".navbar-toggler").css("display", "none");
            <?php endif; ?>
        </script>
    </body>
</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/layout/master.blade.php ENDPATH**/ ?>