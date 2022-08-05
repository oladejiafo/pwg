@extends('layouts.master')
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">

@section('content')
    <div class="container">
        <div class="form-sec1">
        <div class="heading">
            <div class="first-heading">
                <h3>
                    Referal Details
                </h3>
            </div>
            <div class="bottoom-title">
            <p style="color: #C4C4C4;">Please enter your referal Details here</p>
            </div>
        </div>
        <div class="form-sec" style="margin-top: 48px;">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <div class="inputs"> 
                        <input type="text" class="form-control w-full ref" name="referrer_first_name" placeholder="Referrer First Name" autocomplete="off" required autofocus style="border: none">
                        @error('referrer_first_name') <span class="error">{{ $message }}</span> @enderror
                    </div>            
                </div>
                <div class="mb-3">
                    <div class="inputs">
                        <input type="password" class="form-control w-full ref" name="referrer_last_name" placeholder="Referrer Last Name" autocomplete="off" required autofocus style="border: none">
                        @error('referrer_last_name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="inputs"> 
                        <input type="text" class="form-control w-full ref" name="coupon_code" placeholder="Coupon Code(if you have any)" autocomplete="off" required autofocus style="border: none">
                        @error('coupon_code') <span class="error">{{ $message }}</span> @enderror
                    </div>            
                </div>
                <div class="mb-3">
                    <div class="inputs"> 
                        <select class="form-control w-full ref" name="current_location" placeholder="Current Location" autocomplete="off" required autofocus>
                            <option  selected disabled>Current Location</option>
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