s @extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<link rel="stylesheet" href="../user/extra/css/signature-pad.css">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="stylesheet" href="../user/extra/css/signature-pad.css">

@section('content')
@php 
    $completed = DB::table('applications')
        ->where('client_id', '=', Auth::user()->id)
        ->orderBy('id','desc')
        ->first();
    if(Session::has('myproduct_id'))
    {
        $pid = Session::get('myproduct_id');
    } else {
        $pid = $app_id;
    }
    $vals=array(0,1,2);
@endphp

@if($completed)
    @php
        $levels = $completed->application_stage_status;
        $app_id= $completed->id;
    @endphp
@else
    @php $levels=0; @endphp
    {{-- <script>window.location = "/home";</script> --}}
@endif 

<div class="container">
    <div class="col-12">        
        @if($levels == '5')
          <!-- Show Nothing -->
        @else
            <div class="wizard">
                <div class="row">
                    <div class="tabs d-flex justify-content-center">
                        <div class="wrapper">
                            <a href="{{ url('payment_form', $pid)}}" class="wrapper-link">
                                <div class="round-active round2 m-2">1</div>
                            </a>
                            <div class="col-2 round-title">Payment <br> Details</div>
                        </div>
                        <div class="linear"></div>
                        
                        @if ($levels == '5' || $levels == '4' || $levels == '3' || $levels == '2')
	                        <div class="wrapper">
	                            <a href="{{route('applicant.details', $pid)}}" class="wrapper-link">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="{{url('applicant/review', $pid)}}" class="wrapper-link">
	                                <div class="round5 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @else
	                        <div class="wrapper">
	                            <a href="#" onclick="toastr.error('You have to complete Payment first');" class="wrapper-link toastrDefaultError">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="#" onclick="toastr.error('You have to complete Payment first');"  class="wrapper-link toastrDefaultError">
	                                <div class="round5 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="payment-form">
            <div class="contract-signature">
                <div class="row">
                    <div class="col-6">
                        <div class="contract d-flex align-items-center justify-content-center my-col"  style="height: 284px;">
                            <div class="contractImg">
                                <img src="{{asset('images/contract.png')}}" width="100%" height="100%">
                            </div>
                            <div class="contractSubHead">
                                <h6>CONTRACT</h6>
                                <p>Please review the contract carefully</p>
                            </div>
                        </div>
                        <button class="btn btn-primary ">ZOOM TO REVIEW</button>
                    </div>
                    <div class="col-6">
                        <div class="my-col">
                            <form enctype="multipart/form-data" id="signatureSubmit">
                                @csrf
                                <input type="hidden" name="pid" value="{{$data->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="payall" value="{{$payall}}">
                                <div id="signature-pad" class="signature-pad" style="height: 284px;">
                                    <div class="signature-pad--body">
                                        <canvas id="sig"></canvas>
                                    </div>
            
                                        <div class="signature-pad--actions">
                                            <div class="col-6">

                                                <button type="button" class="btn btn-primary clear" id="clear" data-action="clear">CLEAR</button>
                                            </div>
                                            <div class="col-6">
                                                <!-- <button type="submit" id="sigBtn" data-action="savePNG" class="btn btn-primary">SUBMIT</button> -->
                                                <button type="button" id="sigBtn" data-action="save-png" class="btn btn-primary button save">SIGN</button>
                                            </div>
                                        </div>
             
                                    
                                    {{-- <div class="toast-container"></div> --}}
                                </div>
                            </form>
                            <script src="../user/extra/js/signature_pad.umd.js"></script>
                            <script src="../user/extra/js/app.js"></script>
                            <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
                            <script src="{{asset('js/alert.js')}}"></script>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #Fff;padding: 30px; margin-top:5px">
                <div class="col-12">
                    

                        <div classx="form-sec discountForm">
                            <div align="left" style="background-color: #Fff;padding: 30px 0px">
                                <div><b style="color:black;font-size: 16px; margin-left:15px">Choose a Payment Method:</b></div>
                                <div align="left" class="row payoption" style="--bs-gutter-x:0px;display:fles; width:98%; margin:0 auto; margin-bottomx: -30px;margin-top:10px">
                                    <div class="col-4" style="margin-left:-10px;display:inline-block;" align: left>
                                        <input type="radio" id="card" name="payoption" checked value="Card" required> 
                                        <label for="card"><img src="{{asset('user/images/card_pay.png')}}" height="30px"> Card Payment</label>
                                    </div>
                                    <div class="col-4" style="margin-left:0px;display:inline-block;">
                                        <input type="radio" id="transfer" name="payoption" value="Transfer" required> 
                                        <label for="transfer"><img src="{{asset('user/images/transfer_pay.png')}}" height="30px"> Bank Transfer</label>
                                    </div>
                                    <div class="col-4" style="margin-left:0px;display:inline-block;">
                                        <input type="radio" id="deposit" name="payoption" value="Deposit" required> 
                                        <label for="deposit"><img src="{{asset('user/images/deposit_pay.png')}}" height="30px"> Bank Deposit</label>
                                    </div>
                                </div>
    
                            </div>
                           
                            @if (session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon') == 1)
                                @php
                                    $promo = session()->get('myDiscount');
                                @endphp
                            @else
                                @php
                                    $promo = 0;
                                @endphp
                            @endif

                            @if (isset($pdet))
                                @php
                                
                                    $first_pay = $pdet->first_payment_sub_total;
                                    $second_pay = $pdet->submission_payment_sub_total;
                                    $third_pay = $pdet->second_payment_sub_total;
                                    
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
                                $diff = $pays ? $pays->first_payment_remaining : 0; //$pays->first_payment_price - $pays->first_payment_paid
                            @endphp

                            @if ($diff > 0)
                                @php
                                    $pends = $pays ? $pays->first_payment_remaining : 0;
                                @endphp
                            @elseif($diff < 0)
                                @php
                                    $pends = $pays ? $pays->first_payment_paid - $pays->first_payment_sub_total : 0;
                                @endphp
                            @else
                                @php
                                    $pends = 0;
                                @endphp
                            @endif


                            <?php
                            
                            $outsec = $pays ? $pays->second_payment_price - $pays->second_payment_paid : 0;
                            $outsub = $pays ? $pays->submission_payment_price - $pays->submission_payment_paid : 0;
                            if ($payall == 0 || empty($payall)) {
                                if (!isset($pays) || ($pays->first_payment_status != 'PAID' || $pays->first_payment_status == null)) {
                                    //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
                                    $whichPayment = 'FIRST';
                                    $outsub = 0;
                                    $outsec = 0;
                            
                                    $payNow = $pdet->first_payment_sub_total;
                                    // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
                                    if ($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)) {
                                        $pendMsg = 'You have ' . $pends . ' balance on first payment.';
                                        $payNoww = $pends;
                                        $whichPayment = 'BALANCE_ON_FIRST';
                                    } else {
                                        $pendMsg = '';
                                        $payNoww = $pdet->first_payment_sub_total;
                                    }
                                } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status != 'PAID') {
                                    $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
                                    $outsec = 0;
                            
                                    $whichPayment = 'SUBMISSION';
                                    if ($diff > 0 && $pays->is_first_payment_partially_paid == 1) {
                                        $payNow = $pdet->submission_payment_sub_total;
                                        $payNoww = $pdet->submission_payment_sub_total + $pends;
                                        $pendMsg = ' + ' . $pends . ' carried over from previous payment';
                                    } elseif ($diff < 0 && $pays->is_first_payment_partially_paid == 1) {
                                        $payNow = $pdet->submission_payment_sub_total;
                                        $payNoww = $pdet->submission_payment_sub_total - $pends;
                                        $pendMsg = ' - ' . $pends . ' over paid from previous payment';
                                    } else {
                                        $payNow = $pdet->submission_payment_sub_total;
                                        $payNoww = $pdet->submission_payment_sub_total;
                                        $pendMsg = '';
                                    }
                                } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0) {
                                    $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
                                    $outsec = 0;
                            
                                    $pendMsg = 'You have ' . $outsub . ' balance on submission payment.';
                                    $payNow = $outsub; //$pdet->submission_payment_sub_total;
                                    $payNoww = $outsub;
                                    $whichPayment = 'SUBMISSION';
                                } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status != 'PAID') {
                                    $outsec = $pays->second_payment_price - $pays->second_payment_paid;
                                    $outsub = 0;
                            
                                    $whichPayment = 'SECOND';
                                    if ($diff > 0 && $pays->is_submission_payment_partially_paid == 1) {
                                        $payNow = $pdet->second_payment_sub_total;
                                        $payNoww = $pdet->second_payment_sub_total + $pends;
                                        $pendMsg = ' + ' . $pends . ' carried over from previous payment';
                                    } elseif ($diff < 0 && $pays->is_submission_payment_partially_paid == 1) {
                                        $payNow = $pdet->second_payment_sub_total;
                                        $payNoww = $pdet->second_payment_sub_total - $pends;
                                        $pendMsg = ' - ' . $pends . ' over paid from previous payment';
                                    } else {
                                        $payNow = $pdet->second_payment_sub_total;
                                        $payNoww = $pdet->second_payment_sub_total;
                                        $pendMsg = '';
                                    }
                                } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PAID' && $outsec > 0) {
                                    $pendMsg = 'You have ' . $outsec . ' balance on second payment.';
                                    $payNow = $outsec; //$pdet->submission_payment_sub_total;
                                    $payNoww = $outsec;
                                    $whichPayment = 'SECOND';
                                } else {
                                    $whichPayment = 'FIRST';
                                    $payNow = $pdet->first_payment_sub_total;
                                    $payNoww = $pdet->first_payment_sub_total;
                                    $pendMsg = '';
                                }
                                $discount = 0;
                            } else {
                                $discount = 0;
                                $discountPercent = 0;
                                if (isset($pays) && $pays->first_payment_status == 'PENDING' && ($pays->submission_payment_status == 'PENDING') & ($pays->second_payment_status == 'PENDING')) {
                                    $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
                                    $payNoww = $payNow;
                                    $pendMsg = 'Full Payment';
                                    if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                                        $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                            
                                        // $discountPercent = '5%';
                                        // $discount = ($payNow * 5 / 100);
                                        $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
                                    }
                                    $whichPayment = 'Full-Outstanding Payment';
                                } elseif (isset($pays) && $pays->first_payment_status != 'PAID') {
                                    if (is_null($pdet->second_payment_price) or empty($pdet->second_payment_price)) {
                                        $payNow = $pdet->submission_payment_sub_total;
                                        $payNoww = $payNow;
                                        if ($diff > 0) {
                                            $pendMsg = 'Part Paid already';
                                        } else {
                                            $pendMsg = '';
                                        }
                                        $discountPercent = '';
                                        $discount = 0;
                                    } elseif ($diff > 0) {
                                        $payNow = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
                                        $payNoww = $pdet->sub_total - $pdet->first_payment_sub_total - $pdet->third_payment_sub_total;
                                        $pendMsg = 'Part Paid already';
                                        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                                            $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;

                                            $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
                                        }
                                    } else {
                                        $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
                                        $payNoww = $pdet->sub_total - $pdet->third_payment_sub_total;
                                        $pendMsg = 'Full Payment';
                                        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {

                                            $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                                            $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
                                        }
                                    }
                                    $whichPayment = 'Full-Outstanding Payment';
                                } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PENDING') {
                                    if ($pdet->second_payment_price != null || $pdet->second_payment_price != 0) {
                                        $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
                                        $payNoww = $payNow;
                                        $pendMsg = 'Full Outstanding Payment';
                                        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                                            $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                                            $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0;
                                        }
                                        $whichPayment = 'Full-Outstanding Payment';
                                    } else {
                                        $payNow = $pdet->submission_payment_sub_total;
                                        $payNoww = $payNow;
                                        $pendMsg = '';
                                        $discountPercent = '';
                                        $discount = 0;
                                        $whichPayment = 'SUBMISSION';
                                    }

                                } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PENDING') {
                                    $payNow = $pdet->second_payment_sub_total;
                                    $payNoww = $payNow;
                                    $pendMsg = '';
                                    $discountPercent = '';
                                    $discount = 0;
                                } else {
                                    $payNow = 0;
                                    $payNoww = $payNow;
                                    $pendMsg = '';
                                    $discountPercent = '';
                                    $discount = 0;
                                }
                            
                                $whichPayment = 'Full-Outstanding Payment';
                            }

                            $vatPercent = '5%';

                            $vat = (($payNow - $discount) * 5) / 100;
                            
                            $totalPay = round($payNow - $discount + $vat, 2);

                            ?>
                            <div id='card-payment'>
                                @include('user.card-payment')
                            </div>
                            <div id='bank-payment'>
                                @include('user.bank-payment')
                            </div>
                            
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection
@push('custom-scripts')

