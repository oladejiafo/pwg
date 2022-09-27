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

$completed = DB::table('applications')
->where('client_id', '=', Auth::user()->id)
->orderBy('id','desc')
->first();

$levels = $completed->application_stage_status;
$app_id= $completed->id;

if(Session::has('myproduct_id'))
{
$pid = Session::get('myproduct_id');
} else {
$pid = $app_id;
}
$vals=array(0,1,2);
@endphp


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
	                        <!-- <div class="wrapper">
	                            <a href="{{route('applicant', $pid)}}">
	                                <div class="round3 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Details</div>
	                        </div>
	                        <div class="linear"></div> -->
	                        <div class="wrapper">
	                            <a href="{{route('applicant.details', $pid)}}">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="{{url('applicant/review', $pid)}}">
	                                <div class="round5 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @else
	                        <!-- <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round3 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Details</div>
	                        </div>
	                        <div class="linear"></div> -->
	                        <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="#" onclick="return alert('You have to complete Payment first');">
	                                <div class="round5 m-2">3</div>
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
                <div class="heading">
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

                    @if(in_array($levels, $vals) && (empty($completed->embassy_country) || $completed->embassy_country == null)) 
                        <div class="row ">
                            <div class="col-lg-6 col-sm-12 mb-3">
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
                            <div class="col-lg-6 col-sm-12 mb-3">    
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
                    @endif


                        @if(session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon')==1)
                            @php                               
                                $promo = session()->get('myDiscount')
                            @endphp
                        @else
                            @php
                                $promo =0
                            @endphp
                        @endif
                      
                        @if(isset($pdet))
                            @php
                                $first_pay = $pdet->first_payment_price;
                                $second_pay = $pdet->second_payment_price;
                                $third_pay = $pdet->third_payment_price;

                                $tot_pay = $first_pay + $second_pay + $third_pay;
                            @endphp
                        @else 
                            @php
                                $first_pay = 0;
                                $second_pay = 0;
                                $third_pay = 0;

                                $tot_pay = 0;
                            @endphp
                        @endif

                        @php
                            $diff = ($pays) ? $pays->first_payment_remaining : 0;
                        @endphp

                        @if($diff > 0)
                            @php
                                $pends = ($pays) ? $pays->first_payment_remaining : 0 ;
                            @endphp
                        @elseif($diff < 0) 
                            @php
                                $pends= ($pays) ? $pays->first_payment_paid - $pays->first_payment_price : 0;
                            @endphp
                        @else
                            @php
                                $pends=0;
                            @endphp
                        @endif


                            <?php
                                if ($payall == 0 || empty($payall)) {

                                 if($pays->first_payment_status !="Paid" || $pays->first_payment_status ==null){

                                   $whichPayment =  "First Payment";
                                
                                    $payNow = $pdet->first_payment_price;
                                    if($diff > 0) {
                                        $pendMsg = "You have " . $pends . " balance on first payment.";
                                        $payNoww = $pends;

                                    } else {
                                        $pendMsg = "";
                                        $payNoww = $pdet->first_payment_price;
                                    }

                                 }
                                 elseif($pays->first_payment_status =="Paid" && $pays->second_payment_status !="Paid"){
                                    
                                    $whichPayment =  "Second Payment";
                                    if ($diff > 0 && $pays->is_first_payment_partially_paid == 1) {
                                        $payNow = $pdet->second_payment_price;
                                        $payNoww = $pdet->second_payment_price + $pends;
                                        $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                    } elseif ($diff < 0 && $pays->is_first_payment_partially_paid == 1) {
                                        $payNow = $pdet->second_payment_price;
                                        $payNoww = $pdet->second_payment_price - $pends;
                                        $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                    } else {
                                        $payNow = $pdet->second_payment_price;
                                        $payNoww = $pdet->second_payment_price;
                                        $pendMsg = "";
                                    }

                                 }
                                 elseif($pays->second_payment_status =="Paid" && $pays->third_payment_status !="Paid"){
                                    
                                    $whichPayment =  "Third Payment";
                                    if ($diff > 0 && $pays->is_second_payment_partially_paid == 1) {
                                        $payNow = $pdet->third_payment_price;
                                        $payNoww = $pdet->third_payment_price + $pends;
                                        $pendMsg = ' + ' . $pends . " carried over from previous payment";
                                    } elseif ($diff < 0 && $pays->is_second_payment_partially_paid == 1) {
                                        $payNow = $pdet->third_payment_price;
                                        $payNoww = $pdet->third_payment_price - $pends;
                                        $pendMsg = ' - ' . $pends . " over paid from previous payment";
                                    } else {
                                        $payNow = $pdet->third_payment_price;
                                        $payNoww = $pdet->third_payment_price;
                                        $pendMsg = "";
                                    }

                                 }else {
                                    $whichPayment =  "First Payment";
                                    $payNow = $pdet->first_payment_price;
                                    $payNoww = $pdet->first_payment_price;
                                    $pendMsg = "";
                                 }
                                 $discount=0;

                                } else {
                                    if($pays->first_payment_status !="Paid"){
                                        if($diff > 0) {
                                            $payNow = $pdet->total_price-$pays->first_payment_paid;
                                            $payNoww = $pdet->total_price-$pays->first_payment_paid;
                                            $pendMsg = "Part Paid already";
                                            $discountPercent = $data->full_payment_discount . '%';
                                            $discount = ($pdet->total_price * $data->full_payment_discount / 100);
                                        } else {
                                            $payNow = $pdet->total_price;
                                            $payNoww = $pdet->total_price;
                                            $pendMsg = "Full Payment";
                                            $discountPercent = $data->full_payment_discount . '%';
                                            $discount = ($pdet->total_price * $data->full_payment_discount / 100);
                                        }
                                    } elseif($pays->first_payment_status =="Paid" && $pays->second_payment_status =="PENDING"){
                                        $payNow = $pdet->total_price - $pdet->first_payment_price;
                                        $payNoww = $payNow;
                                        $pendMsg = "Full Outstanding Payment";

                                        $discountPercent = $data->full_payment_discount . '%';
                                        $discount = ($pdet->total_price * $data->full_payment_discount / 100);
                                    } elseif ($pays->second_payment_status =="Paid" && $pays->third_payment_status =="PENDING") {
                                        $payNow = $pdet->third_payment_price;
                                        $payNoww = $payNow;
                                        $pendMsg = "";
                                        $discountPercent = '';
                                        $discount = 0;
                                    }else{
                                        $payNow = 0;
                                        $payNoww = $payNow;
                                        $pendMsg = "";
                                        $discountPercent = '';
                                        $discount = 0;
                                    }

                                    $whichPayment =  "Full-Outstanding Payment";
                                    // $discountPercent = $data->full_payment_discount . '%';
                                    // $discount = ($pdet->total_price * $data->full_payment_discount / 100);
                                }
                                // $payNow = 0;
                                $vatPercent = '5%';
                                
                                if(Auth::user()->country_of_residence == "United Arab Emirates")
                                {
                                  $vat = ($payNow * 5) / 100;
                                } else {
                                    $vat = 0;
                                }
                                
                                $totalPay = ($payNow + $vat) - $discount;

                                list($which, $zzz) = explode(' ', $whichPayment);
                            ?>
                    
                                <div class="row payament-sec">
                                    <div class="col-lg-6 col-md-12" style="padding-right:20px">
                                        <div class="total">
                                            <div class="total-sec row mt-3">
                                                <div class="left-section col-6">

                                                    @if($whichPayment  == "First Payment")

                                                    <b>First Payment</b> 
                                                    @else
                                                    First Payment

                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                    @if($pends>1) 
                                                    <br>
                                                    <font style='font-size:10px;color:red'><i fa fa-arrow-up></i>  {{ $pendMsg }} </font> 
                                                    @endif
                                                </div>
                                                <div class="right-section col-6" align="right">
                                                    @if($whichPayment == "First Payment")
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

                                                    @if( $whichPayment == "Second Payment")
                                                    <b>Second Payment</b> @if(strlen($pendMsg)>1) <br>
                                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }} --}} </font> @endif
                                                    @else
                                                    Second Payment
                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                </div>
                                                <div class="right-section col-6" align="right">

                                                    @if( $whichPayment ==  "Second Payment")
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
                                                    @if( $whichPayment ==  "Third Payment")
                                                    
                                                    <b>Third Payment</b> @if(strlen($pendMsg)>1) <br>

                                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }}--}} </font> @endif
                                                    @else
                                                    Third Payment
                                                    @endif
                                                    <span style="font-size:11px">(+ 5% VAT)</span>
                                                </div>
                                                <div class="right-section col-6" align="right">
                                                    @if( $whichPayment ==  "Third Payment")
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

                                                    //    $totalCost = Session::get('totalCost');  
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
                                            <div class="total-sec row mt-3 showDiscount" id ="showDiscount">
                                                <div class="left-section col-6">
                                               
                                                      Discount (<span id="discountPercent">{({$discountPercent) ? $discountPercent : ''}} </span>)
                                                    
                                                </div>
                                                <div class="right-section col-6" align="right">
                                              
                                                    <span id="discountValue">{{number_format($discount,2)}} </span>
                                                    <span style="font-size:11px" id="discountVal">AED</span>
                                                    <input type="hidden" name="discount" id="myDiscount" value="{{$discount}}">
                                                    <input type="hidden" name="discountCode" id="myDiscountCode" value="">
                                                    
                                                </div>
                                                
                                            </div>
                                            <input type="hidden" name="vats" id="vats" value="{{$vat}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        @if($whichPayment =="First Payment" && ($diff == 0 || empty($diff)))
                                        <div class="partial" style="height: 100%;">

                                            <p>Pay {{strtolower($which)}} installment in partial</p>
                                            <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter partial payment" style="text-align:left !important" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                            @if($errors->has('totalpay'))
                                            <div class="error">{{ $errors->first('totalpay') }}</div>
                                            @endif

                                            <p>Minimum amount of <b> 1,000 AED</b></p>

                                            <?php
                                           // $axx = "<script>document.write(ax)</script>";
                                            ?>

                                        </div>
                                        @endif
                                    </div>
                                    <div class="partial-total-sec">
                                  
                                    @if($diff > 0 && $payall ==0) 
                                        <h2 style="font-size: 1em;">Now you will pay the balance on first installment only <b>{{ number_format($pends) }}</b> AED <span style="font-size:11px;opacity:0.6">@if($vat>0) (VAT inclusive) @endif</span></h2>
                                        <input type="hidden" id="amountLink2" name="totalpay" value="{{  number_format($payNoww, 0, '.', '') }}">
                                        <input type="hidden" id="totaldue" name="totaldue" value="{{$payNow + $vat}}">
                                        <input type="hidden" name="totalremaining" value="{{$pends}}">
                                    @else
                                        <h2 style="font-size: 1em;">Now you will pay {{strtolower($which)}} installment only <span id="amountLink"><b>{{number_format($payNoww + $vat)}}</b></span> AED <span style="font-size:11px;opacity:0.6">@if($vat>0) (VAT inclusive) @endif</span></h2>
                                        <input type="hidden" id="amountLink2" name="totalpay" value="{{  number_format($payNoww + $vat, 0, '.', '') }}">
                                        <input type="hidden" id="totaldue" name="totaldue" value="{{$payNoww + $vat}}">
                                    @endif

                                    </div>
                                </div>
                            </div>

                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <input type="hidden" name="ppid" value="{{(isset($pdet->id))?$pdet->id:''}}">
                        <input type="hidden" name="uid" value="{{Auth::user()->id}}">
                        <input type="hidden" name="whichpayment" value="{{ ($whichPayment) ? $whichPayment : 'First Payment' }}">
                    

                        
                        <div class="form-group row mt-4" style="margin-bottom: 70px">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                <p style="font-size:11px; text-align:center;color:green">You will be redirected to a secured payment page!</p>
                            </div>
                        </div>
                    </form>
            </div>
