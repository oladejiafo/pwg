<?php $__env->startComponent('mail::message'); ?>
<div class="mailHeadImage" style="width: 400px;height: 250px;display: block;margin: 30px auto;">
    <img src="<?php echo e(asset('images/verifyemail.png')); ?>" alt="" width="100%" height="100%">
</div>

<?php if(! empty($greeting)): ?>
# <?php echo e($greeting); ?>

<?php else: ?>
<?php if($level === 'error'): ?>
# <?php echo app('translator')->get('Whoops!'); ?>
<?php else: ?>
# <?php echo app('translator')->get('Email Verification'); ?>
<?php endif; ?>
<?php endif; ?>


<?php $__currentLoopData = $introLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($line); ?>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(isset($actionText)): ?>
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
<?php $__env->startComponent('mail::button', ['url' => $actionUrl, 'color' => $color]); ?>
<?php echo e($actionText); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


<?php $__currentLoopData = $outroLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($line); ?>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php if(isset($actionText)): ?>
<?php $__env->slot('subcopy'); ?>
<?php echo app('translator')->get(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
); ?> <span class="break-all">[<?php echo e($displayableActionUrl); ?>](<?php echo e($actionUrl); ?>)</span><br><br>
<?php echo app('translator')->get('Thank you'); ?>,<br>The <b style="font-weight: bold">PWG Group Team</b>
<hr style="margin-left: -33px; margin-right:-33px !important;color:#383838;height:0.25px">

<div style="display: block; margin-top:50px;text-align: center;">
    <div style="width:65%; display:inline-block;margin:auto;">
        <div style="float:right; height: 20%">
            <img src="<?php echo e(asset('images/mailfooter.png')); ?>" alt="" width="100%" height="100%">
        </div>
    </div>
</div>
<?php $__env->endSlot(); ?>
<?php endif; ?>





<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/vendor/notifications/email.blade.php ENDPATH**/ ?>