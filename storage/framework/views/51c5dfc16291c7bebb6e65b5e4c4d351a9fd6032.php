
<div id="tbod">
<?php

// Post::where('Expiration_date','<',Carbon::now())->delete();

$notifications = DB::table('notifications')
->where('client_id', '=', Auth::user()->id)
->orderBy('id', 'desc')
->orderBy('status', 'desc')
->limit(5)
->get();

?>

<?php if($notifications->first()): ?>

<div class="row">
<!-- javascript:void(0) -->
        <div class="col px-3 m-2"><b>NOTIFICATIONS</b></div>
            <div align="right" class="col mb-2" style="margin-right:25px;margin-top:2px">
            <a href="#" id="noty" style="text-decoration:blue; font-size:11px;color:blue"><i>Mark all as read</i></a>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div style="overflow-y: scroll; height:500px">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($notify->status =="Unread"): ?>
        <style>
            #notificationDropdown img {
            content: url("<?php echo e(asset('user/images/Notification.svg')); ?>");
            }
        </style>
        <a class="dropdown-item preview-item" href="#" style="background-color:#FAFDFE !important;color:#000 !important; font-weight:bold !important">
        <?php else: ?>  
        <a class="dropdown-item preview-item" href="#" style="background-color:transparent !important;">
        <?php endif; ?>

        <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
               <i class="mdi mdi-calendar text-success"></i>
            </div>
        </div>
        
        <div class="preview-item-content"  style="width:80%;word-wrap: break-word;">

            <p class="preview-subject mb-1"><b><?php echo e($notify->criteria); ?></b></p>
            
        <?php if($notify->status =="Unread"): ?>
            <p class="text-muted ellipsis mb-0"  style="width:80%;word-wrap: break-word; color:#000 !important; font-weight:500 !important"><?php echo e($notify->message); ?></p>
        <?php else: ?>
            <p class="text-muted ellipsis mb-0"  style="width:80%;word-wrap: break-word;"><?php echo e($notify->message); ?></p>
        <?php endif; ?>
            <p class="text-muted ellipsis mb-0"><?php echo e($notify->link); ?></p>
        </div>
    </a>

        <?php if(!$loop->last): ?>
            <div class="dropdown-divider"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
</div>
<?php endif; ?>

<!-- <p class="p-3 mb-0 text-center">See all notifications</p> -->
<script src="<?php echo e(asset('user/extra/assets/js/jquery-min.js')); ?>"></script>

<script>
    $('#noty').on('click', function(e){
        e.preventDefault(); //1

        var $this = $(this); //alias form reference
        $.ajax({ //2
            url: '<?php echo e(route("mark_read")); ?>',
            method: 'POST',
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
            }
        }).done( function (response) {  
            if (response) {
                $('#tbod').load(document.URL +  ' #tbod');
                // $('#target-div').html(response.status); 
            }
        });
    });

</script><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/notifications.blade.php ENDPATH**/ ?>