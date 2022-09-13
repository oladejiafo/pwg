@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">
<link href="{{asset('css/alert.css')}}" rel="stylesheet">

<!-- <script src="https://paypage-uat.ngenius-payments.com/hosted-sessions/sdk.js"></script> -->
<style>
    input {
        text-align: left;

    }
    .dicountBtn {
        font-size: 28px !important;
    }
    #current_location,
    #embassy_appearance {
        text-align-last:center !important;
        font-size: 14px;
    }
    .dicount_code::placeholder {
        text-align: center !important;
    }
    @media (min-width:375px) and (max-width:768px) {
    .dicountBtn {
        font-size: 1.2em !important;

    }
}
</style>

<script>
    function changeLink(inputElement) {

        document.getElementById('amountLink').innerText.value = document.getElementById('amount').value
        //    $("span").text("$" + inputElement.value);
        //  $('#amountLink').attr("href","donate.php?amount="+inputElement.value);
        // $('#amountLink').text("$" + inputElement.value);
        //console.log($('#donateLink').attr("href"));
    }
</script>
<script src="https://paypage.sandbox.ngenius-payments.com/hosted-sessions/sdk.js"></script>

@section('content')

@php

$completed = DB::table('applicants')
->where('user_id', '=', Auth::user()->id)
->orderBy('id','desc')
->first();

$levels = $completed->applicant_status;
$app_id= $completed->id;

if(Session::has('myproduct_id'))
{
$pid = Session::get('myproduct_id');
} else {
$pid = $app_id;
}

$tryy = DB::table('payments')
->where('application_id', '=', $app_id)
->get();

$first_pay = 0;
$yy = 0;
$ppay = 0;
$pendMsg = null;
$second_pay= $third_pay = $discount = $which = $payNoww = $whichPayment = $payNow = $famCode = 0;
@endphp

@if($tryy->first())
@foreach($tryy as $tri)
<?php $nextt = $tri->product_payment_id + 1; ?>
@endforeach
@else
<?php $nextt = 0; ?>
@endif

