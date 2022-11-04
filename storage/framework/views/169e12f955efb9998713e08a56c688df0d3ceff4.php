

<head>
    
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
  .btn {
    height: 60px;
    color: #000;
    font-size: 20px;
    width:80%;
  }
</style>
</head>

<?php $__env->startSection('content'); ?>
    <div class="login">
        <div class="container" style="margin-top: 130px;">
            <div class="forgot-password" style="padding-top: 30px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src="<?php echo e(asset('images/Approved.svg')); ?>" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Awesome !
                    </div>
                    <div class="subConfirm">Your signature has been uploaded successfully</div>
                    <div class="sig">
                        <form action="<?php echo e(route('payment',$data->id)); ?>" method="GET">
                            <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                            <button  style="font-size:20px;" class="btn btn-primary ose">Proceed To Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\signature-upload-success.blade.php ENDPATH**/ ?>