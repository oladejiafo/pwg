
 <link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <link href="<?php echo e(asset('css/alert.css')); ?>" rel="stylesheet">
 <link href="<?php echo e(asset('user/css/select2.min.css')); ?>" rel="stylesheet" />
<style>
    body {
    background: #f0f3f4 !important;
    font-family: TT Norms Pro;
}

.embassy select{
    height: 60px !important;
    border-radius: 20px !important;

}
</style>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard bg-white">
                    <div class="row">
                        <div class="tabs d-flex justify-content-center">
                            

                        <div class="wrapper">
                              <?php 
                                if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') 
                                {
                              ?>    
                                <a href="#" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">1</div></a>
                              <?php
                                } else {
                              ?>    
                                <a href="<?php echo e(url('payment_form', $productId)); ?>" >
                                    <div class="round-completed round2  m-2">1</div>
                                </a>
                              <?php   
                                }
                              ?>
                              <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            
                            <!-- <div class="wrapper">
                                <a href="<?php echo e(route('applicant', $productId)); ?>" ><div class="round-active  round3  m-2">2</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div> -->

                            <?php 
                              if ($levels == '5' || $levels == '4' || $levels == '3' ) {
                            ?>    
                            <div class="wrapper">
                                <a href="<?php echo e(route('applicant.details',  $productId)); ?>" ><div class="round4 m-2">2</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="<?php echo e(url('applicant/review',  $productId)); ?>" ><div class="round5 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            
                            <?php  
                              } else {
                            ?>

                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round4 m-2">2</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round5 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            <?php  
                              }
                            ?>

                        </div>
                    </div>
                </div>
            <div>
            <div class="row">
                <div class="applicant-sec">
                    <div class="heading">
                      <div class="first-heading">
                          <h3>
                              Application Details
                          </h3>
                      </div>
                    </div>
                    
                    <?php
                        $applied = DB::table('destinations')
                            ->where('id', '=', $productId)
                            ->get();

                        $products =  DB::table('destinations')->get();
                    ?>    

                    <div class="form-sec">
                        <form method="POST" action="<?php echo e(route('store.applicant')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mt-3">
                                    <select class="form-select form-control" id="inputFirstname" name="applied_country" placeholder="Applied Country *" value="<?php echo e(old('applied_country')); ?>" required>
                                        <option selected><?php $__currentLoopData = $applied; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appliedc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($appliedc->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></option>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                    <?php $__errorArgs = ['applied_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-sm-6 mt-3">

                                <input type="text" name="agent_code" class="form-control" placeholder="Please enter your agent code here if available" value="<?php echo e(old('agent_code')); ?>" />
                                <?php $__errorArgs = ['agent_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <!-- <div class="col-sm-6 mt-3"> -->
                                    <!-- <select class="form-select form-control" id="inputLastname" name="job_type" placeholder="Are you apply for white collar job? *" value="<?php echo e(old('job_type')); ?>" required>
                                        <option selected disabled>Are you apply for white collar job? *</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select> -->
                                     
                                <!-- </div> -->
                            </div>        
                            <div class="form-group row mt-3">
                                <div class="col-sm-12 mt-3">
                                    <input type="text" class="form-control cvupload" placeholder="Upload your cv (PDF only)*" name="cv" value="<?php echo e(old('cv')); ?>" readonly required>
                                    <div class="input-group-btn">
                                        <span class="fileUpload btn">
                                            <span class="upl" id="upload">Choose File</span>
                                            <input type="file" class="upload up cvupload" id="up"  name="cv" accept="application/pdf" onchange="readURL(this);" />
                                          </span><!-- btn-orange -->
                                    </div><!-- btn -->
                                    <?php $__errorArgs = ['cv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                            
                            
                            
                            <div class="form-group row mt-4" style="margin-bottom: 70px">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>            
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.embassy').select2();
    });

    $(document).on('change','.up', function(){
        var names = [];
        var length = $(this).get(0).files.length;
          for (var i = 0; i < $(this).get(0).files.length; ++i) {
              names.push($(this).get(0).files[i].name);
          }
          // $("input[name=file]").val(names);
        if(length>2)
        {
          var fileName = names.join(', ');
          $('.cvupload').attr("value",length+" files selected");
        } else {
          $('.cvupload').attr("value",names);
        }
    });
</script>

<?php $__env->stopPush(); ?>

<script src="<?php echo e(asset('js/alert.js')); ?>"></script>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\applicant.blade.php ENDPATH**/ ?>