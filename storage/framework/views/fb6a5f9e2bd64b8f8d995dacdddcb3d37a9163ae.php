<?php $attributes = $attributes->exceptProps(['submit']); ?>
<?php foreach (array_filter((['submit']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div style="border-color:#fff;border-style:hidden" <?php echo e($attributes->merge(['class' => 'md:grid md:grid-cols-1 md:gap-6'])); ?>>


    <div style="border-color:#fff;border-style:hidden" class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="<?php echo e($submit); ?>">
            <div class="px-4 py-5 bg-white sm:p-6  <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
                <div class="gridx grid-cols-6x gap-6">
                    <?php echo e($form); ?>

                </div>
                <?php if(isset($actions)): ?>
                <div class="flex items-center justify-center px-4 py-3 text-right sm:px-6  sm:rounded-bl-md sm:rounded-br-md">
                    <?php echo e($actions); ?>

                </div>
            <?php endif; ?>
            </div>


        </form>
    </div>
</div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\vendor\jetstream\components\form-section.blade.php ENDPATH**/ ?>