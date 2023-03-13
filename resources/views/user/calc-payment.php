<?php
    if(Session::has('payall'))
    {
        $payall = Session::get('payall');
    } elseif(isset($_REQUEST['payall'])) {
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
$outsub= $pays ? $pays->submission_payment_remaining : 0;
if ($payall == 0 || empty($payall)) {
    if (!isset($pays) || ($pays->first_payment_status != 'PAID' || $pays->first_payment_status == null)) {
        //    && (isset($paym->transaction_mode) && $paym->transaction_mode != "TRANSFER" && ($paym->payment_type !="FIRST" || $paym->payment_type != "BALANCE_ON_FIRST"))
        $whichPayment = 'FIRST';
        $outsub = 0;
        $outsec = 0;

        $payNow = $pdet->first_payment_sub_total;
        // if($diff > 0 || $pays->first_payment_price > $pays->first_payment_paid) {
        // if ($diff > 0 || (isset($pays) && $pays->first_payment_remaining > 0)) {
        if(isset($pays) &&  $pays->first_payment_paid > 0){
            $pendMsg = 'You have ' . $pends . ' balance on first payment.';
            $payNoww = $pends;
            $whichPayment = 'BALANCE_ON_FIRST';
        } else {
            $pendMsg = '';
            $payNoww = $pdet->first_payment_sub_total;
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status != 'PAID' && $pdet->submission_payment_sub_total>0) {
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
                $payNoww = $pdet->submission_payment_sub_total;
                $pendMsg = '';
            }
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0 && $pdet->submission_payment_sub_total>0) {
        $outsub = $pays->submission_payment_price - $pays->submission_payment_paid;
        $outsec = 0;

        $pendMsg = 'You have ' . $outsub . ' balance on submission payment.';
        $payNow = $outsub; //$pdet->submission_payment_sub_total;
        $payNoww = $outsub;
        $whichPayment = 'SUBMISSION';
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && empty($pdet->submission_payment_sub_total)) {
        $outsec = $pays->second_payment_price - $pays->second_payment_paid;
        $outsub = 0;

        $whichPayment = 'SECOND';
        if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
            $vat_2 = $pays->second_payment_remaining * (5 / 100);
            $pendMsg = 'You have ' . ($pays->second_payment_remaining) . ' balance on second payment.';
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
    } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status != 'PAID' && $pdet->second_payment_sub_total>0) {
        $outsec = $pays->second_payment_price - $pays->second_payment_paid;
        $outsub = 0;

        $whichPayment = 'SECOND';
        if ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') {
            $vat_2 = $pays->second_payment_remaining * (5 / 100);
            $pendMsg = 'You have ' . ($pays->second_payment_remaining) . ' balance on second payment.';
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
    } elseif (isset($pays) && $pays->submission_payment_status == 'PAID' && $pays->second_payment_status == 'PAID' && $outsec > 0 && $pdet->second_payment_sub_total>0) {
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
    if(!isset($pays)){
        $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
        $payNoww = $payNow;
        $pendMsg = 'Full Payment';
        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
            $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

            // $discountPercent = '5%';
            // $discount = ($payNow * 5 / 100);
            $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
        }
        $whichPayment = 'Full-Outstanding Payment';
    }elseif (isset($pays) && $pays->first_payment_status == 'PENDING' && ($pays->submission_payment_status == 'PENDING') & ($pays->second_payment_status == 'PENDING')) {
        $payNow = $pdet->sub_total - $pdet->third_payment_sub_total;
        $payNoww = $payNow;
        $pendMsg = 'Full Payment';
        if ($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0) {
            $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

            // $discountPercent = '5%';
            // $discount = ($payNow * 5 / 100);
            $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
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
                $discountPercent = ($data->full_payment_discount) ? $data->full_payment_discount . '%' : 0;

                $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount) / 100 : 0; //product discount fetch
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
    } elseif(isset($pays) && $pays->first_payment_status =="PAID"){
        if ($pdet->second_payment_price != null || $pdet->second_payment_price != 0) {

            if($pays->submission_payment_status =="PENDING"){
                $payNow = $pdet->submission_payment_sub_total + $pdet->second_payment_sub_total;
                $payNoww = $payNow;
                if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                    $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                    $discount = ($data->full_payment_discount > 0) ? ($payNow * $data->full_payment_discount / 100) : 0;
                }
            } else if($pays->submission_payment_status =="PARTIALLY_PAID") {
                $payNow = $pdet->second_payment_sub_total;
                $payNoww = $pays->submission_payment_remaining + $payNow;
                if($pdet->submission_payment_sub_total > 0 || $pdet->second_payment_sub_total > 0){
                    $discountPercent =  ($data->full_payment_discount) ? $data->full_payment_discount.'%' : 0;
                    $discount = ($data->full_payment_discount > 0) ? ($pdet->second_payment_sub_total * $data->full_payment_discount / 100) : 0;
                }
            }
            $pendMsg = "Full Outstanding Payment";
            $whichPayment = 'Full-Outstanding Payment';
        } else {
            $payNow = $pdet->submission_payment_sub_total;
            $payNoww = $payNow;
            $pendMsg = '';
            $discountPercent = '';
            $discount = 0;
            $whichPayment = 'SUBMISSION';
        }

    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && ($pays->second_payment_status =="PENDING" || $pays->second_payment_status == 'PARTIALLY_PAID' )) {
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
// echo $payall= $_COOKIE['payallx'];
?>

<hr style="border: 2px solid #ccc;margin:0">
                            <div id='card-payment'>
                                @include('user.card-payment')
                            </div>
                            <div id='bank-payment'>
                                @include('user.bank-payment')
                            </div>