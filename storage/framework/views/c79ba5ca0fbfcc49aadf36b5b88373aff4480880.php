
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/payment-form.css')); ?>" rel="stylesheet">

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-12">
            <div class="bankInfo">
                <h5 style="color:red">Our consultants do NOT accept cash payments- the only acceptable method of payment is bank transfer or deposit with below details :</h5>
            </div>
            <div class="bank-tranfer">
                <form action="<?php echo e(route('submit.bank.transfer')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name='paymentId' value="<?php echo e($paymentId); ?>">
                    <input type="hidden" name="productId" value="<?php echo e($productId); ?>">
                    <div class="row">
                        <div class="heading">
                            <div class="first-heading" style="text-align: center">
                                <h3>
                                    Bank Payment
                                </h3>
                                <p>Proceed to your bank APP to complete this payment and upload your proof of payment.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="row bankDetails">
                                    <div class="adcb">
                                        <ul>
                                            <li><h6>Bank Name: ADCB Bank</h6></li>
                                            <li><h6>Branch: BusinessBay Branch</h6></li>
                                            <li><h6>Account Name :	PWG Visa Services LLC</h6></li>
                                            <li><h6>Account Number: 11977082920001</h6></li>
                                            <li><h6>IBAN: AE500030011977082920001</h6></li>
                                            <li><h6>Swift Code: ADCBAEAA</h6></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3 dob">
                                                <input type="text" name="bank_reference" class="form-control bank_reference" id="floatingInput" placeholder="Bank Reference Number*" value="" autocomplete="off"/>
                                                <label for="floatingInput">Bank/Payment Reference No:*</label>
                                                <?php if($errors->has('bank_reference')): ?>
                                                    <span class="error"><?php echo e($errors->first('bank_reference')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="bank" class="form-select form-control bank" value="2">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3" align="left">
                                                AMOUNT TO PAY: <b>AED</b> <b style="font-size: 18px"> <?php if(isset($thisPaymentMade)): ?><?php echo e(number_format($thisPaymentMade,2)); ?><?php endif; ?> </b>
                                                <input type="hidden" name="invoice_amount" value="<?php echo e($thisPaymentMade); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" name="your_reference" class="form-control your_reference" id="floatingInput" placeholder="Your Reference*" value="" autocomplete="off"/>
                                                <label for="floatingInput">Depositor Name</label>
                                                <?php if($errors->has('your_reference')): ?>
                                                    <span class="error"><?php echo e($errors->first('your_reference')); ?></span>
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
                                <input name="type_payment" value="TRANSFER" type="hidden" />
                                
                                    
                                    
                                
                            </div>
                            
                        </div>
                    </div>  
                    <div class="row">
                        <div class="recieptUpload">
                            <div class='file file--uploading'>
                                <label for='input-file'>
                                    <div class="recieptUploadImage"><img src="<?php echo e(asset('images/receiptupload.png')); ?>" alt="PWG Receipt" width="100%"></div>
                                </label>
                                <h6 style="text-align: center">Please upload receipt/proof of payment</h6>
                                <input id='input-file' name="imgInp" accept="image/*" type='file' id="imgInp" onchange="changeImage(event)"/>
                                <?php if($errors->has('imgInp')): ?>
                                                <span class="error">Please upload receipt</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="previewImage">
                            <img id="output" width="100%"/>
                        </div>
                    </div>
                    <a href="<?php echo e(route('myapplication')); ?>"><buttons type="cancel" class="cancelBtn xbtn" style="float: left;">Cancel</buttons></a>
                    
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
            $('.datepayment').datepicker({
                dateFormat : "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                constrainInput: false     
            });
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
<?php $__env->stopPush(); ?>


<?php if(!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)): ?> 
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
<?php endif; ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/bank-transfer.blade.php ENDPATH**/ ?>