@endsection
@push('custom-scripts')
<script>
    $(document).ready(function(){

        $('#showDiscount').hide();
        $('#discount').hide();

        $('#amount').keyup(function() {

            let ax = $('#amountLink').text($(this).val());
            document.getElementById("amountLink2").value = $(this).val();

        });

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
            
                if (response.status == true) {
                    // alert(response.myDiscount);
                    // alert(response.status);
                    console.log(response);
         
                    var nf = Intl.NumberFormat(); 
                    let amtNow = response.topaynow;
                    let amtNoww = nf.format(amtNow);

                    let discountAmt = response.discountamt;
                    let discountAmtt = nf.format(discountAmt);
              

                    $('#discountValue').html(discountAmtt);
                    $('#discountPercent').html(response.discountPercent);

                    $('#amountLink').html(amtNoww);

                    document.getElementById("amountLink2").value = response.topaynow;

                    document.getElementById("myDiscount").value = response.discountamt;
                    document.getElementById("myDiscountCode").value = $('#discount_code').val();
                    // document.getElementById("totaldue").value = response.topaynow;
                    // $('#amountLink2').html(response.topaynow);
                    // $('#totaldue').html(response.topaynow);
                    $('#showDiscount').show();

                } else {
                    let preAmt = $('#totaldue').val();
                    $('#amountLink').html(preAmt);
                    
                    $('#showDiscount').hide();
                    alert('Invalid Discount Code');
                }
            });
        });

        $('.current_location').change(function(){
            var $this = $(this);
            var amtx = <?php echo $payNoww; ?>; 
     
            if($this.val()=='United Arab Emirates')
            {
                document.getElementById("amountLink2").value = amtx + (amtx*5/100);
                $('#amountLink').text(amtx + (amtx*5/100)); //= amtx + (amtx*5/100);
              document.getElementById("totaldue").value = amtx + (amtx*5/100);
            } else {
                document.getElementById("amountLink2").value = amtx;
                $('#amountLink').text(amtx); //= amtx;
              document.getElementById("totaldue").value = amtx;
            }

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
                } else {
                    $('#discount').hide();
                }
            });
        });

    });


</script>
@endpush
<script src="{{asset('js/alert.js')}}"></script>