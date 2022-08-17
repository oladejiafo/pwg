@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">

<style>
    .btt {
        font-size: 16px;
        margin-top: 5px;
    }

    @media (max-width:768px) {
        .btt {
            font-size: 14px;
            margin-top: 5px;
        }
    }
</style>
@section('content')
<div class="container" style="margin-block: 150px;">
    <div class="payment-form">
        <div class="payment-heading">
            <div class="payment">
                <h2>Payment Details</h2>
            </div>
            <div class="payment-detail">
                <p>Your details are safe and encrypted</p>
            </div>
        </div>
        <form method="POST" action="{{ url('add_payment') }}">
            @csrf

            @foreach(($pays ? $pays : array()) as $pd)

            @foreach($pdet as $index => $det)

            <?php 
             $pp = $pd->product_payment_id;
           ?>

            @if($pd->product_payment_id != $det->id)
            @if($index == $pp)

            <?php
if ($payall ==0) {
    $whichPayment =  $det->payment;
    $payNow = $det->amount;
} else {
     if($pp == 0 || $pp==null) {
        $payNow = $data->unit_price;
     }
     else if($pp == 1) {
        $payNow = $data->unit_price - $pd->total;
     }
     else if($pp == 2) {
        $payNow = $det->amount;
     }

     $whichPayment =  "Full Payment";
}
$vatPercent = '5%';
$vat = ($payNow * 5) / 100;
$discountPercent = $data->discount . '%';
$discount = ($payNow * $data->discount / 100);
$totalPay = ($payNow + $vat) - $discount;   
            ?>
            @endif

            @endif
            @endforeach
            <div class="top-head">
                <input type="hidden" name="pid" value="{{$data->id}}">
                <input type="hidden" name="ppid" value="{{$pd->product_payment_id}}">
                <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                <div class="left-input">
                    <!-- <input type=radio id="rdo1" checked class="radio-input" name="card_type"> -->
                    <label for="rdo1" class="radio-label"><span class="radio-border"></span> <img src="{{asset('images/payment_icons_Mastercard.svg')}}" alt="Option 1" class="radioImage" height="40px" width="40px"></label>

                    <!-- <input type=radio id="rdo2"  class="radio-input" name="card_type"> -->
                    <label for="rdo2" class="radio-label"><span class="radio-border"></span> <img src="{{asset('images/payment_icons _Visa_Logo.svg')}}" alt="Option 2" class="radioImage" height="40px" width="40px"> </label>
                </div>
                <div class="rightside">
                    <p>{{ $whichPayment}} Amount:</p>
                    <div class="amount">
                        <p>AED <span>{{ number_format($payNow) }}</span></p>
                    </div>
                </div>
            </div>
            <div class="payment-form1">

                <div class="fieldset">
                    <div class="form-group">
                        <input type="number" placeholder="Card Number" name="card_number" value="{{ old('card_number') }}" required>
                    </div>
                    <div class="form-group">
                        <input class="b" type="text" placeholder="Cardholder full name" name="card_holder_name" value="{{ old('card_holder_name') }}" required>
                    </div>
                </div>
                <div class="fieldset">
                    <div class="form-group">
                        <select name="month" class="input-field options" name="month" value="{{ old('month') }}" required>
                            <option selected disabled>Month</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                        </select>
                    </div>
                    <div class="cvv">
                        <input type="number" placeholder="Year" name="year" value="{{ old('year') }}" required>
                    </div>
                    <div class="cvv">
                        <input type="number" placeholder="CVV" name=cvv value="{{ old('cvv') }}" required>
                    </div>
                </div>

                <div class="total">
                    <div class="total-sec">
                        <div class="left-section">
                        <input type="hidden" name="whichpayment" value="{{ $whichPayment }}">
                            <p>Subtotal ({{ $whichPayment }})</p>
                        </div>
                        <div class="price">
                            <p>{{ number_format($payNow,2) }}</p>
                        </div>
                    </div>
                    <div class="total-sec">
                        <div class="left-section">
                            <p>VAT ({{ $vatPercent}})</p>
                        </div>
                        <div class="price">
                            <p> {{ number_format($vat,2) }}</p>
                        </div>
                    </div>
                    <div class="total-sec">
                        <div class="left-section">
                            <p>Discount ({{$discountPercent}})</p>
                        </div>
                        <div class="price">
                            <p>{{ number_format($discount,2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="gtotal">
                    <div class="total-sec">
                        <div class="left-section">
                            <p><b>TOTAL AMOUNT</b></p>
                        </div>
                        <div class="price">
                            <input type="hidden" name="totalpay" value="{{ $totalPay }}">
                            <p><b>{{ number_format($totalPay,2) }}</b></p>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="inputs check-box">
                    <input type="checkbox" name="save_card" value="{{ old('save_card') }}" class="checkcolor">
                    <p class="btt">Save my details for future payment & Automatic deductions</p>
                </div>
                <button type="submit" class="btn btn-primary purchase-now">PURCHASE NOW</button>

        </form>
    </div>
    </form>
</div>
</div>

@endsection