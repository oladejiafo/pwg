

<style>
    @media (min-width: 375px) and (max-width: 768px)
    {
        .btn {
            margin: 0 0 0 0px;
            padding: 0;
            width:100%;
            align-self: center;
        }

        .network-partner {
            padding: 20px !important;
            margin-top: 170px !important;
        }

        .network-partner .reset-heading {
            font-size: 20px;
        } 

        .network-partner .reset-title {
            font-size: 18px;
        }
    }

    .network-partner {
        width: 80%;
        max-width: 100%;
        margin: 0 auto;
        padding: 70px 100px 70px 100px;
        background-color: #ffffff;
        margin-top: 100px;
        color: #636466;
        align-content: center;
        /* height: 90%; */
        padding-top: 30px;
    }

    .network-partner .reset-title{
        margin-bottom: 20px;
    }

    .network-partner .reset{
        margin-top: 10px
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="network-partner">
            <div class="reset">
                <div class="resetImage">
                    <img src="<?php echo e(asset('images/icon2.png')); ?>" alt="forgot password pwg">
                </div>
                <div class="reset-heading">
                    Want to be network partner
                </div>
                <div class="reset-title">
                    <p>Please provide the details</p>
                </div>
                <div class="form-sec">
                    <form method="POST" action="<?php echo e(route('add.network.partner')); ?>">
                        <?php echo csrf_field(); ?>
                        <p><b>Partner's Details</b></p>
                        <div class="form-group row">
                            <div class="form-floating col-sm-12">
                                <input type="text"  name="partner_code" class="form-control partner_code" id="floatingInput" placeholder="Partner Code" value="<?php echo e(($data)? $data->partner_code: old('partner_code')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Partner Code*</label>
                                <?php $__errorArgs = ['partner_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row mb-2 mt-4">
                                <input type="hidden" readonly name="partner_type" class="form-control partner_type" id="floatingInput" placeholder="Partner Type" value="Network" autocomplete="off"/>

                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text" name="partner_name" class="form-control partner_name" id="floatingInput" placeholder="Partner Name*" value="<?php echo e(($data)? $data->partner_name : old('partner_name')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Partner Name*</label>
                                <?php $__errorArgs = ['partner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <select class="form-select form-control payment_type" name="payment_type" id="payment_type" placeholder="Payment Type*" value="<?php echo e(old('payment_type')); ?>">
                                    <option selected disabled>Please select payment type</option>
                                    <option <?php echo e(($data)? (($data->payment_method == "Cash")? 'selected' : '') : ''); ?>  value="Cash">Cash</option>
                                    <option <?php echo e(($data)? (($data->payment_method == "Bank Payment")? 'selected' : '') : ''); ?> value="Bank Payment">Bank Payment</option>
                                </select>
                                <label for="payment_type">Payment Type*</label>
                                <?php $__errorArgs = ['payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row mt-4 mb-4 bankDetails">
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_name" class="form-control bank_name" id="floatingInput" placeholder="Bank Name*" value="<?php echo e(($data)?(($data->bank_name == "Bank Payment") ? $data->bank_name : old('bank_iban_number')) :old('bank_name')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Bank Name*</label>
                                <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_iban_number" class="form-control bank_iban_number" id="floatingInput" placeholder="Bank IBAN Number*" value="<?php echo e(($data) ?( ($data->payment_method == "Bank Payment") ? $data->bank_iban_number : old('bank_iban_number')) : old('bank_iban_number')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Bank IBAN Number*</label>
                                <?php $__errorArgs = ['bank_iban_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-floating col-sm-4 mt-3">
                                <input type="text" name="bank_swift_code" class="form-control bank_swift_code" id="floatingInput" placeholder="Bank SWIFT Code*" value="<?php echo e(($data) ?( ($data->payment_method == "Bank Payment") ? $data->bank_swift_code : old('bank_swift_code')) : old('bank_swift_code')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Bank SWIFT Code*</label>
                                <?php $__errorArgs = ['bank_swift_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <p><b>Contact Details</b></p>
                        <div class="form-group row">
                            <div class="form-floating col-sm-6 mt-1">
                                <input type="text" name="partner_location" class="form-control partner_location" id="floatingInput" placeholder="Location*" value="<?php echo e(($data) ? $data->partner_location : old('partner_location')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Location*</label>
                                <?php $__errorArgs = ['partner_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-floating col-sm-6 mt-1">
                                <input type="text"  name="partner_phone_number" class="form-control partner_phone_number" id="floatingInput" placeholder="Contact Number*" value="<?php echo e(($data)? $data->partner_phone_number : old('partner_phone_number')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Contact Number*</label>
                                <?php $__errorArgs = ['partner_phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="email" name="partner_email" class="form-control partner_email" id="floatingInput" placeholder="Email" value="<?php echo e(($data)? $data->partner_email : old('partner_email')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Email</label>
                                <?php $__errorArgs = ['partner_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-floating col-sm-6 mt-3">
                                <input type="text"  name="partner_address" class="form-control partner_address" id="floatingInput" placeholder="Address" value="<?php echo e(($data)? $data->partner_address : old('partner_address')); ?>" autocomplete="off"/>
                                <label for="floatingInput"> Address</label>
                                <?php $__errorArgs = ['partner_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <button <?php if($data): ?> disabled <?php else: ?> type="submit"<?php endif; ?> class="btn btn-primary"><?php if($data): ?> Already Partner <?php else: ?> Continue <?php endif; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('.bankDetails').hide();

        $('#payment_type').on('change', function(){
            if($('#payment_type').val() == 'Bank Payment'){
                $('.bankDetails').show();

            } else {
                $('.bankDetails').hide();
            }
        })
        var paymentType = "<?php echo e(($data)? $data->payment_method : NULL); ?>";
        if(paymentType == 'Bank Payment'){
            $('.bankDetails').show();
        } else {
            $('.bankDetails').hide();
        }
    });
    
</script>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/network/partner.blade.php ENDPATH**/ ?>