<style>
        button {
        width: 350px !important;
        height:60px !important; 
        text-align:center !important; 
        color:#000 !important; 
        font-family:'TT Norms Pro' !important; 
        font-weight:700 !important;
        font-size: 30px !important;
        /* border-color: #6b7280 !important;
        border-width: 1px !important; */
        margin: 0 auto !important;

    }

    .dg button {
        font-size: 20px !important;
    }

    .dgg button {
        font-size: 20px !important;
        margin: auto;
    }

    @media (min-width:375px) and (max-width:768px){
        button {
        width: 90% !important;
        height:50px !important; 
        font-size: 24px !important;
      }   
    }
</style>

<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 btn btn-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <?php echo e($slot); ?>

</button>

<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/vendor/jetstream/components/button.blade.php ENDPATH**/ ?>