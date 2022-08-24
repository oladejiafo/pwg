@extends('layouts.master')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
@section('content')
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard-details bg-white">
                    <div class="row">
                        @php $productId = 1; @endphp
                        <div class="tabs-detail d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="{{ url('referal_details', $productId) }}" ><div class="round-completed round1 m-2">1</div></a>
                                <div class="round-title"><p>Refferal</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{ url('payment_form', $productId) }}" ><div class="round-completed round2 m-2">2</div></a>
                                <div class="round-title"><p>Payment</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant', $productId)}}" ><div class="round-completed  round3 m-2">3</div></a>
                                <div class="round-title"><p>Application</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant.details')}}" ><div class="round-completed round4 m-2">4</div></a>
                                <div class="round-title"><p>Applicant</p><p> Details</p></div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant/review')}}" ><div class="round-active round5 m-2">5</div></a>
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
                                <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseApplicant" aria-expanded="true" aria-controls="collapseApplicant">
                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="collapse show" id="collapseApplicant">
                            <div class="form-sec">
                                <form method="POST" enctype="multipart/form-data" id="applicant_details">
                                    @csrf
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <input type="tel" name="first_name" class="form-control" placeholder="First Name*" value="{{$applicant['first_name']}}" autocomplete="off" required/>
                                            @error('first_name') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{$applicant['middle_name']}}"  autocomplete="off"/>
                                            @error('middle_name') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="surname" class="form-control" placeholder="Surname*" value="{{$applicant['surname']}}" autocomplete="off" required />
                                            @error('surname') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="email" class="form-control" placeholder="Email*" value="{{$user['email']}}" autocomplete="off" required/>
                                            @error('email') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="tel" name="phone_number" class="form-control" id="phone" placeholder="Phone Number*" value="{{$user['phone_number']}}" autocomplete="off"  required/>
                                            @error('phone_number') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="dob" class="form-control" placeholder="Date of Birth*" value="{{ date('d-m-Y', strtotime($applicant['dob']))}}" id="datepicker" autocomplete="off"  required/>
                                            @error('dob') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="place_birth" class="form-control" placeholder="Place of Birth*" value="{{$applicant['place_birth']}}" autocomplete="off" required/>
                                            @error('place_birth') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select class="form-select form-control" name="country_birth" placeholder="Country of Birth*"  required>
                                                <option selected>{{$applicant['country_birth']}}</option>
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
                                            @error('country_birth') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <select class="form-select form-control" name="citizenship" placeholder="Citizenship*" value="{{old('citizenship')}}"  required>
                                                <option selected>{{$applicant['citizenship']}}</option>
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
                                            @error('citizenship') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select name="sex"  aria-required="true" class="form-control form-select" required>
                                                <option selected disabled>Sex *</option>
                                                <option {{($applicant['sex'] == "Male") ? 'selected' : ''}} value="Male">Male</option>
                                                <option {{($applicant['sex'] == "Female") ? 'selected' : ''}} value="Female">Female</option>
                                            </select>
                                            @error('sex') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <select name="civil_status" id="civil_status" required="" aria-required="true" class="form-control form-select">
                                                <option selected disabled>Civil Status *</option>
                                                <option {{($applicant['civil_status'] == "Single") ? 'selected' : ''}} value="Single">Single</option>
                                                <option {{($applicant['civil_status'] == "Married") ? 'selected' : ''}} value="Married">Married</option>
                                                <option {{($applicant['civil_status'] == "Separated") ? 'selected' : ''}} value="Separated">Separated</option>
                                                <option {{($applicant['civil_status'] == "Divorced") ? 'selected' : ''}} value="Divorced">Divorced</option>
                                                <option {{($applicant['civil_status'] == "Widow") ? 'selected' : ''}} value="Widow">Widow</option>
                                                <option {{($applicant['civil_status'] == "Other") ? 'selected' : ''}} value="Other">Other</option>
                                            </select>
                                            @error('civil_status') <span class="error">{{ $message }}</span> @enderror
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
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <input type="text" name="passport_number" class="form-control" placeholder="Passport Number*" value="{{$applicant['passport_number']}}" autocomplete="off" required/>
                                            @error('passport_number') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="passport_issue" class="form-control" placeholder="Passport Date of Issue*" value="{{ date('d-m-Y', strtotime($applicant['passport_date_issue']))}}" autocomplete="off" required/>
                                            @error('passport_issue') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="passport_expiry" class="form-control" placeholder="assport Date of Expiry*" value="{{ date('d-m-Y', strtotime($applicant['passport_date_expiry']))}}" autocomplete="off"  required/>
                                            @error('passport_expiry') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <input type="text" name="issued_by" class="form-control" placeholder="Issued By(Authority that issued the passport)*" value="{{$applicant['issued_by']}}" autocomplete="off" required/>
                                            @error('issued_by') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="passport_copy" class="form-control" placeholder="Upload Passport Copy*" value="{{$applicant['passport']}}" autocomplete="off" readonly required/>
                                            <div class="input-group-btn">
                                                <span class="fileUpload btn">
                                                    <span class="upl" id="upload">Choose File</span>
                                                    <input type="file" class="upload up" id="up"  name="passport_copy" onchange="readURL(this);" />
                                                </span><!-- btn-orange -->
                                            </div><!-- btn -->
                                            @error('passport_copy') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="tel" name="home_phone_number" class="form-control" placeholder="Phone Number" value="{{$applicant['phone_number']}}" autocomplete="off"  required/>
                                            @error('home_phone_number') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-3 mt-3">
                                            <select class="form-select form-control" name="home_country" placeholder="home_country*" value="{{$applicant['home_country']}}"  required>
                                                <option selected>{{$applicant['home_country']}}</option>
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
                                            @error('home_country') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="text" name="state" class="form-control" placeholder="State/Province*" value="{{$applicant['state']}}" required>
                                            @error('state') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="text" name="city" class="form-control" placeholder="City*"  value="{{$applicant['city']}}" required>
                                            @error('city') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-3 mt-3">
                                            <input type="integer" name="postal_code" value="{{old('postal_code')}}" class="form-control" value="{{$applicant['postal_code']}}" placeholder="Postal Code*" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="address1" class="form-control" placeholder="Address (Street And Number) Line 1*" value="{{$applicant['address_1']}}" required>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="address1" class="form-control" placeholder="Address (Street And Number) Line 2*" value="{{$applicant['address_2']}}" required>
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
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <select class="form-select form-control" name="current_country" placeholder="current_country*" value="{{$applicant['current_residance_country']}}"  required>
                                                <option selected>{{$applicant['current_residance_country']}}</option>                                            </option>
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
                                            @error('current_country') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="tel" class="form-control" name='current_residance_mobile' value="{{$applicant['current_residance_mobile']}}" placeholder="Current Residence Mobile Number" required>
                                            @error('current_residance_mobile') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" name="residence_id" class="form-control" placeholder="Residence Id*" value="{{$applicant['residence_id']}}" required />
                                            @error('residence_id') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" class="form-control" name="id_validity" placeholder="Your ID/Visa Date of Validity*" value="{{ date('d-m-Y', strtotime($applicant['id_validity']))}}" required>
                                            @error('id_validity') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" class="form-control" name="residenc_id" placeholder="Residence/Emirates ID*" readonly required>
                                            <div class="input-group-btn">
                                                <span class="fileUpload btn">
                                                    <span class="upl" id="upload">Choose File</span>
                                                    <input type="file" class="upload residence" id="up"  name="residenc_id" onchange="readURL(this);" />
                                                </span><!-- btn-orange -->
                                            </div><!-- btn -->
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <input type="text" class="form-control" name="visa_copy" placeholder="Visa Copy*" readonly required>
                                            <div class="input-group-btn">
                                                <span class="fileUpload btn">
                                                    <span class="upl" id="upload">Choose File</span>
                                                    <input type="file" class="upload visa" id="up"  name="visa_copy" onchange="readURL(this);" />
                                                </span><!-- btn-orange -->
                                            </div><!-- btn -->
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <input type="text" name="prof_current_job" class="form-control" placeholder="Profession As Per Current Job (or on Visa)*" value="{{$applicant['current_job']}}" required>
                                            @error('prof_current_job') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="work_state" class="form-control" placeholder="Work State/Province*" value="{{$applicant['work_state']}}" required />
                                            @error('work_state') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" class="form-control" name="work_city" placeholder="Work City*" value="{{$applicant['work_city']}}" required>
                                            @error('work_city') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" class="form-control" name="work_postal_code" placeholder="Work Place Postal Code*" value="{{$applicant['work_postal_code']}}" required>
                                            @error('work_postal_code') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" name="work_street" class="form-control" placeholder="Work Place Street & Number*" value="{{$applicant['work_street_number']}}" required />
                                            @error('work_street') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" class="form-control" name="company_name" placeholder="Name of Company" value="{{$applicant['company_name']}}">
                                        </div>
                                        <div class="col-sm-4 mt-3">
                                            <input type="text" class="form-control" name="employer_phone" placeholder="Employer Phone Number" value="{{$applicant['employer_phone_number']}}">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <input type="email" name="employer_email" class="form-control" placeholder="Email of the employer" value="{{$applicant['employer_email']}}">
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
                                <form method="POST" id="schengen_details">
                                    @csrf
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 mt-3">
                                            <select name="is_schengen_visa_issued_last_five_year" id="is_schengen_visa_issued_last_five_year" required="" aria-required="true" class="form-control form-select">
                                                <option selected disabled>Schengen Or National Visa Issued During Last 5 Years*</option>
                                                <option {{($applicant['is_schengen_visa_issued'] == "No") ? 'selected' : ''}} value="No">No</option>
                                                <option {{($applicant['is_schengen_visa_issued'] == "Yes") ? 'selected' : ''}} value="Yes">Yes</option>
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
                                            <select name="is_finger_print_collected_for_Schengen_visa" id="is_finger_print_collected_for_Schengen_visa" required="" aria-required="true" class="form-control form-select">
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
                                {{-- @foreach ($jobCategories as $key => $jobCategoryOne)
                                    <div class="jobCategory">
                                        <div class="experience-sec" data-bs-toggle="collapse" data-bs-target="#collapseExperience{{$key}}" aria-expanded="false" aria-controls="collapseExperience{{$key}}">
                                            <div class="row">
                                                <div class="col-11">
                                                    <p class="exp-font">{{$jobCategoryOne['name']}}</p>
                                                </div>
                                                <div class="col-1 mx-auto my-auto">
                                                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperience{{$key}}" aria-expanded="false" aria-controls="collapseExperience{{$key}}">
                                                        <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse" id="collapseExperience{{$key}}" style="width: 95%; margin-left:2%">
                                            @foreach($jobCategoryOne['job_category_two'] as $keyTwo => $jobCategoryTwo)
                                                <div class="jobCategoryTwo">
                                                    <div class="experience-sec" data-bs-toggle="collapse" data-bs-target="#collapseExperienceTwo{{$key}}{{$keyTwo}}" aria-expanded="false" aria-controls="collapseExperienceTwo{{$key}}{{$keyTwo}}">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <p class="exp-font">{{$jobCategoryTwo['name']}}</p>
                                                            </div>
                                                            <div class="col-1 mx-auto my-auto">
                                                                <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperienceTwo{{$key}}{{$keyTwo}}" aria-expanded="false" aria-controls="collapseExperienceTwo{{$key}}{{$keyTwo}}">
                                                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse" id="collapseExperienceTwo{{$key}}{{$keyTwo}}" style="width: 95%; margin-left:2%">
                                                        @foreach($jobCategoryTwo['job_category_three'] as $keyThree => $jobCategoryThree)
                                                            <div class="jobCategoryThree" data-bs-toggle="collapse" data-bs-target="#collapseExperienceThree{{$key}}{{$keyTwo}}{{$keyThree}}" aria-expanded="false" aria-controls="collapseExperienceThree{{$key}}{{$keyTwo}}{{$keyThree}}">
                                                                <div class="experience-sec">
                                                                    <div class="row">
                                                                        <div class="col-11">
                                                                            <p class="exp-font">{{$jobCategoryThree['name']}}</p>
                                                                        </div>
                                                                        <div class="col-1 mx-auto my-auto">
                                                                            <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperienceThree{{$key}}{{$keyTwo}}{{$keyThree}}" aria-expanded="false" aria-controls="collapseExperienceThree{{$key}}{{$keyTwo}}{{$keyThree}}">
                                                                                <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="collapse" id="collapseExperienceThree{{$key}}{{$keyTwo}}{{$keyThree}}" style="width: 95%; margin-left:2%">
                                                                    @foreach($jobCategoryThree['job_category_four'] as $keyFour => $jobCategoryFour)
                                                                        <div class="experience-sec" data-bs-toggle="collapse" data-bs-target="#collapseExperienceFour{{$key}}{{$keyTwo}}{{$keyThree}}{{$keyFour}}" aria-expanded="false" aria-controls="collapseExperienceFour{{$key}}{{$keyTwo}}{{$keyThree}}{{$keyFour}}">
                                                                            <div class="row">
                                                                                <div class="col-11">
                                                                                    <p class="exp-font">{{$jobCategoryFour['name']}}</p>
                                                                                </div>
                                                                                <div class="col-1 mx-auto my-auto">
                                                                                    <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapseExperienceFour{{$key}}{{$keyTwo}}{{$keyThree}}{{$keyFour}}" aria-expanded="false" aria-controls="collapseExperienceFour{{$key}}{{$keyTwo}}{{$keyThree}}{{$keyFour}}">
                                                                                        <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="collapse" id="collapseExperienceFour{{$key}}{{$keyTwo}}{{$keyThree}}{{$keyFour}}">
                                                                            <form>
                                                                                @csrf
                                                                                <input type="hidden" name="jobCategoryone" value="{{$jobCategoryOne['id']}}">
                                                                                <input type="hidden" name="jobCategorytwo" value="{{$jobCategoryTwo['id']}}">
                                                                                <input type="hidden" name="jobCategorythree" value="{{$jobCategoryThree['id']}}">
                                                                                <input type="hidden" name="jobCategoryfour" value="{{$jobCategoryFour['id']}}">
                                                                                <div class="detail-sec">
                                                                                    <div class="row">
                                                                                        <h5>Description</h5>
                                                                                        <p>{{$jobCategoryFour['description']}}</p>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <h5>Example Titles</h5>
                                                                                        <p>{!! nl2br($jobCategoryFour['example_titles']) !!}</p>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <h5>Main Duties</h5>
                                                                                        <p>{!! nl2br($jobCategoryFour['main_duties']) !!}</p>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <h5>Employement Requirment</h5>
                                                                                        <p>{{ $jobCategoryFour['employement_requirements'] }}</p>
                                                                                    </div>
                                                                                    <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                                                        <div class="row">
                                                                                            <button type="submit" class="btn btn-primary submitBtn">Add Experience</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach --}}
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endSection
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    $(document).ready(function(){
        if($('#is_schengen_visa_issued_last_five_year').val() == 'Yes'){
            $('.schengen_visa').show();                
        } else {
            $('.schengen_visa').hide();                
        }
    });
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: "ae",
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });


    $("#applicant_details").submit(function(stay){
        var formdata = $(this).serialize(); 
        console.log(formdata);
        e.preventDefault(); 
        // $.ajax({
        //     type: 'POST',
        //     url: "{{ route('store.applicant.details') }}",
        //     data: formdata, 
        //     success: function (data) {

        //         alert('hereer');
        //     },
        //     errror: function (error) {
        //         console.log(error);
        //     }
        // });
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
          $(this).closest('.form-group').find('.form-control').attr("value",names);
        }
     });
     $(document).on('change','.residence', function(){
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
          $(this).closest('.form-group').find('.form-control').attr("value",names);
        }
     });
     $(document).on('change','.visa', function(){
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
          $(this).closest('.form-group').find('.form-control').attr("value",names);
        }
     });

</script>

@endpush