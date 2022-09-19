@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link href="{{asset('user/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')

@php 
 //Session::get('myproduct_id');
    $completed = DB::table('applications')
                ->where('destination_id', '=', $productId)
                ->where('client_id', '=', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->first();

   $levels = $completed->application_stage_status;
@endphp

    <div class="container" id="app" data-applicantId="{{$applicant['id']}}" data-dependentid="{{$dependent}}">
        <div class="col-12">
            <div class="row">
                <div class="wizard bg-white">
                    <div class="row">
                        <div class="tabs-detail d-flex justify-content-center">
                            
                        <div class="wrapper">
                              @if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') 
                                <a href="#" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">1</div></a>
                              @else 
                                <a href="{{ url('payment_form', $productId) }}" >
                                    <div class="round-completed round2  m-2">1</div>
                                </a>
                              @endif
                              <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant', $productId)}}" ><div class="round-completed round3  m-2">2</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div>


                            <div class="wrapper">
                                <a href="{{route('applicant.details',  $productId)}}" ><div class="round-active  round4 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>


                            @php 
                              if ($levels == '5' || $levels == '4') {
                            @endphp     
                            <div class="wrapper">
                                <a href="{{url('applicant/review',  $productId)}}" ><div class="round5 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            
                            @php  
                              } else {
                            @endphp
                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Applicants Details first');"><div class="round5 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            @php  
                              }
                            @endphp
                           
                        </div>
                    </div>
                </div>
                    <div class="applicant-tab-sec">
                        <div class="row">
                            @if(($applicant['work_permit_category']) && ($client['is_spouse'] != null || $client['is_spouse'] != 0) && ($client['children_count'] != null || $client['children_count'] != 0))
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
                            @elseif(($applicant['work_permit_category']) && ($client['is_spouse'] != null || $client['is_spouse'] != 0) &&  ($client['children_count'] == null || $client['children_count'] == 0))
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
                            @elseif(($applicant['work_permit_category']) && ($client['is_spouse'] == null || $client['is_spouse'] == 0) && ($client['children_count'] != null || $client['children_count'] != 0))
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
                    @include('user.main-applicant-detail')
                    @include('user.main-applicant-dependent')
                    @include('user.main-applicant-children')
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
                    <input type="hidden" name="passport_copy" class="form-control passport_copy" placeholder="Upload Passport Copy*" class="passportFormatModal"  autocomplete="off" readonly/>
                    <div class="input-group-btn">
                        <span class="fileUpload btn">
                            <span class="upl" id="upload">Choose File</span>
                            <input type="file" class="passport_upload" id="passport_upload"  name="passport_copy" />
                        </span><!-- btn-orange -->
                    </div><!-- btn -->
                    <button type="button" class="btn closeBtn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="residenceIdFormatModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{asset('images/ResidenceID.jpg')}}" width ="100%" height ="100%;">
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control residence_id" name="residence_copy" placeholder="Residence/Emirates ID*" readonly >
                    <div class="input-group-btn">
                        <span class="fileUpload btn">
                            <span class="upl" id="upload">Choose File</span>
                            <input type="file" class="upload residence_upload" id="residence_upload"  name="residence_copy" />
                        </span><!-- btn-orange -->
                    </div><!-- btn -->
                    <button type="button" class="btn closeBtn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="visaFormatModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{asset('images/Visa.jpg')}}" width ="100%" height ="100%;">
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control visa_copy"  name="visa_copy" placeholder="Visa Copy" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <span class="fileUpload btn">
                            <span class="upl" id="upload">Choose File</span>
                            <input type="file" class="upload visa_upload" id="visa_upload"  name="visa_copy" />
                        </span><!-- btn-orange -->
                    </div><!-- btn -->
                    <button type="button" class="btn closeBtn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="schengenVisaFormatModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{asset('images/ShengenVisa.jpg')}}" width ="100%" height ="100%;">
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control schengen_copy" name="schengen_copy" readonly >
                    <div class="input-group-btn">
                        <span class="fileUpload btn">
                            <span class="upl" id="upload">Choose File</span>
                            <input type="file" class="upload schengen_upload" accept="image/png, image/gif, image/jpeg" name="schengen_copy" />
                        </span><!-- btn-orange -->
                    </div><!-- btn -->
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        // $('.country_birth, .citizenship, .home_country, .current_country').select2();
        // Main Applicant
        $('.applicantReviewSpin, .dependentReviewSpin, .childReviewSpin').hide();
        $('.schengen_visa, .applicantData, .homeCountryData, .currentCountryData, .schengenData, .dependent_schengen_visa, #is_finger_print_collected_for_Schengen_visa,#is_dependent_finger_print_collected_for_Schengen_visa').hide();
        $('.datepicker').datepicker({
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            maxDate: '-18Y',
            yearRange: "-100:+0",
            constrainInput: false ,  
        });
        $('.dependent_datepicker, .child-dob').datepicker({
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
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        const phoneCurrentInputField = document.querySelector("#current_residance_mobile");
        const phoneCurrentInput = window.intlTelInput(phoneCurrentInputField, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        const dependentPhone = document.querySelector("#dependent_phone");
        const dependentcurrentresidancemobile = document.querySelector("#dependent_current_residance_mobile");
        const dependentPhoneInput = window.intlTelInput(dependentPhone, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        const dependentcurrentresidancemobileInput = window.intlTelInput(dependentcurrentresidancemobile, {
            separateDialCode: false,
            preferredCountries:["ae"],
            nationalMode: false,
            hiddenInput: "full",
            autoHideDialCode: false,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });


        $(document).on('change','.up', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            $('.passport_copy, .up').attr("value",names);
        });
        $('.passport_upload, .residence_upload, .visa_upload, .schengen_upload').click(function(){
            $("#passportFormatModal").modal('hide');
            $("#visaFormatModal").modal('hide');
            $("#residenceIdFormatModal").modal('hide');
            $('#schengenVisaFormatModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        })
        $(document).on('change', '.passport_upload', function ()  {
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.passport_copy, .passport_upload').attr("value",length+" files selected");
            }
            else{
                $('.passport_upload, .passport_copy').attr("value",names);
            }
        })
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
        $(document).on('change','.residence_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
            var fileName = names.join(', ');
                $('.residence_copy').attr("value",length+" files selected");
            }
            else{
                $('.residence_copy').attr("value",names);
            }
        });
        $(document).on('change','.visa_upload', function(){
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
        $(document).on('change','.schengen_upload', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            if(length>2){
                var fileName = names.join(', ');
                $('.schengen_copy').attr("value",length+" files selected");
            }
            else{
                $('.schengen_copy').attr("value",names);
            }
        });
        $('#is_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_schengen_visa_issued_last_five_year').val() == "YES"){
                $('.schengen_visa').show();
                $('#is_finger_print_collected_for_Schengen_visa').show();
            } else {
                $('.schengen_visa').hide();
                $('#is_finger_print_collected_for_Schengen_visa').hide();
            }
        });
        $('.applicantReview').click(function(e){
            $('.applicantReviewSpin').show();
            e.preventDefault(); 
            if($('.applicantCompleted').val() == 1){
                if($('.homeCountryCompleted').val() == 1) {
                    if($('.currentCountryCompleted').val() == 1) {
                        if($('.schengenCompleted').val() == 1) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ url('/submit/applicant/Details/') }}",
                                data: {
                                    applicantId: '{{$applicant['id']}}',
                                    user: 'applicant',
                                },
                                success: function (response) {
                                    if(response.status) {
                                        checkdata = checkStatus('{{$productId}}');
                                        $('.applicantReviewSpin').hide();
                                        if(checkdata.status){
                                            location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                                        } else {
                                            toastr.error(checkdata.message);
                                        }
                                    } else {
                                        $('.applicantReviewSpin').hide();
                                        var validationError = response.errors;
                                        $.each(validationError, function(index, value) {
                                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                                            toastr.error(value);
                                        });
                                    }
                                }
                            });
                        } else {
                            $('.applicantReviewSpin').hide();
                            toastr.error('Please provide all details');
                            $('#collapseSchengen').addClass('show');
                            $('#collapseExperience').removeClass('show');
                        }
                    } else {
                        $('.applicantReviewSpin').hide();
                        toastr.error('Please provide all details');
                        $('#collapseCurrent').addClass('show');
                        $('#collapseExperience').removeClass('show');
                    }
                } else {
                    $('.applicantReviewSpin').hide();
                    $('#collapseHome').addClass('show');
                    $('#collapseExperience').removeClass('show');
                    toastr.error('Please provide all details');
                }
            } else {
                $('.applicantReviewSpin').hide();
                $('#collapseapplicant').addClass('show');
                $('#collapseExperience').removeClass('show');
                toastr.error('Please provide all details');
                $('html, body').animate({
                    scrollTop: $("#collapseapplicant").offset().top
                }, 2000);
            }
        });

        $('.applicantNext').click(function(e){
            e.preventDefault(); 
            if($('.applicantCompleted').val() == 1){
                if($('.homeCountryCompleted').val() == 1) {
                    if($('.currentCountryCompleted').val() == 1) {
                        if($('.schengenCompleted').val() == 1) {
                            if(('{{($applicant['work_permit_category'])}}' == 'FAMILY PACKAGE') && ('{{$client['is_spouse']}}' == null || '{{$client['is_spouse']}}' == 0)){
                                updateStatus('applicant'); 
                                $('#children').show();
                                $('#mainApplicant, #dependant').hide();
                                $('.children').addClass('active');
                                $('.mainApplicant, .dependant').removeClass('active');
                            } else {
                                updateStatus('applicant'); 
                                $('#dependant').show();
                                $('#mainApplicant, #children').hide();
                                $('.dependant').addClass('active');
                                $('.mainApplicant, .children').removeClass('active');
                                $('#collapsespouseapplicant').addClass('show');
                            }
                        } else {
                            toastr.error('Please provide all details');
                            $('#collapseSchengen').addClass('show');
                            $('#collapseExperience').removeClass('show');
                        }
                    } else {
                        toastr.error('Please provide all details');
                        $('#collapseCurrent').addClass('show');
                        $('#collapseExperience').removeClass('show');
                    }
                } else {
                    $('#collapseHome').addClass('show');
                    $('#collapseExperience').removeClass('show');
                    toastr.error('Please provide all details');
                }
            } else {
                $('#collapseapplicant').addClass('show');
                $('#collapseExperience').removeClass('show');
                toastr.error('Please provide all details');
                $('html, body').animate({
                    scrollTop: $("#collapseapplicant").offset().top
                }, 2000);
            }
        });

        $("#applicant_details").submit(function(e){
            e.preventDefault(); 
            $("#applicant_details :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var full_number = phoneInput.getNumber(intlTelInputUtils.numberFormat.E164);

            $.ajax({
                type: 'POST',
                url: "{{ route('store.applicant.details') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseapplicant').removeClass('show');
                        $('.applicantData').show();
                        $('#collapseHome').addClass('show');
                        $('.applicantCompleted').val(1);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
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
            
            var formData = new FormData(this);
            formData.append('passport_copy', $('.passport_upload')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: "{{ url('store/home/country/details') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseHome').removeClass('show');
                        $('.homeCountryData').show();
                        $('#collapseCurrent').addClass('show');
                        $('.homeCountryCompleted').val(1);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
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
            var full_number = phoneCurrentInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='current_residance_mobile'").val(full_number);
            var formData = new FormData(this);
            formData.append('visa_copy', $('.visa_upload')[0].files[0]);
            formData.append('residence_copy', $('.residence_upload')[0].files[0]);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: "{{ url('store/current/details') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseCurrent').removeClass('show');
                        $('.currentCountryData').show();
                        $('#collapseSchengen').addClass('show');
                        $('.currentCountryCompleted').val(1);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
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
            var formData = new FormData(this);
            formData.append('schengen_copy', $('.schengen_upload')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: "{{ url('store/schengen/details') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.success) {
                        $('#collapseSchengen').removeClass('show');
                        $('.schengenData').show();
                        $('#collapseExperience').addClass('show');
                        $('.schengenCompleted').val(1);
                    } else {
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error('error');
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

        $('.closeBtn').click(function(){
            $("#passportFormatModal").modal('hide');
            $("#residenceIdFormatModal").modal('hide');
            $('#visaFormatModal').modal('hide');
            $('#schengenVisaFormatModal').modal('hide');
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
            var full_number = dependentPhoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='dependent_phone'").val(full_number);
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
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
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
            // var full_number = dependenthomephonenumberInput.getNumber(intlTelInputUtils.numberFormat.E164);
            // $("input[id='dependent_home_phone_number'").val(full_number);
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
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
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
            var full_number = dependentcurrentresidancemobileInput.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[id='dependent_current_residance_mobile'").val(full_number);
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
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
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
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('#is_dependent_schengen_visa_issued_last_five_year').on('change', function(){
            if($('#is_dependent_schengen_visa_issued_last_five_year').val() == "YES"){
                $('.dependent_schengen_visa').show();
                $('#is_dependent_finger_print_collected_for_Schengen_visa').show();
            } else {
                $('.dependent_schengen_visa').hide();
                $('#is_dependent_finger_print_collected_for_Schengen_visa').hide();
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

        for(var i= 1 ; i<='{{$client['children_count']}}'; i++)
        {
            $('.childData'+i).hide();
        }

        $('#child_details').submit(function(e){
            e.preventDefault(); 
            $('.childReviewSpin').show();
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
                        checkdata = checkStatus('{{$productId}}');
                        $('.childReviewSpin').hide();
                        if(checkdata.status){
                            location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                        } else {
                            toastr.error(checkdata.message);
                        }
                    } else {
                        $('.childReviewSpin').hide();
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                            toastr.error(value);
                        });
                    }
                },
                errror: function (error) {
                    toastr.error(error);
                }
            });
        });

        $('.dependentReview').click(function(e){
            e.preventDefault(); 
            $('.dependentReviewSpin').show();
            if($('.dependentApplicantCompleted').val() == 1){
                if($('.spouseHomeCountryCompleted').val() == 1) {
                    if($('.spouseCurrentCountryCompleted').val() == 1) {
                        if($('.schengenSpouseCompleted').val() == 1) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ url('/submit/applicant/Details/') }}",
                                data: {
                                    applicantId: '{{$applicant['id']}}',
                                    user: 'family',
                                },
                                success: function (response) {
                                    if(response.status) {
                                        checkdata = checkStatus('{{$productId}}');
                                        $('.dependentReviewSpin').hide();
                                        if(checkdata.status){
                                            location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                                        } else {
                                            toastr.error(checkdata.message);
                                        }
                                    } else {
                                        $('.dependentReviewSpin').hide();
                                        var validationError = response.errors;
                                        $.each(validationError, function(index, value) {
                                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                                            toastr.error(value);
                                        });
                                    }
                                }
                            });
                        } else {
                            toastr.error('Please provide all details');
                            $('#collapseSpouseSchengen').addClass('show');
                            $('#collapseSpouseExperience').removeClass('show');
                        }
                    } else {
                        toastr.error('Please provide all details');
                        $('#collapseSpouseCurrent').addClass('show');
                        $('#collapseSpouseExperience').removeClass('show');
                    }
                } else {
                    $('#collapsespouseHome').addClass('show');
                    $('#collapseSpouseExperience').removeClass('show');
                    toastr.error('Please provide all details');
                }
            } else {
                $('#collapsespouseapplicant').addClass('show');
                $('#collapseSpouseExperience').removeClass('show');
                toastr.error('Please provide all details');
                $('html, body').animate({
                    scrollTop: $("#collapsespouseapplicant").offset().top
                }, 2000);
            }
        });

        $('.dependentNext').click(function(e){
            e.preventDefault(); 
            if($('.dependentApplicantCompleted').val() == 1){
                if($('.spouseHomeCountryCompleted').val() == 1) {
                    if($('.spouseCurrentCountryCompleted').val() == 1) {
                        if($('.schengenSpouseCompleted').val() == 1) {
                            if(('{{($applicant['work_permit_category'])}}' == 'FAMILY PACKAGE') && ('{{$client['children_count']}}' != null || '{{$client['children_count']}}' != 0)){
                                updateStatus('family'); 
                                $('#children').show();
                                $('#mainApplicant, #dependant').hide();
                                $('.children').addClass('active');
                                $('.mainApplicant, .dependant').removeClass('active');
                            } else {
                                location.href = "{{url('applicant/review')}}/"+'{{$productId}}'
                            }
                        } else {
                            toastr.error('Please provide all details');
                            $('#collapseSpouseSchengen').addClass('show');
                            $('#collapseSpouseExperience').removeClass('show');
                        }
                    } else {
                        toastr.error('Please provide all details');
                        $('#collapseSpouseCurrent').addClass('show');
                        $('#collapseSpouseExperience').removeClass('show');
                    }
                } else {
                    $('#collapsespouseHome').addClass('show');
                    $('#collapseSpouseExperience').removeClass('show');
                    toastr.error('Please provide all details');
                }
            } else {
                $('#collapsespouseapplicant').addClass('show');
                $('#collapseSpouseExperience').removeClass('show');
                toastr.error('Please provide all details');
                $('html, body').animate({
                    scrollTop: $("#collapsespouseapplicant").offset().top
                }, 2000);
            }
        });
    });

    function showPassportFormat()
    {
        $("#passportFormatModal").modal('show');
    }

    function showResidenceIdFormat() 
    {
        $("#residenceIdFormatModal").modal('show');
    } 

    function showVisaFormat()
    {
        $("#visaFormatModal").modal('show');
    }

    function showSchengenVisaFormat()
    {
        $("#schengenVisaFormatModal").modal('show');
    }


    function updateStatus(userType)
    {        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ url('update/applicant/status') }}",
            data: {
                _token: "{{ csrf_token() }}",
                userType: userType,
            },
            success: function (response) {
                if(response.status){
                    return true;
                }
            }
        });
    }

    function checkStatus(productId)
    {
        var returnValue;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            async: false,
            url: "{{ url('check/applicant/status') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                product_id: productId
            },
            success: function (response) {
                returnValue = response;
            }
        });
        return returnValue;
    }

</script>
<script src="https://unpkg.com/vue@next"></script>
<script src="{{ asset('js/application-details.js') }}" type="text/javascript"></script>
@endpush
<script src="../user/extra/assets/js/jquery-min.js"></script>
<script src="{{asset('js/alert.js')}}"></script>
