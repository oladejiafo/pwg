@extends('layouts.master')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
 -->
 <link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
 <script src=”https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <link href="{{asset('css/alert.css')}}" rel="stylesheet">
<style>
    body {
    background: #f0f3f4 !important;
    font-family: TT Norms Pro;
}

</style>
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
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard bg-white">
                    <div class="row">
                        <div class="tabs d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="{{ url('referal_details', $productId) }}" ><div class="round-completed round1  m-2">1</div></a>
                                <div class="round-title">Refferal <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                            @php 
                                if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') {
                            @endphp    
                                <a href="#" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">2</div></a>
                                <!-- <a href="{{ url('payment_form', $productId) }}" ><div class="round-completed round2  m-2">2</div></a> -->
                                @php
                          } else {
                                @endphp    
                                <a href="{{ url('payment_form', $productId) }}" >
                                    <div class="round2  m-2">2</div>
                                </a>
                              @php   
                        }
                            @endphp
                                <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant', $productId)}}" ><div class="round-active  round3  m-2">3</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            @php 
                                if ($levels == '5' || $levels == '4' || $levels == '3') {
                            @endphp    
                            <div class="wrapper">
                                <a href="{{route('applicant.details')}}" ><div class="round4 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant/review')}}" ><div class="round5 m-2">5</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            @php  
                                } else {
                            @endphp
                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round4 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                            <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round5 m-2">5</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            @php  
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            <div>
            <div class="row">
                <div class="applicant-sec">
                    <div class="heading">
                      <div class="first-heading">
                          <h3>
                              Application Details
                          </h3>
                      </div>
                    </div>
                    
                    @php
                        $applied = DB::table('products')
                            ->where('id', '=', $productId)
                            ->get();

                        $products =  DB::table('products')->get();
                    @endphp    

                    <div class="form-sec">
                        <form method="POST" action="{{route('store.applicant')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$productId}}">
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mt-3">
                                    <select class="form-select form-control" id="inputFirstname" name="applied_country" placeholder="Applied Country *" value="{{old('applied_country')}}" required>
                                        <!-- <option selected disabled>Applied Country *</option> -->
                                        <option selected>@foreach($applied as $appliedc) {{$appliedc->product_name}} @endforeach</option>
                                        @foreach($products as $product)
                                         <option value="{{$product->product_name}}">{{$product->product_name}}</option>
                                        @endforeach 
                                        <!-- <option value="Canada">Canada</option>

                                        <option value="Czech">Czech</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Malta">Malta</option> -->
                                    </select>
                                    @error('applied_country') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <select class="form-select form-control" id="inputLastname" name="job_type" placeholder="Are you apply for white collar job? *" value="{{old('job_type')}}" required>
                                        <option selected disabled>Are you apply for white collar job? *</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    @error('job_type') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>        
                            <div class="form-group row mt-3">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Upload your cv (PDF only)*" name="cv" value="{{old('cv')}}" readonly required>
                                    <div class="input-group-btn">
                                        <span class="fileUpload btn">
                                            <span class="upl" id="upload">Choose File</span>
                                            <input type="file" class="upload up" id="up"  name="cv" accept="application/pdf" onchange="readURL(this);" />
                                          </span><!-- btn-orange -->
                                    </div><!-- btn -->
                                    @error('cv') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mt-3">

                                    <input id="phone" type="tel" name="agent_phone" class="form-control" placeholder="Your agent phone number" value="{{old('agent_phone')}}" />
                                    @error('agent_phone') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <input id="agent-name" type="tel" name="agent_name" class="form-control" placeholder="Your agent name" value="{{old('agent_name')}}" />
                                    @error('agent_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="heading">
                                <div class="first-heading">
                                    <h3>
                                        Country of embassy appearance
                                    </h3>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2 col-sm-12">
                                    <select class="form-select form-control" name="embassy_country" placeholder="Applied Country *" value="{{old('embassy_country')}}"  required>
                                        <option selected disabled>Select Country</option>
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
                                    @error('embassy_country') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="form-check col-lg-6 col-md-10 offset-lg-3 offset-md-1 col-sm-12 agree-terms">
                                    <input class=" checkcolor" type="checkbox" id="TnC" value="TnC" name="agree" value="{{old('agree')}}" required checked>
                                    <label class="form-check-label" for="TnC">
                                        I agree to <a class="text-primary" style="cursor: pointer" data-toggle="modal"
                                            data-target="#exampleModalLong">Terms and Conditions</a>
                                    </label>
                                    <label class="form-check-label text-danger" id="TnCAlert"></label>
                                    @error('agree') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4" style="margin-bottom: 70px">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                </div>
                            </div>

                        </form>
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
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: "ae",
        // geoIpLookup: getIp,
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

///TESTTTTTTTTTTTTTTTTTTTTTTTTT


///TESTTTTTTTTTTTTTTTTTTTTTTTTTTTT

    function getIp(callback) {
        var api_key = 'hk9woa8o8wuag4hd';
        fetch('https://api.ipregistry.co/?key=tryout')
        .then(function (response) {
            return response.json();
        })
        .catch((resp) => {
                return {
                    country: 'ae',
                };
            })
        //  .then((payload) => callback(payload.location.country.code))
        .then((payload) => callback('ae'))
        .then(function (payload) {
            // return payload.location.country.code;
            return 'ae';
        });
        // $.getJSON("https://api.ipify.org/?format=json", function(e) {
        //     ip = e.ip;
        // //     var ipInfo = request_ipwhois(ip)
        //     console.log(ip);
        //     $.getJSON("https://cors-anywhere.herokuapp.com/http://www.geoplugin.net/json.gp?ip=" + ip, function(response) {
        //         console.log(response.geoplugin_countryCode);

        //     });
        // });
    }

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
</script>

@endpush

<script src="{{asset('js/alert.js')}}"></script>