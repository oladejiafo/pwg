<style>
    input[type='text'] {
            border-radius: 10px;
    }
    select {
        border-radius: 10px !important;
        height: 50px !important;
        border-color: #ccc !important;
        text-align: left !important;
        align-content: flex-start;
    }
    .cols {
        width:50%; 
        margin-left: 0 auto;
    }

    button {
        width: 350px !important;
        height:60px !important; 
        text-align:center; 
        color:#000; 
        font-family:'TT Norms Pro'; 
        font-weight:700;
        
        display: block;
    margin: 0 auto;

    }

    @media (min-width:375px) and (max-width:768px){
        .cols {
        width:70%; 
        margin-left: 0 auto;
    }
    button {
        width:200px !important;
    }
    }
</style>
<form name="form" id="updatePassword" method="POST" action="{{ route('update.current.password') }}" style="width:100%; border-color:#fff;border-style:hidden">
    @csrf
    <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
        <div class="col">
            <input type="hidden" name="email" value="{{Auth::user()->email}}">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="text" class="form-control" name="current_password" id="current_password">
            <span class="current_password_errorClass"></span>
        </div>
    </div>
    <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
        <div class="col">
            <label for="password" class="form-label">New Password</label>
            <input type="text" class="form-control" name="password" id="password" >
            <span class="password_errorClass"></span>
        </div>
    </div> 
    <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
        <div class="col">
            <label for="password_confirmation" class="form-label">Password Confirmation</label>
            <input type="text" class="form-control" name="password_confirmation" id="password_confirmation">
            <span class="password_confirmation_errorClass"></span>
        </div>
    </div>
    <div class="row mb-3 otp-profile" style="width:70%; margin: 0 auto; margin-bottom:20px">
        
    </div>
    <div class="row mb-3" style="width:70%; margin: 50px auto; margin-bottom:20px">
        <div align="center" class="col-12">
            <button type="submit" class="btn btn-primary my-button">Save<i class="fa fa-spinner fa-spin updateSpin"></i></button>
        </div>
        <div id="target-otp"></div>
    </div>
</form>


<script src="{{asset('user/extra/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.updateSpin').hide();
        $('#updatePassword').submit(function(e){
            e.preventDefault(); 
            $('.updateSpin').show();
            $('.my-button').prop('disabled', true)
            $("#updatePassword :input").each(function(index, elm){
                $("."+elm.name+"_errorClass").empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('update/password') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status) {
                        if(data.otp){
                            $('.otp-profile').append('<div class="col otpShow"><label for="otp" class="form-label">OTP</label><input type="text" class="form-control" name="otp" id="otp" ><span class="error">Please check your mail for otp.</span><span class="otp_errorClass"></span></div>');
                        } else {
                            $('.otpShow').remove();
                            $('#target-otp').html(data.message); 
                        }
                        $('.my-button').prop('disabled', false)
                        $('.updateSpin').hide();
                    } else {

                        if(data.message){
                            toastr.error(data.message);
                        }
                        var validationError = data.errors;
                        $.each(validationError, function(index, value) {
                            $("."+index+"_errorClass").append('<span class="error">'+value+'</span>');
                        });
                        $('.my-button').prop('disabled', false)
                        $('.updateSpin').hide();
                    }
                },
                errror: function (error) {
                    $('.updateSpin').hide();
                    toastr.error('error');
                }
            });
        });
    });
</script>
