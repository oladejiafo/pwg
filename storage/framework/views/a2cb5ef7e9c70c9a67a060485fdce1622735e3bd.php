<style>
    .card-body {
        padding-left:25%;
        padding-right: 25%;
    }
    .request {
        font-weight: bold;
        font-size: larger;
        margin: auto;
        background: #FFF;
        border-color: #000;
        height: 55px;
        width: 40%;
        border-radius: 0px;
    }

    .request:hover {
        background: #FACB08;
        border-color: #FACB08;
    }

    .submit{
        text-align: center;
    }
</style>

      <div class="card tab-pane" id="transferTab" role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <img src="<?php echo e(asset('images/affiliate/affiliate_withdraw.png')); ?>" alt=""><br>
          <h3><span style="color: #9d9e9f;padding:5px">Account Balance</span> </h3>
          <h4><?php echo e(number_format($mine->balance,2)); ?><span style="font-size:10px;">AED</span></h4>
        </div>
        <div class="card-body">
          
        <form action="<?php echo e(route('affiliate.process_transfer')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="formGroupamount" class="form-label">Amount to Transfer</label>
                <input type="hidden" name="myid" value="<?php echo e(Session::get('loginId')); ?>">
                <input type="text" name="amount" class="form-control" id="formGroupamount" placeholder="Amount to Transfer">
                <?php if($errors->has('amount')): ?>
                <span class="error" style="color:red;font-style:italic;font-size:small"><?php echo e($errors->first('amount')); ?></span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="formGroupname" class="form-label">Your Full Name</label>
                <input type="text" name="name" class="form-control" id="formGroupname" placeholder="Your Full Name" required="" <?php if(isset($acct->account_name)): ?> value="<?php echo e($acct->account_name); ?>" <?php else: ?> value="<?php echo e($mine->first_name .' '.$mine->surname); ?>" <?php endif; ?>>
                <?php if($errors->has('name')): ?>
                <span class="error" style="color:red;font-style:italic;font-size:small"><?php echo e($errors->first('name')); ?></span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="formGroupbank" class="form-label">Your Bank Name</label>
                <input type="text" name="bank" class="form-control" id="formGroupbank" placeholder="Your Bank Name" required="" <?php if(isset($acct->bank_name)): ?> value="<?php echo e($acct->bank_name); ?>" <?php endif; ?>>
                <?php if($errors->has('bank')): ?>
                <span class="error" style="color:red;font-style:italic;font-size:small"><?php echo e($errors->first('bank')); ?></span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="formGroupbankAddress" class="form-label">Bank Address</label>
                <input type="text" name="bankAddress" class="form-control" id="formGroupbankAddress" placeholder="Address of Your Bank" required="" <?php if(isset($acct->bank_address)): ?> value="<?php echo e($acct->bank_address); ?>" <?php endif; ?>>
            </div>
            <div class="mb-3">
                <label for="formGroupbankCountry" class="form-label">Bank Country</label>
                <input type="text" name="bankCountry" class="form-control" id="formGroupbankCountry" placeholder="Bank Country" required=""  <?php if(isset($acct->bank_country)): ?> value="<?php echo e($acct->bank_country); ?>" <?php else: ?> value="<?php echo e($mine->country_of_residence); ?>" <?php endif; ?>>
            </div>
            <div class="mb-3">
                <label for="formGroupaccountNumber" class="form-label">Bank Account Number (IBAN)</label>
                <input type="text" name="accountNumber" class="form-control" id="formGroupaccountNumber" placeholder="Bank Account Number (IBAN)" required="" <?php if(isset($acct->account_number_iban)): ?> value="<?php echo e($acct->account_number_iban); ?>" <?php endif; ?>>
                <?php if($errors->has('accountNumber')): ?>
                <span class="error" style="color:red;font-style:italic;font-size:small"><?php echo e($errors->first('accountNumber')); ?></span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="formGroupswiftCode" class="form-label">SWIFT Code</label>
                <input type="text" name="swiftCode" class="form-control" id="formGroupswiftCode" placeholder="Bank SWIFT Code" <?php if(isset($acct->swift_code)): ?> value="<?php echo e($acct->swift_code); ?>" <?php endif; ?>>
            </div>
            <div class="submit">
                <button type="submit" class="btn request">Request Transfer</button>
            </div>
        </form>
        </div>
      </div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/new-transfer.blade.php ENDPATH**/ ?>