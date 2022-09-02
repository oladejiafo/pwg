@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('content')


@php 
     $completed = DB::table('applicants')
                ->where('product_id', '=', $productId)
                ->where('user_id', '=', Auth::user()->id)
                ->get();

    $levels='0';
    foreach($completed as $complete) 
    {
            $levels = $complete->applicant_status;
    } 
@endphp
<div class="container" id="app" data-applicantId="{{$applicant['id']}}" data-dependentId="{{($dependent != null) ? $dependent['id']  : ''}}">
    <div class="col-12">
            <div class="row">
                <div class="wizard-details bg-white">
                    <div class="row">
                        <div class="tabs-detail d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="{{ url('payment_form', $applicant['productId']) }}" ><div class="round-completed round1 m-2">1</div></a>
                                <div class="round-title"><p>Payment</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant', $applicant['productId'])}}" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">2</div></a>
                                <div class="round-title"><p>Application</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant/details', $applicant['productId'])}}" ><div class="round-completed  round3 m-2">3</div></a>
                                <div class="round-title"><p>Applicant</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant/review', $applicant['productId'])}}" ><div class="round-active round4 m-2">4</div></a>
                                <div class="round-title"><p>Application</p><p> Review</p></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="applicant-tab-sec">
                    <div class="row">
                        @if(($applicant['is_spouse'] != null || $applicant['is_spouse'] != 0) && ($applicant['children_count'] != null || $applicant['children_count'] != 0))
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
                                        <h4>Spouse/Depedant</h4>
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
                        @elseif(($applicant['is_spouse'] != null || $applicant['is_spouse'] != 0) &&  ($applicant['children_count'] == null || $applicant['children_count'] == 0))
                            <div class="col-6">
                                <div class="mainApplicant active" data-toggle="tab" role="tab" style="border-radius: 20px 0 0 20px;">
                                    <a  href="#mainApplicant">
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
                            @elseif(($applicant['is_spouse'] == null || $applicant['is_spouse'] == 0) && ($applicant['children_count'] != null || $applicant['children_count'] != 0))
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
                        @endif
                    </div>
                </div>

                <div class="tab-content clearfix" style="margin: 0; padding: 0;">
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
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseapplicant" aria-expanded="true" aria-controls="collapseapplicant">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="collapseapplicant" class="collapse show">
                                    <div class="form-sec">
                                        <form method="POST" id="applicant_details">
                                            @csrf
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="tel" name="first_name" class="form-control" placeholder="First Name*" value="{{$applicant['first_name']}}" autocomplete="off" required/>
                                                    <span class="first_name_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{$applicant['middle_name']}}"  autocomplete="off"/>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="surname" class="form-control" placeholder="Surname*" value="{{$applicant['surname']}}" autocomplete="off" required />
                                                    <span class="surname_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="email" class="form-control" placeholder="Email*" value="{{$user['email']}}" autocomplete="off" required/>
                                                    <span class="email_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" name="phone_number" class="form-control" id="phone" placeholder="Phone Number*" value="{{$user['phone_number']}}" autocomplete="off"  required/>
                                                    <span class="phone_number_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3 dob">
                                                    <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth*" value="{{ date('d-m-Y', strtotime($applicant['dob']))}}" id="datepicker" autocomplete="off"  readonly="readonly" required/>
                                                    <span class="dob_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="place_birth" class="form-control" placeholder="Place of Birth*" value="{{$applicant['place_birth']}}" autocomplete="off" required/>
                                                    <span class="place_birth_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select class="form-select form-control" name="country_birth" placeholder="Country of Birth*"  required>
                                                        <option selected>{{$applicant['country_birth']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($key == $applicant['country_birth']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="country_birth_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <select class="form-select form-control" name="citizenship" placeholder="Citizenship*"  required>
                                                        <option selected>{{$applicant['citizenship']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                                <option {{($key == $applicant['citizenship']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                            @endforeach
                                                    </select>
                                                    <span class="citizenship_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select name="sex"  aria-required="true" class="form-control form-select" required>
                                                        <option selected disabled>Sex *</option>
                                                        <option {{($applicant['sex'] == 'MALE') ? 'selected' : '' }} value="Male">Male</option>
                                                        <option {{($applicant['sex'] == 'FEMALE') ? 'selected' : ''}} value="Female">Female</option>
                                                    </select>
                                                    <span class="sex_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select name="civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
                                                        <option selected disabled>Civil Status *</option>
                                                        <option  {{($applicant['civil_status'] == 'Single') ? 'selected' : '' }} value="Single">Single</option>
                                                        <option  {{($applicant['civil_status'] == 'Married') ? 'selected' : '' }} value="Married">Married</option>
                                                        <option  {{($applicant['civil_status'] == 'Separated') ? 'selected' : '' }} value="Separated">Separated</option>
                                                        <option  {{($applicant['civil_status'] == 'Divorced') ? 'selected' : '' }} value="Divorced">Divorced</option>
                                                        <option  {{($applicant['civil_status'] == 'Widow') ? 'selected' : '' }} value="Widow">Widow</option>
                                                        <option  {{($applicant['civil_status'] == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                                                    </select>
                                                    <span class="civil_status_errorClass"></span>
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
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseHome" aria-expanded="true" aria-controls="collapseHome">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseHome">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="home_country_details">
                                            @csrf
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" name="passport_number" class="form-control" placeholder="Passport Number*" value="{{$applicant['passport_number']}}" autocomplete="off"/>
                                                    <span class="passport_number_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="passport_issue" class="form-control passport_issue" placeholder="Passport Date of Issue*" value="{{ date('d-m-Y', strtotime($applicant['passport_date_issue']))}}" autocomplete="off"/>
                                                    <span class="passport_issue_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="passport_expiry" class="form-control passport_expiry" placeholder="passport Date of Expiry*" value="{{ date('d-m-Y', strtotime($applicant['passport_date_expiry']))}}" autocomplete="off" />
                                                    <span class="passport_expiry_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" name="issued_by" class="form-control" placeholder="Issued By(Authority that issued the passport)*" value="{{$applicant['issued_by']}}" autocomplete="off"/>
                                                    <span class="issued_by_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="passport_copy" class="form-control passport_copy" placeholder="Upload Passport Copy*" value="{{$applicant['passport']}}"  class="passportFormatModal" data-target="#passportFormatModal" onclick="showPassportFormat()" autocomplete="off" readonly/>
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up passport_copy" id="up" value="{{$applicant['passport']}}"  name="passport_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#passportModal" onclick="showPassport()">click to view uploaded passport copy</a>
                                                    <span class="passport_copy_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" name="home_phone_number" class="form-control" placeholder="Phone Number" value="{{$applicant['phone_number']}}" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-3 mt-3">
                                                    <select class="form-select form-control" name="home_country" placeholder="home_country*" autocomplete="off">
                                                        <option selected>{{$applicant['home_country']}}</option>
                                                            @foreach (Constant::countries as $key => $item)
                                                                <option {{($key == $applicant['home_country']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                            @endforeach
                                                    </select>
                                                    <span class="home_country_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="text" name="state" class="form-control" placeholder="State/Province*" value="{{$applicant['state']}}" autocomplete="off">
                                                    @error('state') <span class="error">{{ $message }}</span> @enderror
                                                    <span class="state_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="text" name="city" class="form-control" placeholder="City*" autocomplete="off" value="{{$applicant['city']}}">
                                                    <span class="city_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="integer" name="postal_code" value="{{$applicant['postal_code']}}" class="form-control" placeholder="Postal Code*" autocomplete="off">
                                                    <span class="postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="address_1" class="form-control" placeholder="Address (Street And Number) Line 1*" value="{{$applicant['address_1']}}" autocomplete="off">
                                                    <span class="address1_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="address_2" class="form-control" placeholder="Address (Street And Number) Line 2*" value="{{$applicant['address_2']}}" autocomplete="off">
                                                    <span class="address2_errorClass"></span>
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
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseCurrent">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="current_residency">
                                            @csrf
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <select class="form-select form-control" name="current_country" placeholder="current_country*">
                                                        <option selected> {{$applicant['current_residance_country']}} </option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($key == $applicant['current_residance_country']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="current_country_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" class="form-control" name='current_residance_mobile' value="{{$applicant['current_residence_mobile']}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                                    <span class="current_residance_mobile_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="residence_id" class="form-control" placeholder="Residence Id*" value="{{$applicant['residence_id']}}" autocomplete="off"/>
                                                    <span class="residence_id_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control visa_validity" name="visa_validity" value="{{ date('d-m-Y', strtotime($applicant['id_validity']))}}" placeholder="Your ID/Visa Date of Validity*" >
                                                    <span class="visa_validity_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control residence_id" name="residence_copy" placeholder="Residence/Emirates ID*" value="{{$applicant['residence_copy']}}" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload residence_id" id="up"  name="residence_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#residenceCopyModal" onclick="residenceCopyModal()">click to view uploaded residence copy</a>
                                                    <span class="residence_copy_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control visa_copy" name="visa_copy" placeholder="Visa Copy" value="{{$applicant['visa_copy']}}" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload visa_copy" id="up"  name="visa_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    @if($applicant['visa_copy'])
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#visaCopyModal" onclick="visaCopyModal()">click to view uploaded visa copy</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" name="current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" value="{{$applicant['current_job']}}" autocomplete="off">
                                                    <span class="current_job_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="work_state" class="form-control" placeholder="Work State/Province*" value="{{$applicant['work_state']}}" autocomplete="off"/>
                                                    <span class="work_state_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="work_city" placeholder="Work City*" value="{{$applicant['work_city']}}" autocomplete="off">
                                                    <span class="work_city_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="work_postal_code" placeholder="Work Place Postal Code*" value="{{$applicant['work_postal_code']}}" autocomplete="off">
                                                    <span class="work_postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="work_street" class="form-control" placeholder="Work Place Street & Number*" value="{{$applicant['work_street_number']}}" autocomplete="off"/>
                                                    <span class="work_street_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="company_name" placeholder="Name of Company" value="{{$applicant['company_name']}}" autocomplete="off">
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="employer_phone" placeholder="Employer Phone Number" value="{{$applicant['employer_phone_number']}}" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="email" name="employer_email" class="form-control" placeholder="Email of the employer" value="{{$applicant['employer_email']}}" autocomplete="off">
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
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSchengen" aria-expanded="true" aria-controls="collapseSchengen">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSchengen">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="schengen_details">
                                            @csrf
                                            <input type="hidden" name="product_id" value="1">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <select name="is_schengen_visa_issued_last_five_year" id="is_schengen_visa_issued_last_five_year" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option selected disabled>Schengen Or National Visa Issued During Last 5 Years*</option>
                                                        <option {{($applicant['is_schengen_visa_issued'] == "No") ? 'selected' : ''}} value="No">No</option>
                                                        <option {{($applicant['is_schengen_visa_issued'] == "Yes") ? 'selected' : ''}} value="Yes">Yes</option> 
                                                    </select>
                                                    <span class="is_schengen_visa_issued_last_five_year_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4 schengen_visa">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" class="form-control schengen_copy" name="schengen_copy" value="{{$applicant['schengen_visa']}}" placeholder="Image of Schengen Or National Visa Issued During Last 5 Years" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload schengen_copy" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    @if($applicant['schengen_visa'])
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#schengenVisatModal" onclick="schengenVisatModal()">click to view uploaded schengen visa copy</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <select name="is_finger_print_collected_for_Schengen_visa" id="is_finger_print_collected_for_Schengen_visa" aria-required="true" class="form-control form-select" autocomplete="off">
                                                        <option value="">Fingerprints Collected Previously For The Purpose Of Applying For Schengen Visa*</option>
                                                        <option {{($applicant['is_fingerprint_collected'] == "No") ? 'selected' : ''}} value="No">No</option>
                                                        <option {{($applicant['is_fingerprint_collected'] == "Yes") ? 'selected' : ''}} value="Yes">Yes</option>
                                                    </select>
                                                    <span class="is_finger_print_collected_for_Schengen_visa_errorClass"></span>
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
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-2 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="true" aria-controls="collapseExperience">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseExperience">
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
                                                        <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id)">Remove</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
                                                                <button type="button" class="btn btn-primary submitBtn" applicantId="{{$applicant['id']}}" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name)" style="line-height: 22px">Add Experience</button>
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
                                                                                        <button type="button" class="btn btn-primary submitBtn" data-applicantId="{{$applicant['id']}}" v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name)" style="line-height: 22px">Add Experience</button>
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
                </div>

                @if($dependent)
                    <div class="tab-pane active" id="dependant" style="margin: 0; padding: 0;">
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
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsespouseapplicant" aria-expanded="true" aria-controls="collapsespouseapplicant">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="collapsespouseapplicant" class="collapse show">
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
                                                    <input type="text" name="dependent_first_name" class="form-control dependent_first_name" placeholder="First Name*" value="{{$dependent['first_name']}}" autocomplete="off"/>
                                                    <span class="dependent_first_name_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="dependent_middle_name" class="form-control" placeholder="Middle Name" value="{{$dependent['middle_name']}}"  autocomplete="off"/>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="dependent_surname" class="form-control dependent_surname" placeholder="Surname*" value="{{$dependent['surname']}}" autocomplete="off"  />
                                                    <span class="dependent_surname_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="email" name="dependent_email" class="form-control dependent_email" placeholder="Email*" value="{{$dependent['email']}}" autocomplete="off" />
                                                    <span class="dependent_email_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" name="dependent_phone_number" class="form-control dependent_phone_number" id="phone" placeholder="Phone Number*" value="{{$dependent['phone_number']}}" autocomplete="off"  />
                                                    <span class="dependent_phone_number_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" class="form-control dependent_resume" placeholder="Upload your cv (PDF only)*" name="dependent_resume" value="{{$dependent['resume']}}" readonly required>
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
                                                    <input type="text" name="dependent_dob" class="form-control dependent_datepicker" placeholder="Date of Birth*" value="{{ date('d-m-Y', strtotime($dependent['dob']))}}" id="dependent_datepicker" autocomplete="off"  readonly="readonly" />
                                                    <span class="dependent_dob_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="dependent_place_birth" class="form-control dependent_place_birth" placeholder="Place of Birth*" value="{{$dependent['place_birth']}}" autocomplete="off" />
                                                    <span class="dependent_place_birth_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select class="form-select form-control dependent_country_birth" name="dependent_country_birth" placeholder="Country of Birth*" >
                                                        <option selected>{{$dependent['country_birth']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($dependent['country_birth'] == $key) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="dependent_country_birth_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <select class="form-select form-control dependent_citizenship" name="dependent_citizenship" placeholder="Citizenship*" >
                                                        <option selected>{{$dependent['citizenship']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($key == $dependent['citizenship']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="dependent_citizenship_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select name="sex"  aria-required="true" class="form-control form-select dependent_sex">
                                                        <option selected disabled>Sex *</option>
                                                        <option {{($dependent['sex'] == 'MALE') ? 'selected' : '' }}value="Male">Male</option>
                                                        <option {{($dependent['sex'] == 'FEMALE') ? 'selected' : ''}} value="Female">Female</option>
                                                    </select>
                                                    <span class="dependent_sex_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <select name="civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
                                                        <option selected disabled>Civil Status *</option>
                                                        <option  {{($dependent['civil_status'] == 'Single') ? 'selected' : '' }} value="Single">Single</option>
                                                        <option  {{($dependent['civil_status'] == 'Married') ? 'selected' : '' }} value="Married">Married</option>
                                                        <option  {{($dependent['civil_status'] == 'Separated') ? 'selected' : '' }} value="Separated">Separated</option>
                                                        <option  {{($dependent['civil_status'] == 'Divorced') ? 'selected' : '' }} value="Divorced">Divorced</option>
                                                        <option  {{($dependent['civil_status'] == 'Widow') ? 'selected' : '' }} value="Widow">Widow</option>
                                                        <option  {{($dependent['civil_status'] == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                                                    </select>
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
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsespouseHome" aria-expanded="true" aria-controls="collapsespouseHome">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapsespouseHome ">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="dependent_home_country_details">
                                            @csrf
                                            <input type="hidden" name="spouseHomeCountryCompleted" value="0" class="spouseHomeCountryCompleted">
                                            <input type="hidden" name="product_id" value="{{$productId}}">
                                            <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" name="dependent_passport_number" class="form-control dependent_passport_number" placeholder="Passport Number*" value="{{$dependent['passport_number']}}" autocomplete="off"/>
                                                    <span class="dependent_passport_number_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_passport_issue" class="form-control dependent_passport_issue" placeholder="Passport Date of Issue*" value="{{ date('d-m-Y', strtotime($dependent['passport_date_issue']))}}" autocomplete="off"/>
                                                    <span class="dependent_passport_issue_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_passport_expiry" class="form-control dependent_passport_expiry" placeholder="passport Date of Expiry*" value="{{ date('d-m-Y', strtotime($dependent['passport_date_expiry']))}}" autocomplete="off" />
                                                    <span class="dependent_passport_expiry_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="text" name="dependent_issued_by" class="form-control dependent_issued_by" placeholder="Issued By(Authority that issued the passport)*" value="{{$dependent['issued_by']}}" autocomplete="off"/>
                                                    <span class="dependent_issued_by_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_passport_copy" class="form-control dependent_passport_copy" placeholder="Upload Passport Copy*" value="{{$dependent['passport']}}" data-toggle="modal" class="passportFormatModal" data-target="#passportFormatModal" onclick="showPassportFormat()" autocomplete="off" readonly/>

                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload up dependent_passport_copy" id="up"  name="dependent_passport_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <span class="dependent_passport_copy_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" name="dependent_home_phone_number" class="form-control dependent_home_phone_number" placeholder="Phone Number" value="{{$dependent['phone_number']}}" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-3 mt-3">
                                                    <select class="form-select form-control dependent_home_country" name="dependent_home_country" placeholder="home_country*" value="{{$dependent['home_country']}}" autocomplete="off">
                                                        <option selected>{{$dependent['home_country']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($key == $dependent['home_country']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="dependent_home_country_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="text" name="dependent_state" class="form-control dependent_state" placeholder="State/Province*" value="{{$dependent['state']}}" autocomplete="off">
                                                    <span class="dependent_state_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="text" name="dependent_city" class="form-control dependent_city" placeholder="City*" value="{{$dependent['city']}}" autocomplete="off">
                                                    <span class="dependent_city_errorClass"></span>
                                                </div>
                                                <div class="col-sm-3 mt-3">
                                                    <input type="integer" name="dependent_postal_code" value="{{$dependent['postal_code']}}" class="form-control dependent_postal_code" placeholder="Postal Code*" autocomplete="off">
                                                    <span class="dependent_postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_address_1" class="form-control dependent_address_1" value="{{$dependent['address_1']}}" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                                    <span class="dependent_address_1_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_address_2" class="form-control dependent_address_2" value="{{$dependent['address_2']}}" placeholder="Address (Street And Number) Line 2*" autocomplete="off">
                                                    <span class="dependent_address_2_errorClass"></span>
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
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseCurrent" aria-expanded="true" aria-controls="collapseSpouseCurrent">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSpouseCurrent">
                                    <div class="form-sec">
                                        <form method="POST" enctype="multipart/form-data" id="dependent_current_residency">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$productId}}">
                                            <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                                            <input type="hidden" name="spouseCurrentCountryCompleted" value="0" class="spouseCurrentCountryCompleted">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <select class="form-select form-control" name="dependent_current_country" placeholder="current_country*"  >
                                                        <option selected>{{$dependent['current_residance_country']}}</option>
                                                        @foreach (Constant::countries as $key => $item)
                                                            <option {{($key == $dependent['current_residance_country']) ? 'seleceted' : ''}} value="{{$key}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="dependent_current_country_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="tel" class="form-control" name='dependent_current_residance_mobile' value="{{$dependent['current_residance_mobile']}}" placeholder="Current Residence Mobile Number" autocomplete="off">
                                                    <span class="dependent_current_residance_mobile_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" name="dependent_residence_id" class="form-control" placeholder="Residence Id*"  value="{{$dependent['residence_id']}}" autocomplete="off"/>
                                                    <span class="dependent_residence_id_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_visa_validity" name="dependent_visa_validity" value="{{$dependent['id_validity']}}" placeholder="Your ID/Visa Date of Validity*" >
                                                    <span class="dependent_visa_validity_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_residence_copy" name="dependent_residence_copy" value="{{$dependent['residence_copy']}}" placeholder="Residence/Emirates ID*" readonly >
                                                    <div class="input-group-btn">
                                                        <span class="fileUpload btn">
                                                            <span class="upl" id="upload">Choose File</span>
                                                            <input type="file" class="upload dependent_residence_copy" id="up"  name="dependent_residence_copy" />
                                                        </span><!-- btn-orange -->
                                                    </div><!-- btn -->
                                                    <span class="dependent_residence_copy_errorClass"></span>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text" class="form-control dependent_visa_copy" name="dependent_visa_copy" value="{{$dependent['visa_copy']}}" placeholder="Visa Copy" readonly >
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
                                                    <input type="text" name="dependent_current_job" class="form-control" value="{{$dependent['current_job']}}"  placeholder="Profession As Per Current Job (or on Visa)*" autocomplete="off">
                                                    <span class="dependent_current_job_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="dependent_work_state" class="form-control" value="{{$dependent['work_state']}}" placeholder="Work State/Province*" autocomplete="off"/>
                                                    <span class="dependent_work_state_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="dependent_work_city"  value="{{$dependent['work_city']}}" placeholder="Work City*" autocomplete="off">
                                                    <span class="dependent_work_city_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="dependent_work_postal_code" value="{{$dependent['work_postal_code']}}" placeholder="Work Place Postal Code*" autocomplete="off">
                                                    <span class="dependent_work_postal_code_errorClass"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="dependent_work_street" class="form-control" value="{{$dependent['work_street_number']}}" placeholder="Work Place Street & Number*" autocomplete="off"/>
                                                    <span class="dependent_work_street_errorClass"></span>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="dependent_company_name"  value="{{$dependent['company_name']}}" placeholder="Name of Company" autocomplete="off">
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" class="form-control" name="dependent_employer_phone" value="{{$dependent['employer_phone_number']}}" placeholder="Employer Phone Number" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-12 mt-3">
                                                    <input type="email" name="dependent_employer_email" class="form-control" value="{{$dependent['employer_email']}}" placeholder="Email of the employer" autocomplete="off">
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
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseSchengen" aria-expanded="true" aria-controls="collapseSpouseSchengen">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSpouseSchengen">
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
                                                        <option {{($dependent['is_schengen_visa_issued'] == "No") ? 'selected' : ''}} value="No">No</option>
                                                        <option {{($dependent['is_schengen_visa_issued'] == "Yes") ? 'selected' : ''}} value="Yes">Yes</option> 
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
                                                        <option {{($dependent['is_fingerprint_collected'] == "No") ? 'selected' : ''}} value="No">No</option>
                                                        <option {{($dependent['is_fingerprint_collected'] == "Yes") ? 'selected' : ''}} value="Yes">Yes</option> 
                                                    </select>
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
                                        <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseSpouseExperience" aria-expanded="true" aria-controls="collapseSpouseExperience">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse show" id="collapseSpouseExperience">
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
                                                                <button type="button" class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent['id']}}" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'dependent')" style="line-height: 22px">Add Experience</button>
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
                                                                                        <button type="button" v-else class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent['id']}}"  v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name, 'dependent')" style="line-height: 22px">Add Experience</button>
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
                @endif

                <div class="tab-pane active" id="children" style="margin: 0; padding: 0;">
                    <form method="POST" id="child_details">
                        @csrf
                        @foreach($children as $key => $child)
                            <div class="applicant-detail-sec" @if($key+1 ==  $applicant['children_count']) style="margin-bottom:70px" @endif>
                                <div class="heading">
                                    <div class="row">
                                        <div class="col-2 my-auto">
                                            <div class="image">
                                                <img src="{{asset('images/child.svg')}}" width="70%" height="auto">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="vl"></div>
                                        </div>
                                        <div class="col-6 my-auto">
                                            <div class="first-heading d-flex justify-content-center">
                                                <h3>
                                                    Child {{$key+1}}
                                                </h3>
                                                <div class="dataCompleted childData{{$key+1}}">
                                                    <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-2 mx-auto my-auto">
                                            <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsechild{{$key+1}}" aria-expanded="true" aria-controls="collapsechild{{$key+1}}">
                                                <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="collapse show" id="collapsechild{{$key+1}}">
                                        <div class="form-sec">
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-4 mt-3">
                                                    <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                                                    <input type="hidden" name="childrenCount" value="{{$applicant['children_count']}}">
                                                    <input type="hidden" name="product_id" value="{{$productId}}">
                                                    <input type="hidden" name="child" value="{{$key+1}}">
                                                    <input type="text" name="child_{{$key+1}}_first_name" class="form-control child_{{$key+1}}_first_name" placeholder="First Name*" value="{{$child['first_name']}}" autocomplete="off" />
                                                    <span class="child_{{$key+1}}_first_name_errorClass"></span>
                                                    @error('child_{{$key+1}}_first_name') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="child_{{$key+1}}_middle_name" class="form-control " placeholder="Middle Name" value="{{$child['middle_name']}}"  autocomplete="off"/>
                                                </div>
                                                <div class="col-sm-4 mt-3">
                                                    <input type="text" name="child_{{$key+1}}_surname" class="form-control child_{{$key+1}}_surname" placeholder="Surname*" value="{{$child['surname']}}" autocomplete="off"  />
                                                    <span class="child_{{$key+1}}_surname_errorClass"></span>
                                                    @error('child_{{$key+1}}_surname') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row mt-4">
                                                <div class="col-sm-6 mt-3">
                                                    <input type="text"  name="child_{{$key+1}}_dob" class="child-dob form-control" placeholder="Date Of Birth*" value="{{$child['dob']}}">
                                                    <span class="child_{{$key+1}}_dob_errorClass"></span>
                                                    @error('child_{{$key+1}}_dob') <span class="error">{{ $message }}</span> @enderror

                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <select name="child_{{$key+1}}_gender" aria-required="true" class="form-control form-select child_{{$key+1}}_gender" >
                                                        <option selected disabled>Gender *</option>
                                                        <option {{($child['gender'] == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                                        <option {{($child['gender'] == 'Female') ? 'selected' : ''}} value="Female">Female</option>
                                                    </select>
                                                    <span class="child_{{$key+1}}_gender_errorClass"></span>
                                                    @error('child_{{$key+1}}_gender') <span class="error">{{ $message }}</span> @enderror

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4">
                                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                                @if($key+1 ==  $applicant['children_count'])
                                                    <button type="submit" class="btn btn-primary submitBtn submitChild">Submit</button>  
                                                @else 
                                                    <button type="button" class="btn btn-primary submitBtn collapsechild{{$key+2}}" data-bs-toggle="collapse" data-bs-target="#collapsechild{{$key+2}}" aria-expanded="false" aria-controls="collapsechild{{$key+2}}">Ammend</button>  
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        <div id="passportFormatModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="{{asset('images/Passport_Requirement.jpg')}}" width ="760px" height ="760px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="passportModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <iframe src ="{{asset('storage/passportCopy/'.$applicant['passport'])}}" width="100%" height="400px" style="margin: auto"></iframe>
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
                        <iframe src ="{{asset('storage/residenceCopy/'.$applicant['residence_copy'])}}"  width="100%" height="400px"></iframe>
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
                        <iframe src ="{{asset('storage/residenceCopy/'.$applicant['residence_copy'])}}"  width="100%" height="400px"></iframe>
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
                        <iframe src ="{{asset('storage/visaCopy/'.$applicant['visa_copy'])}}"  width="100%" height="400px"></iframe>
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
                        <iframe src ="{{asset('storage/schengenCopy/'.$applicant['schengen_visa'])}}"  width="100%" height="400px"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection  
@push('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
               // Main Applicant
        $('.schengen_visa, .applicantData, .homeCountryData, .currentCountryData, .schengenData, .dependent_schengen_visa').hide();
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

        if($('#is_schengen_visa_issued_last_five_year').val() == 'Yes') {
            $('.schengen_visa').show();
        } else {
            $('.schengen_visa').hide();
        }
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ae",
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });


        $(".applicantDetails").click(function(e){
            e.preventDefault(); 
            $("#applicant_details").validate();
            $("#applicant_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            var formdata = $('#applicant_details').serialize(); 
            $.ajax({
                type: 'POST',
                url: "{{ route('store.applicant.details') }}",
                data: formdata, 
                success: function (data) {
                    if(data.success) {
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
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
            $.ajax({
                type: 'POST',
                url: "{{ url('store/home/country/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('.passportFrame').src = data.passport;
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
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
            $.ajax({
                type: 'POST',
                url: "{{ url('store/current/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
                }
            });
        });
        
        $(document).on('change','.up', function(){
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
            }
        });

        $('#is_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_schengen_visa_issued_last_five_year').val() == "Yes"){
                $('.schengen_visa').show();
            } else {
                $('.schengen_visa').hide();
            }
        });

        $('#schengen_details').submit(function(e){
            e.preventDefault(); 
            $("#schengen_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ url('store/schengen/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
                }
            });
        });

        $(document).on('change','.schengen_copy', function(){
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
            console.log(cat1, cat2, cat3, cat4);
            $('.jobSelected .table tbody').append('<tr><th style="text-align: left;" data-bs-toggle="collapse" data-bs-target="#collapseExperienceFour"'+cat1+cat2+cat3+cat4+' aria-expanded="false" aria-controls="collapseExperienceFour"'+cat1+cat2+cat3+cat4+'>'+jobTitle+'</th><td style="text-align: right;"><button class="btn btn-danger">Remove</button></td></tr>');
            
        }

        $('.close').click(function(e){
            $("#passportModal").modal('hide');
            $("#passportFormatModal").modal('hide');
            $('#residenceCopyModal').modal('hide');
            $('#visaCopyModal').modal('hide');
            $('#schengenVisatModal').modal('hide');
        });

        $('.applicantSubmit, .submitChild, .dependentReview').click(function(e){
            if (confirm("After submit these details can't be changed")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('submit/applicant/Details') }}",
                    data: {applicantId : '{{$applicant['id']}}'},
                    success: function (response) {
                        location.href = "{{url('myapplication')}}"
                    },
                    errror: function (error) {
                        
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
            $.ajax({
                type: 'POST',
                url: "{{ route('store.dependent.details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapsespouseapplicant').removeClass('show');
                        $('.spouseApplicantData').show();
                        $('#collapsespouseHome').addClass('show');
                        $('.dependentApplicantCompleted').val(1);
                        $('.addExperience, .container').attr('data-dependentId', data.dependentId);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
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
            $.ajax({
                type: 'POST',
                url: "{{ url('store/spouse/home/country/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapsespouseHome').removeClass('show');
                        $('.spouseHomeCountryData').show();
                        $('#collapseSpouseCurrent').addClass('show');
                        $('.spouseHomeCountryCompleted').val(1);
                        $('.addExperience, .container').data('data-dependentId', data.dependentId);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
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
            $.ajax({
                type: 'POST',
                url: "{{ url('store/spouse/current/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseSpouseCurrent').removeClass('show');
                        $('.spouseCurrentCountryData').show();
                        $('#collapseSpouseSchengen').addClass('show');
                        $('.spouseCurrentCountryCompleted').val(1);
                        $('.addExperience, .container').data('data-dependentId', data.dependentId);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
                }
            });
        });

        $('#dependent_schengen_details').submit(function(e){
            e.preventDefault(); 
            $("#dependent_schengen_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ url('store/spouse/schengen/details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseSpouseSchengen').removeClass('show');
                        $('.spouseSchengenData').show();
                        $('#collapseSpouseExperience').addClass('show');
                        $('.schengenSpouseCompleted').val(1);
                        $('.addExperience, .container').data('data-dependentId', data.dependentId);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
                }
            });
        });

        $('#is_dependent_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_dependent_schengen_visa_issued_last_five_year').val() == "Yes"){
                $('.dependent_schengen_visa').show();
            } else {
                $('.dependent_schengen_visa').hide();
            }
        });

        $(document).on('change','.dependent_passport_copy', function(){
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
            }
        });

        $(document).on('change','.dependent_residence_copy', function(){
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

        // children

        for(var i= 1 ; i<='{{$applicant['children_count']}}'; i++)
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
                url: "{{ route('store.children.details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        location.href = "{{url('myapplication')}}"
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                    }
                },
                errror: function (error) {
                }
            });
        });

        $('.applicantNext').click(function(e){
            e.preventDefault(); 
            if('{{$applicant['is_spouse']}}' == null || '{{$applicant['is_spouse']}}' == 0){
                $('#children').show();
                $('#mainApplicant, #dependant').hide();
                $('.children').addClass('active');
                $('.mainApplicant, .dependant').removeClass('active');
            } else {
                $('#dependant').show();
                $('#mainApplicant, #children').hide();
                $('.dependant').addClass('active');
                $('.mainApplicant, .children').removeClass('active');
                $('#collapsespouseapplicant').addClass('show');
            }
        });

        $('.dependentNext').click(function(e){
            e.preventDefault(); 
            $('#children').show();
            $('#mainApplicant, #dependant').hide();
            $('.children').addClass('active');
            $('.mainApplicant, .dependant').removeClass('active');
            
        });

    });
    function showPassport()
    {
        $("#passportModal").modal('show');
    }

    function showPassportFormat()
    {
        $("#passportFormatModal").modal('show');
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

</script>
<script src="https://unpkg.com/vue@next"></script>
<script src="{{ asset('js/application-details.js') }}" type="text/javascript"></script>
<script src="{{asset('js/alert.js')}}"></script>
@endpush

