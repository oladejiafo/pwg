<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<div style="margin-bottom: 30px"></div>

<?php $__env->endSlot(); ?>


<?php echo e($slot); ?>



<hr style="margin-left: -33px; margin-right:-33px !important;color:#383838;height:0.25px">

<div style="display: block; margin-top:50px;text-align: center;">
    <div style="width:65%; display:inline-block;margin:auto;">
        <div style="float:right; height: 20%">
            <img src="<?php echo e(asset('images/mailfooter.png')); ?>" alt="" width="100%" height="100%">
        </div>
    </div>
</div>
<?php if(isset($subcopy)): ?>
<?php $__env->slot('subcopy'); ?>
<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e($subcopy); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php endif; ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/vendor/mail/html/message.blade.php ENDPATH**/ ?>