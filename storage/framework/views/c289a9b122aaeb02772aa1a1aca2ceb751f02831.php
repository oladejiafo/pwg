
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link href="<?php echo e(asset('css/alert.css')); ?>" rel="stylesheet">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<?php $__env->startSection('content'); ?>


<?php 
     $completed = DB::table('applications')
                ->where('destination_id', '=', $productId)
                ->where('client_id', '=', Auth::user()->id)
                ->first();

    $levels = $completed->application_stage_status;
?>

 
<?php if($levels != '5' && $levels != '4'): ?> 
    <script>window.location = "/applicant/details/<?php echo $productId; ?>";</script>
<?php endif; ?>

<div class="container" id="app" data-applicantId="<?php echo e($client['id']); ?>" <?php if($dependent): ?>  data-dependentId="<?php echo e($dependent['id']); ?>" <?php endif; ?>>
    <div class="col-12">
            <div class="row">
                <div class="wizard-details bg-white">
                    <div class="row">
                        <div class="tabs-detail d-flex justify-content-center">

                            <div class="wrapper">
                              <?php 
                                if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') 
                                {
                              ?>    
                                <a href="#" onclick="toastr.error('Payment Concluded Already!');" class="wrapper-link toastrDefaultError">
                                    <div class="round-completed round2 m-2">1</div>
                                </a>
                              <?php
                                } else {
                              ?>    
                                <a href="<?php echo e(url('payment_form', $productId)); ?>" class="wrapper-link">
                                    <div class="round-completed round2  m-2">1</div>
                                </a>
                              <?php   
                                }
                              ?>
                              <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            
                            <?php 
                              if ($levels == '5' || $levels == '4') {
                            ?>     
                            <!-- <div class="wrapper">
                                <a href="#" onclick="return alert('Section completed already');" class="wrapper-link"><div class="round-completed round3 m-2">2</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div> -->

                            <div class="wrapper">
                                <a href="#" onclick="toastr.error('Section completed already');" class="wrapper-link"><div class="toastrDefaultError round-completed round4 m-2">2</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <?php
                                } else {
                            ?> 
                            <!-- <div class="wrapper">
                                <a href="<?php echo e(route('applicant', $productId)); ?>" class="wrapper-link" ><div class="round-completed round3  m-2">2</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div> -->

                            <div class="wrapper">
                                <a href="<?php echo e(route('applicant.details',  $productId)); ?>" class="wrapper-link"><div class="round-completed round4 m-2">2</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <?php
                                }
                            ?>
                            <div class="wrapper">
                                <a href="<?php echo e(url('applicant/review',  $productId)); ?>" class="wrapper-link"><div class="round-active round5 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="applicant-tab-sec">
                    <div class="row">
                        <?php if(($applicant['work_permit_category']) && ($client['is_spouse'] != null || $client['is_spouse'] != 0) && ($client['children_count'] != null || $client['children_count'] != 0)): ?>
                            <div class="col-4">
                                <div class="mainApplicant active" data-toggle="tab" role="tab" style="border-radius: 20px 0 0 20px;">
                                    <a  href="#mainApplicant">
                                        <h4>Main Applicant</h4> 
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="dependant">
                                    <a href="#dependant" data-toggle="tab" role="tab">
                                        <h4>Spouse/Dependant</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="children" style="border-radius: 0 20px 20px 0;">
                                    <a href="#children" data-toggle="tab" role="tab">
                                        <h4>Children</h4>
                                    </a>
                                </div>
                            </div>
                        <?php elseif(($applicant['work_permit_category']) && ($client['is_spouse'] != null || $client['is_spouse'] != 0) &&  ($client['children_count'] == null || $client['children_count'] == 0)): ?>
                            <div class="col-6">
                                <div class="mainApplicant active" data-toggle="tab" role="tab" style="border-radius: 20px 0 0 20px;">
                                    <a href="#mainApplicant">
                                        <h4>Main Applicant</h4> 
                                    </a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="dependant">
                                    <a href="#dependant" data-toggle="tab" role="tab"  style="border-radius: 0 20px 20px 0;">
                                        <h4>Spouse/Dependant</h4>
                                    </a>
                                </div>
                            </div>
                        <?php elseif(($applicant['work_permit_category']) && ($client['is_spouse'] == null || $client['is_spouse'] == 0) && ($client['children_count'] != null || $client['children_count'] != 0)): ?>
                            <div class="col-6">
                                <div class="mainApplicant active" data-toggle="tab" role="tab" style="border-radius: 20px 0 0 20px;">
                                    <a  href="#mainApplicant">
                                        <h4>Main Applicant</h4> 
                                    </a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="children">
                                    <a href="#children" data-toggle="tab" role="tab" style="border-radius: 0 20px 20px 0;">
                                        <h4>Children</h4>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div style="display:flex;color:white; padding:2%;background-color: #dd9951; height: 80px; float:left;border-radius:3px;margin-top: 5px;"> 
                    <span class="review-info-icon"><i class="fas fa-exclamation-triangle"></i></span> 
                    <span class="review-info" style="display:inline-block;"><b>Application Review:</b> Please confirm your entered details are accurate and submit.<span>
                </div>
                <div class="tab-content clearfix" style="margin: 0; padding: 0;">
                    <div class="tab-pane active" id="mainApplicant">
                        <div class="applicant-detail-sec">
                            <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="true" aria-controls="collapseapplicant">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="image my-auto">
                                            <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Applicants Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="collapseapplicant" class="collapse show">
                                    <div class="form-sec">
                                        <form method="POST" id="applicant_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name*" value="<?php echo e($client['name']); ?>" autocomplete="off" required/>
                                                    <span class="first_name_errorClass"></span>
                                                    <label for="first_name">First Name*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Middle Name" value="<?php echo e($client['middle_name']); ?>"  autocomplete="off"/>
                                                    <label for="middle_name">Middle Name</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="surname" name="surname" class="form-control" placeholder="Surname*" value="<?php echo e($client['sur_name']); ?>" autocomplete="off" required />
                                                    <span class="surname_errorClass"></span>
                                                    <label for="surname">Surname*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email*" value="<?php echo e($client['email']); ?>" autocomplete="off" required/>
                                                    <span class="email_errorClass"></span>
                                                    <label for="email">Email*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="hidden" name="phone_number1" class="form-control" id="phone_no" placeholder="Phone Number*" value="<?php echo e($client['phone_number']); ?>" autocomplete="off"/>
                                                    <input type="tel" onkeypress="return isNumberKey(event)" style="margin-left: -10px !important;" name="phone_number" class="form-control" id="phone" placeholder="Phone Number*" value="<?php echo e($client['phone_number']); ?>" autocomplete="off"  required/>
                                                    <span class="phone_number_errorClass"></span>
                                                    <label for="phone_no" style="margin-top: -5px !important; margin-left: -5px !important;">Phone Number*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 dob form-floating">
                                                    <input type="text" id="dob" name="dob" class="form-control datepicker" placeholder="Date of Birth*" value="<?php echo e(date('d-m-Y', strtotime($client['date_of_birth']))); ?>" id="datepicker" autocomplete="off"  readonly="readonly" required/>
                                                    <span class="dob_errorClass"></span>
                                                    <label for="email">Date of Birth*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="place_of_birth" name="place_birth" class="form-control" placeholder="Place of Birth*" value="<?php echo e($client['place_of_birth']); ?>" autocomplete="off" required/>
                                                    <span class="place_birth_errorClass"></span>
                                                    <label for="place_of_birth">Place of Birth*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select class="form-select form-control" id="country_birth" name="country_birth" placeholder="Country of Birth*"  required>
                                                        <option selected><?php echo e($client['country_of_birth']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($key == $client['country_of_birth']) ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <span class="country_birth_errorClass"></span>
                                                    <label for="country_birth">Country of Birth*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select class="form-select form-control" id="citizenship" name="citizenship" placeholder="Citizenship*"  required>
                                                        <option selected><?php echo e($client['citizenship']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php echo e(($key == $client['citizenship']) ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <span class="citizenship_errorClass"></span>
                                                    <label for="citizenship">Citizenship*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select name="sex" id="sex" aria-required="true" class="form-control form-select" required>
                                                        <option selected disabled>Sex *</option>
                                                        <option <?php echo e(($client['sex'] == 'MALE') ? 'selected' : ''); ?> value="MALE"> Male
                                                        </option>
                                                        <option <?php echo e(($client['sex'] == 'FEMALE') ? 'selected' : ''); ?> value="FEMALE">Female</option>
                                                    </select>
                                                    <span class="sex_errorClass"></span>
                                                    <label for="sex">Sex*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select name="civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
                                                        <option selected disabled>Civil Status *</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'SINGLE') ? 'selected' : ''); ?> value="SINGLE">Single</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'MARRIED') ? 'selected' : ''); ?> value="Married">Married</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'SEPARATED') ? 'selected' : ''); ?> value="SEPARATED">Separated</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'DIVORCED') ? 'selected' : ''); ?> value="DIVORCED">Divorced</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'WIDOW') ? 'selected' : ''); ?> value="WIDOW">Widow</option>
                                                        <option  <?php echo e(($client['civil_status'] == 'OTHER') ? 'selected' : ''); ?> value="OTHER">Other</option>
                                                    </select>
                                                    <span class="civil_status_errorClass"></span>
                                                    <label for="civil_status">Civil Status*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="agent_code" id="agent_code" class="form-control" placeholder="Please enter your agent code here if available" value="<?php echo e($applicant['assigned_agent_id']); ?>" />
                                                    <span class="agent_code_errorClass"></span>
                                                    <label for="agent_code">Agent Code, if any</label>
                                                </div>
                                                <div class="col-sm-8 mt-3 form-floating">
                                                    <input type="text" id="cv" class="form-control cv_upload" placeholder="Upload your cv (PDF only)*" name="cv" value="<?php echo e($client['resumeName']); ?>"  onclick="showResumeFormat('applicant')" autocomplete="off" readonly required>
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up cv_upload" id="up"  name="cv"  value="<?php echo e($client['resumeName']); ?>"/>
                                                            </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <span class="cv_errorClass"></span>
                                                    <label for="cv">CV</label>
                                                </div>

                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="button" class="btn btn-primary submitBtn applicantDetails">Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>
        
                        <div class="applicant-detail-sec">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="true" aria-controls="collapseHome">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_home_country_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Home Country Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseHome">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="home_country_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <input type="text" id="passport_number" name="passport_number" class="form-control" placeholder="Passport Number*" value="<?php echo e($client['passport_number']); ?>" autocomplete="off"/>
                                                    <span class="passport_number_errorClass"></span>
                                                    <label for="passport_number">Passport Number*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="passport_issue_date" name="passport_issue" class="form-control passport_issue" placeholder="Passport Date of Issue*" value="<?php echo e(date('d-m-Y', strtotime($client['passport_issue_date']))); ?>" autocomplete="off" readonly="readonly"/>
                                                    <span class="passport_issue_errorClass"></span>
                                                    <label for="passport_issue_date">Passport Issue Date*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="passport_expiry" name="passport_expiry" class="form-control passport_expiry" placeholder="passport Date of Expiry*" value="<?php echo e(date('d-m-Y', strtotime($client['passport_expiry']))); ?>" autocomplete="off" readonly="readonly"/>
                                                    <span class="passport_expiry_errorClass"></span>
                                                    <label for="passport_expiry">Passport Expiry Date*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <input type="text" id="issued_by" name="issued_by" class="form-control" placeholder="Issued By(Authority that issued the passport)*" value="<?php echo e($client['passport_issued_by']); ?>" autocomplete="off"/>
                                                    <span class="issued_by_errorClass"></span>
                                                    <label for="issued_by">Issued By*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <input type="text" id="passport_copy" name="passport_copy" class="form-control passport_copy" placeholder="Upload Passport Copy*" value="<?php echo e($client['passportName']); ?>"  onclick="showPassportFormat('applicant')" autocomplete="off" readonly/>
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up passport_copy" id="up" value="<?php echo e($client['passport']); ?>"  name="passport_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <span class="passport_copy_errorClass"></span>
                                                    <label for="passport_copy">Passport Copy Upload*</label>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-3 mt-3 form-floating">
                                                    <select class="form-select form-control" id="home_country" name="home_country" placeholder="home_country*" autocomplete="off">
                                                        <option selected><?php echo e($client['country']); ?></option>
                                                            <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php echo e(($key == $client['country']) ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <span class="home_country_errorClass"></span>
                                                    <label for="home_country">Home Country*</label>
                                                </div>
                                                <div class="col-sm-3 mt-3 form-floating">
                                                    <input type="text" name="state" id="state" class="form-control" placeholder="State/Province*" value="<?php echo e($client['state']); ?>" autocomplete="off">
                                                    <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <span class="state_errorClass"></span>
                                                    <label for="state">State/Province*</label>
                                                </div>
                                                <div class="col-sm-3 mt-3 form-floating">
                                                    <input type="text" id="city" name="city" class="form-control" placeholder="City*" autocomplete="off" value="<?php echo e($client['city']); ?>">
                                                    <span class="city_errorClass"></span>
                                                    <label for="city">City*</label>
                                                </div>
                                                <div class="col-sm-3 mt-3 form-floating">
                                                    <input type="integer" id="postal_code" name="postal_code" value="<?php echo e($client['postal_code']); ?>" class="form-control" placeholder="Postal Code*" autocomplete="off">
                                                    <span class="postal_code_errorClass"></span>
                                                    <label for="postal_code">Postal Code*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="address_1" name="address_1" class="form-control" placeholder="Address (Street And Number) Line 1*" value="<?php echo e($client['address_line_1']); ?>" autocomplete="off">
                                                    <span class="address1_errorClass"></span>
                                                    <label for="address_1">Address Line 1*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="address_2" name="address_2" class="form-control" placeholder="Address (Street And Number) Line 2" value="<?php echo e($client['address_line_2']); ?>" autocomplete="off">
                                                    <label for="address_2">Address Line 2</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn homeCountryDetails">Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>
        
                        <div class="applicant-detail-sec">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_current_residency_and_work_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Current Residency and Work Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseCurrent">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="current_residency">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <select class="form-select form-control" id="current_country" name="current_country" placeholder="current_country*">
                                                        <option selected> <?php echo e($client['country']); ?> </option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($key == $client['country']) ? 'seleceted' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <span class="current_country_errorClass"></span>
                                                    <label for="current_country">Current Country*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="tel" onkeypress="return isNumberKey(event)" style="margin-left: -10px !important;" class="form-control" id="current_residance_mobile" name='current_residance_mobile' value="<?php echo e($client['residence_mobile_number']); ?>" placeholder="Current Residence Mobile Number" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="current_mobile" name='current_residance_mobile1' value="<?php echo e($client['residence_mobile_number']); ?>" placeholder="Current Residence Mobile Number" autocomplete="off">
                                                    <span class="current_residance_mobile_errorClass"></span>
                                                    <label for="current_mobile" style="margin-top: -5px !important; margin-left: -5px !important">Current Residence Mobile Number*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="residence_id" name="residence_id" class="form-control" placeholder="Residence Id*" value="<?php echo e($client['residence_id']); ?>" autocomplete="off"/>
                                                    <span class="residence_id_errorClass"></span>
                                                    <label for="residence_id">Residence ID*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="visa_validity" class="form-control visa_validity" name="visa_validity" value="<?php echo e(date('d-m-Y', strtotime($client['visa_validity']))); ?>" placeholder="Your ID/Visa Date of Validity*" readonly="readonly">
                                                    <span class="visa_validity_errorClass"></span>
                                                    <label for="visa_validity">Visa Validity*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" id="residence_copy" class="form-control residence_id" name="residence_copy" onclick="showResidenceIdFormat('applicant')" placeholder="Residence/Emirates ID*" value="<?php echo e($client['residenceName']); ?>" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload residence_id" id="up"  name="residence_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <span class="residence_copy_errorClass"></span>
                                                    <label for="residence_copy">Residence ID Copy*</label>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="text" class="form-control visa_copy" id="visa_copy" name="visa_copy" onclick="showVisaFormat('applicant')" <?php if($client['visaCopyUrl']): ?> value="<?php echo e($client['visaName']); ?>" <?php else: ?> placeholder="Visa Copy" <?php endif; ?> readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload visa_copy" id="up"  name="visa_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="visa_copy">Visa Copy</label>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="work_state" name="work_state" class="form-control" placeholder="Work State/Province*" value="<?php echo e($client['work_state']); ?>" autocomplete="off"/>
                                                    <span class="work_state_errorClass"></span>
                                                    <label for="work_state">Work State*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="work_city" class="form-control" name="work_city" placeholder="Work City*" value="<?php echo e($client['work_city']); ?>" autocomplete="off">
                                                    <span class="work_city_errorClass"></span>
                                                    <label for="work_city">Work City*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="work_postal_code" class="form-control" name="work_postal_code" placeholder="Work Place Postal Code*" value="<?php echo e($client['work_postal_code']); ?>" autocomplete="off">
                                                    <span class="work_postal_code_errorClass"></span>
                                                    <label for="work_postal_code">Work Postal Code*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" id="work_street" name="work_street" class="form-control" placeholder="Work Place Street & Number*" value="<?php echo e($client['work_address']); ?>" autocomplete="off"/>
                                                    <span class="work_street_errorClass"></span>
                                                    <label for="work_street">Work Street Address*</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Name of Company" value="<?php echo e($client['company_name']); ?>" autocomplete="off">
                                                    <label for="company_name">Company Name</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" id="employer_phone" name="employer_phone" placeholder="Employer Phone Number" value="<?php echo e($client['employer_phone_number']); ?>" autocomplete="off">
                                                    <label for="employer_phone">Employer Phone</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <input type="email" id="employer_email" name="employer_email" class="form-control" placeholder="Email of the employer" value="<?php echo e($client['employer_email']); ?>" autocomplete="off">
                                                    <label for="employer_email">Employer Email</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn">Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>
        
                        <div class="applicant-detail-sec">
                            <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseSchengen" aria-expanded="true" aria-controls="collapseSchengen">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_schengen_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Schengen Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSchengen">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="schengen_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <input type="hidden" id="have_schengen">
                                                    <select name="is_schengen_visa_issued_last_five_year" id="is_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option selected disabled>Schengen Or National Visa Issued During Last 5 Years*</option>
                                                        <option <?php echo e(($client['is_schengen_visa_issued_last_five_year'] == "NO") ? 'selected' : ''); ?> value="NO">No</option>
                                                        <option <?php echo e(($client['is_schengen_visa_issued_last_five_year'] == "YES") ? 'selected' : ''); ?> value="YES">Yes</option> 
                                                    </select>
                                                    <span class="is_schengen_visa_issued_last_five_year_errorClass"></span>
                                                    <label for="have_schengen">Have Schengen or National Visa in the Last 5 Years?*</label>
                                                </div>
                                            </div>
                                            <?php  
                                             $vall = $client['schengenVisaName'];
                                             $phold = "Image of Schengen Or National Visa Issued During Last 5 Years";
                                             ?>
                                            <div class="form-group row mt-4 schengen_visa">
                                                <div class="col-sm-12 mt-3 form-floating" id="schengen_visa">

                                                    <input type="text" class="form-control schengen_copy" id="schengen_copy" name="schengen_copy" onclick="showSchengenVisaFormat('applicant')" <?php if($client['schengenVisaUrl']): ?>  value="<?php echo e($client['schengenVisaName']); ?>" <?php endif; ?> placeholder="Image of Schengen Or National Visa Issued During Last 5 Years"  readonly >
                                                    
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="schengen_copy">Image of Schengen Or National Visa Issued During Last 5 Years*</label>
                                                    <?php 
                                                        $cnt = 0; 
                                                        for($i = 1; $i <= 4; $i++)
                                                            {
                                                                if($client['schengenVisaUrl'.$i] != null){
                                                                    $cnt++;
                                                    ?>
                                                                <div class="col-sm-12 mt-3" id="schengen_visa">
                                                                    <input type="text" class="form-control schengen_copy1_<?php echo e($cnt); ?>" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" name="schengen_copy1[]"  value="<?php echo e($client['schengenVisaName'.$i]); ?>" readonly >
                                                                    <div class="input-group-btn">
                                                                        <span class="fileUpload btn">
                                                                            <span class="upl" id="upload">Choose File</span>
                                                                            <input style="position: absolute;top: 0; right: 0; margin: 0; padding: 0; font-size: 20px; cursor: pointer; opacity: 0; filter: alpha(opacity=0);" type="file" class="schengen_copy1_<?php echo e($cnt); ?>" accept="image/png, image/gif, image/jpeg" name="schengen_copy1[]" />
                                                                        </span>
                                                                    </div>
                                                                </div>   
                                                    <?php 
                                                                }
                                                            }
                                                    ?>
                                                </div>
                                                <div style="display: block;color:blue"><a href="#" class="pl" title="click here to add another row for upload" style="display:inline"><i class="fa fa-plus-circle"></i></a> Add another Visa <a href="#" class="mi" id="mi" title="click here to remove the last added row for upload" style="display:inline"><i class="fa fa-minus-circle"></i></a></div>
                                            </div>
                                            <!-- Add more inputs dynamycally here -->

                                            <div class="form-group row mt-4" id="is_finger_print_collected_for_Schengen_visa">
                                                <div class="col-sm-12 mt-3 form-floating">
                                                    <select name="is_finger_print_collected_for_Schengen_visa" id="have_fingerprint" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</option>
                                                        <option <?php echo e(($client['is_finger_print_collected_for_Schengen_visa'] == "NO") ? 'selected' : ''); ?> value="NO">No</option>
                                                        <option <?php echo e(($client['is_finger_print_collected_for_Schengen_visa'] == "YES") ? 'selected' : ''); ?> value="YES">Yes</option>
                                                    </select>
                                                    <span class="is_finger_print_collected_for_Schengen_visa_errorClass"></span>
                                                    <label for="have_fingerprint">Have Fingerprints Collected Previously?</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn">Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="applicant-detail-sec" style="margin-bottom: 70px">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="true" aria-controls="collapseExperience">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_experience_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Experience
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="importExperience" data-applicantId="<?php echo e($client['id']); ?>">
                                <div class="collapse show" id="collapseExperience" data-applicantId="<?php echo e($client['id']); ?>" data-dependentId="<?php echo e(($dependent != null) ? $dependent['id']  : ''); ?>">
                                    <div class="form-sec">
                                        <div class="jobSelected">
                                            <table class="table" v-if="selectedJob.length > 0">
                                                <thead>
                                                    <tr>
                                                        <td>Job Sector</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(job, jobIndex) in selectedJob">
                                                        <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id" aria-expanded="false" :aria-controls="'collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id">{{job.job_title}}</td>
                                                        <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id, 'applicant')"><i class="fa fa-trash" aria-hidden="true"></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h4 style="margin-top:60px">Job Sector List</h4>
                                        <div class="form-group row mt-4 searchForm">
                                            <div class="col-lg-10 col-md-8 mt-3" >
                                                <input type="text" class="form-control" v-model="search" style="max-height:50px !important" name="search" placeholder="Enter Job Title" >
                                            </div>
                                            <div class="col-lg-2 col-md-4 mt-3" style="padding-left: 0px">
                                                <button class="btn btn-danger expSearch" v-on:click="filterJob()">Search</button>
                                            </div>
                                        </div>
                                        <div v-if="filterData.length > 0">
                                            <div  v-for='(data, index) in filterData' class="filterData" >
                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <p class="exp-font">{{data.name}}</p>
                                                        </div>
                                                        <div class="col-1 mx-auto my-auto">
                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" :id="'collapseExperience'+data.id">
                                                    <div class="detail-sec">
                                                        <div class="row">
                                                            <h5>Description</h5>
                                                            <p v-html="data.description"></p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Example Titles</h5>
                                                            <p>{{data.example_titles}}</p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Main Duties</h5>
                                                            <p >
                                                                <span style="white-space: pre-line">{{data.main_duties}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Employement Requirment</h5>
                                                            <p >
                                                                <span style="white-space: pre-line">{{data.employement_requirements}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                            <div class="row">
                                                                <button type="button" v-if="selectedJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                <button type="button" v-else class="btn btn-primary submitBtn" applicantId="<?php echo e($client['id']); ?>" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'applicant')" style="line-height: 22px">Add Experience</button>                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="jobCategories.length > 0" >
                                            <div v-for='(jobCategoryOne, index) in jobCategories' class="jobCategory">
                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+index" aria-expanded="false" :aria-controls="'collapseExperience'+index">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <p class="exp-font">{{jobCategoryOne.name}}</p>
                                                        </div>
                                                        <div class="col-1 mx-auto my-auto">
                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+index" aria-expanded="false" :aria-controls="'collapseExperience'+index">
                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" :id="'collapseExperience'+index" style="width: 95%; margin-left:2%">
                                                    <div class="jobCategoryTwo"  v-for='(jobCategoryTwo, indexTwo) in jobCategoryOne.job_category_two'>
                                                        <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <p class="exp-font">{{jobCategoryTwo.name}}</p>
                                                                </div>
                                                                <div class="col-1 mx-auto my-auto">
                                                                    <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                                                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapse" :id="'collapseExperienceTwo'+index+indexTwo" style="width: 95%; margin-left:2%">
                                                            <div class="jobCategoryThree" v-for='(jobCategoryThree, indexThree) in jobCategoryTwo.job_category_three'>
                                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                                                    <div class="row">
                                                                        <div class="col-11">
                                                                            <p class="exp-font">{{jobCategoryThree.name}}</p>
                                                                        </div>
                                                                        <div class="col-1 mx-auto my-auto">
                                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="collapse" :id="'collapseExperienceThree'+index+indexTwo+indexThree" style="width: 95%; margin-left:2%">
                                                                    <div class="jobCategoryThree" v-for='(jobCategoryFour, indexFour) in jobCategoryThree.job_category_four'>
                                                                        <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                                            <div class="row">
                                                                                <div class="col-11">
                                                                                    <p class="exp-font">{{jobCategoryFour.name}}</p>
                                                                                </div>
                                                                                <div class="col-1 mx-auto my-auto">
                                                                                    <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                                                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="collapse" :id="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                                            <div class="detail-sec">
                                                                                <div class="row">
                                                                                    <h5>Description</h5>
                                                                                    <p v-html="jobCategoryFour.description"></p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Example Titles</h5>
                                                                                    <p>{{jobCategoryFour.example_titles}}</p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Main Duties</h5>
                                                                                    <p >
                                                                                        <span style="white-space: pre-line">{{jobCategoryFour.main_duties}}</span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Employement Requirment</h5>
                                                                                    <p >
                                                                                        <span style="white-space: pre-line">{{jobCategoryFour.employement_requirements}}</span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                                                    <div class="row">
                                                                                        <button type="button" v-if="selectedJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                                        <button type="button" v-else class="btn btn-primary submitBtn" data-applicantId="<?php echo e($client['id']); ?>" v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name,'applicant')" style="line-height: 22px">Add Experience</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                            <?php if($client['is_spouse'] != null || $client['children_count'] != null): ?> 
                                                <button type="submit" class="btn btn-primary submitBtn applicantNext">  Next </button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-primary submitBtn applicantReview">  Submit <i class="fa fa-spinner fa-spin applicantReviewSpin"></i></button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($dependent): ?>
                    <div class="tab-pane active" id="dependant" style="margin: 0; padding: 0;">
                        <div class="applicant-detail-sec">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapsespouseapplicant" aria-expanded="true" aria-controls="collapsespouseapplicant">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="image my-auto">
                                            <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="70%" height="auto">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Spouse/Dependant Details 
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="collapsespouseapplicant" class="collapse show">
                                    <div class="form-sec">
                                        <?php
                                            $name = explode(' ', $client['name']);
                                        ?>
                                        <form method="POST" enctype="multipart/form-data" id="dependent_applicant_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                            <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="hidden" name="dependentApplicantCompleted" value="0" class="dependentApplicantCompleted">
                                                    <input type="text" name="dependent_first_name" id="dependent_first_name" class="form-control dependent_first_name" placeholder="First Name*" value="<?php echo e($dependent['name']); ?>" autocomplete="off"/>
                                                    <label for="dependent_first_name">First Name*</label>
                                                    <span class="dependent_first_name_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="dependent_middle_name" id="dependent_middle_name" class="form-control" placeholder="Middle Name" value="<?php echo e($dependent['middle_name']); ?>"  autocomplete="off"/>
                                                    <label for="dependent_middle_name">Middle Name</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="dependent_surname" class="form-control dependent_surname" id="dependent_surname" placeholder="Surname*" value="<?php echo e($dependent['sur_name']); ?>" autocomplete="off"  />
                                                    <label for="dependent_surname">Surname*</label>
                                                    <span class="dependent_surname_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="email" name="email" class="form-control dependent_email" id="dependent_email" placeholder="Email*" value="<?php echo e($dependent['email']); ?>" autocomplete="off" />
                                                    <label for="dependent_email">Email*</label>
                                                    <span class="email_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="hidden" name="phone_no_label" class="form-control" id="phone_no_label" placeholder="Phone Number*" value="<?php echo e($client['phone_number']); ?>" autocomplete="off"/>
                                                    <input type="tel" onkeypress="return isNumberKey(event)" name="dependent_phone_number" class="form-control dependent_phone_number" id="dependent_phone" placeholder="Phone Number*" value="<?php echo e($dependent['phone_number']); ?>" autocomplete="off"  />
                                                    <span class="dependent_phone_number_errorClass"></span>
                                                    <label for="phone_no_label" style="margin-top: -5px !important; margin-left: -5px !important;">Phone Number*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <input type="text" class="form-control dependent_resume" id="dependent_resume" placeholder="Upload your cv (PDF only)*" name="dependent_resume" value="<?php echo e($dependent['resumeName']); ?>" readonly required>
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up dependent_resume" id="up"  name="dependent_resume" accept="application/pdf" value="<?php echo e($dependent['resumeName']); ?>"/>
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="dependent_resume">Upload your cv (PDF only)*</label>
                                                    <span class="dependent_resume_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 dob form-floating">
                                                    <input type="text" name="dependent_dob" id="dependent_datepicker" class="form-control dependent_datepicker" placeholder="Date of Birth*" value="<?php echo e(date('d-m-Y', strtotime($dependent['date_of_birth']))); ?>" id="dependent_datepicker" autocomplete="off"  readonly="readonly" />
                                                    <label for="dependent_datepicker">Date of Birth*</label>
                                                    <span class="dependent_dob_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="dependent_place_birth" class="form-control dependent_place_birth" id="dependent_place_birth" placeholder="Place of Birth*" value="<?php echo e($dependent['place_of_birth']); ?>" autocomplete="off" />
                                                    <label for="dependent_place_birth">Place of Birth*</label>
                                                    <span class="dependent_place_birth_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select class="form-select form-control dependent_country_birth" id="dependent_country_birth" name="dependent_country_birth" placeholder="Country of Birth*" >
                                                        <option selected><?php echo e($dependent['country_of_birth']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($dependent['country_birth'] == $key) ? 'seleceted' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <label id="dependent_country_birth">Country of Birth*</label>
                                                    <span class="dependent_country_birth_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select class="form-select form-control dependent_citizenship" name="dependent_citizenship" id="dependent_citizenship" placeholder="Citizenship*" >
                                                        <option selected><?php echo e($dependent['citizenship']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($key == $dependent['citizenship']) ? 'seleceted' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <label for="dependent_citizenship">Citizenship*</label>
                                                    <span class="dependent_citizenship_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select name="dependent_sex"  id="dependent_sex" aria-required="true" class="form-control form-select dependent_sex">
                                                        <option selected disabled>Sex </option>
                                                        <option <?php echo e(($dependent['sex'] == 'MALE') ? 'selected' : ''); ?> value="MALE">Male</option>
                                                        <option <?php echo e(($dependent['sex'] == 'FEMALE') ? 'selected' : ''); ?> value="FEMALE">Female</option>
                                                    </select>
                                                    <label for="dependent_sex">Sex *</label>
                                                    <span class="dependent_sex_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <select name="dependent_civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
                                                        <option selected disabled>Civil Status</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'SINGLE') ? 'selected' : ''); ?> value="SINGLE">Single</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'MARRIED') ? 'selected' : ''); ?> value="MARRIED">Married</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'SEPARATED') ? 'selected' : ''); ?> value="SEPARATED">Separated</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'DIVORCED') ? 'selected' : ''); ?> value="DIVORCED">Divorced</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'WIDOW') ? 'selected' : ''); ?> value="WIDOW">Widow</option>
                                                        <option  <?php echo e(($dependent['civil_status'] == 'OTHER') ? 'selected' : ''); ?> value="OTHER">Other</option>
                                                    </select>
                                                    <label for="civil_status">Civil Status *</label>
                                                    <span class="civil_status_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn spouseApplicantDetails" >Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>

                        <div class="applicant-detail-sec dependent_home_country_details">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapsespouseHome" aria-expanded="true" aria-controls="collapsespouseHome">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_home_country_details.svg')); ?>" width="70%" height="auto">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Home Country Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapsespouseHome ">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="dependent_home_country_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="spouseHomeCountryCompleted" value="0" class="spouseHomeCountryCompleted">
                                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                            <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <input type="text" name="passport_number" id="dependent_passport_number" class="form-control dependent_passport_number" placeholder="Passport Number*" value="<?php echo e($dependent['passport_number']); ?>" autocomplete="off"/>
                                                    <label for="dependent_passport_number">Passport Number*</label>
                                                    <span class="dependent_passport_number_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" name="dependent_passport_issue" class="form-control dependent_passport_issue" id="dependent_passport_issue" placeholder="Passport Date of Issue*" value="<?php echo e(date('d-m-Y', strtotime($dependent['passport_issue_date']))); ?>" autocomplete="off" readonly/>
                                                    <label for="dependent_passport_issue">Passport Date of Issue*</label>
                                                    <span class="dependent_passport_issue_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" name="dependent_passport_expiry" class="form-control dependent_passport_expiry" id="dependent_passport_expiry" placeholder="Passport Date of Expiry*" value="<?php echo e(date('d-m-Y', strtotime($dependent['passport_expiry']))); ?>" autocomplete="off" readonly/>
                                                    <label for="dependent_passport_expiry">Passport Date of Expiry*</label>
                                                    <span class="dependent_passport_expiry_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <input type="text" name="dependent_issued_by" class="form-control dependent_issued_by"  id="dependent_issued_by" placeholder="Issued By(Authority that issued the passport)*" value="<?php echo e($dependent['passport_issued_by']); ?>" autocomplete="off"/>
                                                    <label for="dependent_issued_by">Issued By(Authority that issued the passport)*</label>
                                                    <span class="dependent_issued_by_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <input type="text" name="dependent_passport_copy" class="form-control dependent_passport_copy" placeholder="Upload Passport Copy*" value="<?php echo e($dependent['passportName']); ?>"  onclick="showPassportFormat('dependent')" autocomplete="off" readonly/>

                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up dependent_passport_copy" id="up"  name="dependent_passport_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="dependent_passport_copy">Upload Passport Copy*</label>
                                                    <span class="dependent_passport_copy_errorClass"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-3 mt-3">
                                                    <select class="form-select form-control dependent_home_country" name="dependent_home_country" id="dependent_home_country" placeholder="home_country*" value="<?php echo e($dependent['country']); ?>" autocomplete="off">
                                                        <option selected><?php echo e($dependent['country']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($key == $dependent['country']) ? 'seleceted' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <label for="dependent_home_country">Home Country</label>
                                                    <span class="dependent_home_country_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-3 mt-3">
                                                    <input type="text" name="dependent_state" id="dependent_state" class="form-control dependent_state" placeholder="State/Province*" value="<?php echo e($dependent['state']); ?>" autocomplete="off">
                                                    <label for="dependent_state">State/Province*</label>
                                                    <span class="dependent_state_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-3 mt-3">
                                                    <input type="text" name="dependent_city" class="form-control dependent_city" id="dependent_city" placeholder="City*" value="<?php echo e($dependent['city']); ?>" autocomplete="off">
                                                    <label for="dependent_city">City*</label>
                                                    <span class="dependent_city_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-3 mt-3">
                                                    <input type="integer" name="dependent_postal_code" id="dependent_postal_code" value="<?php echo e($dependent['postal_code']); ?>" class="form-control dependent_postal_code" placeholder="Postal Code*" autocomplete="off">
                                                    <label for="dependent_postal_code">Postal Code*</label>
                                                    <span class="dependent_postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" name="dependent_address_1" id="dependent_address_1" class="form-control dependent_address_1" value="<?php echo e($dependent['address_line_1']); ?>" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                                    <label for="dependent_address_1">Address (Street And Number) Line 1*</label>
                                                    <span class="dependent_address_1_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" name="dependent_address_2" class="form-control dependent_address_2" value="<?php echo e($dependent['address_line_2']); ?>" placeholder="Address (Street And Number) Line 2" autocomplete="off">
                                                    <label for="dependent_address_2">Address (Street And Number) Line 2</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn homeCountryDetails" >Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>

                        <div class="applicant-detail-sec">
                            <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseSpouseCurrent" aria-expanded="true" aria-controls="collapseSpouseCurrent">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_current_residency_and_work_details.svg')); ?>" width="70%" height="100px">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Current Residency and Work Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" >
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSpouseCurrent">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="dependent_current_residency">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                            <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                            <input type="hidden" name="spouseCurrentCountryCompleted" value="0" class="spouseCurrentCountryCompleted">
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <select class="form-select form-control" name="dependent_current_country" id="dependent_current_country" placeholder="current_country*"  >
                                                        <option selected><?php echo e($dependent['country_of_residence']); ?></option>
                                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e(($key == $dependent['country_of_residence']) ? 'seleceted' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <label for="dependent_current_country">Current Country *</label>
                                                    <span class="dependent_current_country_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3 form-floating">
                                                    <input type="hidden" name="dependent_current_residance_mobile_label" class="form-control" id="dependent_current_residance_mobile_label" placeholder="Current Residence Mobile Number" value="<?php echo e($client['residence_mobile_number']); ?>" autocomplete="off"/>
                                                    <input type="tel" onkeypress="return isNumberKey(event)" class="form-control" id="dependent_current_residance_mobile" name='dependent_current_residance_mobile' value="<?php echo e($dependent['residence_mobile_number']); ?>" placeholder="Current Residence Mobile Number" autocomplete="off">
                                                    <span class="dependent_current_residance_mobile_errorClass"></span>
                                                    <label for="dependent_current_residance_mobile_label" style="margin-top: -5px !important; margin-left: -5px !important;">Current Residence Mobile Number</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" name="dependent_residence_id" id="dependent_residence_id" class="form-control" placeholder="Residence Id*"  value="<?php echo e($dependent['residence_id']); ?>" autocomplete="off"/>
                                                    <label for="dependent_residence_id">Residence Id*</label>
                                                    <span class="dependent_residence_id_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_visa_validity" id="dependent_visa_validity" name="dependent_visa_validity" value="<?php echo e($dependent['visa_validity']); ?>" placeholder="Your ID/Visa Date of Validity*" >
                                                    <label for="dependent_visa_validity">Your ID/Visa Date of Validity*</label>
                                                    <span class="dependent_visa_validity_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_residence_copy" name="dependent_residence_copy" onclick="showResidenceIdFormat('dependent')" value="<?php echo e($dependent['residenceName']); ?>" placeholder="Residence/Emirates ID*" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload dependent_residence_copy" id="up"  name="dependent_residence_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="dependent_residence_copy">Residence/Emirates ID*</label>
                                                    <span class="dependent_residence_copy_errorClass"></span>
                                                </div>
                                                <div class="form-floating col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_visa_copy" name="dependent_visa_copy" onclick="showVisaFormat('dependent')" <?php if($dependent['visaCopyUrl'] != null): ?>  value="<?php echo e($dependent['visaName']); ?>" <?php else: ?>  placeholder="Visa Copy" <?php endif; ?> readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload dependent_visa_copy" id="up"  name="dependent_visa_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="dependent_visa_copy">Visa Copy</label>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="dependent_work_state" id="dependent_work_state" class="form-control" value="<?php echo e($dependent['work_state']); ?>" placeholder="Work State/Province*" autocomplete="off"/>
                                                    <label for="dependent_work_state">Work State/Province*</label>
                                                    <span class="dependent_work_state_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" name="dependent_work_city" id="dependent_work_city" value="<?php echo e($dependent['work_city']); ?>" placeholder="Work City*" autocomplete="off">
                                                    <label for="dependent_work_city">Work City*</label>
                                                    <span class="dependent_work_city_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" name="dependent_work_postal_code" id="dependent_work_postal_code" value="<?php echo e($dependent['work_postal_code']); ?>" placeholder="Work Place Postal Code*" autocomplete="off">
                                                    <label for="dependent_work_postal_code">Work Place Postal Code*</label>
                                                    <span class="dependent_work_postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" name="dependent_work_street" id="dependent_work_street" class="form-control" value="<?php echo e($dependent['work_address']); ?>" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                                    <label for="dependent_work_street">Work Place Street & Number*</label>
                                                    <span class="dependent_work_street_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" name="dependent_company_name" id="dependent_company_name"  value="<?php echo e($dependent['company_name']); ?>" placeholder="Name of Company" autocomplete="off">
                                                    <label for="dependent_company_name">Name of Company</label>
                                                </div>
                                                <div class="col-sm-4 mt-3 form-floating">
                                                    <input type="text" class="form-control" name="dependent_employer_phone" id="dependent_employer_phone" value="<?php echo e($dependent['employer_phone_number']); ?>" placeholder="Employer Phone Number" autocomplete="off">
                                                    <label>Employer Phone Number</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <input type="email" name="dependent_employer_email" id="dependent_employer_email" class="form-control" value="<?php echo e($dependent['employer_email']); ?>" placeholder="Email of the employer" autocomplete="off">
                                                    <label for="dependent_employer_email" >Email of the employer</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn collapseSpouseCurrent" >Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                        </div>

                        <div class="applicant-detail-sec">
                            <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseSpouseSchengen" aria-expanded="true" aria-controls="collapseSpouseSchengen">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_schengen_details.svg')); ?>" width="70%" height="auto">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Schengen Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSpouseSchengen">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="dependent_schengen_details">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                            <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                            <input type="hidden" name="schengenSpouseCompleted" value="0" class="schengenSpouseCompleted">
                                            <div class="form-group row mt-4">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <select name="is_dependent_schengen_visa_issued_last_five_year" id="is_dependent_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option selected disabled>Schengen Or National Visa Issued During Last 5 Years</option>
                                                        <option <?php echo e(($dependent['is_schengen_visa_issued_last_five_year'] == "NO") ? 'selected' : ''); ?> value="NO">No</option>
                                                        <option <?php echo e(($dependent['is_schengen_visa_issued_last_five_year'] == "YES") ? 'selected' : ''); ?> value="YES">Yes</option> 
                                                    </select>
                                                    <label for="is_dependent_schengen_visa_issued_last_five_year">Schengen Or National Visa Issued During Last 5 Years*</label>
                                                    <span class="is_dependent_schengen_visa_issued_last_five_year_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4 dependent_schengen_visa">
                                                <div class="form-floating col-sm-12 mt-3" id="dependent_schengen_visa">
                                                    <input type="text" class="form-control dependent_schengen_copy" name="dependent_schengen_copy" id="dependent_schengen_copy" onclick="showSchengenVisaFormat('dependent')" <?php if($dependent['schengenVisaUrl'] != null): ?> value="<?php echo e($dependent['schengenVisaName']); ?>" <?php else: ?> placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" <?php endif; ?> readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload dependent_schengen_copy" accept="image/png, image/gif, image/jpeg" name="dependent_schengen_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <label for="dependent_schengen_copy">Image of Schengen Or National Visa Issued During Last 5 Years</label>
                                                        
                                                    <?php 
                                                        $cnt = 0; 
                                                        for($i = 1; $i <= 4; $i++)
                                                            {
                                                                if($client['schengenVisaUrl'.$i] != null){
                                                                    $cnt++;
                                                    ?>
                                                                <div class="col-sm-12 mt-3" id="schengen_visa">
                                                                    <input type="text" class="form-control schengen_copy1_<?php echo e($cnt); ?>" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" name="schengen_copy1[]"  value="<?php echo e($client['schengenVisaName'.$i]); ?>" readonly >
                                                                    <div class="input-group-btn">
                                                                        <span class="fileUpload btn">
                                                                            <span class="upl" id="upload">Choose File</span>
                                                                            <input style="position: absolute;top: 0; right: 0; margin: 0; padding: 0; font-size: 20px; cursor: pointer; opacity: 0; filter: alpha(opacity=0);" type="file" class="schengen_copy1_<?php echo e($cnt); ?>" accept="image/png, image/gif, image/jpeg" name="schengen_copy1[]" />
                                                                        </span>
                                                                    </div>
                                                                </div>   
                                                    <?php 
                                                                }
                                                            }
                                                    ?>                                                
                                                </div>
                                                <div style="display: block;color:blue"><a href="#" class="plus" title="click here to add another row for upload" style="display:inline"><i class="fa fa-plus-circle"></i></a> Add another Visa <a href="#" class="minus" id="minus" title="click here to remove the last added row for upload" style="display:inline"><i class="fa fa-minus-circle"></i></a></div>

                                            </div>
                                            <div class="form-group row mt-4" id="is_dependent_finger_print_collected_for_Schengen_visa">
                                                <div class="form-floating col-sm-12 mt-3">
                                                    <select name="is_dependent_finger_print_collected_for_Schengen_visa" id="dependent_finger" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa</option>
                                                        <option <?php echo e(($dependent['is_finger_print_collected_for_Schengen_visa'] == "NO") ? 'selected' : ''); ?> value="NO">No</option>
                                                        <option <?php echo e(($dependent['is_finger_print_collected_for_Schengen_visa'] == "YES") ? 'selected' : ''); ?> value="YES">Yes</option> 
                                                    </select>
                                                    <label for="dependent_finger">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa</label>
                                                    <span class="is_dependent_finger_print_collected_for_Schengen_visa_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                    <button type="submit" class="btn btn-primary submitBtn collapseSpouseSchengen" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="false" aria-controls="collapseSpouseExperience">Ammend</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="applicant-detail-sec" style="margin-bottom: 70px">
                            <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="true" aria-controls="collapseSpouseExperience">
                                <div class="row">
                                    <div class="col-2 my-auto">
                                        <div class="image">
                                            <img src="<?php echo e(asset('images/Icons_experience_details.svg')); ?>" width="70%" height="auto">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="vl"></div>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="first-heading d-flex justify-content-center">
                                            <h3>
                                                Experience
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="importExperience" data-applicantId="<?php echo e($client['id']); ?>" data-dependentId="<?php echo e($dependent); ?>">
                                <div class="collapse show" id="collapseSpouseExperience" data-applicantId="<?php echo e($client['id']); ?>" data-dependentId="<?php echo e(($dependent != null) ? $dependent['id']  : ''); ?>">
                                    <div class="form-sec">
                                        <div class="jobSelected">
                                            <table class="table" v-if="dependentJob.length > 0">
                                                <thead>
                                                    <tr>
                                                        <td>Job Sector</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(job, jobIndex) in dependentJob">
                                                        <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id" aria-expanded="false" :aria-controls="'collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id">{{job.job_title}}</td>
                                                        <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id, 'dependent')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h3>Please add your experience very carefully, and add multiple experiences if you have worked in more than one job sector
                                        </h3>
                                        <h4 style="margin-top:60px">Job Sector List</h4>
                                        <div class="form-group row mt-4 searchForm">
                                            <div class="col-sm-10 mt-3" >
                                                <input type="text" class="form-control" v-model="search" name="search" placeholder="Enter Job Title" >
                                            </div>
                                            <div class="col-sm-2 mt-3" style="padding-left: 0px">
                                                <button class="btn btn-danger" v-on:click="filterJob()">Search</button>
                                            </div>
                                        </div>
                                        <div v-if="filterData.length > 0">
                                            <div  v-for='(data, index) in filterData' class="filterData" >
                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+data.id" aria-expanded="false" :aria-controls="'collapseDependentExperience'+data.id">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <p class="exp-font">{{data.name}}</p>
                                                        </div>
                                                        <div class="col-1 mx-auto my-auto">
                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+data.id" aria-expanded="false" :aria-controls="'collapseDependentExperience'+data.id">
                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" :id="'collapseDependentExperience'+data.id">
                                                    <div class="detail-sec">
                                                        <div class="row">
                                                            <h5>Description</h5>
                                                            <p v-html="data.description"></p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Example Titles</h5>
                                                            <p>{{data.example_titles}}</p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Main Duties</h5>
                                                            <p >
                                                                <span style="white-space: pre-line">{{data.main_duties}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="row">
                                                            <h5>Employement Requirment</h5>
                                                            <p >
                                                                <span style="white-space: pre-line">{{data.employement_requirements}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                            <div class="row">
                                                                <button type="button" v-if="dependentJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                <button type="button" v-else class="btn btn-primary submitBtn addExperience" data-dependentId="<?php echo e($dependent['id']); ?>" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'dependent')" style="line-height: 22px">Add Experience</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="jobCategories.length > 0" >
                                            <div v-for='(jobCategoryOne, index) in jobCategories' class="jobCategory">
                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <p class="exp-font">{{jobCategoryOne.name}}</p>
                                                        </div>
                                                        <div class="col-1 mx-auto my-auto">
                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index">
                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse" :id="'collapseDependentExperience'+index" style="width: 95%; margin-left:2%">
                                                    <div class="jobCategoryTwo"  v-for='(jobCategoryTwo, indexTwo) in jobCategoryOne.job_category_two'>
                                                        <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <p class="exp-font">{{jobCategoryTwo.name}}</p>
                                                                </div>
                                                                <div class="col-1 mx-auto my-auto">
                                                                    <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo">
                                                                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapse" :id="'collapseDependentExperience'+index+indexTwo" style="width: 95%; margin-left:2%">
                                                            <div class="jobCategoryThree" v-for='(jobCategoryThree, indexThree) in jobCategoryTwo.job_category_three'>
                                                                <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo+indexThree">
                                                                    <div class="row">
                                                                        <div class="col-11">
                                                                            <p class="exp-font">{{jobCategoryThree.name}}</p>
                                                                        </div>
                                                                        <div class="col-1 mx-auto my-auto">
                                                                            <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo+indexThree">
                                                                                <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="collapse" :id="'collapseDependentExperience'+index+indexTwo+indexThree" style="width: 95%; margin-left:2%">
                                                                    <div class="jobCategoryThree" v-for='(jobCategoryFour, indexFour) in jobCategoryThree.job_category_four'>
                                                                        <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo+indexThree+indexFour">
                                                                            <div class="row">
                                                                                <div class="col-11">
                                                                                    <p class="exp-font">{{jobCategoryFour.name}}</p>
                                                                                </div>
                                                                                <div class="col-1 mx-auto my-auto">
                                                                                    <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseDependentExperience'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseDependentExperience'+index+indexTwo+indexThree+indexFour">
                                                                                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="collapse" :id="'collapseDependentExperience'+index+indexTwo+indexThree+indexFour">
                                                                            <div class="detail-sec">
                                                                                <div class="row">
                                                                                    <h5>Description</h5>
                                                                                    <p v-html="jobCategoryFour.description"></p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Example Titles</h5>
                                                                                    <p>{{jobCategoryFour.example_titles}}</p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Main Duties</h5>
                                                                                    <p >
                                                                                        <span style="white-space: pre-line">{{jobCategoryFour.main_duties}}</span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <h5>Employement Requirment</h5>
                                                                                    <p >
                                                                                        <span style="white-space: pre-line">{{jobCategoryFour.employement_requirements}}</span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                                                    <div class="row">
                                                                                        <button type="button" v-if="dependentJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                                        <button type="button" v-else class="btn btn-primary submitBtn addExperience" data-dependentId="<?php echo e($dependent['id']); ?>"  v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name, 'dependent')" style="line-height: 22px">Add Experience</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                            <?php if($client['is_spouse'] != null && $client['children_count'] == null): ?>
                                                <button type="submit" class="btn btn-primary submitBtn dependentReview">Submit <i class="fa fa-spinner fa-spin dependentReviewSpin"></i></button>
                                            <?php else: ?> 
                                                <button type="submit" class="btn btn-primary submitBtn dependentNext">Next</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($children): ?>
                    <div class="tab-pane active" id="children" style="margin: 0; padding: 0;">
                        <form method="POST" id="child_details">
                            <?php echo csrf_field(); ?>
                            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="applicant-detail-sec" <?php if($key+1 ==  $client['children_count']): ?> style="margin-bottom:70px" <?php endif; ?>>
                                    <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapsechild<?php echo e($key+1); ?>" aria-expanded="true" aria-controls="collapsechild<?php echo e($key+1); ?>">
                                        <div class="row">
                                            <div class="col-2 my-auto">
                                                <div class="image">
                                                    <img src="<?php echo e(asset('images/child.svg')); ?>" width="70%" height="auto">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="vl"></div>
                                            </div>
                                            <div class="col-6 my-auto">
                                                <div class="first-heading d-flex justify-content-center">
                                                    <h3>
                                                        Child <?php echo e($key+1); ?>

                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                
                                            </div>
                                            <div class="col-2 mx-auto my-auto">
                                                <div class="down-arrow">
                                                    <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="collapse show" id="collapsechild<?php echo e($key+1); ?>">
                                            <div class="form-sec">
                                                <div class="form-group row mt-4">
                                                    <div class="col-sm-4 mt-3 form-floating">
                                                        <input type="hidden" name="applicant_id" value="<?php echo e($applicant['id']); ?>">
                                                        <input type="hidden" name="childrenCount" value="<?php echo e($client['children_count']); ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                                        <input type="hidden" name="child" value="<?php echo e($key+1); ?>">
                                                        <input type="text" name="child_<?php echo e($key+1); ?>_first_name" id="child_<?php echo e($key+1); ?>_first_name" class="form-control child_<?php echo e($key+1); ?>_first_name" placeholder="First Name*" value="<?php echo e($child['name']); ?>" autocomplete="off" />
                                                        <label for="child_<?php echo e($key+1); ?>_first_name">First Name*</label>
                                                        <span class="child_<?php echo e($key+1); ?>_first_name_errorClass"></span>
                                                        <?php $__errorArgs = ['child_<?php echo e($key+1); ?>_first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="col-sm-4 mt-3 form-floating">
                                                        <input type="text" name="child_<?php echo e($key+1); ?>_middle_name" id="child_<?php echo e($key+1); ?>_middle_name" class="form-control " placeholder="Middle Name" value="<?php echo e($child['middle_name']); ?>"  autocomplete="off"/>
                                                        <label for="child_<?php echo e($key+1); ?>_middle_name">Middle Name</label>
                                                    </div>
                                                    <div class="col-sm-4 mt-3 form-floating">
                                                        <input type="text" name="child_<?php echo e($key+1); ?>_surname" id="child_<?php echo e($key+1); ?>_surname" class="form-control child_<?php echo e($key+1); ?>_surname" placeholder="Surname*" value="<?php echo e($child['sur_name']); ?>" autocomplete="off"  />
                                                        <label for="child_<?php echo e($key+1); ?>_surname">Surname*</label>
                                                        <span class="child_<?php echo e($key+1); ?>_surname_errorClass"></span>
                                                        <?php $__errorArgs = ['child_<?php echo e($key+1); ?>_surname'];
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
                                                    <div class="col-sm-6 mt-3 form-floating">
                                                        <input type="text"  name="child_<?php echo e($key+1); ?>_dob" id="child_<?php echo e($key+1); ?>_dob" class="child-dob form-control" placeholder="Date Of Birth*" value="<?php echo e($child['date_of_birth']); ?>">
                                                        <label for="child_<?php echo e($key+1); ?>_dob">Date Of Birth*</label>
                                                        <span class="child_<?php echo e($key+1); ?>_dob_errorClass"></span>
                                                        <?php $__errorArgs = ['child_<?php echo e($key+1); ?>_dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="col-sm-6 mt-3 form-floating">
                                                        <select name="child_<?php echo e($key+1); ?>_gender" id="child_<?php echo e($key+1); ?>_gender" aria-required="true" class="form-control form-select child_<?php echo e($key+1); ?>_gender" >
                                                            <option selected disabled>Sex</option>
                                                            <option <?php echo e(($child['sex'] == 'MALE') ? 'selected' : ''); ?> value="Male">Male</option>
                                                            <option <?php echo e(($child['sex'] == 'FEMALE') ? 'selected' : ''); ?> value="FEMALE">Female</option>
                                                            </select>
                                                        <label for="child_<?php echo e($key+1); ?>_gender">Sex</label>
                                                        <span class="child_<?php echo e($key+1); ?>_gender_errorClass"></span>
                                                        <?php $__errorArgs = ['child_<?php echo e($key+1); ?>_gender'];
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
                                                    <?php if($key+1 ==  $client['children_count']): ?>
                                                        <button type="submit" class="btn btn-primary submitBtn submitChild">Submit <i class="fa fa-spinner fa-spin childReviewSpin"></i></button>  
                                                    <?php else: ?> 
                                                        <button type="button" class="btn btn-primary submitBtn collapsechild<?php echo e($key+2); ?>" data-bs-toggle="collapse" data-bs-target="#collapsechild<?php echo e($key+2); ?>" aria-expanded="false" aria-controls="collapsechild<?php echo e($key+2); ?>">Ammend</button>  
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="passportFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/Passport_Requirement.jpg')); ?>" width="100%" height ="100%">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="passport_upload" class="form-control" placeholder="Upload Passport Copy*"  autocomplete="off" readonly/>
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="passport_upload" id="passport_upload"  name="passport_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="passportModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">            
                        <embed src="<?php echo e($client['passporUrl']); ?>" width="100%" height="400px" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="cvModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <embed src="<?php echo e($client['resumeUrl']); ?>" width="100%" height="400px"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="residenceCopyModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <embed src="<?php echo e($client['residenceUrl']); ?>" width="100%" height="400px"/>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="visaCopyModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <embed src="<?php echo e($client['visaCopyUrl']); ?>" width="100%" height="400px"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="schengenVisatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <embed src="<?php echo e($client['schengenVisaUrl']); ?>" width="100%" height="400px"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if($dependent): ?>
            <div id="resumeModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <embed src="<?php echo e($dependent['resumeUrl']); ?>" width="100%" height="400px"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dependentPassword" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <embed src="<?php echo e($dependent['passportUrl']); ?>" width="100%" height="400px"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dependentResidence" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <embed src="<?php echo e($dependent['residenceUrl']); ?>" width="100%" height="400px"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dependentVisa" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <embed src="<?php echo e($dependent['visaCopyUrl']); ?>" width="100%" height="400px"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dependentSchengenVisatModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <embed src="<?php echo e($dependent['schengenVisaUrl']); ?>" width="100%" height="400px"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="residenceIdFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/ResidenceID.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="residence_upload" placeholder="Residence/Emirates ID*" readonly >
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload residence_upload" id="residence_upload"  name="residence_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="visaFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/Visa.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control"  name="visa_upload" placeholder="Visa Copy" readonly autocomplete="off">
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload visa_upload" id="visa_upload"  name="visa_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="schengenVisaFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/ShengenVisa.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="schengen_upload" readonly >
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload schengen_upload" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="passportDependentFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/Passport_Requirement.jpg')); ?>" width ="760px" height ="760px;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="dependent_passport_upload" class="form-control" placeholder="Upload Passport Copy*"/>
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload dependent_passport_upload" id="dependent_passport_upload"  name="dependent_passport_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="residenceIdDependentFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/ResidenceID.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="dependent_residence_upload" placeholder="Residence/Emirates ID*" readonly >
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload dependent_residence_upload" id="up"  name="dependent_residence_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="visaDependentFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/Visa.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="dependent_visa_upload">
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload dependent_visa_upload" id="up"  name="dependent_visa_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="schengenVisaDependentFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo e(asset('images/ShengenVisa.jpg')); ?>" width ="100%" height ="100%;">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="dependent_schengen_upload"  >
                        <div class="input-group-btn">
                            <span class="fileUpload btn">
                                <span class="upl" id="upload">Choose File</span>
                                <input type="file" class="upload dependent_schengen_upload" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                            </span><!-- btn-orange -->
                        </div><!-- btn -->
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  
        $vall1 = ($client['schengenVisaName1']) ?? null;
        $vall2 = ($client['schengenVisaName2']) ?? null;
        $vall3 = ($client['schengenVisaName3']) ?? null;
        $vall4 = ($client['schengenVisaName4']) ?? null;

        $phold = "Image of Schengen Or National Visa Issued During Last 5 Years";
        $vall1_dep = ($dependent['schengenVisaName1_dep']) ?? null;
        $vall2_dep = ($dependent['schengenVisaName2_dep']) ?? null;
        $vall3_dep = ($dependent['schengenVisaName3_dep']) ?? null;
        $vall4_dep = ($dependent['schengenVisaName4_dep']) ?? null;

        $sheng_dep = ($dependent['schengenVisaUrl1_dep']) ?? null;
        $phold_dep = "Image of Schengen Or National Visa Issued During Last 5 Years";
    ?>
<?php $__env->stopSection(); ?>  
<?php $__env->startPush('custom-scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    var cnt= <?php echo e($cnt); ?>;
    var cnt_dep = 0; 
    var valle=null;
    $(function() {
        //Add more file input box for schengen visa upload
        $('a.pl').click(function(e) {
          e.preventDefault();
          if (cnt < 4) {
            cnt = cnt+1;
            
            if(cnt == 1)
            {
                valle="<?php echo $vall1;?>";                
            }
            else if(cnt === 2)
            {
                 valle="<?php echo $vall2;?>";                
            }
            else if(cnt === 3)
            {
                 valle="<?php echo e(($vall3) ?? null); ?>";                
            }
            else if(cnt === 4)
            {
                 valle="<?php echo $vall4;?>";                
            }
            var appendData = '<div class="col-sm-12 mt-3" id="schengen_visa"><input type="text" class="form-control schengen_copy1_'+cnt+'" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" name="schengen_copy1[]"  ';
            if(valle.length > 1)  { 
                appendData += 'value="'+valle+'"';
            }
            appendData += ' readonly ><div class="input-group-btn"><span class="fileUpload btn"><span class="upl" id="upload">Choose File</span><input style="position: absolute;top: 0; right: 0; margin: 0; padding: 0; font-size: 20px; cursor: pointer; opacity: 0; filter: alpha(opacity=0);" type="file" class="schengen_copy1_'+cnt+'" accept="image/png, image/gif, image/jpeg" name="schengen_copy1[]" /></span></div></div>';
            $('#schengen_visa').append(appendData);
            
        }
        });

        //Remove the extra file input box for schengen visa upload
        $('a.mi').click(function (e) {
            e.preventDefault();
            console.log(this);
            if ($('#schengen_visa div').length > 1) {
                cnt = cnt-1;
                $('#schengen_visa').children().last().remove();
            }
        }); 

        //Add more file input box for depenant schengen visa upload
        $('a.plus').click(function(e) {
            e.preventDefault();
            if($('.dependent_schengen_copy').val()){
                if (cnt_dep < 4) {
                    cnt_dep = cnt_dep+1;
                    if(cnt_dep == 1)
                    {
                        valle_dep="<?php echo $vall1_dep; ?>";                
                    }
                    else if(cnt_dep === 2)
                    {
                        valle_dep="<?php echo $vall2_dep; ?>";                
                    }
                    else if(cnt_dep === 3)
                    {
                        valle_dep="<?php echo $vall3_dep; ?>";                
                    }
                    else if(cnt_dep === 4)
                    {
                        valle_dep="<?php echo $vall4_dep; ?>";                
                    }

                    $('#dependent_schengen_visa').append('<div class="col-sm-12 mt-3" id="dependent_schengen_visa"><input type="text" class="form-control dependent_schengen_copy1_'+cnt_dep+'" name="dependent_schengen_copy1[]" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" <?php if($sheng_dep): ?>  value="'+valle_dep+'"  <?php endif; ?> readonly ><div class="input-group-btn"><span class="fileUpload btn"><span class="upl" id="upload">Choose File</span><input style="position: absolute;top: 0; right: 0; margin: 0; padding: 0; font-size: 20px; cursor: pointer; opacity: 0; filter: alpha(opacity=0);" type="file" class="dependent_schengen_copy1_'+cnt_dep+'" accept="image/png, image/gif, image/jpeg" name="dependent_schengen_copy1[]" /></span></div></div>');
                }
            } else {
                toastr.error('Please fill pevious field before adding field');
            }
        });
        //Remove the extra file input box for dependent schengen visa upload
        $('a.minus').click(function (e) {
            e.preventDefault();
            if ($('#dependent_schengen_visa div').length > 1) {
                cnt_dep = cnt_dep-1;
                $('#dependent_schengen_visa').children().last().remove();
            }
        });  
    });
     
    $(document).on('change',"[name='schengen_copy1[]']", function(){
        let clsName =$(this).attr("class");

        $('.'+clsName).attr("value", ' ');
        $("input[name=schengen_upload]").val('');
    
        var names = [];
        var length = $(this).get(0).files.length;
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            names.push($(this).get(0).files[i].name);
        }
        
        // $("input[name=file]").val(names);
        if(length>2)
        {
            var fileName = names.join(', ');
            $('.'+clsName).attr("value",length+" files selected");
        } else {
            $('.'+clsName).attr("value",names);
        }
        $('.schengen_upload')[0].files[0] = ' ';
    });


    $(document).ready(function()
    {
        $('.dependentReviewSpin, .childReviewSpin, .applicantReviewSpin').hide();
               // Main Applicant
        $('.schengen_visa, .applicantData, .homeCountryData, .currentCountryData, .schengenData, .dependent_schengen_visa, #is_finger_print_collected_for_Schengen_visa', '#is_dependent_finger_print_collected_for_Schengen_visa').hide();
        $('.datepicker, .dependent_datepicker, .child-dob').datepicker({
            maxDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            constrainInput: false   
        });
        $('.passport_issue, .dependent_passport_issue').datepicker({
            maxDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            constrainInput: false   
        });
        $('.passport_expiry, .visa_validity, .dependent_passport_expiry, .dependent_visa_validity').datepicker({
            minDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            constrainInput: false   
        });

        if($('#is_schengen_visa_issued_last_five_year').val() == 'YES') {
            $('.schengen_visa').show();
            $('#is_finger_print_collected_for_Schengen_visa').show();
        } else {
            $('.schengen_visa').hide();
            $('#is_finger_print_collected_for_Schengen_visa').hide();
        }

        if($('#is_dependent_schengen_visa_issued_last_five_year').val() == 'YES') {
            $('.dependent_schengen_visa').show();
            $('#is_dependent_finger_print_collected_for_Schengen_visa').show();
        } else {
            $('.dependent_schengen_visa').hide();
            $('#is_dependent_finger_print_collected_for_Schengen_visa').hide();
        }

        $(".applicantDetails").click(function(e){
            e.preventDefault(); 
            $("#applicant_details").validate();
            $("#applicant_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            var full_number = phoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='phone'").val(full_number);

            var formdata = $('#applicant_details').serialize(); 
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('store.applicant.details')); ?>",
                data: formdata, 
                success: function (data) {
                    if(data.status) {
                        toastr.success('Applicant Details Updated Successfully !');
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $("#home_country_details").submit(function(e){
            e.preventDefault(); 
            $("#home_country_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(this);
            if($("input[name=passport_upload]").val()){   
                formData.append('passport_copy', $('.passport_upload')[0].files[0]);
            }   
            $.ajax({
                type: 'POST',
                url: "<?php echo e(url('store/home/country/details')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Home Country Details Updated Successfully !');
                        $('.passportFrame').src = data.passport;
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('#current_residency').submit(function(e){
            e.preventDefault(); 
            $("#current_residency :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var full_number = phoneCurrentInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='current_residance_mobile'").val(full_number);
            var full_number = phoneCurrentInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='current_residance_mobile'").val(full_number);
            var formData = new FormData(this);
            if($("input[name=visa_upload]").val()){
                formData.append('visa_copy', $('.visa_upload')[0].files[0]);
            }
            if($("input[name=residence_upload]").val()){
                formData.append('residence_copy', $('.residence_upload')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(url('store/current/details')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Current Residence Details Updated Successfully');
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });
        
        $(document).on('change','.up', function(){
            $('.passport_copy, .up').attr("value", ' ');
            $("input[name=passport_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $(this).closest('.form-group').find('.form-control').attr("value",length+" files selected");
            }
            else{
                $('.passport_copy, .up').attr("value",names);
            }
        });
        $(document).on('change','.residence_id', function(){
            $('.residence_copy').attr("value", ' ');
            $("input[name=residence_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.residence_id').attr("value",length+" files selected");
            }
            else{
                $('.residence_id').attr("value",names);
            }
        });
        $(document).on('change','.visa_copy', function(){
            $('.visa_copy').attr("value", ' ');
            $("input[name=visa_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.visa_copy').attr("value",length+" files selected");
            } else {
                $('.visa_copy').attr("value",names);
            }
        });

        $('#is_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_schengen_visa_issued_last_five_year').val() == "YES"){
                $('.schengen_visa').show();
                $('#is_finger_print_collected_for_Schengen_visa').show();
            } else {
                $('.schengen_visa').hide();
                $('#is_finger_print_collected_for_Schengen_visa').hide();
            }
        });

        $('#schengen_details').submit(function(e){
            e.preventDefault(); 
            $("#schengen_details :input").each(function(index, elm){
                if(elm.name == "schengen_copy1[]"){

                } else {
                    $("."+elm.name+"_errorClass").empty();
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(this);
            if($("input[name=schengen_upload]").val()){
                formData.append('schengen_copy', $('.schengen_upload')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(url('store/schengen/details')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) 
                {
                    if(data.status) 
                    {
                        toastr.success('Schengen details updated successfully');
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) 
                        {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) 
                {
                    toastr.error(error);
                }
            });
        });

        $(document).on('change','.schengen_copy', function(){
            $('.schengen_copy').attr("value", ' ');
            $("input[name=schengen_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
            $('.schengen_copy').attr("value",length+" files selected");
            }
            else{
            $('.schengen_copy').attr("value",names);
            }
        });

        function addExperience(cat1, cat2, cat3, cat4, jobTitle)
        {
            $('.jobSelected .table tbody').append('<tr><th style="text-align: left;" data-bs-toggle="collapse" data-bs-target="#collapseExperienceFour"'+cat1+cat2+cat3+cat4+' aria-expanded="false" aria-controls="collapseExperienceFour"'+cat1+cat2+cat3+cat4+'>'+jobTitle+'</th><td style="text-align: right;"><button class="btn btn-danger">Remove</button></td></tr>');
        }

        $('.close').click(function(e){
            $("#passportModal").modal('hide');
            $("#passportFormatModal").modal('hide');
            $("#cvModal").modal('hide');
            $("#cvFormatModal").modal('hide');
            $('#residenceCopyModal').modal('hide');
            $('#visaCopyModal').modal('hide');
            $('#schengenVisatModal').modal('hide');
            $('#resumeModal').modal('hide');
            $('#dependentPassword').modal('hide');
            $('#dependentVisa').modal('hide');
            $('#dependentResidence').modal('hide');
            $('#dependentSchengenVisatModal').modal('hide');
            $("#residenceIdFormatModal").modal('hide');
            $('#visaFormatModal').modal('hide');
            $('#schengenVisaFormatModal').modal('hide');
            $('#passportDependentFormatModal').modal('hide');
            $('#visaDependentFormatModal').modal('hide');
            $('#schengenVisaDependentFormatModal').modal('hide');
            $('#residenceCopyModal').modal('hide');
        });

        $('.applicantReview, .submitChild, .dependentReview').click(function(e){
            $('.dependentReviewSpin , .childReviewSpin, .applicantReviewSpin').show();

            if (confirm("After submit these details can't be changed")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(url('submit/applicant/review/')); ?>",
                    data: {
                        product_id : '<?php echo e($productId); ?>'
                    },
                    success: function (response) {
                        $('.dependentReviewSpin, .childReviewSpin, .applicantReviewSpin').hide();
                        location.href = "<?php echo e(url('myapplication')); ?>"
                    },
                    errror: function (error) {
                        $('.dependentReviewSpin, .childReviewSpin, .applicantReviewSpin').hide();
                    }
                });
            }
        });

        $('.mainApplicant').click(function(){
            $('#mainApplicant').show();
            $('#dependant, #children').hide();
            $('.mainApplicant').addClass('active');
            $('.dependant, .children').removeClass('active');
        });
        $('.dependant').click(function(){
            $('#dependant').show();
            $('#mainApplicant, #children').hide();
            $('.dependant').addClass('active');
            $('.mainApplicant, .children').removeClass('active');
        });
        $('.children').click(function(){
            $('#children').show();
            $('#mainApplicant, #dependant').hide();
            $('.children').addClass('active');
            $('.mainApplicant, .dependant').removeClass('active');
        });

        // Spouse/Dependent
        $('.spouseApplicantData, .spouseHomeCountryData, .spouseCurrentCountryData, .spouseSchengenData').hide();
        $('#dependant, #children').hide();
        $('.passport_upload,.cv_upload, .residence_upload, .visa_upload, .schengen_upload, .dependent_passport_upload, .dependent_residence_upload, .dependent_visa_upload, .dependent_schengen_upload').click(function(){
            $("#passportFormatModal").modal('hide');
            $("#cvFormatModal").modal('hide');
            $("#visaFormatModal").modal('hide');
            $("#residenceIdFormatModal").modal('hide');
            $('#schengenVisaFormatModal').modal('hide');
            $('#passportDependentFormatModal').modal('hide');
            $('#residenceIdDependentFormatModal').modal('hide');
            $('#visaDependentFormatModal').modal('hide');
            $('#schengenVisaDependentFormatModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        })
        $(document).on('change', '.dependent_resume', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_resume').attr("value",length+" files selected");
            }
            else{
                $('.dependent_resume').attr("value",names);
            }
        });

        $('#dependent_applicant_details').submit(function(e){
            e.preventDefault(); 
            $("#dependent_applicant_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var full_number = dependentPhoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='dependent_phone'").val(full_number);
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('store.dependent.details')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Dependent Deails Updated Successfully !');
                        $('.spouseApplicantData').show();
                        $('#collapsespouseHome').addClass('show');
                        $('.dependentApplicantCompleted').val(1);
                        $('.addExperience, .container').attr('data-dependentId', data.dependentId);
                    } else {
                        if(data.message){
                            toastr.error(data.message);
                        }

                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });
        
        $("#dependent_home_country_details").submit(function(e){
            e.preventDefault(); 
            $("#dependent_home_country_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(this);
            if($("input[name=dependent_passport_upload]").val()){
                formData.append('dependent_passport_copy', $('.dependent_passport_upload')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(url('store/spouse/home/country/details')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Dependent Home Country Details Updated Successfully !');
                        $('.spouseHomeCountryData').show();
                        $('#collapseSpouseCurrent').addClass('show');
                        $('.spouseHomeCountryCompleted').val(1);
                        $('.addExperience, .container').data('data-dependentId', data.dependentId);
                    } else {
                        if(data.message){
                            toastr.error(data.message);
                        }
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('#dependent_current_residency').submit(function(e){
            e.preventDefault(); 
            $("#dependent_current_residency :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(('<?php echo e($applicant['work_permit_category']); ?>' == 'FAMILY PACKAGE') && ('<?php echo e($client['is_spouse']); ?>' > 0)){
                const dependentcurrentresidancemobile = document.querySelector("#dependent_current_residance_mobile");
                const dependentcurrentresidancemobileInput = window.intlTelInput(dependentcurrentresidancemobile,{
                    separateDialCode: false,
                    preferredCountries:["ae"],
                    nationalMode: false,
                    hiddenInput: "full",
                    autoHideDialCode: false,
                    utilsScript:'https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js',
                });
                var full_number = dependentcurrentresidancemobileInput.getNumber(intlTelInputUtils.numberFormat.E164);
                $("input[id='dependent_current_residance_mobile'").val(full_number);
                var formData = new FormData(this);
                if($("input[name=dependent_residence_upload]").val()){
                    formData.append('dependent_residence_copy', $('.dependent_residence_upload')[0].files[0]);
                }
                if($("input[name=dependent_visa_upload]").val()){
                    formData.append('dependent_visa_copy', $('.dependent_visa_upload')[0].files[0]);
                }
                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(url('store/spouse/current/details')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.status) {
                            toastr.success('Dependent Current Residence Details Updated Successflly !')
                            $('.spouseCurrentCountryData').show();
                            $('#collapseSpouseSchengen').addClass('show');
                            $('.spouseCurrentCountryCompleted').val(1);
                            $('.addExperience, .container').data('data-dependentId', data.dependentId);
                        } else {
                            if(data.message){
                                toastr.error(data.message);
                            }
                            var validationError = data.errors;
                            $.each(validationError, function(index, value) {
                                $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                                toastr.error(value);
                            });
                        }
                    },
                    errror: function (error) {
                        toastr.error(error);
                    }
                });
            }
            
        });

        $('#dependent_schengen_details').submit(function(e){
            e.preventDefault(); 
            $("#dependent_schengen_details :input").each(function(index, elm){
                if(elm.name == "dependent_schengen_copy1[]"){

                } else {
                    $("."+elm.name+"_errorClass").empty();
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(this);
            if($("input[name=dependent_schengen_upload]").val()){
                formData.append('dependent_schengen_copy', $('.dependent_schengen_upload')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(url('store/spouse/schengen/details')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Dependent Schengen Details Updated Successfully !');
                        $('.spouseSchengenData').show();
                        $('#collapseSpouseExperience').addClass('show');
                        $('.schengenSpouseCompleted').val(1);
                        $('.addExperience, .container').data('data-dependentId', data.dependentId);
                    } else {
                        if(data.message){
                            toastr.error(data.message);
                        }
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('#is_dependent_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_dependent_schengen_visa_issued_last_five_year').val() == "YES"){
                $('.dependent_schengen_visa').show();
                $('#is_dependent_finger_print_collected_for_Schengen_visa').show();
            } else {
                $('.dependent_schengen_visa').hide();
                $('#is_dependent_finger_print_collected_for_Schengen_visa').hide();
            }
        });

        $(document).on('change','.dependent_passport_copy', function(){
            $("#passportFormatModal").modal('hide');
            $('.dependent_passport_copy, .up').attr("value", ' ');
            $("input[name=dependent_passport_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_passport_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_passport_copy, .up').attr("value",names);
            }
        });

        $(document).on('change','.dependent_residence_copy', function(){
            $('.dependent_residence_copy').attr("value", ' ');
            $("input[name=dependent_residence_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.dependent_residence_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_residence_copy').attr("value",names);
            }
        });

        $(document).on('change','.dependent_visa_copy', function(){
            $('.dependent_visa_copy').attr("value", ' ');
            $("input[name=dependent_visa_upload]").val('');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_visa_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_visa_copy').attr("value",names);
            }
        });
        
        $(document).on('change','.dependent_schengen_copy', function(){
            $('.dependent_schengen_copy').attr("value", ' ');
            $("input[name=dependent_schengen_upload]").val(' ');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_schengen_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_schengen_copy').attr("value",names);
            }
        });

        $(document).on('change','.dependent_residence_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.dependent_residence_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_residence_copy').attr("value",names);
                $("input[name=dependent_residence_upload]").val(names);
            }
        });
        $(document).on('change','.dependent_visa_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_visa_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_visa_copy').attr("value",names);
                $("input[name=dependent_visa_upload]").val(names);
            }
        });
        $(document).on('change','.dependent_schengen_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_schengen_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_schengen_copy').attr("value",names);
                $("input[name=dependent_schengen_upload]").val(names);

            }
        });
        $(document).on('change','.dependent_passport_upload', function(){
            $("#passportFormatModal").modal('hide');
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.dependent_passport_copy').attr("value",length+" files selected");
            }
            else{
                $('.dependent_passport_copy, .up').attr("value",names);
                $("input[name=dependent_passport_upload]").val(names);
            }
        });
        $(document).on('change','.residence_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.residence_id').attr("value",length+" files selected");
            }
            else{
                $('.residence_id').attr("value",names);
                $("input[name=residence_upload]").val(names);
            }
        });
        $(document).on('change','.visa_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $('.visa_copy').attr("value",length+" files selected");
            }
            else{
                $('.visa_copy').attr("value",names);
                $("input[name=visa_upload]").attr("value",names);
            }
        });
        $(document).on('change','.schengen_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            if(length>2){
                var fileName = names.join(', ');
                $('.schengen_copy').attr("value",length+" files selected");
            }
            else{
                $('.schengen_copy').attr("value",names);
                $("input[name=schengen_upload]").val(names);
            }
        });
        $(document).on('change', '.passport_upload', function ()  {
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.passport_copy, .passport_upload').attr("value",length+" files selected");
            }
            else{
                $('.passport_upload, .passport_copy').attr("value",names);
                $("input[name=passport_upload]").attr("value",names);
            }
        })
        // children

        for(var i= 1 ; i<='<?php echo e($client['children_count']); ?>'; i++)
        {
            $('.childData'+i).hide();
        }

        $('#child_details').submit(function(e){
            e.preventDefault(); 
            $("#child_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('store.children.details')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        toastr.success('Data Updated Successully');
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo e(url('submit/applicant/review/')); ?>",
                            data: {
                                product_id : '<?php echo e($productId); ?>'
                            },
                            success: function (response) {
                                $('.dependentReviewSpin, .childReviewSpin, .applicantReviewSpin').hide();
                                location.href = "<?php echo e(url('myapplication')); ?>"
                            },
                            errror: function (error) {
                                $('.dependentReviewSpin, .childReviewSpin, .applicantReviewSpin').hide();
                            }
                        });
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('.applicantNext').click(function(e){
            e.preventDefault(); 
            if('<?php echo e($client['is_spouse']); ?>' == null || '<?php echo e($client['is_spouse']); ?>' == 0){
                $('#children').show();
                $('#mainApplicant, #dependant').hide();
                $('.children').addClass('active');
                $('.mainApplicant, .dependant').removeClass('active');
                $(window).scrollTop(0);
            } else {
                $('#dependant').show();
                $('#mainApplicant, #children').hide();
                $('.dependant').addClass('active');
                $('.mainApplicant, .children').removeClass('active');
                $('#collapsespouseapplicant').addClass('show');
                $(window).scrollTop(0);
            }
        });

        $('.dependentNext').click(function(e){
            e.preventDefault(); 
            $('#children').show();
            $('#mainApplicant, #dependant').hide();
            $('.children').addClass('active');
            $('.mainApplicant, .dependant').removeClass('active');
            $(window).scrollTop(0);
        });

        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:'https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js',
        });

        const phoneCurrentInputField = document.querySelector("#current_residance_mobile");
        const phoneCurrentInput = window.intlTelInput(phoneCurrentInputField, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:'https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js',
        });
        let dependentPhoneInput = null;
        let dependentcurrentresidancemobileInput = null;
        if(('<?php echo e($applicant['work_permit_category']); ?>' == 'FAMILY PACKAGE') && ('<?php echo e($client['is_spouse']); ?>' > 0)){
            const dependentPhone = document.querySelector("#dependent_phone");
            dependentPhoneInput = window.intlTelInput(dependentPhone,{
                separateDialCode: false,
                preferredCountries:["ae"],
                nationalMode: false,
                hiddenInput: "full",
                autoHideDialCode: false,
                utilsScript:'https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js',
            });

            const dependentcurrentresidancemobile = document.querySelector("#dependent_current_residance_mobile");
            dependentcurrentresidancemobileInput = window.intlTelInput(dependentcurrentresidancemobile,{
                separateDialCode: false,
                preferredCountries:["ae"],
                nationalMode: false,
                hiddenInput: "full",
                autoHideDialCode: false,
                utilsScript:'https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js',
            });
        }
    });
    function showPassport()
    {
        $("#passportModal").modal('show');
    }

    function showCV()
    {
        $("#cvModal").modal('show');
    }

    function showPassportFormat(type)
    {
        if(type == 'applicant') {
            $("#passportFormatModal").modal('show');
        } else {
            $("#passportDependentFormatModal").modal('show');
        }
    }

    function showResumeFormat(type)
    {
        if(type == 'applicant') {
            $("#cvFormatModal").modal('show');
        }
    }
    
    function residenceCopyModal()
    {
        $('#residenceCopyModal').modal('show');
    }

    function visaCopyModal()
    {
        $('#visaCopyModal').modal('show');
    }

    function schengenVisatModal()
    {
        $('#schengenVisatModal').modal('show');
    }

    function showResume()
    {
        $('#resumeModal').modal('show');
    }

    function dependentPassword()
    {
        $('#dependentPassword').modal('show');
    }

    function dependentVisa()
    {
        $('#dependentVisa').modal('show');
    }

    function dependentResidence()
    {
        $('#dependentResidence').modal('show');
    }

    function dependentSchengenVisatModal()
    {
        $('#dependentSchengenVisatModal').modal('show');
    }
    function showResidenceIdFormat(type) 
    {
        if(type == 'applicant') {
            $("#residenceIdFormatModal").modal('show');
        } else if(type == 'dependent') {
            $("#residenceIdDependentFormatModal").modal('show');
        }
    } 

    function showVisaFormat(type)
    {
        if(type == 'applicant') {
            $("#visaFormatModal").modal('show');
        } else if(type == 'dependent') {
            $("#visaDependentFormatModal").modal('show');
        }
    }

    function showSchengenVisaFormat(type)
    {
        if(type == 'applicant') {
            $("#schengenVisaFormatModal").modal('show');
        } else if(type == 'dependent') {
            $("#schengenVisaDependentFormatModal").modal('show');
        }
    }
</script>

<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !=43)
            return false;
        return true;
    }
</script>
<script src="https://unpkg.com/vue@next"></script>
<script src="<?php echo e(asset('js/application-details.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/alert.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/application-review.blade.php ENDPATH**/ ?>