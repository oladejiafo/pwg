
<style>
    #text {
        text-decoration: none;
        color: #02c3fa;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="bannerImageDashboard">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 land-left-sec">
                            <div class="row">
                                <h1 class="land-font-dashboard">
                                    Referrals &<br>
                                    Affiliate <br>
                                    Program <br>
                                </h1>
                            </div>
                            <div class="row">
                                <p class="left-sub-dashboard">
                                    Recommend clients. Start earning immediately.
                                    <br>
                                    We are for people !
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 land-right-sec">
                            <div class="landingpageicondashboard">
                                <img src="<?php echo e(asset('/images/affiliate/Landingpageicon.svg')); ?>" width="100%" height="100%">
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">My Refferal Code: <a href="javascript:void(0);" id="text" onclick="copyToClipboard('#text')" title="Click to copy code"><?php echo e(Session::get('ref_code')); ?></a></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">

        <!-- <div class="row align-items-center justify-content-center"> -->

            <div class="steps-dashboard">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="current-available">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-group">
                                            <a href="#">
                                                <span class="head">Current Available Revenue</span>
                                                <img src="<?php echo e(asset('images/affiliate/Bargraph.svg')); ?>" class="bargraph">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h5 class="card-title">$1,456</h5>
                                        <p class="card-text"> 
                                            <i class="fa fa-plus-circle"></i>
                                            5% higher than last month</p>
                                        <div class="align-items-center justify-content-center" style="text-align: center;">
                                            <a href="#" class="btn transfer">Transfer <i class="fa fa-exchange fa-2xs" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="total-refferals">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-group">
                                            <a href="#">
                                            
                                                <span class="head">Total Refferals</span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h5 class="card-title">109</h5>
                                        <p class="card-text"> 
                                            <i class="fa fa-plus-circle"></i>
                                            9% higher than last month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="total-earn">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-group">
                                            <a href="#">
                                                <span class="head">Total Amount Earned</span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h5 class="card-title">$3,456</h5>
                                        <p class="card-text"> 
                                            <i class="fa fa-plus-circle"></i>
                                            3% lower than last month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-md-center">
            <div class="recommend align-items-center justify-content-md-center">
                <h6>Recommended for you</h6>
                <div class="row">
                    <div class="col news1">
                        <img src="<?php echo e(asset('images/affiliate/news1.png')); ?>">
                        <p class="sub-cont">Learn Polish in 6 weeks</p>
                    </div>
                    <div class="col news2">
                        <img src="<?php echo e(asset('images/affiliate/news2.png')); ?>">
                    </div>
                    <div class="col news3">
                        <img src="<?php echo e(asset('images/affiliate/news3.png')); ?>">
                    </div>
                    <div class="col news4">
                        <img src="<?php echo e(asset('images/affiliate/news4.png')); ?>">
                    </div>
                    <div class="col news5">
                        <img src="<?php echo e(asset('images/affiliate/news5.png')); ?>">
                        <p>Learn Polish in 6 weeks</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                'positionClass': 'toast-bottom-right',
            }
        toastr.info("Code copied!");
    }
</script>
<?php echo $__env->make('affiliate.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/dashboard.blade.php ENDPATH**/ ?>