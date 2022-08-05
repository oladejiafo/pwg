@extends('layouts.master')

    <link href="{{asset('css/payment-form.css')}}" rel="stylesheet">

@section('content')
    <div class="container">
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
                <div class="top-head">
                    <div class="left-input">
                        <input type=radio id="rdo1" checked class="radio-input" name="card_type">
                        <label for="rdo1" class="radio-label" > <span class="radio-border"></span>  <img src="images/payment_icons_Mastercard.svg" alt="Option 1" class="radioImage" width="40px"></label>

                        <input type=radio id="rdo2"  class="radio-input" name="card_type">
                        <label for="rdo2" class="radio-label" ><span class="radio-border"></span> <img src="images/payment_icons _Visa_Logo.svg" alt="Option 1" class="radioImage" width="40px" style="margin-top: 11px"> </label>
                    </div>
                    <div class="rightside">
                        <p>Total Amount:</p>
                        <div class="amount"> <p>AED <span>1,975</span></p></div>
                    </div>
                </div>
                <div class="payment-form1">
                    <form>
                        <div class="fieldset">
                            <div class="form-group">
                                <input type="number" placeholder="Card Number" name="card_number" required>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Cardholder full name" name="card_holder_name" required>
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
                                <div class="left-sec"><p>Subtotal (first payment)</p></div>
                                <div class="price"><p>1,975.00</p></div>
                            </div>
                            <div class="total-sec">
                                <div class="left-sec"><p>VAT</p></div>
                                <div class="price"><p>50.00</p></div>
                            </div>
                            <div class="total-sec">
                                <div class="left-sec"><p>Discount</p></div>
                                <div class="price"><p>200.00</p></div>
                            </div>
                        </div>
                        <div class="gtotal">
                            <div class="total-sec">
                                <div class="left-sec"><p>TOTAL AMOUNT</p></div>
                                <div class="price"><p>850.00</p></div>
                            </div>
                        </div>
                        <div class="inputs check-box"> 
                            <input type="checkbox"><p>Save my details for future payment & Automatic deductions</p>
                        </div>
                        <button type="submit" class="btn btn-primary purchase-now">PURCHASE NOW</button>
                    </form>
                </div>
            </form>
        </div>
    </div> 
@endsection        
