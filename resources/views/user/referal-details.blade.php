@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" /> -->
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<!-- <link rel="stylesheet" href="{{ asset('user/css/intlTelInput.css') }}"> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<style>
    .form-sec-content {
        padding: 12%;
        /*100px 110px 100px 110px; */

    }

    .form-secc h3 {
        font-size: 36px;

        text-align: center;
    }

    .form-secc p {
        font-size: 17px;
    }

    @media (min-width:375px) and (max-width: 768px) {
        .form-secc {
            width: 100%;
            padding: 50px;
            margin-bottom: 50px;
            margin-top: 50px;
        }

        .form-secc h3 {
            font-size: 30px;
        }

        .form-secc p {
            font-size: 12px;
        }
    }

    .form-secc input,
    select {
        border-radius: 10px;
        border-color: #f5f5f5;
        background-color: #f5f5f5;
        padding: 10px;

    }

    .form-secc button {
        width: 100%;
        color: #000;
        border-radius: 5px;
        border-color: #C4C4C4;
    }
</style>

@php
$completed = DB::table('applicants')
->where('product_id', '=', $data->id)
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
                            <a href="{{ url('referal_details', $data->id) }}">
                                <div class="round-active round1 m-2">1</div>
                            </a>
                            <div class="round-title">Refferal <br> Details</div>
                        </div>
                        <div class="linear"></div>
                        @php
                        if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') {
                        @endphp
                        <div class="wrapper">
                            <a href="#" onclick="return alert('Payment Concluded Already!');">
                                <div class="round-completed round2 m-2">2</div>
                            </a>
                            <div class="col-2 round-title">Payment <br> Details</div>
                        </div>
                        @php
                          } else {
                                @endphp    
                                <div class="wrapper">
                                <a href="{{ url('payment_form', $data->id) }}" >
                                    <div class="round2  m-2">2</div>
                                </a>
                                <div class="col-2 round-title">Payment <br> Details</div>
                                </div>
                              @php   
                        }
                        @endphp

                        @php
                        if ($levels == '5' || $levels == '4' || $levels == '3' || $levels == '2' || $levels == '1') {
                        @endphp
                        <div class="linear"></div>
                        <div class="wrapper">
                            <a href="{{route('applicant', $data->id)}}">
                                <div class="round3 m-2">3</div>
                            </a>
                            <div class="col-2 round-title">Application <br> Details</div>
                        </div>

                        <div class="linear"></div>
                        <div class="wrapper">
                            <a href="{{route('applicant.details',  $data->id)}}">
                                <div class="round4 m-2">4</div>
                            </a>
                            <div class="col-2 round-title">Applicant <br> Details</div>
                        </div>
                        
                        <div class="linear"></div>
                        <div class="wrapper">
                            <a href="{{url('applicant/review')}}">
                                <div class="round5 m-2">5</div>
                            </a>
                            <div class="col-2 round-title">Application <br> Review</div>
                        </div>

                        @php
                        } else {
                        @endphp

                        <div class="linear"></div>
                        <div class="wrapper">
                            <a href="#" onclick="return alert('You have to complete Application Details first');">
                                <div class="round3 m-2">3</div>
                            </a>
                            <div class="col-2 round-title">Application <br> Details</div>
                        </div>
                        <div class="wrapper">
                            <a href="#" onclick="return alert('You have to complete Application Details first');">
                                <div class="round4 m-2">4</div>
                            </a>
                            <div class="col-2 round-title">Applicant <br> Details</div>
                        </div>
                        <div class="linear"></div>
                        <div class="wrapper">
                            <a href="#" onclick="return alert('You have to complete Application Details first');">
                                <div class="round5 m-2">5</div>
                            </a>
                            <div class="col-2 round-title">Applicant <br> Reviews</div>
                        </div>
                        @php
                        }
                        @endphp
                    </div>
                </div>
            </div>
            <div class="referal-sec">
                <div class="heading">
                    <div class="first-heading">
                        <h3>
                            Referal Details
                        </h3>
                    </div>
                    <div class="bottom-title">
                        <p style="color: #C4C4C4; text-align: center;">Please enter your referal Details here</p>
                    </div>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{ url('add_referal') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                        <div class="form-group row mt-4">
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control" name="referrer_first_name" placeholder="Referrer First Name" autocomplete="off" autofocus>
                                @error('referrer_first_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="text" class="form-control" name="referrer_last_name" placeholder="Referrer Last Name" autocomplete="off" autofocus>
                                @error('referrer_last_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <input type="text" class="form-control" name="coupon_code" placeholder="Coupon Code(if you have any)" autocomplete="off" autofocus>
                                @error('coupon_code') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select title="Current Location" class="form-control  current_location form-select" name="current_location" required="">
                                    <option selected disabled>--Current Location--</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                @error('current_location') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-12 mt-3">
                                <select class="form-control form-select" name="nationality">
                                    <option selected disabled>--Select Nationality--</option>
                                    @foreach (Constant::countries as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                @error('nationality') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <input type="tel" name="phone_number[main]" id="phone_number" />
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

    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    @endpush


    <script src="{{asset('js/alert.js')}}"></script>

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

<script src="{{ asset('user/js/intlTelInput-jquery.min.js') }}"></script>

<script>

// var phone_number = window.intlTelInput(document.querySelector("#phone_number"), {
//   separateDialCode: true,
//   preferredCountries:["in"],
//   hiddenInput: "full",
//   utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
// });


var input = document.querySelector("#phone_number");
    window.intlTelInput(input, {
       allowDropdown: true,
       autoHideDialCode: true,
       autoPlaceholder: "polite",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
       hiddenInput: "full",
    //    initialCountry: "ae",
       localizedCountries: { 'de': 'Deutschland' },
       nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['ae', 'ng'],
       separateDialCode: true,
      utilsScript: "../user/js/utils.js",
    });


// $("form").submit(function() {
//   var full_number = input.getNumber(intlTelInputUtils.numberFormat.E164);
// $("input[name='phone_number[full]'").val(full_number);
  
// });
</script>