<div class="container">
    <div class="col-12">


        <!-- Check if application completed, then exclude the other processes link and allow for subsequent payments only -->
        
        @if($levels == '5')
          <!-- Show Nothing -->
        @else
          <div class="row">
            <div class="wizard bg-white">
                <div class="row">
                    <div class="tabs d-flex justify-content-center">

                        <div class="wrapper">
                            <a href="{{ url('payment_form', $pid)}}">
                                <div class="round-active round2 m-2">1</div>
                            </a>
                            <div class="col-2 round-title">Payment <br> Details</div>
                        </div>
                        <div class="linear"></div>
                        
                        @if ($levels == '5' || $levels == '4' || $levels == '3' || $levels == '2')
	                        <div class="wrapper">
	                            <a href="{{route('applicant', $pid)}}">
	                                <div class="round3 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="{{route('applicant.details', $pid)}}">
	                                <div class="round4 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="{{url('applicant/review', $pid)}}">
	                                <div class="round5 m-2">4</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @else
	                        <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round3 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round4 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round5 m-2">4</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @endif
                    </div>
                </div>
              </div>
            @endif

            <!-- Main Module Begins here -->
            <div class="payment-form" @if($levels == '5') style="margin-top: 150px" @endif>
                <div class="heading" style="">
                    <div class="first-heading">
                        <h3>
                            Payment Details
                        </h3><br>

                      
                    </div>
                    <!-- <div class="bottom-title">
                        <p style="color: #C4C4C4; text-align: center;">If you have a dicount code, enter it here.</p>
                    </div> -->
                </div>
                <div class="form-sec discountForm">
                <form method="POST" action="{{ url('add_payment') }}">
                        @csrf
                        <!-- col-lg-6 col-md-6 col-12 offset-md-3 offset-lg-3 -->
                        <div class="row ">
                            <div class="col-6 mb-3">
                                <div class="inputs">
                                    <select title="Current Location" class="form-control  current_location form-select" id="current_location" name="current_location" required>
                                        <option selected disabled>--Current Location--</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('current_location')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">    
                                <div class="inputs">
                                    <select title="Embassy Appearance Country" class="form-control  embassy_appearance form-select" id="embassy_appearance" name="embassy_appearance" required="">
                                        <option selected disabled>--Country of Embassy Appearance--</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('embassy_appearance') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row" id="discount" style="text-align: center;">
                            <div class="mb-3">    
                                <div class="inputs">
                                    <input type="text" class="form-control dicount_code" name="discount_code" id="discount_code" aria-describedby="emailHelp" autocomplete="off" placeholder="Enter Discount Code, if any">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-3" style="display:block; margin: 0 auto;">
                                <button type="button" class="btn btn-primary dicountBtn" id="dicountBtn" >APPLY CODE</button>
                            </div>
                        </div>
                    <hr>

                        @foreach(($pays ? $pays : array()) as $pd)

                        @if(isset($pd->product_payment_id))
                        @php
                        $pp = $pd->product_payment_id;
                        @endphp
                        @else
                        @php
                        $pp = 0;
                        @endphp
                        @endif

                        @foreach($pdet as $index => $det)

                        @if(session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon')==1)
                        @php
                        $promo = session()->get('myDiscount')
                        @endphp
                        @else
                        @php
                        $promo =0
                        @endphp
                        @endif

                        @if(isset($index) && ($index == 0 || $index ==null))
                        @php
                        $first_pay = $det->amount
                        @endphp
                        @elseif($index == 1)
                        @php
                        $second_pay = $det->amount
                        @endphp
                        @else
                        @php
                        $third_pay = $det->amount;
                        $tot_pay = $first_pay + $second_pay + $third_pay;
                        @endphp
                        @endif

                        @if($first_pay == null || $first_pay == "")
                        @php
                        $first_pay=0
                        @endphp
                        @endif

                        @if($nextt == $det->id)


                        <?php
                        if (isset($det->amount)) {
                            $yy = $det->amount;
                            $ppay = $det->payment;
                        } else {
                            $yy = 0;
                            $ppay = "First Payment";
                        }
                        ?>

                        @php
                        $diff = $pd->total - $pd->total_paid
                        @endphp

                        @if($diff > 0)
                        @php
                        $pends = $pd->total - $pd->total_paid;
                        @endphp
                        @elseif($diff < 0) @php $pends=$pd->total_paid - $pd->total;
                            @endphp
                            @endif


                            <?php
                            if ($pdet) {
                                $det_id = $det->id;

                                if ($payall == 0) {
                                    $whichPayment =  $det->payment;
                                    if ($diff > 0 && $pd->total_paid > 0) {
                                        $payNow = $det->amount;
                                        $payNoww = $det->amount + $pends;
                                        $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                    } elseif ($diff < 0 && $pd->total_paid > 0) {
                                        $payNow = $det->amount;
                                        $payNoww = $det->amount - $pends;
                                        $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                    } else {
                                        $payNow = $det->amount;
                                        $payNoww = $det->amount;
                                        $pendMsg = "";
                                    }
                                    if ($promo > 0) {
                                        $discountPercent = 'PROMO: ' . $promo . '%';
                                        $discount = ($promo * $payNow) / 100;
                                    } else {
                                        $discountPercent = '0%';
                                        $discount = '0.00';
                                    }
                                } else {
                                    if ($index == 0 || $index == null) {
                                        $payNow = $data->unit_price;
                                        $payNoww = $det->unit_price;
                                        $pendMsg = "Full Payment";
                                    } else if ($index == 1) {
                                        $payNow = $data->unit_price - $pd->total;
                                        $payNoww = $payNow;
                                        $pendMsg = "Full Outstanding Payment";
                                    } else if ($index == 2) {
                                        $payNow = $det->amount;
                                        $payNoww = $payNow;
                                        $pendMsg = "";
                                    }

                                    $whichPayment =  "Full Payment";
                                    $discountPercent = $data->full_payment_discount . '%';
                                    $discount = ($data->unit_price * $data->full_payment_discount / 100);
                                }
                                $payNow = 0;
                                $vatPercent = '5%';
                                $vat = ($payNow * 5) / 100;
                                $totalPay = ($payNow + $vat) - $discount;

                                list($which, $zzz) = explode(' ', $whichPayment);
                            }
                            ?>

                            @else
                            @if($loop->first)

                            <?php
                            if (isset($det->amount)) {
                                $yy = $det->amount;
                                $ppay = $det->payment;
                            } else {
                                $yy = 0;
                                $ppay = "First Payment";
                            }
                            ?>
                            @php $diff = $pd->total - $pd->total_paid @endphp

                            @if($diff > 0)
                            @php
                            $pends = $pd->total - $pd->total_paid;
                            @endphp
                            @elseif($diff < 0) @php $pends=$pd->total_paid - $pd->total;
                                @endphp
                                @endif

                                <?php
                                if ($pdet) {
                                    $det_id = $det->id;
                                    //  $payall=0;
                                    if ($payall == 0) {
                                        $whichPayment =  $det->payment;
                                        if ($diff > 0 && $pd->total_paid > 0) {
                                            $payNow = $det->amount;
                                            $payNoww = $det->amount + $pends;
                                            $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                        } elseif ($diff < 0 && $pd->total_paid > 0) {
                                            $payNow = $det->amount;
                                            $payNoww = $det->amount - $pends;
                                            $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                        } else {
                                            $payNow = $det->amount;
                                            $payNoww = $det->amount;
                                            $pendMsg = "";
                                        }
                                        if ($promo > 0) {
                                            $discountPercent = 'PROMO: ' . $promo . '%';
                                            $discount = ($promo * $payNow) / 100;
                                        } else {
                                            $discountPercent = '0%';
                                            $discount = '0.00';
                                        }
                                    } else {

                                        if ($pp == 0 || $pp == null) {

                                            $payNow = $data->unit_price;
                                            $payNoww = $det->amount;
                                            $pendMsg = "Full Payment";
                                        } else if ($pp == 1) {

                                            $payNow = $data->unit_price - $pd->total;
                                            $payNoww = $payNow;
                                            $pendMsg = "Full Outstanding Payment";
                                        } else if ($pp == 2) {

                                            $payNow = 600; //$det->amount;
                                            $payNoww = $payNow;
                                            $pendMsg = "";
                                        } else {
                                            if (isset($ttot) && $ttot > 0) {
                                                $payNow = $ttot;
                                                $payNoww = $ttot;
                                            } else {
                                                $payNow = $data->unit_price;
                                                $payNoww = $data->unit_price;
                                            }
                                            $pendMsg = "Full Payment";
                                        }

                                        $whichPayment =  "Full Payment";
                                        $discountPercent = $data->full_payment_discount . '%';
                                        $discount = ($data->unit_price * $data->full_payment_discount / 100);
                                    }

                                    $vatPercent = '5%';
                                    $vat = ($payNow * 5) / 100;
                                    $totalPay = ($payNow + $vat) - $discount;

                                    list($which, $zzz) = explode(' ', $whichPayment);
                                }
                                ?>
                                @endif
                                @endif

                                <!-- endif -->
                                @endforeach
                                @endforeach
                                <div class="row payament-sec">
                                    <div class="col-6" style="padding-right:20px">
                                        <div class="total">
                                            <div class="total-sec row mt-3">
                                                <div class="left-section col-6">

                                                    @if($first_pay == $yy && $ppay == "First Payment")

                                                    <b>First Payment</b> @if(strlen($pendMsg)>1) <br>
                                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i> {{-- {{ $pendMsg }} --}} </font> @endif
                                                    @else
                                                    First Payment

                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                </div>
                                                <div class="right-section col-6" align="right">
                                                    @if($first_pay == $yy && $ppay == "First Payment")
                                                    @php $vat = $first_pay*5/100; @endphp
                                                    <b>{{number_format($first_pay,2)}}</b>

                                                    @else
                                                    {{number_format($first_pay,2)}}
                                                    @endif
                                                    <span style="font-size:11px">AED</span>
                                                </div>
                                            </div>
                                            <div class="total-sec row mt-3">
                                                <div class="left-section col-6">

                                                    @if($second_pay == $yy && $ppay == "Second Payment")
                                                    <b>Second Payment</b> @if(strlen($pendMsg)>1) <br>
                                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }} --}} </font> @endif
                                                    @else
                                                    Second Payment
                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                </div>
                                                <div class="right-section col-6" align="right">

                                                    @if($second_pay == $yy && $ppay == "Second Payment")
                                                    @php $vat = $second_pay*5/100; @endphp
                                                    <b>{{number_format($second_pay,2)}}</b>

                                                    @else
                                                    {{number_format($second_pay,2)}}
                                                    @endif
                                                    <span style="font-size:11px">AED</span>

                                                </div>
                                            </div>
                                            <div class="total-sec row mt-3">
                                                <div class="left-section col-6">
                                                    @if($third_pay == $yy && $ppay == "Final Payment")
                                                    
                                                    <b>Third Payment</b> @if(strlen($pendMsg)>1) <br>

                                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }}--}} </font> @endif
                                                    @else
                                                    Third Payment
                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                </div>
                                                <div class="right-section col-6" align="right">
                                                    @if($third_pay == $yy && $ppay == "Final Payment")
                                                    @php $vat = $third_pay*5/100; @endphp
                                                    <b>{{number_format($third_pay,2)}}</b>

                                                    @else
                                                    {{number_format($third_pay,2)}}
                                                    @endif
                                                    <span style="font-size:11px">AED</span>
                                                </div>
                                            </div>
                                            <hr>
    
                                            <div class="total-sec row mt-3">
                                                <div class="left-section col-6">
                                                    Total Payment
                                                </div>
                                                <div class="right-section col-6 " align="right">
                                                    <?php 

                                                        $totalCost = Session::get('totalCost');  
                                                       if(isset($tot_pay)) {
                                                        if (is_numeric($tot_pay))
                                                        {
                                                            $ttot = number_format($tot_pay,2);
                                                        } else {
                                                            $ttot = $tot_pay; //$totalCost;
                                                        }
                                                      } else {
                                                        $ttot =Session::get('totalCost');
                                                      }
                                                    ?> 
                                                   

                                                    @if(isset($ttot) && $ttot > 0)
                                                    {{ $ttot }}
                                                    @else
                                                    {{ isset($tot_pay) ? number_format($tot_pay,2) : '' }}
                                                    {{-- {{number_format($data->unit_price,2)}} --}}
                                                    @endif
                                                    <span style="font-size:11px">AED</span>
                                                </div>
                                            </div>
                                            <div class="total-sec row mt-3 showDiscount">
                                                <div class="left-section col-6">
                                               
                                                    @if(Session::has('haveCoupon'))
                                                      Discount (<span id="discountPercent">{{$discountPercent}} </span>)
                                                    @endif 

                                                </div>
                                                <div class="right-section col-6" align="right">
                                                @if(Session::has('haveCoupon'))
                                                    <span id="discountValue">{{number_format($discount,2)}} </span>
                                                    <span style="font-size:11px" id="discountVal">AED</span>
                                                @endif   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @if($ppay =="First Payment")
                                        <div class="partial" style="height: 100%;">

                                            <p>Pay {{strtolower($which)}} installment in partial</p>
                                            <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter partial payment" style="text-align:left !important" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                            @if($errors->has('totalpay'))
                                            <div class="error">{{ $errors->first('totalpay') }}</div>
                                            @endif

                                            <p>Minimum amount of <b> 1,000 AED</b></p>

                                            <script>
                                                $(document).ready(function() {
                                                    $('#amount').keyup(function() {
                                                        // if (parseInt($('input[name="amount"]').val()) >= 1000) 
                                                        // {
                                                        let ax = $('#amountLink').text($(this).val());
                                                        document.getElementById("amountLink2").value = $(this).val();
                                                        // } else {
                                                        //     alert('Too samll');
                                                        // }
                                                    });
                                                });
                                            </script>
                                            <?php
                                            $axx = "<script>document.write(ax)</script>";
                                            ?>

                                        </div>
                                        @endif
                                    </div>
                                    <div class="partial-total-sec">
                                        {{-- @if(isset($ttot) && $ttot > 0)  
                                       {{number_format($ttot,2)}}
                                        @else
                                        {{number_format($data->unit_price,2)}}
                                        @endif --}}
                                        <h2 style="font-size: 20px;">Now you will pay {{strtolower($which)}} installment only <span id="amountLink"><b>{{number_format($payNoww + $vat)}}</b></span> AED <span style="font-size:11px;opacity:0.6">(VAT inclusive)</span></h2>
                                        <input type="hidden" id="amountLink2" name="totalpay" value="{{  number_format($payNoww + $vat, 0, '.', '') }}">
                                        <input type="hidden" id="totaldue" name="totaldue" value="{{$payNoww + $vat}}">
                                    </div>
                                </div>
                            </div>
                           
                

                    <input type="hidden" name="pid" value="{{$data->id}}">
                    <input type="hidden" name="ppid" value="{{(isset($det_id))?$det_id:''}}">
                    <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                    <input type="hidden" name="whichpayment" value="{{ ($whichPayment) ? $whichPayment : 'First Payment' }}">
                    

                        
                        <div class="form-group row mt-4" style="margin-bottom: 70px">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                <p style="font-size:11px; text-align:center;color:green">You will be redirected to a secured payment page!</p>
                            </div>
                        </div>
                    </form>
