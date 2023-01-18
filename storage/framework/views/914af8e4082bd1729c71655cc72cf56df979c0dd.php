<div class="tab-pane active" id="children">
    <form method="POST" id="child_details">
        <?php echo csrf_field(); ?>
        <?php for($i = 1; $i <= $client['children_count']; $i++): ?>
            <div class="applicant-detail-sec" <?php if($i ==  $client['children_count']): ?> style="margin-bottom:70px" <?php endif; ?> >
                <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapsechild<?php echo e($i); ?>" aria-expanded="false" aria-controls="collapsechild<?php echo e($i); ?>">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <div class="image">
                                <img src="<?php echo e(asset('images/child.svg')); ?>" width="100%" height="100%">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="vl"></div>
                        </div>
                        <div class="col-6 my-auto">
                            <div class="first-heading d-flex justify-content-center">
                                <h3>
                                    Child <?php echo e($i); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-2 mx-auto my-auto">
                            <div class="down-arrow">
                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="collapse" id="collapsechild<?php echo e($i); ?>">
                        <div class="form-sec">
                            <div class="form-group row mt-4">
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                    <input type="hidden" name="childrenCount" value="<?php echo e($client['children_count']); ?>">
                                    <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                    <input type="hidden" name="child" value="<?php echo e($i); ?>">
                                    <input type="text" name="child_<?php echo e($i); ?>_first_name" id="child_<?php echo e($i); ?>_first_name" class="form-control child_<?php echo e($i); ?>_first_name" placeholder="First Name*" value="" autocomplete="off" />
                                    <label for="child_<?php echo e($i); ?>_first_name">First Name*</label>
                                    <span class="child_<?php echo e($i); ?>_first_name_errorClass"></span>
                                    <?php $__errorArgs = ['child_<?php echo e($i); ?>_first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="text" name="child_<?php echo e($i); ?>_middle_name"id="child_<?php echo e($i); ?>_middle_name" class="form-control " placeholder="Middle Name" value=""  autocomplete="off"/>
                                    <label for="child_<?php echo e($i); ?>_middle_name">Middle Name</label>
                                </div>
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="text" name="child_<?php echo e($i); ?>_surname" id="child_<?php echo e($i); ?>_surname" class="form-control child_<?php echo e($i); ?>_surname" placeholder="Surname*" value="" autocomplete="off"  />
                                    <label for="child_<?php echo e($i); ?>_surname">Surname*</label>
                                    <span class="child_<?php echo e($i); ?>_surname_errorClass"></span>
                                    <?php $__errorArgs = ['child_<?php echo e($i); ?>_surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="form-floating col-sm-6 mt-3">
                                    <input type="text"  name="child_<?php echo e($i); ?>_dob"  id="child_<?php echo e($i); ?>_dob" class="child-dob form-control" placeholder="Date Of Birth*" readonly>
                                    <label for="child_<?php echo e($i); ?>_dob">Date Of Birth*</label>
                                    <span class="child_<?php echo e($i); ?>_dob_errorClass"></span>
                                    <?php $__errorArgs = ['child_<?php echo e($i); ?>_dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>
                                <div class="form-floating col-sm-6 mt-3">
                                    <select name="child_<?php echo e($i); ?>_gender" id="child_<?php echo e($i); ?>_gender" aria-required="true" class="form-control form-select child_<?php echo e($i); ?>_gender" >
                                        <option selected disabled>Gender</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                    <label for="child_<?php echo e($i); ?>_gender">Gender *</label>
                                    <span class="child_<?php echo e($i); ?>_gender_errorClass"></span>
                                    <?php $__errorArgs = ['child_<?php echo e($i); ?>_gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <?php if($i ==  $client['children_count']): ?>
                                    <button type="submit" class="btn btn-primary submitBtn">Submit <i class="fa fa-spinner fa-spin childReviewSpin"></i></button>  
                                <?php else: ?> 
                                    <button type="button" class="btn btn-primary submitBtn collapsechild<?php echo e($i+1); ?>" data-bs-toggle="collapse" data-bs-target="#collapsechild<?php echo e($i+1); ?>" aria-expanded="false" aria-controls="collapsechild<?php echo e($i+1); ?>">Continue</button>  
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </form>
</div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/main-applicant-children.blade.php ENDPATH**/ ?>