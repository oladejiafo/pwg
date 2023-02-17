<!DOCTYPE html>

<html>

<?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- bootstrap core css -->
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="<?php echo e(asset('user/css/products.css')); ?>" rel="stylesheet">

<style>
  .se2 {
    width: 100% !important;
    background-color: #FFCD04 !important;
    border-style: none !important;
    margin-bottom: 5px !important;
  }

  .se2:hover {
    background-color: white !important;
    border-color: grey !important;
    border-style: solid !important;
  }

  .top{
    margin-block: 50px;
  }

  @media (max-width: 1024px) {
    .top{
      margin-block: 150px;
    } 
  }
</style>

<body>

  <?php if($promo->first()): ?>
  <?php $__currentLoopData = $promo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
  // $offer_discount= $data->prev_discount - $data->discount;

  if ($prom->discount_percent > 0) {
    $icon = 'fa fa-minus-circle';
    $offer_discount_msg = 'Promo Offer: ' . number_format($data->discount) . '% Off !';
    //}
    // else if($offer_discount < 0)
    // { 
    //   $icon = 'fa fa-plus-circle';
    //  $offer_discount_msg = number_format(($offer_discount*-1)) .'% higher than last month';
  } else {
    $icon = '';
    $offer_discount_msg = '';
  }

  ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <?php else: ?>
  <?php
  $icon = '';
  $offer_discount_msg = ''; ?>
  <?php endif; ?>

  <section class="product-section">
    <div class="container-fluid">
      <div class="row top" style="background-color:#fff; border-radius:10px">

        <!-- <p style="font-style: italics; text-decoration:none"><a href="/"><b><i>Packages </a> > <?php echo e($data->name); ?> </i></b></p> -->

        <div class="col-12 col-md-12 col-lg-6 img-fluid packageImage" style="margin-bottom: 0px;">
          <img src="../user/images/<?php echo e($data->image); ?>" style="border-radius:10px" width="100%" height="100%" border="0" alt="PWG Group" />
        </div>
        <div class="col-12 col-md-12 col-lg-6 text">
          <h1><?php echo e($data->name); ?></h1>
          <p class="subheading"><span><?php echo e($data->slogan); ?></span></p>
          <p><?php echo e($data->description); ?></p>
          <h2>
            <?php
             $totalCost = Session::get('totalCost');
               
              if (is_numeric($totalCost))
              {
                $totalCost = number_format($totalCost,2);
              } else {
                $totalCost = $totalCost;
              }
            ?> 
            <?php if(Session::get('totalCost') >0): ?>
             
               <?php echo e($totalCost); ?> 
            <?php else: ?>
            <?php echo e(number_format(($ppay->sub_total - $ppay->third_payment_sub_total),2)); ?>

            <?php endif; ?> 
            <span style="font-size:25px"><?php echo e($data->currency); ?> </span>
          </h2>

          <p class="subheading" style="margin-left: 0px;">
            <i class="<?php echo $icon; ?>"></i><i> <?php echo e($offer_discount_msg); ?> </i>
          </p><br>

          <?php if(Session::has('packageType')): ?>
            <?php
             $a = explode('_', strtolower(Session::get('packageType')));
             $ptype = ucFirst($a[0]). ' ' . ucFirst($a[1]);
            ?>
          <?php else: ?> 
             $ptype ='';  
          <?php endif; ?>

          <p>
         
          <h3><?php echo e($ptype); ?> Payment Installments</h3>
          <table border=0 style="border-radius:10px">
            <tr>
              <td align="left" class="pie" style="border-color:#fff;">
                <?php if($ppay->submission_payment_price > 0 || $ppay->second_payment_price > 0): ?>
                <img src="../user/images/progress_payment_1.svg" alt="PWG Group">
                <?php else: ?>
                <img src="../user/images/progress_payment_3.svg" alt="PWG Group">
                <?php endif; ?>
              </td>

              <?php if($ppay->submission_payment_price > 0): ?>
              <td align="center" class="line" style="border-color:#fff;">
                <img src="../user/images/progress_bar.svg" alt="PWG Group">
              </td>
              <td align="left" class="pie" style="border-color:#fff;">
                <?php if($ppay->submission_payment_price > 0 || $ppay->second_payment_price > 0): ?>
                <img src="../user/images/progress_payment_2.svg" alt="PWG Group">
                <?php else: ?>
                <img src="../user/images/progress_payment_3.svg" alt="PWG Group">
                <?php endif; ?>
              </td>
              <?php endif; ?>

              <?php if($ppay->second_payment_price > 0): ?>
              <td align="center" class="line" style="border-color:#fff;">
                <img src="../user/images/progress_bar.svg" alt="PWG Group">
              </td>
              <td align="left" class="pie" style="border-color:#fff;">
                <img src="../user/images/progress_payment_3.svg" alt="PWG Group">
              </td>
              <?php endif; ?>    
              <?php if($ppay->third_payment_price > 0): ?>
              <td align="center" class="line" style="border-color:#fff;">
                
              </td>
              <td align="left" class="pie" style="border-color:#fff;">
                <img src="../user/images/progress_payment_4.svg"  alt="PWG Group">
              </td>
              <?php endif; ?>             
            </tr>

            <tr>
              <td align="center" class="pie" style="border-color:#fff;">
                <span class="prices" style="font-weight:bold;"><?php echo e(number_format($ppay->first_payment_sub_total)); ?> </span><br>
                <span class="pays" style="margin-left:0px;font-weight:bold;">First Payment &nbsp;&nbsp;&nbsp;&nbsp;</span>
              </td>
              <?php if($ppay->submission_payment_price > 0): ?>
              <td align="left" style="border-color:#fff;width:60px"> </td>
              <td align="center" class="pie" style="border-color:#fff;">
                <span class="prices" style="font-weight:bold;"><?php echo e(number_format($ppay->submission_payment_sub_total)); ?> </span><br>
                <span class="pays" style="margin-left:0px;font-weight:bold;">Submission Payment</span>
              </td>
              <?php endif; ?>
              <?php if($ppay->second_payment_price > 0): ?>
              <td align="left" style="border-color:#fff;width:60px"> </td>
              <td align="center" class="pie" style="border-color:#fff;">
                <span class="prices" style="font-weight:bold;"><?php echo e(number_format($ppay->second_payment_sub_total)); ?> </span><br>
                <span class="pays" style="margin-left:0px;font-weight:bold;">Second Payment</span>
              </td>
              <?php endif; ?>
              <?php if($ppay->third_payment_price > 0): ?>
              <td align="left" style="border-color:#fff;width:60px"> </td>
              <td align="center" class="pie" style="border-color:#fff;">
                <span class="prices" style="font-weight:bold;"><?php echo e(number_format($ppay->third_payment_sub_total)); ?> </span><br>
                <span class="pays" style="margin-left:0px;font-size:10px;font-weight:bold;">Salary Deduction</span>
              </td>
              <?php endif; ?>
            </tr>

          </table>

          </p>
   

          <br>
          <h4>Working in <?php echo e($data->name); ?> provides several benefits not limited to:</h4>

          <p>
          <ul>
            <?php if($data->benefits != ""): ?>

            <?php $__currentLoopData = explode(' - ' ,$data->benefits); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <li> <?php echo e($item); ?> </li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </ul>
          </p>

          <?php if(Route::has('login')): ?>
          <?php if(auth()->guard()->check()): ?>
           <form action="<?php echo e(url('contract', $data->id)); ?>" method="GET">
          <?php else: ?>
           <form action="<?php echo e(url('login')); ?>">
            <?php Session::put('prod_id', $data->id); ?>
          <?php endif; ?>
          <?php endif; ?>
              <input type="hidden" value="<?php echo e($data->id); ?>">
              <input type="hidden" value="<?php echo e($ppay->id); ?>">

              <p style="margin-left:2px;font-weight:bold; font-size:1.4em">Please, select one of the following options:</p>
              <?php
              if ($data->full_payment_discount > 0) {
              ?>
                <p style="margin-left:2px;font-weight:bold">Get <?php echo e(number_format($data->full_payment_discount)); ?>% discount on Full Payment</p>
              <?php
              }

              ?>

              <p><button class="btn btn-secondary se2" id="buy" value="1" name="payall" >Full Payment</button>
                <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:100%; ">Pay in Installments</button>
              </p>

              <p>&nbsp; <input type="checkbox" class="checkcolor" id="agree" style="font-size:25px;transform: scale(1.8); " required=""> &nbsp; By checking this box you accept our <a target="_blank" href="<?php echo e(route('terms')); ?>"  style="color:blue;margin:0">Terms & Conditions</a></p>
            </form>

        </div>

      </div>
    </div>
  </section>
  <script>
    $('#reset').click(function() {
      if (!$('#agree').is(':checked')) {
        alert('You Must Agree To Proceed');
        return false;
      }
    });
  </script>

  


  

  
  
  
  
  <?php echo $__env->make('user/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/package.blade.php ENDPATH**/ ?>