<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PWG Client Receipt</title>
<style>
    body {
        font-size: 14px;;
    }
    .sb {
        font-size: 12px;
    }
</style>
  </head>
  <?php $paid=0; ?>
  <?php
  $paid += $user->paid_amount
  ?>

    <?php
        if($user->payment_type =="FIRST")
        {
            $discounted = $apply->first_payment_discount;
            // if(Auth::user()->country_of_residence == "United Arab Emirates")
            // {
              $vatP = $thisVat = $pricing->first_payment_vat;
            // } else {
            //   $vatP = $thisVat = 0;
            // }
            $thisAmt = $pricing->first_payment_sub_total;  
        } elseif ($user->payment_type == "BALANCE_ON_FIRST") {

            $discounted = 0;
            $vatP = $thisVat = 0;
            $thisAmt = ($user->payable_amount);

            # code...
        } elseif($user->payment_type =="SUBMISSION") {
            $discounted = $apply->submission_payment_discount;
            // if(Auth::user()->country_of_residence == "United Arab Emirates")
            // {
                $vatP = $thisVat = $pricing->submission_payment_vat;
            // } else {
            //   $vatP = $thisVat = 0;
            // }    
            $thisAmt = $pricing->submission_payment_sub_total;  
        } elseif($user->payment_type =="SECOND") {
            $discounted = $apply->second_payment_discount;
            // if(Auth::user()->country_of_residence == "United Arab Emirates")
            // {
                $vatP = $thisVat = $pricing->second_payment_vat ; 
            // } else {
            //     $vatP = $thisVat = 0;
            // }
            $thisAmt = $pricing->second_payment_sub_total; 
        } else {
            $discounted =0;
            $vatP = $thisVat = $apply->total_vat ; 
            $thisAmt = ($user->payable_amount*(100/105));
        }

        // $thisAmt = ($user->payable_amount);

        // $thisAmt = ($user->payable_amount*(100/105));
        // $thisVat = $user->payable_amount - $thisAmt_pseudo; 
    ?>

<?php
// if(Auth::user()->country_of_residence == "United Arab Emirates")
// {
    // $vatP = $thisVat = ($pricing->sub_total - $pricing->third_payment_sub_total) * 5/100;
// } else {
//     $vatP = $thisVat = 0;
// }
 $totalP = ($pricing->sub_total - $pricing->third_payment_sub_total);
$total = $totalP + $vatP;
?>
  <body>
        <div class="row" style="margin-bottom:30px;display: block;text-align: center;">
            <div class="col-lg-2 pull-left" valign="top" style="display: inline-block; float:left; height:auto">
                <img src="<?php echo e(public_path('images/logo2.png')); ?>" alt="logo">
            </div>
            <div class="col-lg-8" align="left" style="display: inline-block; text-align:left !important; margin:0px;width:60%">
                <b>PWG VISA SERVICES LLC</b> <br>
                OBEROI CENTER 20th FLOOR, 2001-2004,<br>
                DUBAI, DUBAI 00000 <br>
                +971 45686033 || sales@pwggroup.pl
            </div>
            <div class="col-lg-2 pull-right" align="right" valign="top" style="color:#ccc; display: inline-block;float:right">
               Invoice No.: <b><?php echo e($user->invoice_no); ?></b>
            </div>
        </div><hr style="height:0.7px; opacity:0.5;color:#ccc;">

        <div class="row" style="display: block;text-align: center;padding-top:5px;padding-bottom:10px; <?php if($discounted > 0): ?> height:135px; <?php else: ?> height:90px; <?php endif; ?> ">
            <div class="col-lg-4" valign="top" style="display: inline-block; float:left; text-align:left;line-height:130%">
                <b>BILL TO:</b> <br>
                <?php echo e(Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name); ?>


            </div>
            <div class="col-lg-8" align="center" style="display: inline-block;float:right;width:62%;margin:0px">
                <div class="row" style="display: block">
                   <b>
                    <?php 
                      $dueDate = date('Y-m-d', strtotime($user->payment_date. ' + 14 days')); 
                    ?>
                    <div class="col-lg-4" style="width:30%;display: inline-block; background-color:#f8f8ff;height:50px; opacity: 0.7;border-radius:5px;margin-top:15px;padding-top:15px">DATE: <br><?php echo e(date("d-m-Y", strtotime($user->payment_date))); ?></div>
                    <div class="col-lg-4" style="width:30%;display: inline-block; background-color:#eee;height:50px; opacity: 1.7;border-radius:5px;margin-top:15px;padding-top:15px">PLEASE PAY: <br><?php echo e(number_format($user->payable_amount-$paid,2)); ?></div>
                    <div class="col-lg-4" style="width:30%;display: inline-block; background-color:#f8f8ff;height:50px; opacity: 0.7; border-radius:5px;margin-top:15px;padding-top:15px">DUE DATE: <br><?php echo e(date("d-m-Y", strtotime($dueDate))); ?></div>
                   </b>
                </div>
            </div>
        </div>
       
        <hr style="height:0.7px; opacity:0.5;color:#ccc;"><br>

        <div class="row" style="display: block;width:100%">
            <div align="left" class="col-3" style="width:40%;display: inline-block; height:20px"><b>DESCRIPTION</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>QTY</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>RATE</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>AMOUNT</b></div>
        </div><hr style="height:0.7px; opacity:0.2;color:#ccc;">

        <div class="row sb" style="display: block;height:40px">
            <div align="left" class="col-3" style="width:40%;display: inline-block; height:20px"> <?php echo e($pricing->plan_name); ?> <?php echo e($user->payment_type); ?></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> 1 </div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> <?php echo e(number_format($thisAmt,2)); ?></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> <?php echo e(number_format($thisAmt,2)); ?></div>
        </div>   
        <div class="row" style="display: block">
            <div class="col-12">
                <div class="row sb" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7">SUB-TOTAL</div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; height:25px; background-color:#eee; opacity: 0.7;border-bottom:#fff solid 1px"><?php echo e(number_format($thisAmt,2)); ?></div>
                </div>
               
                <div class="row sb" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7">VAT</div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1px"><?php echo e(number_format($thisVat,2)); ?></div>
                </div>
           
                <div class="row sb" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7">DISCOUNT</div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1px"><?php echo e(number_format($discounted,2)); ?></div>
                </div>

                <div class="row sb" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block;height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block;height:25px; opacity: 0.7"><b>TOTAL</b></div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1p"><b><?php echo e(number_format(($thisAmt + $thisVat - $discounted),2)); ?></b></div>
                </div>

                <div class="row sb" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7">PAID</div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1px"><?php echo e(number_format($paid,2)); ?></div>
                </div>

                <div class="row sb" style="display: block" style="margin-top:4px">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7;border-bottom:#eee solid 1px;border-top:#eee solid 1px"><b>TOTAL DUE</b></div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#fff;height:25px; opacity: 0.7;border-bottom:#eee solid 1px;border-top:#eee solid 1px"><b>AED <?php echo e(number_format((($thisAmt + $thisVat - $discounted) - $paid),2)); ?></b></div>
                </div>
            </div>
        </div>            



