<div class="tab-pane active" id="mainApplicant">

    <div class="applicant-detail-sec">
        <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseReferrer" aria-expanded="false" aria-controls="collapseReferrer">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="<?php echo e(asset('images/refferal.png')); ?>" width="85%" height="100%" alt="PWG Group" style="opacity: 0.82;">
                    </div>
                </div>
                <div class="col-1">
                    <div class="vl"></div>
                </div>
                <div class="col-6 my-auto">
                    <div class="first-heading d-flex justify-content-center">
                        <h3>
                            <?php echo e(__('Refferer Details')); ?>

                        </h3>
                    </div>
                </div>
                <div class="col-1">
                    <div class="dataCompleted referralData">
                        <img src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow">
                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseReferrer">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="referrer_details">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="referrerName" id="floatingInput" class="form-control referrerName" placeholder="Referrer Name" value="<?php echo e($applicant['referrer_name_by_client']); ?>" autocomplete="off" />
                                <label for="floatingInput">Referrer Name(if you have any)</label>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="referrerPassport" id="floatingInput" class="form-control referrerPassport" placeholder="Referrer Name" value="<?php echo e($applicant['referrer_passport_number_by_client']); ?>" autocomplete="off" />
                                <label for="floatingInput">Referrer Passport Number(if you have any)</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn collapseReferrer" data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="false" aria-controls="collapseapplicant">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec">
        <div class="heading applicantsec" data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="false" aria-controls="collapseapplicant">
            <div class="row">
                <div class="col-2">
                    <div class="image my-auto">
                        <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="100%" height="100%" alt="PWG Group">
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
                <div class="col-1">
                    <div class="dataCompleted applicantData">
                        <img src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved" >
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow">
                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="collapseapplicant" class="collapse">
                <div class="form-sec">
                    <?php
                        $name = explode(' ', $client['name']);
                       
                        // $clt_name = explode(' ', strtolower($client['sales_agent_name_by_client']));

                        // $agents = DB::table('employees')
                        // ->where(DB::raw('lower(name)'), '=', $clt_name[0])
                        // // ->orWhere(DB::raw('lower(sur_name)'), '=', $clt_name[0])
                        // ->where(DB::raw('lower(sur_name)'), '=', $clt_name[1])
                        // // ->orWhere(DB::raw('lower(name)'), '=', $clt_name[1])
                        // ->whereIn('designation_id', [1,33,35])
                        // ->orderBy('id','desc')
                        // ->first();
                        // if (isset($agents))
                        // {
                        //     $agent_id = $agents->id;
                        //     $agent_branch_id = $agents->branch_id;
                        //     $agent_phone_number = $agents->phone_number;
                        // } else {
                        //     $agent_id = '';
                        //     $agent_branch_id = '';
                        //     $agent_phone_number = '';
                        // }
                    ?>

                    <form method="POST" enctype="multipart/form-data" id="applicant_details">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                        <input type="hidden" name="applicantCompleted" value="0" class="applicantCompleted">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="first_name" class="form-control first_name" id="floatingInput" placeholder="First Name*" value="<?php echo e($name[0]); ?>" autocomplete="off"/>
                                <label for="floatingInput">First Name*</label>
                                <span class="first_name_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="middle_name" class="form-control" id="floatingInput" placeholder="Middle Name" <?php if(isset($client['middle_name'])): ?> value="<?php echo e($client['middle_name']); ?>" <?php else: ?> value="<?php echo e(old('middle_name')); ?>" <?php endif; ?> autocomplete="off"/>
                                <label for="floatingInput">Middle Name</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="surname" id="floatingInput" class="form-control surname" <?php if(isset($client['sur_name'])): ?> value="<?php echo e($client['sur_name']); ?>" <?php elseif(count($name) > 1): ?> value="<?php echo e($name[count($name) - 1]); ?>" <?php else: ?> value="<?php echo e(old('surname')); ?>" <?php endif; ?> placeholder="Surname*"  autocomplete="off"  />
                                <label for="floatingInput">Surname*</label>
                                <span class="surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="email" id="floatingInput" class="form-control email" placeholder="Email*" value="<?php echo e($client['email']); ?>" autocomplete="off" />
                                <label for="floatingInput">Email*</label>
                                <span class="email_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="hidden" name="phone_number_label" class="form-control phone_number_label" id="phone_number_label" placeholder="Phone Number*" autocomplete="off"/>
                                <input type="tel" onkeypress="return isNumberKey(event)" name="phone_number" class="form-control phone_number phone" placeholder="Phone Number*" value="<?php echo e($client['phone_number']); ?>" autocomplete="off"  />
                                <span class="phone_number_errorClass"></span>
                                <label for="phone_number_label" style="margin-top: -5px !important; margin-left: -5px !important;">Phone Number*</label>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3 dob">
                                <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth*" <?php if(isset($client['date_of_birth'])): ?> value="<?php echo e($client['date_of_birth']); ?>" <?php else: ?> value="<?php echo e(old('dob')); ?>" <?php endif; ?> id="datepicker" autocomplete="off"  readonly="readonly" />
                                <label for="datepicker">Date of Birth*</label>
                                <span class="dob_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="place_birth" class="form-control place_birth" id="place_birth" placeholder="Place of Birth*" <?php if(isset($client['place_of_birth'])): ?> value="<?php echo e($client['place_of_birth']); ?>" <?php else: ?> value="<?php echo e(old('place_birth')); ?>" <?php endif; ?> autocomplete="off" />
                                <label for="place_birth">Place of Birth*</label>
                                <span class="place_birth_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control country_birth" name="country_birth" id="country_birth" placeholder="Country of Birth*" <?php if(isset($client['country_of_birth'])): ?> value="<?php echo e($client['country_of_birth']); ?>" <?php else: ?> value="<?php echo e(old('country_birth')); ?>" <?php endif; ?> >
                                    <?php if(isset($client['country_of_birth'])): ?>
                                     <option selected> <?php echo e($client['country_of_birth']); ?></option>
                                    <?php else: ?>
                                     <option selected disabled>Country of Birth</option>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="country_birth">Country of Birth*</label>
                                <span class="country_birth_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control citizenship" name="citizenship" id="Citizenship" placeholder="Citizenship*" <?php if(isset($client['citizenship'])): ?> value="<?php echo e($client['citizenship']); ?>" <?php else: ?> value="<?php echo e(old('citizenship')); ?>" <?php endif; ?> >
                                    <?php if(isset($client['citizenship'])): ?>
                                     <option selected> <?php echo e($client['citizenship']); ?></option>
                                    <?php else: ?>
                                     <option selected disabled>Citizenship</option>
                                    <?php endif; ?> 
                                    <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="Citizenship">Citizenship*</label>
                                <span class="citizenship_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="sex"  aria-required="true" id="sex" class="form-control form-select sex" <?php if(isset($client['sex'])): ?> value="<?php echo e($client['sex']); ?>" <?php else: ?> value="<?php echo e(old('sex')); ?>" <?php endif; ?>>
                                   <?php if(isset($client['sex'])): ?>
                                    <option selected> <?php echo e($client['sex']); ?></option>
                                   <?php else: ?>
                                    <option selected disabled>Sex</option>
                                   <?php endif; ?> 
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <label for="sex">Sex *</label>
                                <span class="sex_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="civil_status" id="civil_status"  aria-required="true" class="form-control form-select" <?php if(isset($client['civil_status'])): ?> value="<?php echo e($client['civil_status']); ?>" <?php else: ?> value="<?php echo e(old('civil_status')); ?>" <?php endif; ?>>
                                   <?php if(isset($client['civil_status'])): ?>
                                    <option selected> <?php echo e($client['civil_status']); ?></option>
                                   <?php else: ?>
                                    <option selected disabled>Civil Status</option>
                                   <?php endif; ?> 
                                    <option value="SINGLE">Single</option>
                                    <option value="MARRIED">Married</option>
                                    <option value="SEPARATED">Separated</option>
                                    <option value="DIVORCED">Divorced</option>
                                    <option value="WIDOW">Widow</option>
                                    <option value="OTHER">Other</option>
                                </select>
                                <label for="civil_status">Civil Status *</label>
                                <span class="civil_status_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-floating agent_code col-sm-12 mt-3">
                            
                            <input type="hidden" name="agent_name" id="agent_name" class="form-control" placeholder="Please enter your agent name here if available" value="<?php echo e($client['sales_agent_name_by_client']); ?>"/>
                            
                            
                            <label for="agent_code">Please enter your agent code here if available</label>
                            <span class="agent_code_errorClass"></span>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" class="form-control cvupload"  id="cvupload" placeholder="Upload your cv (PDF only)*" name="cv" value="<?php echo e(old('cv')); ?>" readonly required>
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload cvupload" id="up"  name="cv" accept=".pdf, .doc" onchange="readURL(this);" />
                                        </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="cvupload">Upload your cv (PDF & DOC only)*</label>
                                <span class="cv_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn applicantDetails" >Continue</button>
                            </div>
                        </div>
                    </form>
                </div>   
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec home_country_details">
        <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="false" aria-controls="collapseHome">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="<?php echo e(asset('images/Icons_home_country_details.svg')); ?>" width="100%" height="100%" alt="PWG Group">
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
                <div class="col-1">
                    <div class="dataCompleted homeCountryData">
                        <img src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved" >
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow">
                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseHome">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="home_country_details">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="homeCountryCompleted" value="0" class="homeCountryCompleted">
                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="passport_number" class="form-control passport_number" id="floatingInput" placeholder=" Passport Number*" value="<?php echo e(old('passport_number')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Passport Number*</label>
                                <span class="passport_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="passport_issue" class="form-control passport_issue" id="passport_issue" placeholder="Passport Date of Issue*" value="<?php echo e(old('passport_issue')); ?>" autocomplete="off" readonly="readonly"/>
                                <label for="passport_issue"> Passport Date of Issue*</label>
                                <span class="passport_issue_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="passport_expiry" class="form-control passport_expiry" id="passport_expiry" placeholder="Passport Date of Expiry*" value="<?php echo e(old('passport_expiry')); ?>" autocomplete="off" readonly="readonly"/>
                                <label for="passport_expiry">Passport Date of Expiry*</label>
                                <span class="passport_expiry_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="issued_by" class="form-control issued_by" id="issued_by" placeholder="Issued By(Authority that issued the passport)*" value="<?php echo e(old('issued_by')); ?>" autocomplete="off"/>
                                <label for="issued_by">Issued By(Authority that issued the passport)*</label>
                                <span class="issued_by_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="passport_copy" class="form-control passport_copy" id="passport_copy" placeholder="Upload Passport Copy*" value="<?php echo e(old('passport_copy')); ?>" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload" onclick="showPassportFormat()">Choose File</span>
                                        
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="passport_copy">Upload Passport Copy*</label>
                                <span class="passport_copy_errorClass"></span>
                            </div>
                            
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating  col-sm-3 mt-3">
                                <select class="form-select form-control home_country" name="home_country" placeholder="home_country*" id="home_country" value="<?php echo e(old('home_country')); ?>" autocomplete="off">
                                    <option selected disabled>Home Country</option>
                                    <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="home_country">Home Country</label>
                                <span class="home_country_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-3 mt-3">
                                <input type="text" name="state" id="state" class="form-control state" placeholder="State/Province*" autocomplete="off">
                                <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <label for="state">State/Province*</label>
                                <span class="state_errorClass"></span>
                            </div>
                            <div class="form-floating  col-sm-3 mt-3">
                                <input type="text" name="city" id="city" class="form-control city" placeholder="City*" autocomplete="off">
                                <label for="city">City*</label>
                                <span class="city_errorClass"></span>
                            </div>
                            <div class="form-floating  col-sm-3 mt-3">
                                <input type="integer" name="postal_code" id="postal_code" value="<?php echo e(old('postal_code')); ?>" class="form-control postal_code" placeholder="Postal Code*" autocomplete="off">
                                <label for="postal_code">Postal Code*</label>
                                <span class="postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="address_1" id="address_1" class="form-control address_1" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                <label for="address_1">Address (Street And Number) Line 1*</label>
                                <span class="address_1_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="address_2" class="form-control address_2" id="address_2" placeholder="Address (Street And Number) Line 2" autocomplete="off">
                                <label for="address_2">Address (Street And Number) Line 2</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn homeCountryDetails" >Continue</button>
                            </div>
                        </div>
                    </form>
                </div>   
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec">
        <div class="heading" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="false" aria-controls="collapseCurrent">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="<?php echo e(asset('images/Icons_current_residency_and_work_details.svg')); ?>" width="100%" height="100%" alt="PWG Group">
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
                <div class="col-1">
                    <div class="dataCompleted currentCountryData">
                        <img src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
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
            <div class="collapse" id="collapseCurrent">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="current_residency">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                        <input type="hidden" name="currentCountryCompleted" value="0" class="currentCountryCompleted">
                        <div class="form-group row mt-4">
                            
                            
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-lg-6 col-sm-12 mt-3">
                                
                                    <select title="Current Location" class="form-control  current_location form-select" id="current_location" name="current_location" required>
                                        <option selected disabled>--Current Location*--</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                
                                <label for="current_location">Current Location*</label>
                                <span class="current_location_errorClass"></span>
                                
                            </div>
                            
                            <div class="form-floating col-lg-6 col-sm-12 mt-3">    
                                
                                    <select title="Embassy Appearance Country" class="form-control  embassy_appearance form-select" id="embassy_appearance" placeholder="Country of Embassy Appearance*" name="embassy_appearance" required="">
                                        <option selected disabled>--Country of Embassy Appearance*--</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <?php $__currentLoopData = Constant::countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                
                                <label for="embassy_appearance">Country of Embassy Appearance*</label>
                                <span class="embassy_appearance_errorClass"></span>
                                
                            </div>

                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="hidden" name="current_residence_phone_number_label" class="form-control current_residence_phone_number_label" id="current_residence_phone_number_label" placeholder="Phone Number*" autocomplete="off"/>
                                <input type="tel" class="form-control" onkeypress="return isNumberKey(event)" id="current_residance_mobile" name='current_residance_mobile' value="<?php echo e(old('current_residance_mobile')); ?>" placeholder="Current Residence Mobile Number" autocomplete="off">
                                <span class="current_residance_mobile_errorClass"></span>
                                <label for="current_residence_phone_number_label" style="margin-top: -5px !important; margin-left: -5px !important;">Phone Number*</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="residence_id" class="form-control" id="residence_id" placeholder="Residence Id*" autocomplete="off"/>
                                <label for="residence_id">Residence Id*</label>
                                <span class="residence_id_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control visa_validity" name="visa_validity" id="visa_validity" placeholder="Your ID/Visa Date of Validity*" readonly="readonly">
                                <label for="visa_validity">Your ID/Visa Date of Validity*</label>
                                <span class="visa_validity_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" class="form-control residence_id" id="residence_copy" name="residence_copy" onclick="showResidenceIdFormat('applicant')" placeholder="Residence/Emirates ID*" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload" onclick="showResidenceIdFormat('applicant')">Choose File</span>
                                        
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="residence_copy">Residence/Emirates ID*</label>
                                <span class="residence_copy_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" class="form-control visa_copy" id="visa_copy" onclick="showVisaFormat('applicant')" name="visa_copy" placeholder="Visa Copy" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload" onclick="showVisaFormat('applicant')">Choose File</span>
                                        
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="visa_copy">Visa Copy</label>
                            </div>
                        </div>
                        
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="work_state" class="form-control" id="work_state" placeholder="Work State/Province*" autocomplete="off"/>
                                <label for="work_state">Work State/Province*</label>
                                <span class="work_state_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" name="work_city" id="work_city" placeholder="Work City*" autocomplete="off">
                                <label for="work_city">Work City*</label>
                                <span class="work_city_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" name="work_postal_code" id="work_postal_code" placeholder="Work Place Postal Code*" autocomplete="off">
                                <label for="work_postal_code">Work Place Postal Code*</label>
                                <span class="work_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating  col-sm-4 mt-3">
                                <input type="text" name="work_street" id="work_street" class="form-control" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                <label for="work_street">Work Place Street & Number*</label>
                                <span class="work_street_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Name of Company" autocomplete="off">
                                <label for="company_name">Name of Company</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)" name="employer_phone" id="employer_phone" placeholder="Employer Phone Number" autocomplete="off">
                                <label for="employer_phone">Employer Phone Number</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="email" name="employer_email" id="employer_email" class="form-control" placeholder="Email of the employer" autocomplete="off">
                                <label for="employer_email">Email of the employer</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn collapseCurrent" >Continue</button>
                            </div>
                        </div>
                    </form>
                </div>   
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec">
        <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseSchengen" aria-expanded="false" aria-controls="collapseSchengen">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="<?php echo e(asset('images/Icons_schengen_details.svg')); ?>" width="100%" height="100%" alt="PWG Group">
                    </div>
                </div>
                <div class="col-1">
                    <div class="vl"></div>
                </div>
                <div class="col-6 my-auto">
                    <div class="first-heading d-flex justify-content-center">
                        <h3>
                            <?php echo e(__('Schengen Details')); ?>

                        </h3>
                    </div>
                </div>
                <div class="col-1">
                    <div class="dataCompleted schengenData">
                        <img src="<?php echo e(asset('images/Affiliate_Program_Section_completed.svg')); ?>" alt="PWG Group approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow">
                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseSchengen">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="schengen_details">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                        <input type="hidden" name="schengenCompleted" value="0" class="schengenCompleted">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <select name="is_schengen_visa_issued_last_five_year" id="is_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option selected disabled>Schengen Or National Visa Issued During Last 5 Years</option>
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
                                </select>
                                <label for="is_schengen_visa_issued_last_five_year">Schengen Or National Visa Issued During Last 5 Years*</label>
                                <span class="is_schengen_visa_issued_last_five_year_errorClass"></span>
                            </div>
                        </div>
                        <?php  
                            $vall = $client['schengenVisaName'];
                            $sheng = $client['schengenVisaUrl'];
                            $phold = "Image of Schengen Or National Visa Issued During Last 5 Years";
                        ?>
                        <div class="form-group row mt-4 schengen_visa">
                            <div class="form-floating col-sm-12 mt-3" id="schengen_visa">
                                <input type="text" class="form-control schengen_copy" id="schengen_copy" onclick="showSchengenVisaFormat('applicant')" name="schengen_copy" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload" onclick="showSchengenVisaFormat('applicant')">Choose File</span>
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="schengen_copy">Image of Schengen Or National Visa Issued During Last 5 Years</label>
                            </div>
                            <div style="display: block;color:blue"><a href="#" class="pl" title="click here to add another row for upload" style="display:inline"><i class="fa fa-plus-circle"></i></a> Add another Visa <a href="#" class="mi" id="mi" title="click here to remove the last added row for upload" style="display:inline"><i class="fa fa-minus-circle"></i></a></div>
                        </div>
                        <!-- Add more inputs dynamycally here -->

                        <div class="form-group row mt-4" id="is_finger_print_collected_for_Schengen_visa" >
                            <div class="form-floating col-sm-12 mt-3">
                                <select name="is_finger_print_collected_for_Schengen_visa" id="floating_input" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa</option>
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
                                </select>
                                <label for="floating_input">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</label>
                                <span class="is_finger_print_collected_for_Schengen_visa_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn collapseSchengen" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="false" aria-controls="collapseExperience">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec" style="margin-bottom: 103px">
        <div class="heading"  data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="false" aria-controls="collapseExperience">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="<?php echo e(asset('images/Icons_experience_details.svg')); ?>" width="100%" height="100%">
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
                        <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div id="importExperience" data-applicantId="<?php echo e($applicant['id']); ?>" data-dependentId="<?php echo e($dependent); ?>">
            <?php echo $__env->make('user.experience', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/main-applicant-detail.blade.php ENDPATH**/ ?>