<script>
    $(document).ready(function(){
        $('#bank-payment').hide();

        $('#transfer').click(function(){
            $('#bank-payment').show();
            $('#card-payment').hide();
        });
        $('#deposit').click(function(){
            $('#bank-payment').show();
            $('#card-payment').hide();
        });
        $('#card').click(function(){
            $('#bank-payment').hide();
            $('#card-payment').show();
        });

        $('#showDiscount').hide();
        $('#discount').hide();
        $('#promoDiscount').hide();
        // document.getElementById("amountLink2").value = $(this).val();
        // let ax = $('#amountLink').text(($('#totaldue').val()));

        $('#amount').keyup(function() {
            if($('#amount').val()){
                    var aVat =($('#amount').val()*5)/100;
                    let vval = parseInt($('#amount').val()) + parseInt(($('#amount').val()*5)/100);

                    document.getElementById("amountLink2").value = vval;
                    let ax = $('#amountLink').text(parseInt(vval).toLocaleString());
                
            } else {
                document.getElementById("amountLink2").value = $('#totaldue').val();
                let ax = $('#amountLink').text(parseInt($('#totaldue').val()).toLocaleString());
            }
        });

        $('.dicountBtn').click(function(){
            var paynow = <?php echo $payNoww; ?>;     
            var vat = $('#vats').val();
            var $this = $(this); 
            $.ajax({ 
                url: '{{ route("getPromo") }} ',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "discount_code" : $('#discount_code').val(),
                    "totaldue" : $('#totaldue').val(),
                    'paynow' : paynow,
                    'vat' : vat
                }
            }).done( function (response) {
            
                if (response.status == true) {
                    // alert(response.myDiscount);
                    // alert(response.status);
                    $('#amountLink2').val(0);
                    $('#totaldue').val(0);
                    // $('#discountValue').html(0);
                    // $('#discountValue').text(0);
                    // $('#myDiscount').val(0);
         
                    var nf = Intl.NumberFormat(); 
                    // let amtNow = response.topaynow;
                    let amtNow = Math.floor(response.topaynow * 100)/100;

                    // let amtNoww = nf.format(amtNow);
                    let amtNoww = nf.format(Math.floor(response.topaynow *100)/100);

                    let discountAmt = response.discountamt;
                    let discountAmtt = nf.format(discountAmt);
              
                    let vatNow = Math.floor(response.vatNow * 100)/100;
                    let totalValueNotRounding = Math.floor(response.topaynow *100)/100;

                    // $('#promoDiscount #discountValue').html(discountAmtt);
                    // $('#promoDiscount #discountValue').text(discountAmtt);
                    $('#discountValue').html(discountAmtt);
                    $('#discountPercent').html(response.discountPercent);

                    $('#amountLink').html(amtNoww);
                    $('#vatt').html(vatNow);
                    // alert(response.topaynow.toFixed(2));
                    $('#amountLink2').val(totalValueNotRounding);
                    $('#totaldue').val(totalValueNotRounding);

                    // document.getElementById("amountLink2").value = response.topaynow;

                    document.getElementById("vats").value = Math.floor(response.vatNow * 100)/100;
                    // document.getElementById("myDiscount").value = response.discountamt;
                    document.getElementById("myDiscount").value = Math.floor(discountAmt * 100)/100;

                    document.getElementById("myDiscountCode").value = $('#discount_code').val();
                    // document.getElementById("totaldue").value = response.topaynow;
                    // $('#amountLink2').html(response.topaynow);
                    // $('#totaldue').html(response.topaynow);
                    $('#showDiscount').show();
                    toastr.success('Discount Applied Successfully !');

                } else {
                    let preAmt = $('#totaldue').val();
                    $('#amountLink').html(preAmt);
                    
                    $('#showDiscount').hide();
                    toastr.error('Invalid Discount Code');
                }
            });
        });

        $('.current_location').change(function(){
            var $this = $(this);
            var paynow = <?php echo $payNoww; ?>;            
            var discount = '{{$discount}}';
            var amtx = (paynow - discount);
            var vt =(amtx*5)/100;
            $('#amount').val('');
            
              document.getElementById("amountLink2").value = Math.floor((amtx + (amtx*5/100)) *100)/100;
              $('#amountLink').text(parseFloat(Math.floor((amtx + (amtx*5/100)) * 100)/100).toLocaleString('en')); //= amtx + (amtx*5/100);
              document.getElementById("totaldue").value = Math.floor((amtx + (amtx*5/100)) *100)/100;

              var nf = Intl.NumberFormat(); 
              $('#vatt').html(nf.format(vt));
 
              $('#vats').val(Math.floor(vt * 100)/100);
              $('#showVat').show();
              $('#vt').text("VAT Inclusive");
              $('.vtt').text("(+ 5% VAT)");
            
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
                        $('#discount').show();
                    // $('#target-div').html(response.status); 
                } else {
                    $('#discount').hide();
                }
            });
        });

        savePNGButton.addEventListener("click", () => {
        if (signaturePad.isEmpty()) {
            toastr.error("Please provide a signature.");
        } else {
            const dataURL = signaturePad.toDataURL();

        $.ajax({
        type: 'POST',
        url: "{{ url('upload_signature') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            signed: dataURL,
            payall: '{{$payall}}',
            response: 1
        },
        success: function(data) {
            console.log(data);
            if (data) 
            {
                // location.href = "{{url('payment_form')}}/" + '{{$data->id}}';
            } else {
            alert('Something went wrong');
            }

        },
        error: function(error) {}
        });
    }
    });

  });


</script>
@endpush
<script src="{{asset('js/alert.js')}}"></script>
<script type="text/javascript" src="/path/to/toastr.js"></script>
<script>
    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
            toastr.warning("{{ session('warning') }}");
    @endif
</script>

<script type="text/javascript">

$(document).ready(function() {


});
</script>
    
@if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) 
<script>
    //Disable right click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
        return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
        // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
        if (
            event.keyCode === 123 ||
            ctrlShiftKey(e, 'I') ||
            ctrlShiftKey(e, 'J') ||
            ctrlShiftKey(e, 'C') ||
            (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
        )
        return false;
    };
</script>
@endif