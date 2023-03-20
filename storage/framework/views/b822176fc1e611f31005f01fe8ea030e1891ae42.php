<?php
if (Session::has('payall')) {
    $payall = Session::get('payall');
} elseif (isset($_REQUEST['payall'])) {
    $payall = $_REQUEST['payall'];
} else {
    $payall = $payall;
}

// Session::forget('payall');
?>
<?php if(session()->has('myDiscount') && session()->has('haveCoupon') && session()->get('haveCoupon') == 1): ?>
    <?php
        $promo = session()->get('myDiscount');
    ?>
<?php else: ?>
    <?php
        $promo = 0;
    ?>
<?php endif; ?>

<?php if(isset($pdet)): ?>
    <?php
        
        $first_pay = $pdet->first_payment_sub_total;
        $second_pay = $pdet->submission_payment_sub_total;
        $third_pay = $pdet->second_payment_sub_total;
        
        $tot_pay = $first_pay + $second_pay + $third_pay;
    ?>
<?php else: ?>
    <?php
        $first_pay = 0;
        $second_pay = 0;
        $third_pay = 0;
        
        $tot_pay = 0;
    ?>
<?php endif; ?>

<?php
    $diff = $pays ? $pays->first_payment_remaining : 0; //$pays->first_payment_price - $pays->first_payment_paid
?>

<?php if($diff > 0): ?>
    <?php
        $pends = $pays ? $pays->first_payment_remaining : 0;
    ?>
<?php elseif($diff < 0): ?>
    <?php
        $pends = $pays ? $pays->first_payment_paid - $pays->first_payment_sub_total : 0;
    ?>
<?php else: ?>
    <?php
        $pends = 0;
    ?>
