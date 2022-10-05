<div class="tab-pane active" id="mainApplicant">
    <div class="applicant-detail-sec">
        <div class="heading applicantsec">
            <div class="row">
                <div class="col-2">
                    <div class="image my-auto">
                        <img src="{{asset('images/Icons_applicant_details.svg')}}" width="100%" height="100%">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved" >
                    </div>
                </div>
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
                        $name = explode(' ', $client['name']);
                    @endphp
                    
                    <form method="POST" enctype="multipart/form-data" id="applicant_details">
                        @csrf
                        <input type="hidden" name="destination_id" value="{{$productId}}">
                        <input type="hidden" name="applicantCompleted" value="0" class="applicantCompleted">
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="first_name" class="form-control first_name" placeholder="First Name*" value="{{$name[0]}}" autocomplete="off"/>
                                <span class="first_name_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{old('middle_name')}}"  autocomplete="off"/>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="surname" class="form-control surname" @if(count($name) > 1)   value="{{$name[count($name)-1]}}" @else  placeholder="Surname*" @endif autocomplete="off"  />
                                <span class="surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="email" class="form-control email" placeholder="Email*" value="{{$client['email']}}" autocomplete="off" />
                                <span class="email_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" name="phone_number" class="form-control phone_number" id="phone" placeholder="Phone Number*" value="{{$client['phone_number']}}" autocomplete="off"  />
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
                                    <option value="SINGLE">Single</option>
                                    <option value="MARRIED">Married</option>
                                    <option value="SEPARATED">Separated</option>
                                    <option value="DIVORCED">Divorced</option>
                                    <option value="WIDOW">Widow</option>
                                    <option value="OTHER">Other</option>
                                </select>
                                <span class="civil_status_errorClass"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <input type="number" name="agent_code" id="agent_code" class="form-control" placeholder="Please enter your agent code here if available" value="{{old('agent_code')}}" />
                            <span class="agent_code_errorClass"></span>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12 mt-3">
                                <input type="text" class="form-control cvupload" placeholder="Upload your cv (PDF only)*" name="cv" value="{{old('cv')}}" readonly required>
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload cvupload" id="up"  name="cv" accept="application/pdf" onchange="readURL(this);" />
                                        </span><!-- btn-orange -->
                                </div><!-- btn -->
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_home_country_details.svg')}}" width="100%" height="100%">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved" >
                    </div>
                </div>
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
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="passport_copy" class="form-control passport_copy" placeholder="Upload Passport Copy*" value="{{old('passport_copy')}}" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up passport_copy" id="up"  name="passport_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="passport_copy_errorClass"></span>
                            </div>
                            {{-- <div class="col-sm-6 mt-3">
                                <input type="tel" name="home_phone_number" id="home_phone_number" class="form-control home_phone_number" placeholder="Phone Number" value="{{old('home_phone_number')}}" autocomplete="off" />
                            </div> --}}
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
                                <input type="text" name="address_2" class="form-control address_2" placeholder="Address (Street And Number) Line 2" autocomplete="off">
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
                        <img src="{{asset('images/Icons_current_residency_and_work_details.svg')}}" width="100%" height="100%">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
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
                            {{-- <div class="col-sm-6 mt-3">
                                <select class="form-select form-control current_country" name="current_country" placeholder="current_country*" value="{{old('current_country')}}"  >
                                    <option selected disabled>Current Country Are You Living Right Now? *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="current_country_errorClass"></span>
                            </div> --}}
                            
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="tel" class="form-control" id="current_residance_mobile" name='current_residance_mobile' value="{{old('current_residance_mobile')}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                <span class="current_residance_mobile_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="residence_id" class="form-control" placeholder="Residence Id*" autocomplete="off"/>
                                <span class="residence_id_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control visa_validity" name="visa_validity" placeholder="Your ID/Visa Date of Validity*" >
                                <span class="visa_validity_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control residence_id" name="residence_copy" onclick="showResidenceIdFormat('applicant')" placeholder="Residence/Emirates ID*" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload residence_id" id="up"  name="residence_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="residence_copy_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control visa_copy"  onclick="showVisaFormat('applicant')" name="visa_copy" placeholder="Visa Copy" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload visa_copy" id="up"  name="visa_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                        </div>
                        {{-- <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                <span class="current_job_errorClass"></span>
                            </div>
                        </div> --}}
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
                        <img src="{{asset('images/Icons_schengen_details.svg')}}" width="100%" height="100%">
                    </div>
                </div>
                <div class="col-1">
                    <div class="vl"></div>
                </div>
                <div class="col-6 my-auto">
                    <div class="first-heading d-flex justify-content-center">
                        <h3>
                            {{ __('Schengen Details')}}
                        </h3>
                    </div>
                </div>
                <div class="col-1">
                    <div class="dataCompleted schengenData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
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
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
                                </select>
                                <span class="is_schengen_visa_issued_last_five_year_errorClass"></span>
                            </div>
                        </div>
                        @php  
                            $vall = $client['schengenVisaName'];
                            $sheng = $client['schengenVisaUrl'];
                            $phold = "Image of Schengen Or National Visa Issued During Last 5 Years";
                        @endphp
                        <div class="form-group row mt-4 schengen_visa">
                            <div class="col-sm-12 mt-3" id="schengen_visa">
                                <input type="text" class="form-control schengen_copy" onclick="showSchengenVisaFormat('applicant')" name="schengen_copy" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                            <div style="display: block;color:blue"><a href="#" class="pl" title="click here to add another row for upload" style="display:inline"><i class="fa fa-plus-circle"></i></a> Add another Visa <a href="#" class="mi" id="mi" title="click here to remove the last added row for upload" style="display:inline"><i class="fa fa-minus-circle"></i></a></div>
                        </div>
                        <!-- Add more inputs dynamycally here -->

                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select name="is_finger_print_collected_for_Schengen_visa" id="is_finger_print_collected_for_Schengen_visa" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</option>
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
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
                        <img src="{{asset('images/Icons_experience_details.svg')}}" width="100%" height="100%">
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
                        {{-- <div class="dataCompleted experiencenData" v-if="selectedJob.length > 0">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div> --}}
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
        <div id="importExperience" data-applicantId="{{$applicant['id']}}" data-dependentId="{{$dependent}}">
            @include('user.experience')
        </div>
    </div>
</div>

<script type="text/javascript">
    // $(function() {
    //     //Add more file input box for schengen visa upload
    //     $('a.pl').click(function(e) {
    //         let cnt = $('#schengen_visa div').length;
           
    //         // alert(cnt)
    //         e.preventDefault();
    //         $('#schengen_visa').append('<div class="col-sm-12 mt-3" id="schengen_visa"><input type="text" class="form-control schengen_copy1_'+cnt+'" name="schengen_copy1[]" onclick="showSchengenVisaFormat(\'applicant\')" @if($sheng)  value="{{$vall}}" @else placeholder="{{$phold}}" @endif readonly ><div class="input-group-btn"><span class="fileUpload btn"><span class="upl" id="upload">Choose File</span><input type="file" class="upload schengen_copy1" accept="image/png, image/gif, image/jpeg" name="schengen_copy1[]" /></span></div></div>');
    //     });
    //     //Remove the extra file input box for schengen visa upload
    //     $('a.mi').click(function (e) {
    //         e.preventDefault();
    //         if ($('#schengen_visa div').length > 1) {
    //             $('#schengen_visa').children().last().remove();
    //         }
    //     });
    // });
</script> 