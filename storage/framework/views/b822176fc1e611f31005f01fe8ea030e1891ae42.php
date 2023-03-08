
    <div class="container">
        <div class="col-12">
            
            <div class="bank-tranfer">
                <form action="<?php echo e(route('submit.bank.transfer')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <input type="hidden" name="productId" value="<?php echo e($pdet->destination_id); ?>">
                    <div class="row">
                        <div class="heading">
                            <div class="first-heading" style="text-align: center">
                                <p>Proceed to your bank APP to complete this payment and upload your proof of payment.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5>Bank Details:</h5>
                                <div class="row bankDetails">
                                    <div class="col-12 adcb">
                                        
                                        <ul>
                                            <li><h6>Bank Name:&emsp; <b>ADCB Bank</b></h6></li>
                                            <li><h6>Branch:&emsp; BusinessBay Branch</h6></li>
                                            <li><h6>Account Name:&ensp;	PWG Visa Services LLC</h6></li>
                                            <li><h6>Account Number:&ensp; 11977082920001</h6></li>
                                            <li><h6>IBAN:&emsp; AE500030011977082920001</h6></li>
                                            <li><h6>Swift Code:&emsp; ADCBAEAA</h6></li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3" align="left">
                                                AMOUNT TO PAY:  <b style="font-size: 18px"> <?php if(isset($totalPay)): ?><?php echo e(number_format($totalPay,2)); ?><?php endif; ?> </b> <b>AED</b>
                                                <input type="hidden" name="invoice_amount" value="<?php echo e($totalPay); ?>"/>
                                            </div>
                                        </div>
                                        <input type="hidden" name="bank" class="form-select form-control bank" value="2">
                                            
                                        
                                        <input name="type_payment" value="TRANSFER" type="hidden" />
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5 align="center">Upload Receipt:</h5>
                                <div class="recieptUpload">
                                    <div class='file file--uploading'>
                                        <label for='input-file'>
                                            <div class="recieptUploadImage"><img src="<?php echo e(asset('images/receiptupload.png')); ?>" alt="PWG Receipt" width="100%"></div>
                                        </label>
                                        <h6 style="text-align: center"><span style="color:aqua">Browse to upload</span></h6>
                                        <input id='input-file' name="imgInp" accept="image/*" type='file' id="imgInp" onchange="changeImage(event)"/>
                                        <?php if($errors->has('imgInp')): ?>
                                        <span class="error">Please upload receipt</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div align="center" style="text-align: center;margin:20px auto;color:#ccc;">Supported formats: PDF, JPG, PNG</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5 align="center">Preview:</h5>
                                <div class="previewImage">
                                    <img id="output" width="100%"/>
                                </div>
                            </div>
                            
                        </div>
                    </div>  
                    <div class="row" style="height:40px">
                        &nbsp;
                    </div> 
                    <div class="row">
                        <div class="col-4">
                            <a href="<?php echo e(url()->previous()); ?>"><button type="cancel" class="cancelBtn btnx" style="float: left;">Cancel</button></a>
                        </div>
                        <div class="col-4">
                            <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                            <input type="hidden" name="ppid" value="<?php echo e(isset($pdet->id) ? $pdet->id : ''); ?>">
                            <input type="hidden" name="uid" value="<?php echo e(Auth::user()->id); ?>">
                            <input type="hidden" name="packageType" value="<?php echo e($pdet->pricing_plan_type); ?>">
                            <input type="hidden" name="whichpayment" value="<?php echo e($whichPayment ? $whichPayment : 'FIRST'); ?>">
                            <input type="hidden" name="first_p" value="<?php echo e($pdet->first_payment_sub_total); ?>">
                            <input type="hidden" name="second_p" value="<?php echo e($pdet->submission_payment_sub_total); ?>">
                            <input type="hidden" name="third_p" value="<?php echo e($pdet->second_payment_sub_total); ?>">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary submitBtn" style="float: right;">Submit</button>
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
<?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/user/bank-payment.blade.php ENDPATH**/ ?>