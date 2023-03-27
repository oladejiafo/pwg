
    <style>
.card-bodyx {
        padding-left:5%;
        padding-right: 5%;
    }
    </style>
      <div class="card tab-pane" id="historyTab"  role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <span style="color: #9d9e9f;padding:5px">Trasfer History</span> 
        </div>
      
        <div class="card-bodyx table-responsive">
          <table class="table table-hover" width="100%">
            <thead>
            <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
              <th scope="col" style="padding:5px; ">Account Balance</th>
              <th scope="col" style="padding:5px;;">Bank Details</th>
              <th scope="col" style="padding:5px; text-align:right">IBAN</th>
              <th scope="col" style="padding:5px; text-align:right">Swift</th>
              <th scope="col" style="padding:5px; text-align:right">Transfered Amount</th>
              <th scope="col" style="padding:5px; text-align:center">Date</th>
              <th scope="col" style="padding:5px; text-align:left">Status</th>
            </tr>
            </thead>

            <?php
                $trans = DB::table('affiliate_transactions')
                ->where('affiliate_id', '=', $mine->id)
                ->orderBy('transaction_date', 'desc')
                ->get();
            ?>  

            <tbody>
            <?php $__currentLoopData = $trans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="color: #9d9e9f;background-color: #fff;">
              <td style="padding:5px;"><?php echo e($tran->balance); ?> <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px;"><?php echo e($tran->bank_name); ?></td>
              <td style="padding:5px;text-align:right"><?php echo e($tran->account_number); ?></td>
              <td style="padding:5px;text-align:right"><?php echo e($tran->swift_code); ?></td>
              <td style="padding:5px;text-align:right"><?php echo e(number_format($tran->amount,2)); ?> <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px;text-align:center"><?php echo e(date('d-m-Y', strtotime($tran->transaction_date))); ?></td>
              <td style="padding:5px;text-align:left">Paid</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          
          </table>
        </div>
      </div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/transfer-history.blade.php ENDPATH**/ ?>