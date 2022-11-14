
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="toolbox">
                <div class="col-12">
                    <?php $lastId = null; ?>
                    <div class="presentation">
                        <?php $__currentLoopData = $presents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $present): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="toolbox-sec">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="toolbox-left-sec">
                                            <img src="<?php echo e(asset('storage/presentations/'.$present->image_url)); ?>"  width="100%" height="100%">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="toolbox-right-sec">
                                            <h1><?php echo e($present->title); ?></h1>
                                            <p class="toolbox-right-sub-head"><?php echo e($present->sub_title); ?></p>
                                            <p class="toolbox-right-desc">
                                                <?php echo substr($present->details,0,500); ?>

                                            </p>
                                            <input type="button" class="btn startCopy" value="Copy Link" onclick="Copy('<?php echo e($present->link_url); ?>');" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $lastId = $present->id; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row justify-content-md-center">
                        <button type="button" class="btn btn-default load">Load More <span class="loadImg"><img src="<?php echo e(asset('images/down_arrow.png')); ?>"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('affiliate-scripts'); ?>
    <script>
        var lastid = '<?php echo e($lastId); ?>';
        $('.load').click(function(){
            $.ajax({
                url:"<?php echo e(route('affiliate.loadmore.load_data')); ?>",
                method:"POST",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "lastid": lastid
                },
                success:function(response){  
                    console.log(response);
                    $.each(response, function( index, value ) {
                        $('.presentation').append('<div class="toolbox-sec"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><div class="toolbox-left-sec"><img src="'+value.full_image_url+'"  width="100%" height="100%"></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><div class="toolbox-right-sec"><h1>'+value.title+'</h1><p class="toolbox-right-sub-head">'+value.sub_title+'</p><p class="toolbox-right-desc">'+(value.details).substring(0,500)+'</p><input type="button" class="btn startCopy" value="Copy Link" onclick="Copy('+value.link_ur+');" /></div></div></div></div>');
                        lastid = value.id;
                    });
                }
            });
        });

        function Copy(copyText) {
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');  
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                'positionClass': 'toast-bottom-right',
            }
            toastr.info("Code copied!");
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('affiliate.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shakun\Desktop\myGit\PWG\resources\views/affiliate/toolbox.blade.php ENDPATH**/ ?>