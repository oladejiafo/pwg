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