@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')


@php 
 $productId = 1; 
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
    <div class="container" id="app">
        <div class="col-12">
            <div class="row">
                <div class="wizard-details bg-white">
                    <div class="row">
                        <div class="tabs-detail d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="{{ url('referal_details', $productId) }}" ><div class="round-completed round1 m-2">1</div></a>
                                <div class="round-title"><p>Refferal</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="#" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">2</div></a>


                                <div class="round-title"><p>Payment</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant', $productId)}}" ><div class="round-completed  round3 m-2">3</div></a>
                                <div class="round-title"><p>Application</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant.details')}}" ><div class="round-active round4 m-2">4</div></a>
                                <div class="round-title"><p>Applicant</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                                
                            <div class="wrapper">
                                <a href="{{url('applicant/review')}}" ><div class="round5 m-2">5</div></a>
                                <div class="round-title"><p>Application</p><p> Review</p></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <form method="POST" id="applicant_details">
                                    @csrf
                                    <input type="hidden" name="product_id" value="1">
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <input type="tel" name="first_name" class="form-control" placeholder="First Name*" value="{{$name[0]}}" autocomplete="off" required/>
                                            <span class="first_name_errorClass"></span>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{old('middle_name')}}"  autocomplete="off"/>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="surname" class="form-control" placeholder="Surname*" value="{{$name[count($name)-1]}}" autocomplete="off" required />
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
                                            <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth*" value="{{old('dob')}}" id="datepicker" autocomplete="off"  readonly="readonly" required/>
                                            <span class="dob_errorClass"></span>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="place_birth" class="form-control" placeholder="Place of Birth*" value="{{old('place_birth')}}" autocomplete="off" required/>
                                            <span class="place_birth_errorClass"></span>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select class="form-select form-control" name="country_birth" placeholder="Country of Birth*" value="{{old('country_birth')}}"  required>
                                                <option selected disabled>Country of Birth *</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua &amp; Deps">Antigua &amp; Deps</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina">Burkina</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Rep">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="China - Hong Kong">China - Hong Kong</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo {Democratic Rep}">Congo {Democratic Rep}</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland {Republic}">Ireland {Republic}</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Ivory Coast">Ivory Coast</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea South">Korea South</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar, {Burma}">Myanmar, {Burma}</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Kitts &amp; Nevis">St Kitts &amp; Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="Saint Vincent &amp; the Grenadines">Saint Vincent &amp; the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City">Vatican City</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                            <span class="country_birth_errorClass"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <select class="form-select form-control" name="citizenship" placeholder="Citizenship*" value="{{old('citizenship')}}"  required>
                                                <option selected disabled>Citizenship *</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua &amp; Deps">Antigua &amp; Deps</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina">Burkina</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Rep">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="China - Hong Kong">China - Hong Kong</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo {Democratic Rep}">Congo {Democratic Rep}</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland {Republic}">Ireland {Republic}</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Ivory Coast">Ivory Coast</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea South">Korea South</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar, {Burma}">Myanmar, {Burma}</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Kitts &amp; Nevis">St Kitts &amp; Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="Saint Vincent &amp; the Grenadines">Saint Vincent &amp; the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City">Vatican City</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                            <span class="citizenship_errorClass"></span>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select name="sex"  aria-required="true" class="form-control form-select" required>
                                                <option selected disabled>Sex *</option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                            <span class="sex_errorClass"></span>
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select name="civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
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
                                            <button type="button" class="btn btn-primary submitBtn applicantDetails">Continue</button>
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
                                    <input type="hidden" name="product_id" value="1">
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <input type="text" name="passport_number" class="form-control" placeholder="Passport Number*" value="{{old('passport_number')}}" autocomplete="off"/>
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
                                            <input type="text" name="issued_by" class="form-control" placeholder="Issued By(Authority that issued the passport)*" value="{{old('issued_by')}}" autocomplete="off"/>
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
                                            <input type="tel" name="home_phone_number" class="form-control" placeholder="Phone Number" value="{{old('home_phone_number')}}" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-3 mt-3">
                                            <select class="form-select form-control" name="home_country" placeholder="home_country*" value="{{old('home_country')}}" autocomplete="off">
                                                <option selected disabled>Home Country *</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua &amp; Deps">Antigua &amp; Deps</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina">Burkina</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Rep">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="China - Hong Kong">China - Hong Kong</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo {Democratic Rep}">Congo {Democratic Rep}</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland {Republic}">Ireland {Republic}</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Ivory Coast">Ivory Coast</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea South">Korea South</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar, {Burma}">Myanmar, {Burma}</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Kitts &amp; Nevis">St Kitts &amp; Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="Saint Vincent &amp; the Grenadines">Saint Vincent &amp; the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City">Vatican City</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                            <span class="home_country_errorClass"></span>
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="text" name="state" class="form-control" placeholder="State/Province*" autocomplete="off">
                                            @error('state') <span class="error">{{ $message }}</span> @enderror
                                            <span class="state_errorClass"></span>
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="text" name="city" class="form-control" placeholder="City*" autocomplete="off">
                                            <span class="city_errorClass"></span>
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="integer" name="postal_code" value="{{old('postal_code')}}" class="form-control" placeholder="Postal Code*" autocomplete="off">
                                            <span class="postal_code_errorClass"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="address_1" class="form-control" placeholder="Address (Street And Number) Line 1*" autocomplete="off">
                                            <span class="address1_errorClass"></span>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="address_2" class="form-control" placeholder="Address (Street And Number) Line 2*" autocomplete="off">
                                            <span class="address2_errorClass"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                            <button type="submit" class="btn btn-primary submitBtn homeCountryDetails">Continue</button>
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
                                    <input type="hidden" name="product_id" value="1">
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <select class="form-select form-control" name="current_country" placeholder="current_country*" value="{{old('current_country')}}"  >
                                                <option selected disabled>Current Country Are You Living Right Now? *</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua &amp; Deps">Antigua &amp; Deps</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina">Burkina</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Rep">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="China - Hong Kong">China - Hong Kong</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo {Democratic Rep}">Congo {Democratic Rep}</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland {Republic}">Ireland {Republic}</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Ivory Coast">Ivory Coast</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea South">Korea South</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar, {Burma}">Myanmar, {Burma}</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Kitts &amp; Nevis">St Kitts &amp; Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="Saint Vincent &amp; the Grenadines">Saint Vincent &amp; the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City">Vatican City</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
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
                                            <input type="text" class="form-control visa_copy" name="visa_copy" placeholder="Visa Copy" readonly >
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
                                            <button type="submit" class="btn btn-primary submitBtn">Continue</button>
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
                                    <input type="hidden" name="product_id" value="1">
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
                                            <button type="submit" class="btn btn-primary submitBtn">Continue</button>
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
                                                <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+job.cat1+job.cat2+job.cat3+job.cat4" aria-expanded="false" :aria-controls="'collapseExperienceFour'+job.cat1+job.cat2+job.cat3+job.cat4">@{{job.name}}</td>
                                                <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(jobIndex)">Remove</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h4 style="margin-top:60px">Job Sector List</h4>
                                <form method="POST" id="experience">
                                    @csrf
                                    <div class="form-group row mt-4 searchForm">
                                        <div class="col-sm-10 mt-3" >
                                            <input type="text" class="form-control" name="search" placeholder="Enter Job Title" >
                                        </div>
                                        <div class="col-sm-2 mt-3" style="padding-left: 0px">
                                            <button class="btn btn-danger">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="jobCategory" v-if="jobCategories.length > 0" v-for='(jobCategoryOne, index) in jobCategories'>
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
                                                                {{-- <form>
                                                                    @csrf
                                                                    <input type="hidden" name="jobCategoryone" value="{{$jobCategoryOne['id']}}">
                                                                    <input type="hidden" name="jobCategorytwo" value="{{$jobCategoryTwo['id']}}">
                                                                    <input type="hidden" name="jobCategorythree" value="{{$jobCategoryThree['id']}}">
                                                                    <input type="hidden" name="jobCategoryfour" value="{{$jobCategoryFour['id']}}"> --}}
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
                                                                                <button type="button" class="btn btn-primary submitBtn"  v-on:click="addExperience(index,indexTwo,indexThree,indexFour,jobCategoryFour.name)" style="line-height: 22px">Add Experience</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {{-- </form> --}}
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
                                    <button type="submit" class="btn btn-primary submitBtn">Review</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <button type="button" class="btn closeBtn" data-dismiss="modal">Close</button>
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
        $('.schengen_visa').hide();
        $('.datepicker').datepicker({
            maxDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            constrainInput: false   
        });
        $('.passport_issue').datepicker({
            maxDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            constrainInput: false   
        });
        $('.passport_expiry, .visa_validity').datepicker({
            minDate : 0,
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            constrainInput: false   
        });

        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ae",
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });


        $(".applicantDetails").click(function(){
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
                        alert('Data added successfully !');
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
            
            $.ajax({
                type: 'POST',
                url: "{{ route('store.home-country.details') }}",
                data: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        alert('Data added successfully !');
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
                        alert('Data added successfully !');
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
            $("#passportFormatModal").modal('hide');
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
                        alert('Data added successfully !');
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
        $('.closeBtn').click(function(){
            $("#passportFormatModal").modal('hide');
        });
        
    });
    function showPassportFormat()
    {
        $("#passportFormatModal").modal('show');
    }
</script>
<script src="https://unpkg.com/vue@next"></script>
<script src="{{ asset('js/application-details.js') }}" type="text/javascript"></script>
<script src="{{asset('js/alert.js')}}"></script>
@endpush
<script src="../user/extra/assets/js/jquery-min.js"></script>

