<?php $attributes = $attributes->exceptProps(['disabled' => false]); ?>
<?php foreach (array_filter((['disabled' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<style>
        input [type='Text'],
        input [type='number'],
        input [type='password'],
        select {
        /* width: 350px !important; */
        height:60px !important; 
 
        text-align:center !important; 
        color:#000 !important; 
        font-family:'TT Norms Pro' !important; 
        font-weight:700 !important;
        border-color: #6b7280 !important;
        border-width: 1px !important;
    }

    @media (min-width:375px) and (max-width:768px){
        button {
        width: 90% !important;
        height:50px !important; 
      }   
      input [type='Text'] {
        width: 100% !important;
        padding: 0px;
        margin: 0px;
      }
    }
</style>

<input style="height: 60px;" <?php echo e($disabled ? 'disabled' : ''); ?> <?php echo $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']); ?>>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\vendor\jetstream\components\input.blade.php ENDPATH**/ ?>