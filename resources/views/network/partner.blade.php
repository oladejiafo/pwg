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
</style>
@Section('content')
    <div class="container">
        <div class="network-partner">
            <div class="reset">
                <div class="resetImage">
                    <img src="{{asset('images/icon2.png')}}" alt="forgot password pwg">
                </div>
                <div class="reset-heading">
                    Want to be network partner
                </div>
                <div class="reset-title">
                    <p>Please provide the details</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="{{route('add.network.partner')}}">
                        @csrf
                        <p><b>Partner's Details</b></p>
                        <div class="form-group row">
                            <div class="form-floating col-sm-12">
                                <input type="text"  name="partner_code" class="form-control partner_code" id="floatingInput" placeholder="Partner Code" value="{{old('partner_code')}}" autocomplete="off"/>
                                <label for="floatingInput"> Partner Code*</label>
                                @error('partner_code') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2 mt-4">
                                <input type="hidden" readonly name="partner_type" class="form-control partner_type" id="floatingInput" placeholder="Partner Type" value="Network" autocomplete="off"/>

                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="partner_name" class="form-control partner_name" id="floatingInput" placeholder="Partner Name*" value="{{old('partner_name')}}" autocomplete="off"/>
                                <label for="floatingInput"> Partner Name*</label>
                                @error('partner_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <select class="form-select form-control payment_type" name="payment_type" id="payment_type" placeholder="Payment Type*" value="{{old('payment_type')}}">
                                    <option selected disabled>Please select payment type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Payment">Bank Payment</option>
                                </select>
                                <label for="payment_type">Payment Type*</label>
                                @error('payment_type') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4 mb-4 bankDetails">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_name" class="form-control bank_name" id="floatingInput" placeholder="Bank Name*" value="{{old('bank_name')}}" autocomplete="off"/>
                                <label for="floatingInput"> Bank Name*</label>
                                @error('bank_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_iban_number" class="form-control bank_iban_number" id="floatingInput" placeholder="Bank IBAN Number*" value="{{old('bank_iban_number')}}" autocomplete="off"/>
                                <label for="floatingInput"> Bank IBAN Number*</label>
                                @error('bank_iban_number') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_swift_code" class="form-control bank_swift_code" id="floatingInput" placeholder="Bank SWIFT Code*" value="{{old('bank_swift_code')}}" autocomplete="off"/>
                                <label for="floatingInput"> Bank SWIFT Code*</label>
                                @error('bank_swift_code') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <p><b>Contact Details</b></p>
                        <div class="form-group row">
                            <div class="form-floating col-sm-6 mt-1">
                                <input type="text" name="partner_location" class="form-control partner_location" id="floatingInput" placeholder="Location*" value="{{old('partner_location')}}" autocomplete="off"/>
                                <label for="floatingInput"> Location*</label>
                                @error('partner_location') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-floating col-sm-6 mt-1">
                                <input type="text"  name="partner_phone_number" class="form-control partner_phone_number" id="floatingInput" placeholder="Contact Number*" value="{{old('partner_phone_number')}}" autocomplete="off"/>
                                <label for="floatingInput"> Contact Number*</label>
                                @error('partner_phone_number') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="email" name="partner_email" class="form-control partner_email" id="floatingInput" placeholder="Email" value="{{old('partner_email')}}" autocomplete="off"/>
                                <label for="floatingInput"> Email</label>
                                @error('partner_email') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text"  name="partner_address" class="form-control partner_address" id="floatingInput" placeholder="Address" value="{{old('partner_address')}}" autocomplete="off"/>
                                <label for="floatingInput"> Address</label>
                                @error('partner_address') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <button type="submit" class="btn btn-primary"> Submit</button>
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
    });
    
</script>
