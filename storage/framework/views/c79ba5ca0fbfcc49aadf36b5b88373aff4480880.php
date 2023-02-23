
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/payment-form.css')); ?>" rel="stylesheet">

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-12">
            <div class="bankInfo">
                <h5 style="color:red">Our consultants do NOT accept cash payments- the only acceptable method of payment is bank transfer or deposit with below details :</h5>
            </div>
            <div class="bank-tranfer">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="heading">
                            <div class="first-heading" style="text-align: center">
                                <h3>
                                    New Payment
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="row bankDetails">
                                    <div class="adcb">
                                        <ul>
                                            <li class="bankLogo"><img src="<?php echo e(asset('images/ADCB-Logo.jpg')); ?>" alt="PWG ADCB LOGO" width="100%"></li>
                                            <li><h6>Bank Name: ADCB Bank</h6></li>
                                            <li><h6>Branch: BusinessBay Branch</h6></li>
                                            <li><h6>Account Number: 11977082920001</h6></li>
                                            <li><h6>IBAN: AE500030011977082920001</h6></li>
                                            <li><h6>Swift Code: ADCBAEAA</h6></li>
                                        </ul>
                                    </div>
                                    <div class="eis">
                                        <ul>
                                            <li class="bankLogo"><img src="<?php echo e(asset('images/emirates_islamic.jpg')); ?>" alt="PWG ADCB LOGO" width="100%"></li>
                                            <li><h6>Bank Name: Emirates Islamic Bank</h6></li>
                                            <li><h6>Branch: Dubai Mall Branch</h6></li>    
                                            <li><h6>Account Number: 3708431539301</h6></li>
                                            <li><h6>IBAN: AE780340003708431539301</h6></li>
                                            <li><h6>Swift Code: MEBLAEAD</h6></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3 dob">
                                                <select class="form-select form-control bank" name="bank" id="bank" placeholder="Destination / Bank*" >
                                                    <option selected disabled>Destination / Bank* (where you deposited money )</option>
                                                    <option value="1">Emirates Islamic Bank</option>
                                                    <option value="2" selected>ADCB Bank</option>
                                                </select>
                                                <label for="bank">Destination / Bank*</label>
                                                <?php if($errors->has('bank')): ?>
                                                    <span class="error"><?php echo e($errors->first('bank')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" name="datepayment" class="form-control datepayment" placeholder="Date of Payment*" <?php if(isset($client['payment_date'])): ?> value="<?php echo e($client['payment_date']); ?>" <?php else: ?> value="<?php echo e(old('payment_date')); ?>" <?php endif; ?> id="payment_date" autocomplete="off" />
                                                <label for="datepayment">Date of payment*</label>
                                                <?php if($errors->has('datepayment')): ?>
                                                    <span class="error"><?php echo e($errors->first('datepayment')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" name="your_reference" class="form-control your_reference" id="floatingInput" placeholder="Your Reference*" value="" autocomplete="off"/>
                                                <label for="floatingInput">Your Reference*</label>
                                                <?php if($errors->has('your_reference')): ?>
                                                    <span class="error"><?php echo e($errors->first('your_reference')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" name="bank_reference" class="form-control bank_reference" id="floatingInput" placeholder="Bank Reference Number*" value="" autocomplete="off"/>
                                                <label for="floatingInput">Bank Reference No:*</label>
                                                <?php if($errors->has('bank_reference')): ?>
                                                    <span class="error"><?php echo e($errors->first('bank_reference')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <input type="number" name="amount_deposited" pattern="[0-9]+" class="form-control amount_deposited" id="floatingInput" placeholder="Amount Deposited*" value="" autocomplete="off"/>
                                                <label for="floatingInput">Amount Deposited*</label>
                                                <?php if($errors->has('amount_deposited')): ?>
                                                    <span class="error"><?php echo e($errors->first('amount_deposited')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <select class="form-select form-control type_payment" name="type_payment" id="type_payment" placeholder="Type of payment*" >
                                                    <option selected disabled>Type of payment*</option>
                                                    <option value="2">Bank Transfer</option>
                                                    <option value="3">Bank Deposit</option>
                                                </select>
                                                <label for="type_payment">Type of payment*</label>
                                            </div>
                                            <?php if($errors->has('type_payment')): ?>
                                                <span class="error"><?php echo e($errors->first('type_payment')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>  
                    <div class="row">
                        <div class="recieptUpload">
                            <div class='file file--uploading'>
                                <label for='input-file'>
                                    <div class="recieptUploadImage"><img src="<?php echo e(asset('images/receiptupload.png')); ?>" alt="PWG Receipt" width="100%"></div>
                                </label>
                                <h6 style="text-align: center">Please upload receipt</h6>
                                <input id='input-file' type='file' />
                            </div>
                        </div>
                    </div>
                    <button type="cancel" class="btn cancelBtn" style="float: left;">Cancel</button>

                    <button type="submit" class="btn btn-primary submitBtn" style="float: right;">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.adcb').hide();
            $('.eis').hide();
            $('.datepayment').datepicker({
                dateFormat : "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                constrainInput: false     
            });
            if($('#bank').val() == 2){
                $('.adcb').show();
                $('.eis').hide();
            }
            
            $('#bank').on("change", function () {
                if($('#bank').val() == 2){
                    $('.adcb').show();
                    $('.eis').hide();
                }
                if($('#bank').val() == 1){
                    $('.eis').show();
                    $('.adcb').hide();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/bank-transfer.blade.php ENDPATH**/ ?>