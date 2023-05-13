@extends('layouts.auth')

<style>
    @media (min-width: 375px) and (max-width: 768px)
    {
        .btn {
            margin: 0 0 0 0px;
            padding: 0;
            width:100%;
            align-self: center;
        }

        .network-partner {
            padding: 20px !important;
            margin-top: 170px !important;
        }

        .network-partner .reset-heading {
            font-size: 20px;
        } 

        .network-partner .reset-title {
            font-size: 18px;
        }
    }

    .network-partner {
        width: 80%;
        max-width: 100%;
        margin: 0 auto;
        padding: 70px 100px 70px 100px;
        background-color: #ffffff;
        margin-top: 100px;
        color: #636466;
        align-content: center;
        /* height: 90%; */
        padding-top: 30px;
        margin-bottom: 100px;
    }

    .network-partner .reset-title{
        margin-bottom: 20px;
    }

    .network-partner .reset{
        margin-top: 10px
    }

    #days {
        display: none !important;
    }
</style>
@Section('content')
    <div class="container">
        <div class="network-partner">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/icon2.png')}}" alt="forgot password pwg">
                </div>
                <div class="reset-heading">
                    Register network partner
                </div>
                <div class="reset-title">
                    <p>Please provide the details</p>
                </div>
                <div class="form-sec">
                    <form method="POST" id="GCM">
                        @csrf
                        <p><b>Global Mobility Consultant Code</b></p>
                        <div class="form-group row mb-3">
                            <div class="form-floating col-sm-12">
                                <input type="text"  name="global_mobility_consultant_code" class="form-control global_mobility_consultant_code" id="floatingInput" placeholder="Global Mobility Consultant Code" value="{{old('global_mobility_consultant_code')}}" autocomplete="off"/>
                                <label for="floatingInput"> Global Mobility Consultant Code*</label>
                                <span class="error"></span>
                            </div>
                            <a class="btn mt-4  btn-primary submitGMC">Next</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('.bankDetails').hide();
        $('#payment_type').on('change', function(){
            if($('#payment_type').val() == 'Bank Payment'){
                $('.bankDetails').show();

            } else {
                $('.bankDetails').hide();
            }
        })
        $('.error').text('');
        $('.submitGMC').click(function(){
            if($('.global_mobility_consultant_code').val()){
                var gmc = $("input[name=global_mobility_consultant_code]").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('check/gmcc') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        gmc: gmc,
                    },
                    success: function (data) {
                        if(data) {
                            window.location.href = '{{url("network/partner/code/")}}'+'/'+gmc;
                            $('.error').text('');
                        } else {
                            $('.error').text('Invalid Code!');
                        }
                    },
                    errror: function (error) {
                        toastr.error(error);
                    }
                });
            } else {
                $('.error').text('Please provide Global Mobility Consultant Code');
            }
        });
    });
    
</script>
