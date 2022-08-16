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
        <form>
            @csrf
            <div class="top-head">
                <input type="hidden" name="pid" value="{{$data->id}}">
                <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                <div class="left-input">
                    <!-- <input type=radio id="rdo1" checked class="radio-input" name="card_type"> -->
                    <label for="rdo1" class="radio-label"><span class="radio-border"></span> <img src="images/payment_icons_Mastercard.svg" alt="Option 1" class="radioImage" height="40px" width="40px"></label>

                    <!-- <input type=radio id="rdo2"  class="radio-input" name="card_type"> -->
                    <label for="rdo2" class="radio-label"><span class="radio-border"></span> <img src="images/payment_icons _Visa_Logo.svg" alt="Option 2" class="radioImage" height="40px" width="40px"> </label>
                </div>
                <div class="rightside">
                    <p>Total Amount:</p>
                    <div class="amount">
                        <p>AED <span>{{ number_format($data->unit_price) }}</span></p>
                    </div>
                </div>
            </div>
            <div class="payment-form1">

                <div class="fieldset">
                    <div class="form-group">
                        <input type="number" placeholder="Card Number" name="card_number" value="" required>
                    </div>
                    <div class="form-group">
                        <input class="b" type="text" placeholder="Cardholder full name" name="card_holder_name" value="" required>
                    </div>
                </div>
                <div class="fieldset">
                    <div class="form-group">
                        <select name="month" class="input-field options" name="month" required>
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
                        <input type="number" placeholder="Year" name="year" required>
                    </div>
                    <div class="cvv">
                        <input type="number" placeholder="CVV" name=cvv required>
                    </div>
                </div>

                <div class="total">
                    <div class="total-sec">
                        <div class="left-section">
                            <p>Subtotal (first payment)</p>
                        </div>
                        <div class="price">
                            <p> @foreach($pdet as $det) @if ($det == reset($pdet)) last Item: @endif {{ number_format($det->amount,2) }} @endforeach</p>
                        </div>
                    </div>
                    <div class="total-sec">
                        <div class="left-section">
                            <p>VAT</p>
                        </div>
                        <div class="price">
                            <p>50.00</p>
                        </div>
                    </div>
                    <div class="total-sec">
                        <div class="left-section">
                            <p>Discount</p>
                        </div>
                        <div class="price">
                            <p>200.00</p>
                        </div>
                    </div>
                </div>
                <div class="gtotal">
                    <div class="total-sec">
                        <div class="left-section">
                            <p>TOTAL AMOUNT</p>
                        </div>
                        <div class="price">
                            <p>850.00</p>
                        </div>
                    </div>
                </div>
                <div class="inputs check-box">
                    <input type="checkbox" class="checkcolor">
                    <p class="btt">Save my details for future payment & Automatic deductions</p>
                </div>
                <button type="submit" class="btn btn-primary purchase-now">PURCHASE NOW</button>

                @foreach($paid as $pd)

                @foreach($pdet as $index => $det)

                @if( $pd->product_payment_id != $det->id)
                
                
                @if($index ==1)
                {{ number_format($det->amount,2) }}
                @endif


                @endif

                @endforeach
                @endforeach
        </form>
    </div>
    </form>
</div>
</div>


@endsection