<div class="tab-pane active" id="mainApplicant">
    <div class="applicant-detail-sec">
        <div class="heading applicantsec">
            <div class="row">
                <div class="col-2">
                    <div class="image my-auto">
                        <img src="{{asset('images/Icons_applicant_details.svg')}}" width="100%" height="100%" alt="PWG Group">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="PWG Group approved" >
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="false" aria-controls="collapseapplicant">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%" alt="PWG Group">
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
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicantCompleted" value="0" class="applicantCompleted">
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="first_name" class="form-control first_name" id="floatingInput" placeholder="First Name*" value="{{$name[0]}}" autocomplete="off"/>
                                <label for="floatingInput">First Name*</label>
                                <span class="first_name_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="middle_name" class="form-control" id="floatingInput" placeholder="Middle Name" value="{{old('middle_name')}}"  autocomplete="off"/>
                                <label for="floatingInput">Middle Name</label>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="surname" id="floatingInput" class="form-control surname" @if(count($name) > 1)   value="{{$client['sur_name']}}" @endif placeholder="Surname*"  autocomplete="off"  />
                                <label for="floatingInput">Surname</label>
                                <span class="surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="email" id="floatingInput" class="form-control email" placeholder="Email*" value="{{$client['email']}}" autocomplete="off" />
                                <label for="floatingInput">Email*</label>
                                <span class="email_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="hidden" name="phone_number_label" class="form-control phone_number_label" id="phone_number_label" placeholder="Phone Number*" autocomplete="off"/>
                                <input type="tel" name="phone_number" class="form-control phone_number phone"   placeholder="Phone Number*" value="{{$client['phone_number']}}" autocomplete="off"  />
                                <span class="phone_number_errorClass"></span>
                                <label for="phone_number_label" style="margin-top: -5px !important; margin-left: -5px !important;">Phone Number*</label>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3 dob">
                                <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth*" value="{{old('dob')}}" id="datepicker" autocomplete="off"  readonly="readonly" />
                                <label for="datepicker">Date of Birth*</label>
                                <span class="dob_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="place_birth" class="form-control place_birth" id="place_birth" placeholder="Place of Birth*" value="{{old('place_birth')}}" autocomplete="off" />
                                <label for="place_birth">Place of Birth*</label>
                                <span class="place_birth_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control country_birth" name="country_birth" id="country_birth" placeholder="Country of Birth*" value="{{old('country_birth')}}"  >
                                    <option selected disabled>Country of Birth</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <label for="country_birth">Country of Birth*</label>
                                <span class="country_birth_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-4 mt-3">
                                <select class="form-select form-control citizenship" name="citizenship" id="Citizenship" placeholder="Citizenship*" value="{{old('citizenship')}}"  >
                                    <option selected disabled>Citizenship</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <label for="Citizenship">Citizenship*</label>
                                <span class="citizenship_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="sex"  aria-required="true" id="sex" class="form-control form-select sex" >
                                    <option selected disabled>Sex</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <label for="sex">Sex *</label>
                                <span class="sex_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <select name="civil_status" id="civil_status"  aria-required="true" class="form-control form-select">
                                    <option selected disabled>Civil Status</option>
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
                            <input type="number" name="agent_code" id="agent_code" class="form-control" placeholder="Please enter your agent code here if available" value="{{old('agent_code')}}"/>
                            <label for="agent_code">Please enter your agent code here if available</label>
                            <span class="agent_code_errorClass"></span>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" class="form-control cvupload"  id="cvupload" placeholder="Upload your cv (PDF only)*" name="cv" value="{{old('cv')}}" readonly required>
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_home_country_details.svg')}}" width="100%" height="100%" alt="PWG Group">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="PWG Group approved" >
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="false" aria-controls="collapseHome">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%" alt="PWG Group">
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
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="passport_number" class="form-control passport_number" id="floatingInput" placeholder=" Passport Number*" value="{{old('passport_number')}}" autocomplete="off"/>
                                <label for="floatingInput"> Passport Number*</label>
                                <span class="passport_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="passport_issue" class="form-control passport_issue" id="passport_issue" placeholder="Passport Date of Issue*" value="{{old('passport_issue')}}" autocomplete="off" readonly="readonly"/>
                                <label for="passport_issue"> Passport Date of Issue*</label>
                                <span class="passport_issue_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="passport_expiry" class="form-control passport_expiry" id="passport_expiry" placeholder="Passport Date of Expiry*" value="{{old('passport_expiry')}}" autocomplete="off" readonly="readonly"/>
                                <label for="passport_expiry">Passport Date of Expiry*</label>
                                <span class="passport_expiry_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="issued_by" class="form-control issued_by" id="issued_by" placeholder="Issued By(Authority that issued the passport)*" value="{{old('issued_by')}}" autocomplete="off"/>
                                <label for="issued_by">Issued By(Authority that issued the passport)*</label>
                                <span class="issued_by_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-12 mt-3">
                                <input type="text" name="passport_copy" class="form-control passport_copy" id="passport_copy" placeholder="Upload Passport Copy*" value="{{old('passport_copy')}}" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up passport_copy" id="up"  name="passport_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="passport_copy">Upload Passport Copy*</label>
                                <span class="passport_copy_errorClass"></span>
                            </div>
                            {{-- <div class="col-sm-6 mt-3">
                                <input type="tel" name="home_phone_number" id="home_phone_number" class="form-control home_phone_number" placeholder="Phone Number" value="{{old('home_phone_number')}}" autocomplete="off" />
                            </div> --}}
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating  col-sm-3 mt-3">
                                <select class="form-select form-control home_country" name="home_country" placeholder="home_country*" id="home_country" value="{{old('home_country')}}" autocomplete="off">
                                    <option selected disabled>Home Country</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <label for="home_country">Home Country</label>
                                <span class="home_country_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-3 mt-3">
                                <input type="text" name="state" id="state" class="form-control state" placeholder="State/Province*" autocomplete="off">
                                @error('state') <span class="error">{{ $message }}</span> @enderror
                                <label for="state">State/Province*</label>
                                <span class="state_errorClass"></span>
                            </div>
                            <div class="form-floating  col-sm-3 mt-3">
                                <input type="text" name="city" id="city" class="form-control city" placeholder="City*" autocomplete="off">
                                <label for="city">City*</label>
                                <span class="city_errorClass"></span>
                            </div>
                            <div class="form-floating  col-sm-3 mt-3">
                                <input type="integer" name="postal_code" id="postal_code" value="{{old('postal_code')}}" class="form-control postal_code" placeholder="Postal Code*" autocomplete="off">
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_current_residency_and_work_details.svg')}}" width="100%" height="100%" alt="PWG Group">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="PWG Group approved">
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
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="hidden" name="current_residence_phone_number_label" class="form-control current_residence_phone_number_label" id="current_residence_phone_number_label" placeholder="Phone Number*" autocomplete="off"/>
                                <input type="tel" class="form-control" id="current_residance_mobile" name='current_residance_mobile' value="{{old('current_residance_mobile')}}" placeholder="Current Residence Mobile Number" autocomplete="off">
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
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload residence_id" id="up"  name="residence_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="residence_copy">Residence/Emirates ID*</label>
                                <span class="residence_copy_errorClass"></span>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" class="form-control visa_copy" id="visa_copy" onclick="showVisaFormat('applicant')" name="visa_copy" placeholder="Visa Copy" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload visa_copy" id="up"  name="visa_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <label for="visa_copy">Visa Copy</label>
                            </div>
                        </div>
                        {{-- <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                <span class="current_job_errorClass"></span>
                            </div>
                        </div> --}}
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
                                <input type="text" class="form-control" name="employer_phone" id="employer_phone" placeholder="Employer Phone Number" autocomplete="off">
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
        <div class="heading">
            <div class="row">
                <div class="col-2 my-auto">
                    <div class="image">
                        <img src="{{asset('images/Icons_schengen_details.svg')}}" width="100%" height="100%" alt="PWG Group">
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
                        <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="PWG Group approved">
                    </div>
                </div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSchengen" aria-expanded="false" aria-controls="collapseSchengen">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%" alt="PWG Group">
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
                        @php  
                            $vall = $client['schengenVisaName'];
                            $sheng = $client['schengenVisaUrl'];
                            $phold = "Image of Schengen Or National Visa Issued During Last 5 Years";
                        @endphp
                        <div class="form-group row mt-4 schengen_visa">
                            <div class="form-floating col-sm-12 mt-3" id="schengen_visa">
                                <input type="text" class="form-control schengen_copy" id="schengen_copy" onclick="showSchengenVisaFormat('applicant')" name="schengen_copy" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
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
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="PWG Group approved">
                        </div> --}}
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="false" aria-controls="collapseExperience">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%" alt="PWG Group">
                    </div>
                </div>
            </div>
        </div>
        <div id="importExperience" data-applicantId="{{$applicant['id']}}" data-dependentId="{{$dependent}}">
            @include('user.experience')
        </div>
    </div>
</div>
