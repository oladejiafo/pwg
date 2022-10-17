<div class="tab-pane active" id="dependant">
    <div class="applicant-detail-sec">
        <div class="heading">
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
                            Spouse/Dependant Details 
                        </h3>
                    </div>
                </div>
                <div class="col-1">
                    <div class="dataCompleted spouseApplicantData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsespouseapplicant" aria-expanded="false" aria-controls="collapsespouseapplicant">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="collapsespouseapplicant" class="collapse">
                <div class="form-sec">
                    @php
                        $name = explode(' ', $client['name']);
                    @endphp
                    <form method="POST" enctype="multipart/form-data" id="dependent_applicant_details">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="hidden" name="dependentApplicantCompleted" value="0" class="dependentApplicantCompleted">
                                <input type="text" name="dependent_first_name" class="form-control dependent_first_name" id="dependent_first_name" placeholder="First Name*" value="" autocomplete="off"/>
                                <label for="dependent_first_name">First Name*</label>
                                <span class="dependent_first_name_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="dependent_middle_name" class="form-control" id="dependent_middle_name" placeholder="Middle Name" value="{{old('dependent_middle_name')}}"  autocomplete="off"/>
                                <label for="dependent_middle_name">Middle Name</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="dependent_surname" id="dependent_surname" class="form-control dependent_surname" placeholder="Surname*" value="" autocomplete="off"  />
                                <label for="dependent_surname">Surname*</label>
                                <span class="dependent_surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="email" name="email" id="email" class="form-control dependent_email" placeholder="Email*" value="" autocomplete="off" />
                                <label for="email">Email*</label>
                                <span class="email_errorClass"></span>
                            </div>
                            <div class=" col-sm-6 mt-3">
                                <input type="tel" name="dependent_phone_number" class="form-control dependent_phone_number" id="dependent_phone" placeholder="Phone Number*" value="" autocomplete="off"  />
                                <span class="dependent_phone_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" class="form-control dependent_resume" placeholder="Upload your cv (PDF only)*" name="dependent_resume" value="{{old('cv')}}" readonly required>
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up dependent_resume" id="up"  name="dependent_resume" accept="application/pdf" />
                                      </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label id="dependent_resume">Upload your cv (PDF only)*</label>
                                <span class="dependent_resume_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3 dob">
                                <input type="text" name="dependent_dob" class="form-control dependent_datepicker" id="dependent_datepicker" placeholder="Date of Birth*" value="{{old('dependent_dob')}}" id="dependent_datepicker" autocomplete="off"  readonly="readonly" />
                                <label for="dependent_datepicker">Date of Birth*</label>
                                <span class="dependent_dob_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="dependent_place_birth" id="dependent_place_birth" class="form-control dependent_place_birth" placeholder="Place of Birth*" value="{{old('dependent_place_birth')}}" autocomplete="off" />
                                <label for="dependent_place_birth">Place of Birth*</label>
                                <span class="dependent_place_birth_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control dependent_country_birth" id="dependent_country_birth" name="dependent_country_birth" placeholder="Country of Birth*" value="{{old('dependent_country_birth')}}"  >
                                    <option selected disabled>Country of Birth</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <label for="dependent_country_birth">Country of Birth *</label>
                                <span class="dependent_country_birth_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control dependent_citizenship" name="dependent_citizenship" id="dependent_citizenship" placeholder="Citizenship*" value="{{old('dependent_citizenship')}}"  >
                                    <option selected disabled>Citizenship </option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <label for="dependent_citizenship">Citizenship*</label>
                                <span class="dependent_citizenship_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="dependent_sex" id="dependent_sex" aria-required="true" class="form-control form-select dependent_sex" >
                                    <option selected disabled>Sex </option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <label for="dependent_sex">Sex*</label>
                                <span class="dependent_sex_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="dependent_civil_status" id="dependent_civil_status"  aria-required="true" class="form-control form-select">
                                    <option selected disabled>Civil Status</option>
                                    <option value="SINGLE">Single</option>
                                    <option value="MARRIED">Married</option>
                                    <option value="SEPARATED">Separated</option>
                                    <option value="DIVORCED">Divorced</option>
                                    <option value="WIDOW">Widow</option>
                                    <option value="OTHER">Other</option>
                                </select>
                                <label for="dependent_civil_status">Civil Status *</label>
                                <span class="dependent_civil_status_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn spouseApplicantDetails" >Continue</button>
                            </div>
                        </div>
                    </form>
                </div>   
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec dependent_home_country_details">
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
                    <div class="dataCompleted spouseHomeCountryData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsespouseHome" aria-expanded="false" aria-controls="collapsespouseHome">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapsespouseHome">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="dependent_home_country_details">
                        @csrf
                        <input type="hidden" name="spouseHomeCountryCompleted" value="0" class="spouseHomeCountryCompleted">
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="passport_number" class="form-control passport_number" id="passport_number" placeholder="Passport Number*" value="{{old('passport_number')}}" autocomplete="off"/>
                                <label name="passport_number">Passport Number*</label>
                                <span class="passport_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="dependent_passport_issue" class="form-control dependent_passport_issue" id="dependent_passport_issue" placeholder="Passport Date of Issue*" value="{{old('dependent_passport_issue')}}" autocomplete="off" readonly="readonly"/>
                                <label for="dependent_passport_issue">Passport Date of Issue*</label>
                                <span class="dependent_passport_issue_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="dependent_passport_expiry" class="form-control dependent_passport_expiry"  id="dependent_passport_expiry" placeholder="Passport Date of Expiry*" value="{{old('dependent_passport_expiry')}}" autocomplete="off" readonly="readonly" />
                                <label for="dependent_passport_expiry">Passport Date of Expiry*</label>
                                <span class="dependent_passport_expiry_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="dependent_issued_by" class="form-control dependent_issued_by" id="dependent_issued_by" placeholder="Issued By(Authority that issued the passport)*" value="{{old('dependent_issued_by')}}" autocomplete="off"/>
                                <label for="dependent_issued_by">Issued By(Authority that issued the passport)*</label>
                                <span class="dependent_issued_by_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="dependent_passport_copy" class="form-control dependent_passport_copy" id="dependent_passport_copy" placeholder="Upload Passport Copy*" value="{{old('dependent_passport_copy')}}"  onclick="showDependentPassportFormat('dependent')" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up dependent_passport_copy" id="up"  name="dependent_passport_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="dependent_passport_copy">Upload Passport Copy*</label>
                                <span class="dependent_passport_copy_errorClass"></span>
                            </div>
                            {{-- <div class="col-sm-6 mt-3">
                                <input type="tel" name="dependent_home_phone_number" id="dependent_home_phone_number" class="form-control dependent_home_phone_number" placeholder="Phone Number" value="{{old('dependent_home_phone_number')}}" autocomplete="off" />
                            </div> --}}
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-3 mt-3">
                                <select class="form-select form-control dependent_home_country" name="dependent_home_country" placeholder="home_country*" id="home_country" value="{{old('dependent_home_country')}}" autocomplete="off">
                                    <option selected disabled>Home Country</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <label for="home_country">Home Country *</label>
                                <span class="dependent_home_country_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-3 mt-3">
                                <input type="text" name="dependent_state" id="dependent_state" class="form-control dependent_state" placeholder="State/Province*" autocomplete="off">
                                <label for="dependent_state">State/Province*</label>
                                <span class="dependent_state_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-3 mt-3">
                                <input type="text" name="dependent_city" id="dependent_city" class="form-control dependent_city" placeholder="City*" autocomplete="off">
                                <label for="dependent_city">City*</label>
                                <span class="dependent_city_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-3 mt-3">
                                <input type="integer" name="dependent_postal_code" id="dependent_postal_code" value="{{old('dependent_postal_code')}}" class="form-control dependent_postal_code" placeholder="Postal Code*" autocomplete="off">
                                <label for="dependent_postal_code">Postal Code*</label>
                                <span class="dependent_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="dependent_address_1" id="dependent_address_1" class="form-control dependent_address_1" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                <label for="dependent_address_1">Address (Street And Number) Line 1*</label>
                                <span class="dependent_address_1_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="dependent_address_2" id="dependent_address_2" class="form-control dependent_address_2" placeholder="Address (Street And Number) Line 2" autocomplete="off">
                                <label for="dependent_address_2">Address (Street And Number) Line 2</label>
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
                    <div class="dataCompleted spouseCurrentCountryData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseCurrent" aria-expanded="false" aria-controls="collapseSpouseCurrent">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseSpouseCurrent">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="dependent_current_residency">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                        <input type="hidden" name="spouseCurrentCountryCompleted" value="0" class="spouseCurrentCountryCompleted">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <select class="form-select form-control" id="dependent_current_country" name="dependent_current_country" placeholder="current_country*" value="{{old('dependent_current_country')}}"  >
                                    <option selected disabled>Select Current Country Are You Living Right Now</option>
                                    @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <label for="dependent_current_country">Current Country Are You Living Right Now?</label>
                                <span class="dependent_current_country_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" class="form-control" id="dependent_current_residance_mobile" name='dependent_current_residance_mobile' value="{{old('dependent_current_residance_mobile')}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                <span class="dependent_current_residance_mobile_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="dependent_residence_id" id="dependent_residence_id" class="form-control" placeholder="Residence Id*" autocomplete="off"/>
                                <label for="dependent_residence_id">Residence Id*</label>
                                <span class="dependent_residence_id_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" class="form-control dependent_visa_validity" id="dependent_visa_validity" name="dependent_visa_validity" placeholder="Your ID/Visa Date of Validity*" readonly="readonly">
                                <label>Your ID/Visa Date of Validity*</label>
                                <span class="dependent_visa_validity_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" class="form-control dependent_residence_copy" id="dependent_residence_copy" name="dependent_residence_copy" onclick="showResidenceIdFormat('dependent')" placeholder="Residence/Emirates ID*" readonly >
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
                                <input type="text" class="form-control dependent_visa_copy" name="dependent_visa_copy" id="dependent_visa_copy" placeholder="Visa Copy" onclick="showVisaFormat('dependent')" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload dependent_visa_copy" id="up"  name="dependent_visa_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="dependent_visa_copy">Visa Copy</label>
                            </div>
                        </div>
                        {{-- <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="dependent_current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                <span class="dependent_current_job_errorClass"></span>
                            </div>
                        </div> --}}
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="dependent_work_state" class="form-control" placeholder="Work State/Province*" autocomplete="off"/>
                                <label for="dependent_work_state">Work State/Province*</label>
                                <span class="dependent_work_state_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_work_city" placeholder="Work City*" autocomplete="off">
                                <label for="dependent_work_city">Work City*</label>
                                <span class="dependent_work_city_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" id="dependent_work_postal_code" name="dependent_work_postal_code" placeholder="Work Place Postal Code*" autocomplete="off">
                                <label for="dependent_work_postal_code">Work Place Postal Code*</label>
                                <span class="dependent_work_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="dependent_work_street" id="dependent_work_street" class="form-control" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                <label for="dependent_work_street">Work Place Street & Number*</label>
                                <span class="dependent_work_street_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_company_name" placeholder="Name of Company" autocomplete="off">
                                <label for="dependent_company_name">Name of Company</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_employer_phone" id="dependent_employer_phone" placeholder="Employer Phone Number" autocomplete="off">
                                <label for="dependent_employer_phone">Employer Phone Number</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="email" name="dependent_employer_email" id="dependent_employer_email" class="form-control" placeholder="Email of the employer" autocomplete="off">
                                <label for="dependent_employer_email">Email of the employer</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn collapseSpouseCurrent" >Continue</button>
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
                            Schengen Details
                        </h3>
                    </div>
                </div>
                <div class="col-1">
                    <div class="dataCompleted spouseSchengenData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseSchengen" aria-expanded="false" aria-controls="collapseSpouseSchengen">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseSpouseSchengen">
                <div class="form-sec">
                    <form method="POST" enctype="multipart/form-data" id="dependent_schengen_details">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                        <input type="hidden" name="schengenSpouseCompleted" value="0" class="schengenSpouseCompleted">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <select name="is_dependent_schengen_visa_issued_last_five_year" id="is_dependent_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option selected disabled>Schengen Or National Visa Issued During Last 5 Years</option>
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
                                </select>
                                <label for="is_dependent_schengen_visa_issued_last_five_year">Schengen Or National Visa Issued During Last 5 Years</label>
                                <span class="is_dependent_schengen_visa_issued_last_five_year_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4 dependent_schengen_visa">
                            <div class="form-floating col-sm-12 mt-3" id="dependent_schengen_visa">
                                <input type="text" class="form-control dependent_schengen_copy" id="dependent_schengen_copy" name="dependent_schengen_copy" onclick="showSchengenVisaFormat('dependent')" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload dependent_schengen_copy" accept="image/png, image/gif, image/jpeg" name="dependent_schengen_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="dependent_schengen_copy">Image of Schengen Or National Visa Issued During Last 5 Years</label>
                            </div>
                            <div style="display: block;color:blue"><a href="#" class="plus" title="click here to add another row for upload" style="display:inline"><i class="fa fa-plus-circle"></i></a> Add another Visa <a href="#" class="minus" id="minus" title="click here to remove the last added row for upload" style="display:inline"><i class="fa fa-minus-circle"></i></a></div>
                        </div>
                        <!-- Add more inputs dynamycally here -->

                        <div class="form-group row mt-4"  id="is_dependent_finger_print_collected_for_Schengen_visa">
                            <div class="form-floating col-sm-12 mt-3">
                                <select name="is_dependent_finger_print_collected_for_Schengen_visa" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa</option>
                                    <option value="NO">No</option>
                                    <option value="YES">Yes</option>
                                </select>
                                <label for="is_dependent_finger_print_collected_for_Schengen_visa">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</label>
                                <span class="is_dependent_finger_print_collected_for_Schengen_visa_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn collapseSpouseSchengen" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="false" aria-controls="collapseSpouseExperience">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="applicant-detail-sec" style="margin-bottom: 70px" >
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
                        {{-- <div class="dataCompleted experienceData" v-if="dependentJob.length > 0">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div> --}}
                    </div>
                </div>
                <div class="col-1">
                    {{-- <div class="dataCompleted experienceData">
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                    </div> --}}
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="false" aria-controls="collapseSpouseExperience">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div id="importExperienceDependent" data-clientId="{{$applicant['id']}}" data-dependentId="{{$dependent}}">
            @include('user.dependent-experience')
        </div>
    </div>
</div>