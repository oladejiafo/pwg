<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<div style="margin-bottom: 30px"></div>

<?php $__env->endSlot(); ?>


<?php echo e($slot); ?>




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
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/vendor/mail/html/message.blade.php ENDPATH**/ ?>