<?php endif; ?>


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

        if (isset($pays) && $pays->first_payment_paid > 0 && $pays->first_payment_remaining > 0) {
           $pendMsg = 'You have ' . $pends . ' balance on first payment.';
            $payNoww = $pends;
            $payNow = $pends;
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
                $payNoww = $pdet->submission_payment_sub_total;
                $pendMsg = '';
            }
        }
    } elseif (isset($pays) && $pays->first_payment_status == 'PAID' && $pays->submission_payment_status == 'PAID' && $outsub > 0 && $pdet->submission_payment_sub_total > 0) {
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

$payall;
$vat = (($payNow - $discount) * 5) / 100;

// die();
if (isset($pays) && (($pays->first_payment_remaining > 0 && $pays->first_payment_status == 'PARTIALLY_PAID') || ($pays->second_payment_remaining > 0 && $pays->second_payment_status == 'PARTIALLY_PAID') || ($pays->submission_payment_remaining > 0 && $pays->submission_payment_status == 'PARTIALLY_PAID')))
{
    $totalPay = round($payNoww, 2);
} else {

    $totalPay = round($payNow - $discount + $vat, 2);
} 
?>

<div class="container">
    <div class="col-12">

        <div class="bank-tranfer">
            <form action="<?php echo e(route('submit.bank.transfer')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="productId" value="<?php echo e($pdet->destination_id); ?>">
                <div class="row">
                    <div class="heading">
                        <div class="first-heading" style="text-align: center">
                            <p style="font-size: 14px">Proceed to your bank APP to complete this payment and upload your proof of payment.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h5>Bank Details:</h5>
                            <div class="row bankDetails">
                                <div class="col-12 adcb">
                                    <p class="flash"><i class="fa fa-warning"></i> <b>Pay directly to the bank account provided below, do not give cash to anyone or pay to another account!</b></p>
                                    <ul>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">Bank Name:</div>
                                                <div style="width: 50%;display:inline-block"><b>ADCB Bank</b></div>
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">Branch:</div>
                                                <div style="width: 50%;display:inline-block">BusinessBay Branch</div>
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">Account Name:</div>
                                                <div style="width: 50%;display:inline-block">PWG Visa Services LLC</div>
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">Account Number:</div>
                                                <div style="width: 50%;display:inline-block">11977082920001</div>
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">IBAN:</div>
                                                <div style="width: 50%;display:inline-block">AE500030011977082920001
                                                </div>
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <div style="width: 40%;display:inline-block">Swift Code:</div>
                                                <div style="width: 50%;display:inline-block">ADCBAEAA</div>
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12">

                                    <div class="form-group row mt-4">
                                        <div class="form-floating mt-3" align="left">
                                            AMOUNT TO PAY: <b style="font-size: 18px"><span id="transAmount">
                                                    <?php if(isset($totalPay)): ?>
                                                        <?php echo e(number_format($totalPay, 2)); ?>

                                                    <?php endif; ?>
                                                </span></b> <b>AED</b>
                                            <input type="hidden" name="invoice_amount" id="invoiceAmount"
                                                value="<?php echo e($totalPay); ?>" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="bank" class="form-select form-control bank"
                                        value="2">

                                    <input name="type_payment" value="TRANSFER" type="hidden" />
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h5 align="center">Upload Receipt:</h5>
                            <div class="previewImage">
                                <img id="output" width="100%" style="max-height: 240px;" />
                            </div>
                            <div class="recieptUpload">
                                <div class='file file--uploading'>
                                    <label for='input-file'>
                                        <div class="recieptUploadImage"><img
                                                src="<?php echo e(asset('images/receiptupload.png')); ?>" alt="PWG Receipt"
                                                width="100%"></div>
                                    </label>
                                    <h6 style="text-align: center"><span style="color:aqua">Browse to upload</span></h6>
                                    <input id='input-file' name="imgInp" accept="image/*" type='file' id="imgInp"
                                        onchange="changeImage(event)" />
                                    <?php if($errors->has('imgInp')): ?>
                                        <span class="error">Please upload receipt</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div align="center" style="text-align: center;margin:20px auto;color:#ccc;">Supported
                                formats: PDF, JPG, PNG</div>
                        </div>
                        

                    </div>
                </div>
                <div class="row" style="height:40px">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-4">
                        <a href="<?php echo e(url()->previous()); ?>"><button type="cancel" class="cancelBtn btnx"
                                style="float: left;">Cancel</button></a>
                    </div>
                    <div class="col-4">
                        <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                        <input type="hidden" name="ppid" value="<?php echo e(isset($pdet->id) ? $pdet->id : ''); ?>">
                        <input type="hidden" name="uid" value="<?php echo e(Auth::user()->id); ?>">
                        <input type="hidden" name="packageType" value="<?php echo e($pdet->pricing_plan_type); ?>">
                        <input type="hidden" name="whichpayment"
                            value="<?php echo e($whichPayment ? $whichPayment : 'FIRST'); ?>">
                        <input type="hidden" name="first_p" value="<?php echo e($pdet->first_payment_sub_total); ?>">
                        <input type="hidden" name="second_p" value="<?php echo e($pdet->submission_payment_sub_total); ?>">
                        <input type="hidden" name="third_p" value="<?php echo e($pdet->second_payment_sub_total); ?>">
                    </div>
                    <div class="col-4">
                        <button type="submit" onclick="saveSign()" class="btn btn-primary submitBtn"
                            style="float: right;">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // $('.datepayment').datepicker({
            //     dateFormat : "yy-mm-dd",
            //     changeMonth: true,
            //     changeYear: true,
            //     constrainInput: false     
            // });

            $('#partial').click(function() {

                $.ajax({
                    url: '<?php echo e(route('payType')); ?> ',
                    method: 'POST',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        "payall": 0
                    },
                    success: function(data) {

                        $("#bank-payment").load(window.location.href + " #bank-payment > *");
                        $('#bank-payment').hide();

                        if ($('input[name="payoption"]:checked').val() == "Transfer" || $(
                                'input[name="payoption"]:checked').val() == "Deposit") {
                            $('#bank-payment').show();
                            $('#card-payment').hide();
                        } else {
                            $('#bank-payment').hide();
                            $('#card-payment').show();
                        }

                    }

                });
            });

            $('#full').click(function() {

                // throw new Error();
                $.ajax({
                    url: '<?php echo e(route('payType')); ?> ',
                    method: 'POST',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        "payall": 1
                    },
                    success: function(data) {

                        console.log($("#bank-payment").load(window.location.href + " #bank-payment > *"));

                        if ($('input[name="payoption"]:checked').val() == "Transfer" || $(
                                'input[name="payoption"]:checked').val() == "Deposit") {

                            $('#paymain #bank-payment').show();
                            $('#card-payment').hide();
                        } else {
                            $('#bank-payment').hide();
                            $('#card-payment').show();
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
                // alert($('input[name="payall"]:checked').val());
                if($('input[name="payall"]:checked').val() == 0){
                    ppyall = 1;
                } else {
                    ppyall = 0;
                }
                // alert(ppyall);
                $.ajax({
                    // type: 'GET',
                    url: "<?php echo e(route('packageType',$data->id)); ?>",
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
    </script>
    <script language="javascript" type="text/javascript">
        changeImage = (evt) => {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>


    <script>
        function saveSign() {
            var Signed = '<?php echo e(is_object($pays) ? $pays->contract_1st_signature_status : null); ?>';
            var pays = '<?php echo e(is_object($pays)); ?>';
            if (signaturePad.isEmpty() && (pays != 1 && Signed != "SIGNED")) {
                toastr.error("Please provide a signature.");
            } else {
                const dataURL = signaturePad.toDataURL();

                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(url('upload_signature')); ?>",
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        signed: dataURL,
                        payall: '<?php echo e($payall); ?>',
                        response: 1
                    },
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            // toastr.success("Signature updated successfully!");

                            $('.contract-signature').hide();
                            //  location.href = "<?php echo e(url('payment_form')); ?>/" + '<?php echo e($data->id); ?>';
                        } else {
                            alert('Something went wrong');
                        }

                    },
                    error: function(error) {}
                });
            }

        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/bank-payment.blade.php ENDPATH**/ ?>