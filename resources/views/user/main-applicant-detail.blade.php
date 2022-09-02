<div class="tab-pane active" id="mainApplicant">
    <div class="applicant-detail-sec">
        <div class="heading">
            <div class="row">
                <div class="col-2">
                    <div class="image my-auto">
                        <img src="{{asset('images/Icons_applicant_details.svg')}}" width="70%" height="auto">
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
                        <div class="dataCompleted applicantData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="false" aria-controls="collapseapplicant">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="collapseapplicant" class="collapse">
                <div class="form-sec">
                    @php
                        $name = explode(' ', $user['name']);
                    @endphp
                    
                    <form method="POST" enctype="multipart/form-data" id="applicant_details">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="hidden" name="applicantCompleted" value="0" class="applicantCompleted">
                                <input type="text" name="first_name" class="form-control first_name" placeholder="First Name*" value="{{$name[0]}}" autocomplete="off"/>
                                <span class="first_name_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{old('middle_name')}}"  autocomplete="off"/>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="surname" class="form-control surname" placeholder="Surname*" value="{{$name[count($name)-1]}}" autocomplete="off"  />
                                <span class="surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="email" class="form-control email" placeholder="Email*" value="{{$user['email']}}" autocomplete="off" />
                                <span class="email_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" name="phone_number" class="form-control phone_number" id="phone" placeholder="Phone Number*" value="{{$user['phone_number']}}" autocomplete="off"  />
                                <span class="phone_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3 dob">
                                <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth*" value="{{old('dob')}}" id="datepicker" autocomplete="off"  readonly="readonly" />
                                <span class="dob_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="place_birth" class="form-control place_birth" placeholder="Place of Birth*" value="{{old('place_birth')}}" autocomplete="off" />
                                <span class="place_birth_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select class="form-select form-control country_birth" name="country_birth" placeholder="Country of Birth*" value="{{old('country_birth')}}"  >
                                    <option selected disabled>Country of Birth *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="country_birth_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <select class="form-select form-control citizenship" name="citizenship" placeholder="Citizenship*" value="{{old('citizenship')}}"  >
                                    <option selected disabled>Citizenship *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="citizenship_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select name="sex"  aria-required="true" class="form-control form-select sex" >
                                    <option selected disabled>Sex *</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <span class="sex_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select name="civil_status" id="civil_status"  aria-required="true" class="form-control form-select">
                                    <option selected disabled>Civil Status *</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widow">Widow</option>
                                    <option value="Other">Other</option>
                                </select>
                                <span class="civil_status_errorClass"></span>
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_home_country_details.svg')}}" width="70%" height="auto">
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
                        <div class="dataCompleted homeCountryData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="false" aria-controls="collapseHome">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseHome">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="home_country_details">
                        @csrf
                        <input type="hidden" name="homeCountryCompleted" value="0" class="homeCountryCompleted">
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="passport_number" class="form-control passport_number" placeholder="Passport Number*" value="{{old('passport_number')}}" autocomplete="off"/>
                                <span class="passport_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="passport_issue" class="form-control passport_issue" placeholder="Passport Date of Issue*" value="{{old('passport_issue')}}" autocomplete="off"/>
                                <span class="passport_issue_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="passport_expiry" class="form-control passport_expiry" placeholder="passport Date of Expiry*" value="{{old('passport_expiry')}}" autocomplete="off" />
                                <span class="passport_expiry_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="issued_by" class="form-control issued_by" placeholder="Issued By(Authority that issued the passport)*" value="{{old('issued_by')}}" autocomplete="off"/>
                                <span class="issued_by_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="passport_copy" class="form-control passport_copy" placeholder="Upload Passport Copy*" value="{{old('passport_copy')}}" data-toggle="modal" class="passportFormatModal" data-target="#passportFormatModal" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up passport_copy" id="up"  name="passport_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="passport_copy_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" name="home_phone_number" class="form-control home_phone_number" placeholder="Phone Number" value="{{old('home_phone_number')}}" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-3 mt-3">
                                <select class="form-select form-control home_country" name="home_country" placeholder="home_country*" value="{{old('home_country')}}" autocomplete="off">
                                    <option selected disabled>Home Country *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="home_country_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="text" name="state" class="form-control state" placeholder="State/Province*" autocomplete="off">
                                @error('state') <span class="error">{{ $message }}</span> @enderror
                                <span class="state_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="text" name="city" class="form-control city" placeholder="City*" autocomplete="off">
                                <span class="city_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="integer" name="postal_code" value="{{old('postal_code')}}" class="form-control postal_code" placeholder="Postal Code*" autocomplete="off">
                                <span class="postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="address_1" class="form-control address_1" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                <span class="address_1_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="address_2" class="form-control address_2" placeholder="Address (Street And Number) Line 2*" autocomplete="off">
                                <span class="address_2_errorClass"></span>
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_current_residency_and_work_details.svg')}}" width="70%" height="100px">
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
                        <div class="dataCompleted currentCountryData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="false" aria-controls="collapseCurrent">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseCurrent">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="current_residency">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="currentCountryCompleted" value="0" class="currentCountryCompleted">
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <select class="form-select form-control" name="current_country" placeholder="current_country*" value="{{old('current_country')}}"  >
                                    <option selected disabled>Current Country Are You Living Right Now? *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="current_country_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" class="form-control" name='current_residance_mobile' value="{{old('current_residance_mobile')}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                <span class="current_residance_mobile_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="residence_id" class="form-control" placeholder="Residence Id*" autocomplete="off"/>
                                <span class="residence_id_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control visa_validity" name="visa_validity" placeholder="Your ID/Visa Date of Validity*" >
                                <span class="visa_validity_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control residence_id" name="residence_copy" placeholder="Residence/Emirates ID*" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload residence_id" id="up"  name="residence_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="residence_copy_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control visa_copy" name="visa_copy" placeholder="Visa Copy" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload visa_copy" id="up"  name="visa_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                <span class="current_job_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="work_state" class="form-control" placeholder="Work State/Province*" autocomplete="off"/>
                                <span class="work_state_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="work_city" placeholder="Work City*" autocomplete="off">
                                <span class="work_city_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="work_postal_code" placeholder="Work Place Postal Code*" autocomplete="off">
                                <span class="work_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="work_street" class="form-control" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                <span class="work_street_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="company_name" placeholder="Name of Company" autocomplete="off">
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="employer_phone" placeholder="Employer Phone Number" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="email" name="employer_email" class="form-control" placeholder="Email of the employer" autocomplete="off">
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_schengen_details.svg')}}" width="70%" height="auto">
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
                        <div class="dataCompleted schengenData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSchengen" aria-expanded="false" aria-controls="collapseSchengen">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseSchengen">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="schengen_details">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="schengenCompleted" value="0" class="schengenCompleted">
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select name="is_schengen_visa_issued_last_five_year" id="is_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option selected disabled>Schengen Or National Visa Issued During Last 5 Years*</option>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <span class="is_schengen_visa_issued_last_five_year_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4 schengen_visa">
                            <div class="col-sm-12 mt-3">
                                <input type="text" class="form-control schengen_copy" name="schengen_copy" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select name="is_finger_print_collected_for_Schengen_visa" id="is_finger_print_collected_for_Schengen_visa" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</option>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
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

    <div class="applicant-detail-sec" style="margin-bottom: 70px">
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_experience_details.svg')}}" width="70%" height="auto">
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
                        <div class="dataCompleted experiencenData" v-if="selectedJob.length > 0">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="false" aria-controls="collapseExperience">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseExperience">
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
                                    <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id" aria-expanded="false" :aria-controls="'collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id">@{{job.job_title}}</td>
                                    <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                                <div class="row">
                                    <div class="col-11">
                                        <p class="exp-font">@{{data.name}}</p>
                                    </div>
                                    <div class="col-1 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
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
                                        <p>@{{data.example_titles}}</p>
                                    </div>
                                    <div class="row">
                                        <h5>Main Duties</h5>
                                        <p >
                                            <span style="white-space: pre-line">@{{data.main_duties}}</span>
                                        </p>
                                    </div>
                                    <div class="row">
                                        <h5>Employement Requirment</h5>
                                        <p >
                                            <span style="white-space: pre-line">@{{data.employement_requirements}}</span>
                                        </p>
                                    </div>
                                    <div class="form-group row mt-4" style="margin-bottom: 20px">
                                        <div class="row">
                                            <button type="button" v-if="selectedJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                            <button type="button" class="btn btn-primary submitBtn" applicantId="{{$applicant['id']}}" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'applicant')" style="line-height: 22px">Add Experience</button>
                                        </div>
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
                                        <p class="exp-font">@{{jobCategoryOne.name}}</p>
                                    </div>
                                    <div class="col-1 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+index" aria-expanded="false" :aria-controls="'collapseExperience'+index">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" :id="'collapseExperience'+index" style="width: 95%; margin-left:2%">
                                <div class="jobCategoryTwo"  v-for='(jobCategoryTwo, indexTwo) in jobCategoryOne.job_category_two'>
                                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                        <div class="row">
                                            <div class="col-11">
                                                <p class="exp-font">@{{jobCategoryTwo.name}}</p>
                                            </div>
                                            <div class="col-1 mx-auto my-auto">
                                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" :id="'collapseExperienceTwo'+index+indexTwo" style="width: 95%; margin-left:2%">
                                        <div class="jobCategoryThree" v-for='(jobCategoryThree, indexThree) in jobCategoryTwo.job_category_three'>
                                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                                <div class="row">
                                                    <div class="col-11">
                                                        <p class="exp-font">@{{jobCategoryThree.name}}</p>
                                                    </div>
                                                    <div class="col-1 mx-auto my-auto">
                                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse" :id="'collapseExperienceThree'+index+indexTwo+indexThree" style="width: 95%; margin-left:2%">
                                                <div class="jobCategoryThree" v-for='(jobCategoryFour, indexFour) in jobCategoryThree.job_category_four'>
                                                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <p class="exp-font">@{{jobCategoryFour.name}}</p>
                                                            </div>
                                                            <div class="col-1 mx-auto my-auto">
                                                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
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
                                                                <p>@{{jobCategoryFour.example_titles}}</p>
                                                            </div>
                                                            <div class="row">
                                                                <h5>Main Duties</h5>
                                                                <p >
                                                                    <span style="white-space: pre-line">@{{jobCategoryFour.main_duties}}</span>
                                                                </p>
                                                            </div>
                                                            <div class="row">
                                                                <h5>Employement Requirment</h5>
                                                                <p >
                                                                    <span style="white-space: pre-line">@{{jobCategoryFour.employement_requirements}}</span>
                                                                </p>
                                                            </div>
                                                            <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                                <div class="row">
                                                                    <button type="button" v-if="selectedJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                    <button type="button" v-else class="btn btn-primary submitBtn" data-applicantId="{{$applicant['id']}}" v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name,'applicant')" style="line-height: 22px">Add Experience</button>
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
                        @if($applicant['is_spouse'] != null || $applicant['children_count'] != null) 
                            <button type="submit" class="btn btn-primary submitBtn applicantNext">  Next </button>
                        @else
                            <button type="submit" class="btn btn-primary submitBtn applicantReview">  Submit </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>