
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->startSection('content'); ?>
    <?php
        $payall = $_REQUEST['payall'];
        
        $prodd = DB::table('destinations')
            ->where('id', '=', $productId)
            ->orderBy('id', 'desc')
            ->first();
    ?>


    <?php if(Session::has('packageType')): ?>
        <?php
            $package = Session::get('packageType');
        ?>
    <?php endif; ?>

    <?php if(isset($prodd) && isset($package)): ?>
        <?php if($prodd->name == 'Czech'): ?>
            <?php $contract_name = "czech.pdf"; ?>
        <?php elseif($prodd->name == 'Malta'): ?>
            <?php $contract_name = "malta.pdf"; ?>
        <?php elseif($prodd->name == 'Canada'): ?>
            <?php if($package == 'Express Entry'): ?>
                <?php $contract_name = "canada_express_entry.pdf"; ?>
            <?php elseif($package == 'Study Permit'): ?>
                <?php $contract_name = "canada_study.pdf"; ?>
            <?php else: ?>
                <?php $contract_name = "canada.pdf"; ?>
            <?php endif; ?>
        <?php else: ?>
            <?php $contract_name = "poland.pdf"; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php $contract_name = "poland.pdf"; ?>
    <?php endif; ?>

    <div class="container">
        <div class="col-12">
            <div class="contract">
                <form method="get" action="<?php echo e(route('signature', $productId)); ?>" id="sign">
                    <input type="hidden" name="contract" value="<?php echo e($newFileName); ?>">
                    <div class="col-4 offset-4 contractLogo">
                        <img src="<?php echo e(asset('images/contract.svg')); ?>" width="100%" height="100%" alt="pwg">
                    </div>
                    <div class="header">
                        <h3>Contract</h3>
                        <div class="bottom-title">
                            <p>Please review the contract carefully</p>
                        </div>
                    </div>
                    <div class="contract-section">
                        <div class="col-12 col-md-8 col-lg-12 offset-md-2 offset-lg-2 contractZoomIn">
                            <div class="zoomIcon">
                                <img src="<?php echo e(asset('images/Magnifying_Glass.svg')); ?>" width="124px" height="124px"
                                    class="zoomOut" alt="pwg">
                            </div>
                            <div class="contractPdf">
                                <embed src="<?php echo e($fileUrl); ?>" type="application/pdf" />

                                
                            </div>
                        </div>
                        <div class="contractPreview">
                            <embed src="<?php echo e($fileUrl); ?>" type="application/pdf" />

                            
                        </div>
                        <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                            
                            <button type="button" class="btn btn-secondary zoomOut" id="zoom"
                                value="<?php echo e($payall); ?>" name="payall" style="width:100%; font-size:1.6em">ZOOM TO
                                REVIEW</button>
                            <button type="button" class="btn btn-secondary zoomIn" id="zoom"
                                value="<?php echo e($payall); ?>" name="payall" style="width:100%; font-size:1.6em">ZOOM TO
                                REVIEW</button>

                            <button type="submit" class="btn btn-secondary" id="signd" value="<?php echo e($payall); ?>"
                                name="payall" style="width:100%; font-size:1.6em;margin-top: 18px;">SIGNATURE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
    <script>
        $(document).ready(function() {
            $('.contractPreview').hide();
            $('.zoomIn').hide();
            $('.zoomOut').click(function() {
                $('.contractPreview').show();
                $('.contractZoomIn').hide();
                $('.zoomIn').show();
                $('.zoomOut').hide();
            })
            $('.zoomIn').click(function() {
                $('.zoomOut').show();
                $('.zoomIn').hide();
                $('.contractPreview').hide();
                $('.contractZoomIn').show();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/contract.blade.php ENDPATH**/ ?>