<style>
    .footer {
        font-size: 15px;
    }

    .footer a {
        font-size: 15px;
        margin: 0px;
    }

    .footer a:hover {
        color: blue;
    }

    hr {
        border: 2px solid #fff;
    }

    @media (max-width:360px) {
        .footer {
            font-size: 12px;
        }

        .footer a {
            font-size: 12px;
            margin: 0px;
        }
    }
</style>
<div class="footer" align="right" style="padding:20px; ">
    <hr>
    &copy <?php echo e(date('Y')); ?> <a style="" href="http://pwggroup.ae" target="_blank">PWG Group</a>. All rights
    reserved.
</div>

<?php if(!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)): ?> 
<script>
    //Disable right click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
        return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
        // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
        if (
            event.keyCode === 123 ||
            ctrlShiftKey(e, 'I') ||
            ctrlShiftKey(e, 'J') ||
            ctrlShiftKey(e, 'C') ||
            (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
        )
            return false;
    };
</script>
<?php endif; ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/footer.blade.php ENDPATH**/ ?>