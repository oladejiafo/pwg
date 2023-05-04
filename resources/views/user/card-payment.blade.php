<?php
if (Session::has('payall')) {
    $payall = Session::get('payall');
} elseif (isset($_REQUEST['payall'])) {
    $payall = $_REQUEST['payall'];
} else {
    $payall = 0;
}
?>
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

// $outsec = $pays ? $pays->second_payment_price - $pays->second_payment_paid : 0;
// $outsub = $pays ? $pays->submission_payment_price - $pays->submission_payment_paid : 0;
$outsec = $pays ? $pays->second_payment_remaining : 0;
$outsub = $pays ? $pays->submission_payment_remaining : 0;
if ($payall == 0 || empty($payall)) {
    if (!isset($pays) || ($pays->first_payment_status != 'PAID' || $pays->first_payment_status == null)) {
        //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
        $whichPayment = 'FIRST';
        $outsub = 0;
        $outsec = 0;

        $payNow = $pdet->first_payment_sub_total;
        // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
        // if ($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)) {
        if (isset($pays) && $pays->first_payment_paid > 0) {
            $pendMsg = 'You have ' . $pends . ' balance on first payment.';
            $payNoww = $pends;
            $whichPayment = 'BALANCE_ON_FIRST';
        } else {
            $pendMsg = '';
            $payNoww = $pdet->first_payment_sub_total;
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status != 'PAID' && $pdet->submission_payment_sub_total > 0) {
        $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
        $outsec = 0;

        $whichPayment = 'SUBMISSION';
        if ($pays->submission_payment_remaining > 0 && $pays->submission_payment_status == 'PARTIALLY_PAID') {
            $pendMsg = 'You have ' . $pays->submission_payment_remaining . ' balance on submisssion payment.';
            $payNoww = $pays->submission_payment_remaining;
            $payNow = $pdet->submission_payment_sub_total;
            $whichPayment = 'BALANCE_ON_SUBMISSION';
        } else {
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
                if($pays->coupon_code != null){
                    $payNow = $pdet->submission_payment_sub_total - $pays->submission_payment_discount;
                } else {
                    $payNoww = $pdet->submission_payment_sub_total;
                }
                $pendMsg = '';
            }
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0 && $pdet->submission_payment_sub_total > 0) {
        $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
        $outsec = 0;

        $pendMsg = 'You have ' . $outsub . ' balance on submission payment.';
        if($pays->coupon_code != null){
            $payNoww = $pdet->submission_payment_sub_total - $pays->submission_payment_discount;
            $payNow = $outsub  - $pays->submission_payment_discount; //$pdet->submission_payment_sub_total;
        } else {
            $payNoww = $pdet->outsub;
            $payNow = $outsub; //$pdet->submission_payment_sub_total;
        }
        // $payNoww = $outsub;
        $whichPayment = 'SUBMISSION';
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && empty($pdet->submission_payment_sub_total)) {
        $outsec = $pays->second_payment_price - $pays->second_payment_paid;
        $outsub = 0;

        $whichPayment = 'SECOND';
        if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
            $vat_2 = $pays->second_payment_remaining * (5 / 100);
            $pendMsg = 'You have ' . $pays->second_payment_remaining . ' balance on second payment.';
            $payNoww = $pays->second_payment_remaining;
            $payNow = $pdet->second_payment_sub_total;
            $whichPayment = 'BALANCE_ON_SECOND';
        } else {
            if ($diff > 0 && $pays->is_submission_payment_partially_paid == 1) {
                $payNow = $pdet->second_payment_sub_total;
                $payNoww = $pdet->second_payment_sub_total + $pends;
                $pendMsg = ' + ' . $pends . ' carried over from previous payment';
            } elseif ($diff < 0 && $pays->is_submission_payment_partially_paid == 1) {
                $payNow = $pdet->second_payment_sub_total;
                $payNoww = $pdet->second_payment_sub_total - $pends;
                $pendMsg = ' - ' . $pends . ' over paid from previous payment';
            } else {
                if($pays->coupon_code != null){
                    $payNoww = $pdet->second_payment_sub_total - $pays->second_payment_discount;
                    $payNow = $pdet->second_payment_sub_total - $pays->second_payment_discount;
                } else {
                    $payNoww = $pays->second_payment_remaining;
                    $payNow = $pdet->second_payment_sub_total;
                }
                $pendMsg = '';
            }
        }
    } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && $pdet->second_payment_sub_total > 0) {
        $outsec = $pays->second_payment_price - $pays->second_payment_paid;
        $outsub = 0;

        $whichPayment = 'SECOND';
        if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
            $vat_2 = $pays->second_payment_remaining * (5 / 100);
            $pendMsg = 'You have ' . $pays->second_payment_remaining . ' balance on second payment.';
            $payNoww = $pays->second_payment_remaining;
            $payNow = $pdet->second_payment_sub_total;
            $whichPayment = 'BALANCE_ON_SECOND';
        } else {
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
        }
    } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PAID' && $outsec > 0 && $pdet->second_payment_sub_total > 0) {
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
    if (!isset($pays)) {
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
    } elseif (isset($pays) && $pays->first_payment_status == 'PENDING' && ($pays->submission_payment_status == 'PENDING') & ($pays->second_payment_status == 'PENDING')) {
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
        // } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PENDING') {
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID') {
        if ($pdet->second_payment_price != null || $pdet->second_payment_price != 0) {
            if ($pays->submission_payment_status == 'PENDING') {
                $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
                $payNoww = $payNow;
                if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                    $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                    $discount = $data->full_payment_discount > 0 ? ($payNow * $data->full_payment_discount) / 100 : 0;
                }
            } elseif ($pays->submission_payment_status == 'PARTIALLY_PAID') {
                $payNow = $pdet->second_payment_sub_total;
                $payNoww = $pays->submission_payment_remaining + $payNow;
                if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
                    $discountPercent = $data->full_payment_discount ? $data->full_payment_discount . '%' : 0;
                    $discount = $data->full_payment_discount > 0 ? ($pdet->second_payment_sub_total * $data->full_payment_discount) / 100 : 0;
                }
            }
            $pendMsg = 'Full Outstanding Payment';
            $whichPayment = 'Full-Outstanding Payment';
        } else {
            $payNow = $pdet->submission_payment_sub_total;
            $payNoww = $payNow;
            $pendMsg = '';
            $discountPercent = '';
            $discount = 0;
            $whichPayment = 'SUBMISSION';
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && ($pays->second_payment_status == 'PENDING' || $pays->second_payment_status == 'PARTIALLY_PAID')) {
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

<form method="POST" action="{{ url('add_payment') }}">
    @csrf

    <div class="row payament-sec">


        <div class="col-lg-6 col-md-12" style="padding-right:20px">

            <div class="total">
                @if ($first_pay > 0 && ($whichPayment == 'FIRST' || $whichPayment == 'BALANCE_ON_FIRST'))
                    <div class="total-sec row mt-3">
                        <div class="left-section col-6">

                            @if ($whichPayment == 'FIRST')
                                <b>First Payment</b>
                            @else
                                First Payment
                            @endif

                            @if ($pends > 1)
                                <br>
                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }} </font>
                            @endif
                        </div>
                        <div class="right-section col-6" align="right" id="thispay">
                            @if ($whichPayment == 'FIRST')
                                <b>{{ number_format($first_pay, 2) }}</b>
                            @else
                                {{ number_format($first_pay, 2) }}
                            @endif
                            <span style="font-size:11px">AED</span>
                        </div>
                    </div>
                @elseif($second_pay > 0 && ($whichPayment == 'SUBMISSION' || $whichPayment == 'BALANCE_ON_SUBMISSION'))
                    <div class="total-sec row mt-3">
                        <div class="left-section col-6">

                            @if ($whichPayment == 'SUBMISSION')
                                <b>Submission Payment</b>
                            @else
                                Submission Payment
                            @endif
                            {{-- <span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                (+ 5% VAT)
                            @endif
                        </span> --}}
                            @if ($outsub > 1)
                                <br>
                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }}
                                </font>
                            @endif
                        </div>
                        <div class="right-section col-6" align="right">

                            @if ($whichPayment == 'SUBMISSION')
                                <b>{{ number_format($second_pay, 2) }}</b>
                            @else
                                {{ number_format($second_pay, 2) }}
                            @endif
                            <span style="font-size:11px">AED</span>

                        </div>
                    </div>
                @elseif($third_pay > 0 && ($whichPayment == 'SECOND' || $whichPayment == 'BALANCE_ON_SECOND'))
                    <div class="total-sec row mt-3">
                        <div class="left-section col-6">
                            @if ($whichPayment == 'SECOND')

                                <b>Second Payment</b>
                                @if (strlen($pendMsg) > 1)
                                    <br>

                                    <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }} --}}
                                    </font>
                                @endif
                            @else
                                Second Payment
                            @endif

                            @if ($outsec > 1)
                                <br>
                                <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }}
                                </font>
                            @endif
                        </div>
                        <div class="right-section col-6" align="right">
                            @if ($whichPayment == 'SECOND')
                                <b>{{ number_format($third_pay, 2) }}</b>
                            @else
                                {{ number_format($third_pay, 2) }}
                            @endif
                            <span style="font-size:11px">AED</span>
                        </div>
                    </div>
                @elseif($whichPayment == 'Full-Outstanding Payment')
                    <div class="total-sec row mt-3">
                        <div class="left-section col-6">
                            <b>Full Outstanding Payment</b>
                        </div>
                        <div class="right-section col-6" align="right" id="thispay" style="font-weight:bold">

                            <b>{{ number_format($payNoww, 2) }}</b>

                            <span style="font-size:11px">AED</span>
                        </div>
                    </div>
                @endif
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">
                        You are saving
                    </div>
                    <div class="right-section col-6" align="right" id="thissave">
                        @if($payall == 1 && isset($discount) && $discount > 0)
                            {{ (($payNoww*1.2995) - $payNoww)+$discount }} 
                        @else
                            {{ ($payNoww*1.2995) - $payNoww }} 
                        @endif
                        <span style="font-size:11px"> AED</span>
                    </div>
                </div>
                {{-- <hr> --}}

                @if ($payall == 1 && isset($discount) && $discount > 0)
                    <div class="total-sec row mt-3 showDiscount">
                        <div class="left-section col-6">
                            Full Payment Discount (<span
                                id="discountPercent"> {{ $discountPercent ? $discountPercent : '' }}</span>)
                        </div>
                        <div class="right-section col-6" align="right">

                            <span id="discountValue">{{ number_format($discount, 2) }} </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="coupon" class="couponDetails">
                            <input type="hidden" name="discount" id="myDiscount" value="{{ $discount }}">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">

                        </div>

                    </div>
                @else
                    <div class="total-sec row mt-3 showDiscount" id="showDiscount">
                        <div class="left-section col-6">

                            Discount (<span
                                id="discountPercent">{{ isset($discountPercent) ? $discountPercent : 0 }} </span>)

                        </div>
                        <div class="right-section col-6" align="right">
                            <input type="hidden" name="coupon[]" class="couponDetails">
                            <span id="discountValue">{{ number_format($discount, 2) }} </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="discount" id="myDiscount" value="{{ $discount }}">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">
                        </div>

                    </div>
                @endif
                @if (isset($vat) && $vat > 0)
                    {{-- <div class="total-sec row mt-3 showVat" id="showVat">
                        <div class="left-section col-6">
                            VAT (+ 5% of {{ $whichPayment }})
                        </div>
                        <div class="right-section col-6" align="right">
                            <span id="vatt">{{ number_format($vat, 2) }} </span>
                            <span style="font-size:11px">AED</span>
                        </div>
                    </div> --}}
                @endif
                <input type="hidden" name="vats" id="vats" value="{{ $vat }}">
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            @if ($whichPayment == 'FIRST' && (!isset($pays) || $pays->first_payment_paid == 0))
                <div class="partial" style="height: 100%;font-size:14px">
                    <p style="font-size:14px"><b>You may pay {{ strtolower($whichPayment) }} installment in partial</b></p>
                    <input type="text" class="form-control" name="amount" id="amount"
                        placeholder="Enter partial payment" style="text-align:left !important"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                    {{-- @if ($errors->has('totalpay'))
                              <div class="error">{{ $errors->first('totalpay') }}</div>
                            @endif  --}}
                    @if ($errors->has('amount'))
                        <div class="error">{{ $errors->first('amount') }}</div>
                    @endif
                    <p style="font-size:12px">Minimum amount of <b> 1,000 AED</b><span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                {{-- (+ 5% VAT) --}}
                            @endif
                        </span></p>

                    <p style="font-size:12px"><b>Remaining amount to be paid within 30 days</b></p>
                </div>
            @endif
        </div>
        <div class="partial-total-sec">

            @if (isset($pays) && $pays->first_payment_paid > 0 && $pays->first_payment_remaining > 0 && $payall == 0)
                <h2 style="font-size: 1em;">Now you will pay the balance on first installment only
                    <b>{{ number_format(floor($pends * 100) / 100, 2) }}</b> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if ($vat > 0) (VAT inclusive @if ($discount > 0)
                                ,less Discount
                            @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{ round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round($payNow + $vat, 2) }}">
                <input type="hidden" name="totalremaining" value="{{ round($pends, 2) }}">
            @elseif(isset($pays) &&
                    $pays->submission_payment_paid > 0 &&
                    $pays->submission_payment_remaining > 0 &&
                    $payall == 0 &&
                    (strtolower($whichPayment) == 'submission' || strtolower($whichPayment) == 'balance_on_submission'))
                <h2 style="font-size: 1em;">Now you will pay the balance on submission installment only
                    <b>{{ number_format(floor($payNoww * 100) / 100, 2) }}</b> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if ($vat > 0) (VAT inclusive @if ($discount > 0)
                                ,less Discount
                            @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{ round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round($payNow + $vat, 2) }}">
                <input type="hidden" name="totalremaining" value="{{ round($pends, 2) }}">
            @elseif(isset($pays) &&
                    $pays->second_payment_paid > 0 &&
                    $pays->second_payment_remaining > 0 &&
                    $payall == 0 &&
                    (strtolower($whichPayment) == 'second' || strtolower($whichPayment) == 'balance_on_second'))
                <h2 style="font-size: 1em;">Now you will pay the balance on second installment only
                    <b>{{ number_format(floor($payNoww * 100) / 100, 2) }}</b> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if ($vat > 0) (VAT inclusive @if ($discount > 0)
                                ,less Discountpwg
                            @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{ round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round($payNow + $vat, 2) }}">
                <input type="hidden" name="totalremaining" value="{{ round($pends, 2) }}">
            @else
                <h2 style="font-size: 1em;">Now you will pay {{ strtolower($whichPayment) }} installment only
                    <span id="amountLink">

                        {{-- <b>{{(($pays->first_payment_status !="PAID") ? (($diff > 0) ? number_format((floor(((($payNoww - $discount)+ $vat)+$pays->first_payment_remaining)*100)/100),2) : (number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))):number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))}}</b> --}}
                        <b><span id="amountLink">
                                {{ !isset($pays) || $pays->first_payment_status != 'PAID' ? ($diff > 0 ? number_format(floor(($payNoww - $discount + $vat) * 100) / 100, 2) : number_format(floor(($payNoww - $discount + $vat) * 100) / 100, 2)) : number_format(floor(($payNoww - $discount + $vat) * 100) / 100, 2) }}
                            </span></b>
                    </span> AED
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if ($vat > 0)
                            (<span id="vt">VAT inclusive</span>
                            @if ($discount > 0)
                                ,less Discount
                            @endif)
                        @else
                            @if ($discount > 0)
                                (less Discount)
                            @endif
                        @endif
                    </span>
                </h2>
                {{-- <input type="hidden" id="amountLink2" name="totalpay" value="{{ round((($payNoww - $discount)+ $vat),2) }}"> --}}
                <input type="hidden" id="amountLink2" name="totalpay"
                    value="{{ !isset($pays) || $pays->first_payment_status != 'PAID' ? ($diff > 0 ? round($payNoww - $discount + $vat, 2) : round($payNoww - $discount + $vat, 2)) : round($payNoww - $discount + $vat, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue"
                    value="{{ round($payNoww - $discount + $vat, 2) }}">
            @endif
        </div>

    </div>

    {{-- @if ($payall == 1)
    <input type="hidden" name="pr_id" value="{{$data->id}}"> --}}
    {{-- <input type="hidden" name="productId" value="{{$productId}}"> --}}
    {{-- <input type="hidden" class="hiddenFamAmount" name="cost" value="{{($famdet) ?  number_format($famdet['first_payment_sub_total']) : 0 }}"> --}}
    {{-- <input type="hidden" value="FAMILY_PACKAGE" name="myPack">
    <input type="hidden" value="{{ isset($pdet->id) ? $pdet->id : '' }}" name="fam_id" class="fam_id"> --}}
    {{-- @else  --}}
    <input type="hidden" name="cost" value="{{ $payNoww }}">
    <input type="hidden" name="blue_id" value="{{ isset($pdet->id) ? $pdet->id : '' }}">
    <input type="hidden" name="pr_id" value="{{ $data->id }}">
    <input type="hidden" value="BLUE_COLLAR" name="myPack">
    {{-- @endif --}}

    <input type="hidden" name="pid" value="{{ $data->id }}">
    <input type="hidden" name="ppid" value="{{ isset($pdet->id) ? $pdet->id : '' }}">
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
    <input type="hidden" name="packageType" value="{{ $pdet->pricing_plan_type }}">
    <input type="hidden" name="whichpayment" value="{{ $whichPayment ? $whichPayment : 'FIRST' }}">
    <input type="hidden" name="first_p" value="{{ $pdet->first_payment_sub_total }}">
    <input type="hidden" name="second_p" value="{{ $pdet->submission_payment_sub_total }}">
    <input type="hidden" name="third_p" value="{{ $pdet->second_payment_sub_total }}">
    <input type="hidden" name="signed"  class="dataUrl" value="">
    {{-- <input type="text" name="signed" value="return signaturePad.toDataURL(); "> --}}

    <div class="row mt4">
        <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px">
            <input type="checkbox" name="agree" required autocomplete="off">
            <span>By continuing you agree to the <a href="{{ route('terms') }}"
                    style="color:#000;margin:30px 0;font-size: 15px" target="_blank"><u>Terms &
                        Conditions</u></a></span>
        </div>
        <div class="col-lg-2 col-md-1 col-sm-12"></div>
        <div class="col-lg-4 col-md-5 col-sm-12">
            {{-- id="sigBtn" data-action="save-png" class="btn btn-primary button save --}}
            <button type="submit" onclick="saveSign()" class="btn btn-primary submitBtn"
                style="border-radius: 0px">Pay Now</button>
        </div>

    </div>
</form>

<script>
    $(document).ready(function() {

        $('#partial').click(function() {
            $('.coupon').show();
            $.ajax({
                url: '{{ route('payType') }} ',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payall": 0
                },
                success: function(data) {

                    $("#card-payment").load(window.location.href + " #card-payment > *");
                    $("#bank-payment").load(window.location.href + " #bank-payment > *");
                    $('#bank-payment').hide();

                    if ($('input[name="payoption"]:checked').val() == "Card") {
                        $('#bank-payment').hide();
                        $('#card-payment').show();
                    } else {
                        $('#bank-payment').show();
                        $('#card-payment').hide();
                    }

                }
            });
        });


        $('#full').click(function() {
            
            $('.coupon').hide();
            $.ajax({
                url: '{{ route('payType') }} ',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payall": 1
                },
                success: function(data) {

                    $("#card-payment").load(window.location.href + " #card-payment > *");
                    $("#bank-payment").load(window.location.href + " #bank-payment > *");
                    if ($('input[name="payoption"]:checked').val() == "Card") {
                        
                        $('#bank-payment').hide();
                        $('#card-payment').show();
                    } else {
                        $('#bank-payment').show();
                        $('#card-payment').hide();
                    }

                }

            });
        });


        $('input[name="spouse"]').click(function(e) {
            let parents = e.target.value;
            // parents = spouse.value;
            kidd = $('input[name="children"]:checked').val();
            getCost(kidd,parents);      
        });

        $('input[name="children"]').click(function(e) {
            let kidd = e.target.value;
            parents = $("input[name=spouse]:checked").val();
            getCost(kidd,parents);

        });

        function getCost(kidd, parents)
        {
            let ppyall = 0;
            if($('input[name="payall"]:checked').val() == 0){
                ppyall = 1;
            } else {
                ppyall = 0;
            }
            console.log(kidd, parents);
            $.ajax({
                // type: 'GET',
                url: "{{ route('packageType',$data->id)  }}",
                data: {kid : kidd, parents: parents , response : 1 }, 
                success: function (data) {
                    let vallu = (data.first_payment_sub_total*1.2995)-(data.first_payment_sub_total);
                    let thisVat = data.first_payment_sub_total*0.05;
                    let thisTotal = parseFloat(data.first_payment_sub_total) + parseFloat(thisVat);

                    let fullVallu = (data.sub_total*1.2995)-(data.sub_total);
                    let fullVat = data.sub_total*0.05;
                    let fullTotal = parseFloat(data.sub_total) + parseFloat(fullVat);


                    if(ppyall == 0)
                    {
                        $('#amountLink2').val(parseFloat(thisTotal).toLocaleString());
                        $('#amountLink').text(parseFloat(thisTotal).toLocaleString());
                        $('#totaldue').val(parseFloat(thisTotal).toLocaleString());
                        $('#thispay').text(parseFloat(data.first_payment_sub_total).toLocaleString());
                        $('#transAmount').text(parseFloat(thisTotal).toLocaleString());
                        $('#invoiceAmount').val(parseFloat(thisTotal).toLocaleString());

                        $('#thissave').text(parseFloat(vallu).toLocaleString());
                        // $('.hiddenFamAmount').val(data.first_payment_sub_total);
                    } else {
                        $('#amountLink2').val(parseFloat(fullTotal).toLocaleString());
                        $('#amountLink').text(parseFloat(fullTotal).toLocaleString());
                        $('#totaldue').val(parseFloat(fullTotal).toLocaleString());
                        $('#thispay').text(parseFloat(data.sub_total).toLocaleString());
                        $('#transAmount').text(parseFloat(fullTotal).toLocaleString());
                        $('#invoiceAmount').val(parseFloat(fullTotal).toLocaleString());

                        $('#thissave').text(parseFloat(fullVallu).toLocaleString());
                    }
                    $('.fam_id').val(data.id);
                },
                error: function (error) {
                }
            });
        }
    });

    function saveSign() {
            var Signed = '{{is_object($pays) ? $pays->contract_1st_signature_status : null}}';
            var pays = '{{is_object($pays)}}';
            const dataURL = signaturePad.toDataURL();
            if (signaturePad.isEmpty() && (pays != 1 && Signed != "SIGNED")) {
                // toastr.error("Please provide a signature.");
            } else {
                $('.dataUrl').val(dataURL);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('upload_signature') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        signed: dataURL,
                        payall: '{{ $payall }}',
                        response: 1
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status) {
                            toastr.success("Signature updated successfully!");

                            $('.contract-signature').hide();
                            //  location.href = "{{ url('payment_form') }}/" + '{{ $data->id }}';
                        } else {
                            // toastr.error("Something went wrong!");
                        }

                    },
                    error: function(error) {}
                });
            }

    }
</script>
