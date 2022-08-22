@extends('layouts.master')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
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

    .payment-form .payment-heading {
        padding-top: 30px
    }
</style>
@section('content')
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard bg-white">
                    <div class="row">
                        <div class="tabs d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="{{ url('referal_details', $data->id) }}" ><div class="round-completed round1 m-2">1</div></a>
                                <div class="round-title">Refferal <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{ url('payment_form', $data->id)}}" ><div class="round-active round2 m-2">2</div></a>
                                <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{route('applicant', $data->id)}}" ><div class="round3 m-2">3</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href=" " ><div class="round4 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href=" " ><div class="round5 m-2">5</div></a>
                                <div class="col-2 round-title">Application <br> Review</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-form">
                    <div class="heading">
                        <div class="first-heading">
                            <h3>
                                Payment Details
                            </h3>
                        </div>
                        <div class="bottom-title">
                            <p style="color: #C4C4C4; text-align: center;">Your details are safe and encrypted</p>
                        </div>
                    </div>
                    <div class="form-sec">
                        <form method="POST" action="{{ url('add_payment') }}">
                            @csrf
                            <?php 
                                $whichPayment = null ;
                                $payNow = 0;
                                $vatPercent = 0;
                                $vat = 0;
                                $discountPercent = 0;
                                $discount = 0;
                                $totalPay = 0;
                            ?>
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
                                <input type="hidden" name="pid" value="{{$data->id}}">
                                <input type="hidden" name="ppid" value="{{$det->id}}">
                                <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                                <div class="form-group row mt-4">
                                    <div class="col-sm-6 mt-3">
                                        <div class="left-input">
                                            <label for="rdo1" class="radio-label"><span class="radio-border"></span> <img src="{{asset('images/payment_icons_Mastercard.svg')}}" alt="Option 1" class="radioImage" height="40px" width="40px"></label>
                                            <label for="rdo2" class="radio-label"><span class="radio-border"></span> <img src="{{asset('images/payment_icons _Visa_Logo.svg')}}" alt="Option 2" class="radioImage" height="40px" width="40px"> </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="rightside">
                                            <p>{{ $whichPayment}} Amount:</p>
                                            <div class="amount">
                                                <p>AED <span>{{ number_format($payNow) }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mt-4">
                                    <div class="col-sm-6 mt-3">
                                        <input type="number" class="form-control" placeholder="Card Number" name="card_number" value="{{ old('card_number') }}" required>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <input class="b form-control" type="text" placeholder="Cardholder full name" name="card_holder_name" value="{{ old('card_holder_name') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mt-4">
                                    <div class="col-sm-4 mt-3">
                                        <select name="month" class="form-control form-select" name="month" value="{{ old('month') }}" required>
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
                                    <div class="col-sm-4 mt-3">
                                        <input type="number" class="form-control" placeholder="Year" name="year" value="{{ old('year') }}" required>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <input type="number" class="form-control" placeholder="CVV" name=cvv value="{{ old('cvv') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mt-6 payment-form1 ">
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
                                </div>
                            @endforeach
                            <div class="form-group row mt-4">
                                <div class="form-check">
                                    <input type="checkbox" id="TnC" name="save_card" value="{{ old('save_card') }}" class="checkcolor" checked>
                                    <label class="form-check-label" for="TnC">
                                        Save my details for future payment & Automatic deductions
                                    </label>
                                    <label class="form-check-label text-danger" id="TnCAlert"></label>
                                    @error('save_card') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4" style="margin-bottom: 70px">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection