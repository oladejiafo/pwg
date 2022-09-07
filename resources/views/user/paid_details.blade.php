<!-- Theme style  -->
<link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">
@php  //$payNow = $whichPayment = 0; @endphp
<div class="row card">

    <div class="col-md-12">

        <div class="about-desc animate-box">
            <div class="fancy-collapse-panel">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> &nbsp; @foreach($prod as $pp) {{$pp->product_name}} @endforeach PACKAGE
                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#333;background-color:#333;">
                        <div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
                            <!-- collapse in -->
                            <div class="panel-body">
                                @foreach($paid as $index => $pd)

                                <?php
                                $count = $pd->count;
                                $px = $pd->product_payment_id;
                                if ($count > 1) {
                                    $countt = $pd->count - 1;
                                } else {
                                    $countt = 1;
                                }

                                $ind = $index + 1;
                                ?>

                                @endforeach

                                @foreach($pays as $pay)

                                <?php
                                $pay_id = $pay->id;
                                $payment = $pay->payment;
                                $amount = $pay->amount;
                                
                               
                                $ppid = $pay->id;
                                $ptid = $pd->product_payment_id;
                                
                                ?>
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                            {{$pay->payment}}
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                        @if( $ptid == $ppid)
                                            Status PAID
                                            @else
                                            Status PENDING
                                            @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>

                                           
                                            @if( $ptid == $ppid)

                                            <a class="btn btn-secondary" style="font-family: 'TT Norms Pro';font-weight:700" href="#">Get Reciept</a>
                                            @else
                                        <form action="{{ route('payment',$pp->id) }}" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                        </form>
                                        <!-- <a class="btn btn-secondary" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('payment') }}">Pay Now</a> -->
                                        @endif

                                        <?php
                                        while ($countt < $count) {
                                            $countt = $countt + 1;
                                        } ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="row" style="font-size:18px">
                        <div style="align-items: left; align:left; float: left; padding-left:40px;padding-right:40px" class="col-12">Your next payment is <b>

                                @foreach($prod as $pdd) <?php  $pdd = $pdd->id; ?> @endforeach

                                <?php
                                $items = DB::table('applicants')
                                    ->leftJoin('payments', 'payments.application_id', '=', 'applicants.id')
                                    ->leftJoin('product_payments', 'product_payments.id', '=', 'payments.product_payment_id')
                                    ->select('product_payments.*', 'payments.product_payment_id', 'payments.total')
                                    ->where('applicants.user_id', '=', Auth::user()->id)
                                    ->where('applicants.product_id', '=', $pdd)
                                    ->orderBy('payments.id', 'desc')
                                    ->limit(1)
                                    ->get();
                                ?>
                                @foreach($items as $item)
                                <?php
                                $pp = $item->product_payment_id;
                                ?>
                                @endforeach


                                @foreach($pays as $index => $pd)
                                @foreach($paid as $det)
                                @php

                                $completed = DB::table('applicants')
                                ->where('user_id', '=', Auth::user()->id)
                                ->get();

                                foreach($completed as $complete)
                                {
                                $app_id= $complete->id;
                                }

                                if(Session::has('myproduct_id'))
                                {
                                $pid = Session::get('myproduct_id');
                                } else {
                                $pid =$app_id;  
                                }

                                $tri = DB::table('payments')
                                ->where('application_id', '=', $app_id)
                                ->first();
                                var_dump($tri);die;
                                @endphp



<?php  $nextt = $tri->product_payment_id +1; ?>

                        @if($nextt == $pd->id)
                        
                                <?php

                                $payNow = $pd->amount;

                                $whichPayment =  $pd->payment;

                                ?>
                                @else 

                                 @if($index==0 && $loop->first)
     
                                 <?php
                                 $payNow = $pd->amount;
                                 $whichPayment =  $pd->payment;
                                 ?>
                                 @endif
                                @endif
                              
                                @endforeach
                                @endforeach

                                {{ number_format($payNow) }}


                                AED
                            </b>, to be charged for {{ $whichPayment }}.</div>



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
</div>

<!-- jQuery -->
<script src="{{asset('user/extra/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('user/extra/js/bootstrap.min.js')}}"></script>

</body>

</html>