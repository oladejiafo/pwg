<!DOCTYPE html>
<html lang="en">
    <?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    #info{
        font-size: 1.2em;
    }
    #info-sub{
        font-size: 0.8em;
    }

    svg .ft{
        height:80px; 
        width:80px;
    }
    @media (max-width:800px){
        #info{
        font-size: 1.0rem;
    }
    #info-sub{
        font-size: 0.8rem;
    }
    svg .ft{
        height:40px; 
        width:40px;
    }
    }
</style>
    <body>
        
        <?php if(session()->has('success')): ?>
        <div class="alert alert-success alert-block" style="color:#fff; padding:2px; margin-left:auto;margin-right:auto; width:45%;height:120px; text-align:center;margin-bottom:-80px;background-colorx:green;border-radius:10px">
        <button type="button" class="close" data-dismiss="alert" style="float:right;border-style:none;background-color: transparent"><i class="fa fa-times-circle" aria-hidden="true" style="color:#000; font-size:25px";></i>
                    
                    </button>
                <h3 style="padding-top: 20px;font-size: 1.8em">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 300 300">
                    <defs>
                        <style>
                        .cls-1{fill:url(#linear-gradient);}
                        .cls-2{fill:url(#linear-gradient-2);}
                        </style>
                        <linearGradient id="linear-gradient" x1="-51.86" y1="150" x2="303.13" y2="150" gradientUnits="userSpaceOnUse">
                        <stop offset="0.02" stop-color="#fff"/>
                        <stop offset="0.15" stop-color="#fff"/>
                        </linearGradient>
                        <linearGradient id="linear-gradient-2" x1="47.83" y1="140.38" x2="283.31" y2="140.38" xlink:href="#linear-gradient"/>
                    </defs>
                    <g id="Email_confirmation" data-name="Email confirmation">
                    <path class="cls-1" d="M289.53,94.94,288,91.2l-6.1,6.1.63,1.61a141.32,141.32,0,0,1,9.5,51.09c0,78.34-63.73,142.07-142.07,142.07S7.93,228.34,7.93,150,71.66,7.93,150,7.93A141.68,141.68,0,0,1,259.48,59.58l1.85,2.24L267,56.18l-1.54-1.86A149.67,149.67,0,0,0,150,0C67.29,0,0,67.29,0,150S67.29,300,150,300s150-67.29,150-150A148.76,148.76,0,0,0,289.53,94.94Z"/>
                    <path class="cls-2" d="M279,72.21a4,4,0,0,0-5.61,0L147.1,198.49,89.77,141.17a4,4,0,0,0-5.61,5.61l62.94,62.93L279,77.81A4,4,0,0,0,279,72.21Z"/>
                    </g>
                </svg>
                <!-- <img src="../user/images/Approved.svg" height="80px" width="80px"> &nbsp; -->
                <span><?php echo e(session()->get('success')); ?></span></h3>
            </div>
        <?php endif; ?>

        <?php if(session()->has('failed')): ?>
            <div class="alert alert-danger" style="margin-left:auto;margin-right:auto; width:40%; text-align:center;margin-bottom:20px">
            <button type="button" class="close" data-dismiss="alert" style="float:right;border-style:none;background-color: transparent"><i class="fa fa-times-circle" aria-hidden="true" style="color:#000; font-size:25px";></i>
                    
                    </button>
                <strong><?php echo e(session()->get('failed')); ?></strong>
            </div>
        <?php endif; ?>
        <?php if(session()->has('info')): ?>
            <div class="alert alert-infox alert-block">
                <button type="button" class="close" data-dismiss="alert" style="float:right;border-style:none;background-color: transparent"><i class="fa fa-times-circle" aria-hidden="true" style="color:#fff; font-size:25px";></i>
                    
                </button>
                <p style="padding-top: 20px;font-size: 1.8em;line-height:0px">
                <svg class="ft" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 300 300" >
                    <defs>
                        <style>
                        .cls-1{fill:url(#linear-gradient);}
                        .cls-2{fill:url(#linear-gradient-2);}
                        </style>
                        <linearGradient id="linear-gradient" x1="-51.86" y1="150" x2="303.13" y2="150" gradientUnits="userSpaceOnUse">
                        <stop offset="0.02" stop-color="#fff"/>
                        <stop offset="0.15" stop-color="#fff"/>
                        </linearGradient>
                        <linearGradient id="linear-gradient-2" x1="47.83" y1="140.38" x2="283.31" y2="140.38" xlink:href="#linear-gradient"/>
                    </defs>
                    <g id="Email_confirmation" data-name="Email confirmation">
                    <path class="cls-1" d="M289.53,94.94,288,91.2l-6.1,6.1.63,1.61a141.32,141.32,0,0,1,9.5,51.09c0,78.34-63.73,142.07-142.07,142.07S7.93,228.34,7.93,150,71.66,7.93,150,7.93A141.68,141.68,0,0,1,259.48,59.58l1.85,2.24L267,56.18l-1.54-1.86A149.67,149.67,0,0,0,150,0C67.29,0,0,67.29,0,150S67.29,300,150,300s150-67.29,150-150A148.76,148.76,0,0,0,289.53,94.94Z"/>
                    <path class="cls-2" d="M279,72.21a4,4,0,0,0-5.61,0L147.1,198.49,89.77,141.17a4,4,0,0,0-5.61,5.61l62.94,62.93L279,77.81A4,4,0,0,0,279,72.21Z"/>
                    </g>
                </svg> &nbsp;
                <!-- <img src="../user/images/Approved.svg" height="80px" width="80px"> &nbsp; -->
                <span id="info" style="margin-bottom:0px;line-height:0px"><?php echo e(session()->get('info')); ?></span>
                <?php if(session()->has('info_sub')): ?>
                <br><span id="info-sub" style="line-height:0px; ;"><?php echo e(session()->get('info_sub')); ?></span>
                <?php endif; ?>
               </p>
            </div>
        <?php endif; ?>

    <div class="login">
        
        <?php echo $__env->yieldContent('content'); ?>
    </div>
     <!--  load jQuery  -->

     <!--load JS for Select2 -->    
    <script>
        <?php if(Session::has('message')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("<?php echo e(session('message')); ?>");
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>

        // <?php if(Session::has('info')): ?>
        // toastr.options =
        // {
        //     "closeButton" : true,
        //     "progressBar" : true
        // }
        //         toastr.info("<?php echo e(session('info')); ?>");
        // <?php endif; ?>

        <?php if(Session::has('warning')): ?>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.warning("<?php echo e(session('warning')); ?>");
        <?php endif; ?>
    </script>
        <?php echo $__env->yieldPushContent('custom-scripts'); ?>
</body>
</html><?php /**PATH C:\Users\shakun\Desktop\myGit\PWG\resources\views/layouts/master.blade.php ENDPATH**/ ?>