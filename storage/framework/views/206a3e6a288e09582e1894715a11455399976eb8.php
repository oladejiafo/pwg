
<!-- Theme style  -->
<link rel="stylesheet" href="<?php echo e(asset('user/extra/css/bootstrap.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('user/extra/css/styled.css')); ?>">

<div class="row cardd">


    <h4>WHITE COLLAR JOBS</h4>
    <?php $__currentLoopData = $whiteJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
        <div class="about-decc xxanimate-box">

            <div class="card fancy-collapse-panel">
                <div class="panel-group" id="accordionx" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default" style="background-color: #F5F5F5;border:none">
                        <div class="paneled-heading" role="tab" id="headings<?php echo e($pdet->id); ?>">
                            <h4 class="panel-title" style="padding-top:15px;padding-left:15px;">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionx" href="#collapsew<?php echo e($pdet->id); ?>" aria-expanded="true" aria-controls="collapsew<?php echo e($pdet->id); ?>"> &nbsp; <?php echo e($pdet->job_title); ?>

                                </a>
                            </h4>
                        </div>
                        <div id="collapsew<?php echo e($pdet->id); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headings<?php echo e($pdet->id); ?>">
                        <hr style="height:0.1px;border:none;color:#333;">
                            <div class="paneled-body">
                                        <p>
                                            <?php echo e($pdet->description); ?>

                                        </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<!-- jQuery -->
<script src="<?php echo e(asset('user/extra/js/jquery.min.js')); ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo e(asset('user/extra/js/bootstrap.min.js')); ?>"></script>

</body>

</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\white-collar-packge.blade.php ENDPATH**/ ?>