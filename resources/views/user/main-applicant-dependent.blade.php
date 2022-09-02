<div class="tab-pane active" id="dependant">
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
                            Spouse/Dependant Details 
                        </h3>
                        <div class="dataCompleted spouseApplicantData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
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
                        $name = explode(' ', $user['name']);
                    @endphp
                    <form method="POST" enctype="multipart/form-data" id="dependent_applicant_details">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productId}}">
                        <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="hidden" name="dependentApplicantCompleted" value="0" class="dependentApplicantCompleted">
                                <input type="text" name="dependent_first_name" class="form-control dependent_first_name" placeholder="First Name*" value="" autocomplete="off"/>
                                <span class="dependent_first_name_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="dependent_middle_name" class="form-control" placeholder="Middle Name" value="{{old('dependent_middle_name')}}"  autocomplete="off"/>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="dependent_surname" class="form-control dependent_surname" placeholder="Surname*" value="" autocomplete="off"  />
                                <span class="dependent_surname_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="email" name="dependent_email" class="form-control dependent_email" placeholder="Email*" value="" autocomplete="off" />
                                <span class="dependent_email_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" name="dependent_phone_number" class="form-control dependent_phone_number" id="phone" placeholder="Phone Number*" value="" autocomplete="off"  />
                                <span class="dependent_phone_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" class="form-control dependent_resume" placeholder="Upload your cv (PDF only)*" name="dependent_resume" value="{{old('cv')}}" readonly required>
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up dependent_resume" id="up"  name="dependent_resume" accept="application/pdf" />
                                      </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="dependent_resume_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3 dob">
                                <input type="text" name="dependent_dob" class="form-control dependent_datepicker" placeholder="Date of Birth*" value="{{old('dependent_dob')}}" id="dependent_datepicker" autocomplete="off"  readonly="readonly" />
                                <span class="dependent_dob_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="dependent_place_birth" class="form-control dependent_place_birth" placeholder="Place of Birth*" value="{{old('dependent_place_birth')}}" autocomplete="off" />
                                <span class="dependent_place_birth_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select class="form-select form-control dependent_country_birth" name="dependent_country_birth" placeholder="Country of Birth*" value="{{old('dependent_country_birth')}}"  >
                                    <option selected disabled>Country of Birth *</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="dependent_country_birth_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <select class="form-select form-control dependent_citizenship" name="dependent_citizenship" placeholder="Citizenship*" value="{{old('dependent_citizenship')}}"  >
                                    <option selected disabled>Citizenship *</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <span class="dependent_citizenship_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select name="dependent_sex"  aria-required="true" class="form-control form-select dependent_sex" >
                                    <option selected disabled>Sex *</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <span class="dependent_sex_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <select name="dependent_civil_status" id="dependent_civil_status"  aria-required="true" class="form-control form-select">
                                    <option selected disabled>Civil Status *</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widow">Widow</option>
                                    <option value="Other">Other</option>
                                </select>
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
                        <div class="dataCompleted spouseHomeCountryData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
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
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="dependent_passport_number" class="form-control dependent_passport_number" placeholder="Passport Number*" value="{{old('dependent_passport_number')}}" autocomplete="off"/>
                                <span class="dependent_passport_number_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_passport_issue" class="form-control dependent_passport_issue" placeholder="Passport Date of Issue*" value="{{old('dependent_passport_issue')}}" autocomplete="off"/>
                                <span class="dependent_passport_issue_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_passport_expiry" class="form-control dependent_passport_expiry" placeholder="passport Date of Expiry*" value="{{old('dependent_passport_expiry')}}" autocomplete="off" />
                                <span class="dependent_passport_expiry_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="dependent_issued_by" class="form-control dependent_issued_by" placeholder="Issued By(Authority that issued the passport)*" value="{{old('dependent_issued_by')}}" autocomplete="off"/>
                                <span class="dependent_issued_by_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_passport_copy" class="form-control dependent_passport_copy" placeholder="Upload Passport Copy*" value="{{old('dependent_passport_copy')}}" data-toggle="modal" class="passportFormatModal" data-target="#passportFormatModal" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload up dependent_passport_copy" id="up"  name="dependent_passport_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="dependent_passport_copy_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" name="dependent_home_phone_number" class="form-control dependent_home_phone_number" placeholder="Phone Number" value="{{old('dependent_home_phone_number')}}" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-3 mt-3">
                                <select class="form-select form-control dependent_home_country" name="dependent_home_country" placeholder="home_country*" value="{{old('dependent_home_country')}}" autocomplete="off">
                                    <option selected disabled>Home Country *</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <span class="dependent_home_country_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="text" name="dependent_state" class="form-control dependent_state" placeholder="State/Province*" autocomplete="off">
                                @error('state') <span class="error">{{ $message }}</span> @enderror
                                <span class="dependent_state_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="text" name="dependent_city" class="form-control dependent_city" placeholder="City*" autocomplete="off">
                                <span class="dependent_city_errorClass"></span>
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input type="integer" name="dependent_postal_code" value="{{old('dependent_postal_code')}}" class="form-control dependent_postal_code" placeholder="Postal Code*" autocomplete="off">
                                <span class="dependent_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_address_1" class="form-control dependent_address_1" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                <span class="dependent_address_1_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_address_2" class="form-control dependent_address_2" placeholder="Address (Street And Number) Line 2*" autocomplete="off">
                                <span class="dependent_address_2_errorClass"></span>
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
                        <div class="dataCompleted spouseCurrentCountryData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
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
                            <div class="col-sm-6 mt-3">
                                <select class="form-select form-control" name="dependent_current_country" placeholder="current_country*" value="{{old('dependent_current_country')}}"  >
                                    <option selected disabled>Current Country Are You Living Right Now? *</option>
                                    @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                </select>
                                <span class="dependent_current_country_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="tel" class="form-control" name='dependent_current_residance_mobile' value="{{old('dependent_current_residance_mobile')}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                <span class="dependent_current_residance_mobile_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" name="dependent_residence_id" class="form-control" placeholder="Residence Id*" autocomplete="off"/>
                                <span class="dependent_residence_id_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control dependent_visa_validity" name="dependent_visa_validity" placeholder="Your ID/Visa Date of Validity*" >
                                <span class="dependent_visa_validity_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control dependent_residence_copy" name="dependent_residence_copy" placeholder="Residence/Emirates ID*" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload dependent_residence_copy" id="up"  name="dependent_residence_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                                <span class="dependent_residence_copy_errorClass"></span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control dependent_visa_copy" name="dependent_visa_copy" placeholder="Visa Copy" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload dependent_visa_copy" id="up"  name="dependent_visa_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" name="dependent_current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                <span class="dependent_current_job_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="dependent_work_state" class="form-control" placeholder="Work State/Province*" autocomplete="off"/>
                                <span class="dependent_work_state_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_work_city" placeholder="Work City*" autocomplete="off">
                                <span class="dependent_work_city_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_work_postal_code" placeholder="Work Place Postal Code*" autocomplete="off">
                                <span class="dependent_work_postal_code_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-4 mt-3">
                                <input type="text" name="dependent_work_street" class="form-control" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                <span class="dependent_work_street_errorClass"></span>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_company_name" placeholder="Name of Company" autocomplete="off">
                            </div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" name="dependent_employer_phone" placeholder="Employer Phone Number" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="email" name="dependent_employer_email" class="form-control" placeholder="Email of the employer" autocomplete="off">
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
                        <div class="dataCompleted spouseSchengenData">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
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
                            <div class="col-sm-12 mt-3">
                                <select name="is_dependent_schengen_visa_issued_last_five_year" id="is_dependent_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option selected disabled>Schengen Or National Visa Issued During Last 5 Years*</option>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <span class="is_dependent_schengen_visa_issued_last_five_year_errorClass"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-4 dependent_schengen_visa">
                            <div class="col-sm-12 mt-3">
                                <input type="text" class="form-control dependent_schengen_copy" name="dependent_schengen_copy" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                <div class="input-group-btn">
                                    <span class="fileUpload btn">
                                        <span class="upl" id="upload">Choose File</span>
                                        <input type="file" class="upload dependent_schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                                    </span><!-- btn-orange -->
                                </div><!-- btn -->
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select name="is_dependent_finger_print_collected_for_Schengen_visa" id="is_dependent_finger_print_collected_for_Schengen_visa" aria-required="true" class="form-control form-select" autocomplete="off">
                                    <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</option>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
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
                        <div class="dataCompleted experienceData" v-if="dependentJob.length > 0">
                            <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-2 mx-auto my-auto">
                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="false" aria-controls="collapseSpouseExperience">
                        <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseSpouseExperience">
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
                                            <button type="button" v-if="dependentJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                            <button type="button" class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent}}" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'dependent')" style="line-height: 22px">Add Experience</button>
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
                                                                    <button type="button" v-if="dependentJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                                    <button type="button" v-else class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent}}"  v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name, 'dependent')" style="line-height: 22px">Add Experience</button>
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
                        @if($applicant['is_spouse'] != null && $applicant['children_count'] == null)
                            <button type="submit" class="btn btn-primary submitBtn dependentReview">Submit</button>
                        @else 
                            <button type="submit" class="btn btn-primary submitBtn dependentNext">Next</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>