@endsection
@push('custom-scripts')
<script>
    $(document).ready(function(){

        // $('#showDiscount').hide();
        $('#discount').hide();
        $('.dicountBtn').click(function(){

            var $this = $(this); 
            $.ajax({ 
                url: '{{ route("getPromo") }} ',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "discount_code" : $('#discount_code').val(),
                    "totaldue" : $('#totaldue').val()
                }
            }).done( function (response) {
            
                if (response) {
                    // alert(response.myDiscount);
                    console.log(response);
                    $('#discountValue').html(response.discountamt);
                    $('#discountPercent').html(response.discountPercent);
                     
                    $('#amountLink').html(parseInt(response.topaynow));

                    document.getElementById("amountLink2").value = response.topaynow;
                    // document.getElementById("totaldue").value = response.topaynow;
                    // $('#amountLink2').html(response.topaynow);
                    // $('#totaldue').html(response.topaynow);

                } else {
                    alert('Invalid Discount Code');
                }
            });
        });


        $('.embassy_appearance').change(function(){

            var $this = $(this); 
            $.ajax({ 
                url: '{{ route("checkPromo") }} ',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "embassy_appearance" : $('#embassy_appearance').val()
                }
            }).done( function (response) {

                if (response.status) {
                    // alert(response.status);
                    console.log(response);
                        $('#discount').show();
                    // $('#target-div').html(response.status); 
                }
            });
            });


    });


   

    // $('#discountForm').on('submit', function(e){
    //     e.preventDefault(); 

    //     var $this = $(this); 
    //     $.ajax({ 
    //         url: '{{ route("getPromo") }} ',
    //         method: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //         }
    //     }).done( function (response) {
        
    //         if (response) {
    //             alert(response.status)
    //             // $('#target-div').html(response.status); 
    //         }
    //     });
    // });
</script>
@endpush
<script src="{{asset('js/alert.js')}}"></script>