<br>

                    <div class="row">
                        <div class="col-12" align="left" style="border-bottom:1px solid #ccc;margin-top:5px;margin-bottom:5px;padding-bottom:-15px; height:12px;width:100%;font-size:9px !important;">
                            <b>VAT SUMMARY</b>
                        </div>
                    </div>
                    <!-- ($user->payable_amount*(100/105)) -->
                    <?php 
                    //$thisAmt = ($user->payable_amount*(100/105)); 
                    //$thisVat = $user->payable_amount - $thisAmt; 
                    ?>
                    <div class="row" style="display: block">
                    <b>
                        <div class="col" align="right" style="width:20%;display: inline-block;height:12px; opacity: 0.7;font-size:9px">RATE</div>
                        <div class="col" align="right" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">VAT AMOUNT</div>
                        <div class="col" align="right" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">NET AMOUNT</div>
                    </b>
                    </div>
                    <div class="row" style="display: block">
                    <div class="col" align="right" style="width:20%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">5%</div>
                    <div class="col" align="right" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"><?php echo e(number_format($thisVat,2)); ?></div>
                    <div class="col" align="right" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"><?php echo e(number_format($thisAmt,2)); ?></div>
                    </div>
                
  

                <?php if($discounted > 0): ?>
                    <div class="row">
                        <div class="col-12" align="center" style="border-bottom:1px solid #ccc;margin:20px;margin-top:5px;margin-bottom:5px;padding-bottom:-15px; height:12px;width:90%;font-size:9px !important;">
                            <b>DISCOUNT SUMMARY</b>
                        </div>
                    </div>
                    <?php $netAmt = $user->paid_amount - $discounted; ?>
                    <div class="row" style="display: block;">
                    <b>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px"></div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">DISCOUNT AMOUNT</div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">UNDISCOUNTED AMOUNT</div>
                    </b>
                    </div>
                    <div class="row" style="display: block">
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"></div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"><?php echo e(number_format($discounted,2)); ?></div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"><?php echo e(number_format($netAmt,2)); ?></div>
                    </div>
                <?php endif; ?>
                <br>
                <div>
                    <strong>Disclaimer*: </strong>Invoice is temporary and subject to change, and the final version will be available on the eportal dashboard the next working day after 11 am.
                </div>
        
  </body>
</html>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal - optimization\resources\views/user/invoice.blade.php ENDPATH**/ ?>