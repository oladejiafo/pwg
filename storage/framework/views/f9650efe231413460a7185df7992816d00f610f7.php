
      <div class="card tab-pane" id="clientTab" role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <img src="<?php echo e(asset('images/affiliate/head.png')); ?>" alt=""><br>
          <span style="color: #9d9e9f;padding:5px">Total Referred Clients</span> <br>
          <?php echo e($clients->count()); ?>

        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover" width="100%">
            <thead>
            <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
              <th scope="col" style="padding:5px; font-size:18px;">Client Name</th>
              <th scope="col" style="padding:5px; font-size:18px;">Product</th>
              <th scope="col" style="padding:5px; font-size:18px;text-align:right">Product Amount</th>
              <!-- <th style="padding:5px; font-size:18px;">Product ID</th> -->
              <th scope="col" style="padding:5px; font-size:18px;text-align:right">Commission</th>
              <th scope="col" style="padding:5px; font-size:18px;text-align:center">Payment Date</th>

              <th scope="col" style="padding:5px; font-size:18px;text-align:center">Status</th>
            </tr>
            </thead>

            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
          $reffered = DB::table('clients')
          ->where('id', '=', $client->client_id)
          ->get();
            $pays = DB::table('payments')
            ->where('application_id', '=', $client->id)
            ->where('payment_type', '=', 'First Payment')
            ->first();

            $prod = DB::table('pricing_plans')
            ->where('destination_id', '=', $client->destination_id)
            ->first();

            $comm = DB::table('commission')
            ->where('product_id', '=', $client->destination_id)
            ->first();

            list($product, $ot) = explode(' ', $prod->plan_name);
            ?>
            <?php $__currentLoopData = $reffered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reffer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $name = $reffer->name . ' ' . $reffer->sur_name;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tbody>
            <tr style="color: #9d9e9f;background-color: #fff;">
              <td style="padding:5px; font-size:15px;"><?php echo e($name); ?></td>
              <td style="padding:5px; font-size:15px;"><?php echo e($product); ?></td>
              <td style="padding:5px; font-size:15px;text-align:right"><?php echo e(number_format($prod->total_price,2)); ?> <span style="font-size:10px;">AED</span></td>
              <!-- <td style="padding:5px; font-size:15px;"></td> -->
              <td style="padding:5px; font-size:15px;text-align:right"><?php echo e(number_format($comm->client_commission,2)); ?> <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px; font-size:15px;text-align:center"><?php echo e($pays->payment_date); ?></td>

              <td style="padding:5px; font-size:15px;text-align:center"><?php echo e($client->first_payment_status); ?></td>
            </tr>
            </tbody>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </table>
        </div>
      </div>
<?php /**PATH C:\Users\shakun\Desktop\myGit\PWG\resources\views/affiliate/reffered-client.blade.php ENDPATH**/ ?>