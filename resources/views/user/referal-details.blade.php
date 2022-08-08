@extends('layouts.master')


<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">
<style>
.form-secc {
    width: 60%;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    margin: 0 auto;
    padding: 70px 100px 70px 100px;
    background-color: #ffffff;
    margin-bottom: 420px;
    margin-top: 70px;
    color: #000;
    align-content: center;
    box-shadow: 0 0 0 0.7px #C4C4C4;
    font-family: 'TT Norms Pro';
    font-weight: bold;
    font-style: normal;

}

.form-secc h3 {
    font-size: 36px;

    text-align: center;
}

.form-secc input, select {
    border-radius: 10px;
    border-color: #f5f5f5;
    background-color: #f5f5f5;
    padding: 10px;
    
}
.form-secc button {
    width: 100%;
    color: #000;
    border-radius: 5px;
}

</style>

@section('content')
    <div class="container">
        <div class="form-secc">
        <div class="heading">
            <div class="first-heading">
                <h3>
                    Referal Details
                </h3>
            </div>
            <div class="bottoom-title">
            <p style="color: #C4C4C4; font-size:17px;text-align: center;">Please enter your referal Details here</p>
            </div>
        </div>
        <div class="form-sec" style="margin-top: 48px;">
            <form method="POST" action="{{ url('add_referal') }}">
                @csrf
                <div class="mb-3">
                    <div class="inputs"> 
                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                        <input type="text" class="form-control w-full ref" name="referrer_first_name" placeholder="Referrer First Name" autocomplete="off" autofocus style="border: none">
                        @error('referrer_first_name') <span class="error">{{ $message }}</span> @enderror
                    </div>            
                </div>
                <div class="mb-3">
                    <div class="inputs">
                        <input type="text" class="form-control w-full ref" name="referrer_last_name" placeholder="Referrer Last Name" autocomplete="off" autofocus style="border: none">
                        @error('referrer_last_name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="inputs"> 
                        <input type="text" class="form-control w-full ref" name="coupon_code" placeholder="Coupon Code(if you have any)" autocomplete="off" autofocus style="border: none">
                        @error('coupon_code') <span class="error">{{ $message }}</span> @enderror
                    </div>            
                </div>
                <div class="mb-3">
                    <div class="inputs"> 
                        <select class="form-control w-full ref" name="current_location" placeholder="Current Location" autocomplete="off" required="" autofocus>
                            <option value="">Select Current Location</option>
                            <option value="UAE">UAE</option>
                            <option value="Others">Outside UAE</option>
                        </select>
                        @error('current_location') <span class="error">{{ $message }}</span> @enderror
                    </div>            
                </div>
                
                <button type="submit" class="btn btn-primary submitBtn">Continue</button>
            </form>
        </div>
        </div>
    </div>
@endsection