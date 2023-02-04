<!-- Theme style  -->
<link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">

<div class="row card">

    <div class="col-md-12">

        <div class="about-desc animate-box">
            <div class="fancy-collapse-panel">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> &nbsp;  {{$prod->name}} PACKAGE
                                </a>
                            </h4>
                        </div>
                        <hr style="height:1px;border:none;color:#333;background-color:#333;">
                        <div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
                            <!-- collapse in -->
                            <div class="panel-body">


                              

                                <?php
                                $pay_id = $pays->id;
                                // $payment = $pay->payment;
                                // $amount = $pay->amount;
                                
                               
                                $ppid = $pays->id;
                                // $ptid = $pd->product_payment_id;
                                
                                ?>

                                <!-- First Begins -->
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                            First Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         @if($paid->first_payment_status =='PAID' && $paid->first_payment_price == $paid->first_payment_paid)
                                            Status PAID
                                         @elseif($paid->first_payment_status =='PARTIALLY_PAID')
                                            Status PAID PARTIAL   
                                         @else
                                            Status PENDING
                                         @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                        @if($paid->first_payment_status =='PAID' && $paid->first_payment_price == $paid->first_payment_paid)

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/FIRST')}}">Get Invoice</a>
                                       @else
                                        @if($paid->application_stage_status != 5)
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        @else
                                         <form action="{{ route('payment',$prod->id) }}" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        @endif
                                       @endif

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                 <!-- first Ends -->

                                
                                <!-- Second Begins -->
                                @if($pays->submission_payment_sub_total > 0)
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                           Submission Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_price == $paid->submission_payment_paid)
                                            Status PAID
                                         @else
                                            Status PENDING
                                         @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>

                                           
                                        @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_price == $paid->submission_payment_paid)

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/SUBMISSION')}}">Get Invoice</a>
                                       @else
                                        @if($paid->application_stage_status != 5)
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        @else
                                         <form action="{{ route('payment',$prod->id) }}" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        @endif
                                       @endif

                                        </p>
                                    </div>
                                </div>
                                @endif
                                <hr>
                                 <!-- Second Ends -->
                                
                                <!-- Third Begins -->
                                @if($pays->second_payment_sub_total > 0)
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                           Second Payment
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                         @if($paid->second_payment_status =='PAID'  && $paid->second_payment_price == $paid->second_payment_paid)
                                            Status PAID
                                         @else
                                            Status PENDING
                                         @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>

                                           
                                        @if($paid->second_payment_status =='PAID' && $paid->second_payment_price == $paid->second_payment_paid)

                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/SECOND')}}">Get Invoice</a>
                                       @else
                                        @if($paid->application_stage_status != 5)
                                            <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                        @else
                                         <form action="{{ route('payment',$prod->id) }}" method="GET">

                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                         </form>
                                        @endif

                                       @endif
                                        </p>
                                    </div>
                                </div>
                                @endif
                                 <!-- Third Ends -->

                            </div>
                        </div>
                    </div>  


                    @if($paid->second_payment_status != 'PAID')
                    <div class="row" style="font-size:18px">
                        <div style="align-items: left; align:left; float: left; padding-left:40px;padding-right:40px" class="col-12">Your next payment is <b>

                          @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_price == $paid->submission_payment_paid)                    
                            {{ $pays->second_payment_sub_total }} AED
                            </b>, to be charged for Third Payment.
                          @elseif($paid->first_payment_status =='PAID' && $paid->first_payment_price == $paid->first_payment_paid)
                            {{ $pays->submission_payment_sub_total }} AED
                            </b>, to be charged for Second Payment.
                          @elseif($paid->first_payment_status !='PAID' && $paid->submission_payment_status !='PAID')

                           @if($paid->first_payment_remaining >0 && $paid->first_payment_status !='PAID')
                               {{ $paid->first_payment_remaining }} AED
                                </b>, outstanding on First Payment.
                           @else
                                {{ $pays->first_payment_sub_total }} AED
                                </b>, to be charged for First Payment.
                           @endif
                          @endif

                        </div>
                    </div>
                    @endif

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