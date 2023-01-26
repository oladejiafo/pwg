
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">

<style>
  .selected path {
    fill: #000;
  }


@media (max-width:800px)
{
    .package {
        padding: 20px 5% !important;
    }
    h3 {
        font-size: 25px !important;
        text-align: center !important;
    }
    p {
        text-align: center;
        font-size: 20px;
    }
    .package-type{
        margin: 20px;
        /* width: 100%; */
        padding: 0px !important;
        /* height: 350px; */
    }
    .package-type img {
    width:100px; 
    /* height:120px; */
 }
}
</style>


<?php $__env->startSection('content'); ?>

<?php if($canadaOthers->first()): ?>

<?php 
$cSamount=0;
$cXamount=0;
?>
<?php $__currentLoopData = $canadaOthers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php if($canada->pricing_plan_type == "Study Permit"): ?>
<?php  
  $cSname = $canada->pricing_plan_type;
  $cSamount =$cSamount + $canada->total_price;
?>
<?php endif; ?>

<?php if($canada->pricing_plan_type == "Express Entry"): ?>
<?php  
  $cXname = $canada->pricing_plan_type;
  $cXamount = $cXamount + $canada->total_price;
?>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>

    <div class="container" style="margin-top: 150px;">
        <div class="col-12">
            <div class="package">
                <div class="header">
                    <h3><?php echo e($data->name); ?> Package Types</h3>
                    <div class="bottoom-title">
                        <p>We’ve got you covered</p>
                    </div>
                </div>
                
                <div class="row" style="margin-left:auto; margin-right:auto; text-align:center;justify-content: center; display: flex;">
                
                      <?php if($proddet->first()): ?>
                        <?php $__currentLoopData = $proddet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prdet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($loop->first): ?>
                    
                            <?php                                   
                            $blue_cost = $prdet->total_price
                            ?> 

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?> 
                        <?php                                   
                            $blue_cost = 0
                            ?>
                        <?php endif; ?>

                    <div class="col-xs-6 col-md-4" style="display:inline-block;">
                        <div class="package-type blue-collar">
                            <div class="content">
                            <div class="dataCompletedx" id="blueSelect">
                                <img class="selected" style="width:30px" src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                            </div>
                                <img src="<?php echo e(asset('images/yellowWhiteCollar.svg')); ?>" alt="PWG Group">
                                <h6>Blue Collar Package</h6>
                                <p class="amountSection"><span class="amount"><?php echo e(number_format($blue_cost,0)); ?></span><b style="font-size:15px">AED</b></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($data->name == "Canada" && $canada->is_active==1): ?>
                    <div class="col-xs-12 col-md-4" style="display:inline-block;">
                        <div class="package-type  study-permit">                            
                            <div class="content">
                             <div class="dataCompletedx" id="studySelect">
                                <img class="selected" style="width:30px" src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                             </div>
                                <img src="<?php echo e(asset('images/yellowBlueCollar.svg')); ?>" alt="PWG Group">

                                <h6><?php echo e($cSname); ?> Package</h6>
                                <p class="amountSection"><span class="amount"><?php echo e(($cSamount > 0) ? number_format($cSamount,0) : 0); ?></span><b style="font-size:15px">AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4" style="display:inline-block;">
                        <div class="package-type  express-entry">                            
                            <div class="content">
                             <div class="dataCompletedx" id="expressSelect">
                                <img class="selected" style="width:30px" src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                             </div>
                                <img src="<?php echo e(asset('images/yellowFamily.svg')); ?>" alt="PWG Group">

                                <h6><?php echo e($cXname); ?> </h6>
                                <p class="amountSection"><span class="amount"><?php echo e(($cXamount > 0) ? number_format($cXamount,0) : 0); ?></span><b style="font-size:15px">AED</b></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>



                        <?php if($whiteJobs->first()): ?>
                        <?php $__currentLoopData = $whiteJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $whiteJob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($loop->first): ?>
                        
                            <?php                                   
                            $whiteJob_cost = $whiteJob->total_price
                            ?> 

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?> 
                        <?php                                   
                            $whiteJob_cost = 0
                            ?>
                        <?php endif; ?>

                       <?php if(isset($whiteJob_cost) && $whiteJob_cost > 0): ?>
                       <div class="col-xs-12 col-md-4" style="display:inline-block;">
                        <div class="package-type  white-collar">                            
                            <div class="content">
                             <div class="dataCompletedx" id="whiteSelect">
                                <img class="selected" style="width:30px" src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                             </div>
                                <img src="<?php echo e(asset('images/yellowBlueCollar.svg')); ?>" alt="PWG Group">

                                <h6>White Collar Package</h6>
                                <p class="amountSection"><span class="amount"><?php echo e(($whiteJob_cost > 0) ? number_format($whiteJob_cost,0) : 0); ?></span><b style="font-size:15px">AED</b></p>
                                                      
                                   <?php if($whiteJob_cost == 0): ?>
                                   <p style="font-size: 14px">
                                     Package Not Available 
                                   </p> 
                                   <?php endif; ?>
                                
                            </div>
                        </div>
                        </div>
                        <?php endif; ?>


                    <?php if($famdet): ?>
                        <!-- <style>
                            .package-typed {
                                align-items: center;
                                background: #FFFFFF;
                                box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.04);
                                border-radius: 26px;
                                height: 400px;
                            }
                        </style> -->
                      <div class="col-xs-12 col-md-4" style="display:inline-block;">

                        <div class="package-type family-package">
                            <div class="content">
                            <div class="dataCompletedx" id="familySelect">
                                <img class="selected" style="width:30px" src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>"  alt="PWG Group approved">
                            </div>
                                <img src="<?php echo e(asset('images/yellowFamily.svg')); ?>" alt="PWG Group">
                                <h6>Family Package</h6>
                                <p class="amountSection"><span class="Famamount"><?php echo e(($famdet) ?  number_format($famdet['total_price'],0) : 0); ?></span><b style="font-size:15px">AED</b></p>
                                   <?php if(!$famdet): ?>
                                   <p style="font-size: 14px">
                                     Package Not Available 
                                   </p> 
                                   <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <p style="font-size:11px; color:#ccc">Click on a package to select</p>
                    </div>

                <div class="row">
                    <div class="package-desc">
                        <div class="blue-desc">
                            
                           
                            <div class="form-group row" style="margin-top: -120px;"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <form method="POST" action="<?php echo e(url('product')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="cost" value="<?php echo e($blue_cost); ?>">
                                   
                                     <input type="hidden" value="Blue Collar Jobs" name="myPack">
                                    <!-- <a class="btn btn-primary" href="<?php echo e(url('product')); ?>" style="width: 100%;font-size: 24px;">Continue</a> -->
                                    <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                </form>
                                </div>
                            </div>
                        </div>
                     
                       <?php if($data->name == "Canada" && $canada->is_active==1): ?>
                        <div class="study-desc">
                        
                            <div class="form-group row" style="margin-top: -120px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <form method="POST" action="<?php echo e(url('product')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="cost" value="<?php echo e($cSamount); ?>">
                                    <input type="hidden" value="<?php echo e($cSname); ?>" name="myPack">
                                    <!-- <a class="btn btn-primary" href="<?php echo e(url('product')); ?>" style="width: 100%;font-size: 24px;">Continue</a> -->
                                    <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="express-desc">
                        
                         <div class="form-group row" style="margin-top: -120px"> 
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                            <form method="POST" action="<?php echo e(url('product')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="cost" value="<?php echo e($cXamount); ?>">
                                <input type="hidden" value="<?php echo e($cXname); ?>" name="myPack">
                                <!-- <a class="btn btn-primary" href="<?php echo e(url('product')); ?>" style="width: 100%;font-size: 24px;">Continue</a> -->
                                <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                            </form>
                            </div>
                        </div>
                       </div>
                       <?php endif; ?>

                       <?php if(isset($whiteJob_cost) && $whiteJob_cost == 0): ?>
                        
                        <script>
                            $(document).ready(function(){
                            $('.white-desc').hide();
                        </script>
                        <?php else: ?>     
                       
                       <?php endif; ?>
                       <div class="white-desc">
                             
                        
                            <div class="form-group row" style="margin-top: -120px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <form method="POST" action="<?php echo e(url('product')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="cost" value="<?php echo e($whiteJob_cost); ?>">
                                    <input type="hidden" value="White Collar Jobs" name="myPack">
                                    <!-- <a class="btn btn-primary" href="<?php echo e(url('product')); ?>" style="width: 100%;font-size: 24px;">Continue</a> -->
                                    <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="family-desc">

                            <div class="header">
                                <h4>Dependants Details</h4>
                                <div class="bottoom-title">
                                    <p>Please add details about your dependants here</p>
                                </div>
                            </div>

                            <form method="POST" action="<?php echo e(url('product')); ?>">
                           
                                <?php echo csrf_field(); ?>
                              
                                <input type="hidden" name="productId" value="<?php echo e($productId); ?>">
                                <input type="hidden" class="hiddenFamAmount" name="cost" value="<?php echo e(($famdet) ?  number_format($famdet['total_price']) : 0); ?>">
                                <input type="hidden" value="FAMILY PACKAGE" name="myPack">
                                <input type="hidden" value="<?php echo e(($famdet) ? $famdet->id : 0); ?>" name="fam_id">

                                <div class="partner-sec">
                                <?php $XYZ = Session::get('mySpouse'); ?>
                                    <p style="height: 13px"><span class="header"> Partner/Spouse</span>
                                        Yes
                                        <label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" <?php if($XYZ == 'yes' ): ?> checked="checked" <?php endif; ?>  onclick="handleClick(this);" value="yes">
                                            <span class="slider round"></span>
                                        </label>
                                        
                                        No<label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" <?php if($XYZ == 'no' || $XYZ == null): ?> checked="checked" <?php endif; ?> onclick="handleClick(this);" value="no">
                                            <span class="slider round"></span>
                                        </label>
                                    </p>

                                    <p>Is your spouse/partner accompanying you?</p>
                                </div>

                                <?php $ABC = Session::get('myKids'); ?>

                                <div class="children-sec">
                                    <p style="height: 13px">
                                        <span class="header"> Children</span>
                                        <ul class="children">
                                            
                                            <li>
                                                <input type="radio" id="one" name="children" <?php if($ABC == 1 || $ABC==null ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="1"/>
                                                <label for="one">One</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="two" name="children" <?php if($ABC == 2 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="2" />
                                                <label for="two">Two</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="three" name="children" <?php if($ABC == 3 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="3" />
                                                <label for="three">Three</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="four" name="children" <?php if($ABC == 4 ): ?> checked="checked" <?php endif; ?> onclick="handleKids(this);" value="4" />
                                                <label for="four">Four</label>
                                            </li>
                                            
                                        </ul>
                                    </p>
                                </div>

                                <div class="form-group row" style="margin-top: 140px"> 
                                    <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-12">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<script>
    $(document).ready(function(){
            $('.blue-desc').hide();
            $('.white-desc').hide();
            $('.family-desc').hide();
            $('.study-desc').hide();
            $('.express-desc').hide();
            
            $('#blueSelect').hide()
            $('#whiteSelect').hide()
            $('#familySelect').hide()
            $('#studySelect').hide()
            $('#expressSelect').hide()

            $('.blue-collar').click(function(){
                let bluej = "Blue Collar Jobs"
                document.cookie = 'packageType='+bluej ;

                if($('.blue-desc').is(":visible"))
                {
                    $('.blue-desc').hide();
                } else {
                    $('.blue-desc').show(); 
                }
                $('.white-desc').hide();
                $('.family-desc').hide();
                $('.study-desc').hide();
                $('.express-desc').hide();

                $('#studySelect').hide()
                $('#expressSelect').hide()
                if($('#blueSelect').is(":visible"))
                {
                    $('#blueSelect').hide()
                } else {
                    $('#blueSelect').show()
                }
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.white-collar').click(function(){
                let whitej = "White Collar Jobs"
                document.cookie = 'packageType='+whitej ;

                $('.blue-desc').hide();
                if($('.white-desc').is(":visible"))
                {
                    $('.white-desc').hide();
                } else {
                    $('.white-desc').show();
                }
                $('.family-desc').hide();

                $('#blueSelect').hide()
                if($('#whiteSelect').is(":visible"))
                {
                    $('#whiteSelect').hide()
                } else {
                    $('#whiteSelect').show()
                }                 
                $('#familySelect').hide()
            });
            $('.family-package').click(function(){
                let famj = "FAMILY PACKAGE"
                document.cookie = 'packageType='+famj ;

                $('.blue-desc').hide();
                $('.white-desc').hide();
                if($('.family-desc').is(":visible"))
                {
                 $('.family-desc').hide();
                } else {
                    $('.family-desc').show();
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                if($('#familySelect').is(":visible"))
                {
                    $('#familySelect').hide()
                } else {
                    $('#familySelect').show()
                }
            });

            $('.study-permit').click(function(){
                let studyj = "Study Permit"
                document.cookie = 'packageType='+studyj ;

                if($('.study-desc').is(":visible"))
                {
                   $('.study-desc').hide();
                } else {
                    $('.study-desc').show();
                }
                $('.express-desc').hide();
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                if($('#studySelect').is(":visible"))
                {
                    $('#studySelect').hide()
                } else {
                    $('#studySelect').show()
                }
                $('#expressSelect').hide()
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.express-entry').click(function(){
                let expressj = "Express Entry"
                document.cookie = 'packageType='+expressj ;
               
                $('.study-desc').hide();
                if($('.express-desc').is(":visible"))
                {
                    $('.express-desc').hide();
                } else {
                    $('.express-desc').show();
                }
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                $('#studySelect').hide()
                if($('#expressSelect').is(":visible"))
                {
                    $('#expressSelect').hide()
                } else {
                    $('#expressSelect').show()
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
        });

</script>
<?php $__env->stopPush(); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

<script src="Scripts/jquery.session.js"></script>
<script type="text/javascript">

function handleClick(spouse) {
 
    parents = spouse.value;
    kidd = $('input[name="children"]:checked').val();

    getCost(kidd,parents);
    // document.cookie = 'parents='+parents ;        
}

function handleKids(children) {
let kidd = children.value;
parents = $("input[name=spouse]:checked").val();

getCost(kidd,parents);


//  document.cookie = 'pers='+kidd ; 
//  window.location.href = "<?php echo e(route('packageType',$productId)); ?>";
}

function getCost(kidd, parents)
{
 
    $.ajax({
        type: 'GET',
        url: "<?php echo e(route('packageType',$productId)); ?>",
        data: {kid : kidd, parents: parents , response : 1}, 
        success: function (data) {
            $('.Famamount').text(parseFloat(data.total_price).toLocaleString());
            $('.hiddenFamAmount').val(data.total_price);
        },
        errror: function (error) {
        }
    });
}

</script>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/package-type.blade.php ENDPATH**/ ?>