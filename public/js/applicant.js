$(document).ready(function(){
    // Main Applicant
    $('.applicantReviewSpin, .dependentReviewSpin, .childReviewSpin').hide();
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

    const phoneHomeInputField = document.querySelector("#home_phone_number");
    const phoneHomeInput = window.intlTelInput(phoneHomeInputField, {
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
    const dependenthomephonenumber = document.querySelector("#dependent_home_phone_number");
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

    const dependenthomephonenumberInput = window.intlTelInput(dependenthomephonenumber, {
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
                                    checkdata = checkStatus('{{$applicant['id']}}', '{{$productId}}');
                                    $('.applicantReviewSpin').hide();
                                    if(checkdata.status){
                                        location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                                    } else {
                                        alert(checkdata.message);
                                    }
                                } else {
                                    $('.applicantReviewSpin').hide();
                                    var validationError = response.errors;
                                    $.each(validationError, function(index, value) {
                                        $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                                    });
                                }
                            }
                        });
                    } else {
                        alert('Please provide all details');
                        $('#collapseSchengen').addClass('show');
                        $('#collapseExperience').removeClass('show');
                    }
                } else {
                    alert('Please provide all details');
                    $('#collapseCurrent').addClass('show');
                    $('#collapseExperience').removeClass('show');
                }
            } else {
                $('#collapseHome').addClass('show');
                $('#collapseExperience').removeClass('show');
                alert('Please provide all details');
            }
        } else {
            $('#collapseapplicant').addClass('show');
            $('#collapseExperience').removeClass('show');
            alert('Please provide all details');
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
                        if('{{$applicant['is_spouse']}}' == null || '{{$applicant['is_spouse']}}' == 0){
                            updateStatus('applicant', '{{$applicant['id']}}', '{{$productId}}'); 
                            $('#children').show();
                            $('#mainApplicant, #dependant').hide();
                            $('.children').addClass('active');
                            $('.mainApplicant, .dependant').removeClass('active');
                        } else {
                            updateStatus('applicant', '{{$applicant['id']}}', '{{$productId}}'); 
                            $('#dependant').show();
                            $('#mainApplicant, #children').hide();
                            $('.dependant').addClass('active');
                            $('.mainApplicant, .children').removeClass('active');
                            $('#collapsespouseapplicant').addClass('show');
                        }
                    } else {
                        alert('Please provide all details');
                        $('#collapseSchengen').addClass('show');
                        $('#collapseExperience').removeClass('show');
                    }
                } else {
                    alert('Please provide all details');
                    $('#collapseCurrent').addClass('show');
                    $('#collapseExperience').removeClass('show');
                }
            } else {
                $('#collapseHome').addClass('show');
                $('#collapseExperience').removeClass('show');
                alert('Please provide all details');
            }
        } else {
            $('#collapseapplicant').addClass('show');
            $('#collapseExperience').removeClass('show');
            alert('Please provide all details');
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
        $("input[id='phone'").val(full_number);
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
        var full_number = phoneHomeInput.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[id='home_phone_number'").val(full_number);
        $.ajax({
            type: 'POST',
            url: "{{ url('store/home/country/details') }}",
            data: new FormData(this),
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
        var full_number = phoneCurrentInput.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[id='current_residance_mobile'").val(full_number);
        $.ajax({
            type: 'POST',
            url: "{{ url('store/current/details') }}",
            data: new FormData(this),
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
                    });
                }
            },
            errror: function (error) {
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

        $.ajax({
            type: 'POST',
            url: "{{ url('store/schengen/details') }}",
            data: new FormData(this),
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

    $('.closeBtn').click(function(){
        $("#passportFormatModal").modal('hide');
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
        var full_number = dependenthomephonenumberInput.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[id='dependent_home_phone_number'").val(full_number);
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
                    checkdata = checkStatus('{{$applicant['id']}}', '{{$productId}}');
                    $('.childReviewSpin').hide();
                    if(checkdata.status){
                        location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                    } else {
                        alert(checkdata.message);
                    }
                } else {
                    $('.childReviewSpin').hide();
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
                                    checkdata = checkStatus('{{$applicant['id']}}', '{{$productId}}');
                                    $('.dependentReviewSpin').hide();
                                    if(checkdata.status){
                                        location.href = "{{url('applicant/review')}}/"+'{{$productId}}';
                                    } else {
                                        alert(checkdata.message);
                                    }
                                } else {
                                    $('.dependentReviewSpin').hide();
                                    var validationError = response.errors;
                                    $.each(validationError, function(index, value) {
                                        $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                                    });
                                }
                            }
                        });
                    } else {
                        alert('Please provide all details');
                        $('#collapseSpouseSchengen').addClass('show');
                        $('#collapseSpouseExperience').removeClass('show');
                    }
                } else {
                    alert('Please provide all details');
                    $('#collapseSpouseCurrent').addClass('show');
                    $('#collapseSpouseExperience').removeClass('show');
                }
            } else {
                $('#collapsespouseHome').addClass('show');
                $('#collapseSpouseExperience').removeClass('show');
                alert('Please provide all details');
            }
        } else {
            $('#collapsespouseapplicant').addClass('show');
            $('#collapseSpouseExperience').removeClass('show');
            alert('Please provide all details');
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
                        if('{{$applicant['children_count']}}' != null || '{{$applicant['children_count']}}' != 0){
                            updateStatus('family', '{{$applicant['id']}}', '{{$productId}}'); 
                            $('#children').show();
                            $('#mainApplicant, #dependant').hide();
                            $('.children').addClass('active');
                            $('.mainApplicant, .dependant').removeClass('active');
                        } else {
                            location.href = "{{url('applicant/review')}}/"+'{{$productId}}'
                        }
                    } else {
                        alert('Please provide all details');
                        $('#collapseSpouseSchengen').addClass('show');
                        $('#collapseSpouseExperience').removeClass('show');
                    }
                } else {
                    alert('Please provide all details');
                    $('#collapseSpouseCurrent').addClass('show');
                    $('#collapseSpouseExperience').removeClass('show');
                }
            } else {
                $('#collapsespouseHome').addClass('show');
                $('#collapseSpouseExperience').removeClass('show');
                alert('Please provide all details');
            }
        } else {
            $('#collapsespouseapplicant').addClass('show');
            $('#collapseSpouseExperience').removeClass('show');
            alert('Please provide all details');
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

        function updateStatus(userType, applicantId, productId)
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
                    id: applicantId,
                    userType: userType,
                    product_id: productId
                },
                success: function (response) {
                    if(response.status){
                        return true;
                    }
                }
            });
        }

        function checkStatus(applicantId, productId)
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
                    id: applicantId,
                    product_id: productId
                },
                success: function (response) {
                    returnValue = response;
                }
            });
            return returnValue;
        }