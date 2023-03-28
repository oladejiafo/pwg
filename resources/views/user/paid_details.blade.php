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
                                         {{-- @if($paid->first_payment_status =='PAID' && $paid->first_payment_price == $paid->first_payment_paid) --}}
                                         @if($paid->first_payment_status =='PAID' && $paid->first_payment_remaining == 0)

                                            Status PAID
                                         @elseif($paid->first_payment_status =='PARTIALLY_PAID')
                                            Status PAID PARTIAL
                                         @elseif($paid->first_payment_status == 'PENDING' && $paid->first_payment_verified_by_cfo == 0 && $paid->first_payment_txn_mode == "TRANSFER")
                                            Status Being Verified
                                         @else
                                            Status PENDING
                                         @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                        {{-- @if($paid->first_payment_status =='PAID' && $paid->first_payment_price == $paid->first_payment_paid) --}}
                                        @if($paid->first_payment_status =='PAID' && $paid->first_payment_remaining == 0)
                                            <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/FIRST')}}">Get Invoice</a>
                                        @else
                                            @if($paid->application_stage_status != 5)
                                                @if(in_array($paid->first_payment_status, ['PENDING', 'PARTIALLY_PAID']) && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 0 && $paid->first_payment_txn_mode == 'TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @elseif($paid->first_payment_status == 'PARTIALLY_PAID' && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 1 && $paid->first_payment_txn_mode == 'BALANCE_TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @else
                                                    <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>  
                                                @endif                         
                                                {{-- @elseif($paid->first_payment_status == 'PENDING' && $paid->first_payment_verified_by_cfo == 0 && (isset($paym->transaction_mode) && ($paym->payment_type=="FIRST" || $paym->payment_type == "BALANCE_ON_FIRST")))
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#000;font-weight:700" disabled>Being Verified..</button> --}}
                                            @elseif(isset($paym))
                                                @if(in_array($paid->first_payment_status, ['PENDING', 'PARTIALLY_PAID']) && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 0 && $paid->first_payment_txn_mode == 'TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @elseif($paid->first_payment_status == 'PARTIALLY_PAID' && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 1 && $paid->first_payment_txn_mode == 'BALANCE_TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @else
                                                    <form action="{{ route('payment', $prod->id) }}"
                                                        method="GET">
                                                        <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                    </form>
                                                @endif
                                            @else
                                                @if(in_array($paid->first_payment_status, ['PENDING', 'PARTIALLY_PAID']) && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 0 && $paid->first_payment_txn_mode == 'TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @elseif($paid->first_payment_status == 'PARTIALLY_PAID' && $paid->first_payment_verified_by_cfo == 0 && $paid->is_first_payment_partially_paid == 1 && $paid->first_payment_txn_mode == 'BALANCE_TRANSFER')
                                                    <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                @else 
                                                    <form action="{{ route('payment', $prod->id) }}"
                                                        method="GET">
                                                        <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                    </form>
                                                @endif
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
                                         {{-- @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_price == $paid->submission_payment_paid) --}}
                                         @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_remaining == 0)

                                            Status PAID
                                        @elseif($paid->submission_payment_status == 'PENDING' && $paid->submission_payment_verified_by_cfo == 0 && $paid->submission_payment_txn_mode == 'TRANSFER')
                                            Status Being Verified
                                        @else
                                            Status PENDING
                                         @endif

                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                            {{-- @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_price == $paid->submission_payment_paid) --}}
                                            @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_remaining == 0)

                                                    <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/SECOND')}}">Get Invoice</a>
                                            @else
                                                @if($paid->application_stage_status != 5)
                                                    <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                                @elseif(isset($paym))
                                                    @if($paid->submission_payment_status != "PAID" && $paid->submission_payment_verified_by_cfo == 0 && $paid->submission_payment_txn_mode == 'TRANSFER')
                                                        <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                    @elseif($paid->submission_payment_status == 'PARTIALLY_PAID' &&  $paid->submission_payment_verified_by_cfo == 0 && $paid->is_submission_payment_partially_paid == 1 && ($paid->submission_payment_txn_mode == 'BALANCE_TRANSFER' || $paid->submission_payment_txn_mode =="TRANSFER"))
                                                        <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                    @elseif($paid->first_payment_status != "PAID" && $paid->first_payment_verified_by_cfo == 0)
                                                        <button class="btn btn-secondary toastrDefaultError"
                                                        onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                        Now</button>
                                                    @else
                                                        <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if($paid->submission_payment_status != "PAID" && $paid->submission_payment_verified_by_cfo == 0 && $paid->submission_payment_txn_mode == 'TRANSFER')
                                                        <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                    @elseif($paid->submission_payment_status == 'PARTIALLY_PAID' &&  $paid->submission_payment_verified_by_cfo == 0 && $paid->is_submission_payment_partially_paid == 1 && ($paid->submission_payment_txn_mode == 'BALANCE_TRANSFER' || $paid->submission_payment_txn_mode =="TRANSFER"))
                                                        <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                    @elseif($paid->first_payment_status != "PAID" && $paid->first_payment_verified_by_cfo == 0)
                                                        <button class="btn btn-secondary toastrDefaultError"
                                                        onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                        Now</button>
                                                    @else
                                                        <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                            <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                        </form>
                                                    @endif
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
                                            {{-- @if($paid->second_payment_status =='PAID'  && $paid->second_payment_price == $paid->second_payment_paid) --}}
                                            @if($paid->second_payment_status =='PAID'  && $paid->second_payment_remaining == 0)

                                                Status PAID
                                            @elseif($paid->second_payment_status == 'PENDING' && $paid->second_payment_verified_by_cfo == 0 && $paid->second_payment_txn_mode == 'TRANSFER')
                                                Status Being Verified
                                            @else
                                                Status PENDING
                                            @endif

                                            </p>
                                        </div>
                                        <div class="col-md-6" align="right">
                                            <p>

                                            {{-- @if($paid->second_payment_status =='PAID' && $paid->second_payment_price == $paid->second_payment_paid) --}}
                                            @if($paid->second_payment_status =='PAID' && $paid->second_payment_remaining == 0)

                                                <a class="btn btn-secondary" target="_blank" style="font-family: 'TT Norms Pro';font-weight:700" href="{{ url('/get/invoice/SECOND')}}">Get Invoice</a>
                                            @else
                                                @if($paid->application_stage_status != 5)
                                                    <button class="btn btn-secondary toastrDefaultError" style="font-weight:700" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                                                @elseif(isset($paym))
                                                    @if($pays->submission_payment_sub_total > 0)
                                                        @if($paid->second_payment_status != "PAID" && $paid->second_payment_verified_by_cfo == 0 && ($paid->second_payment_txn_mode == 'TRANSFER' || $paid->submission_payment_txn_mode == 'BALANCE_ON_TRANSFER'))
                                                            <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                        @elseif($paid->submission_payment_status != "PAID" && $paid->submission_payment_verified_by_cfo == 0)
                                                            <button class="btn btn-secondary toastrDefaultError"
                                                            onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                            Now</button>
                                                        @else
                                                            <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                                <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        @if($paid->second_payment_status != "PAID" && $paid->second_payment_verified_by_cfo == 0 && ($paid->second_payment_txn_mode == 'TRANSFER' || $paid->second_payment_txn_mode == 'BALANCE_ON_TRANSFER'))
                                                            <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                        @elseif($paid->first_payment_status != "PAID" && $paid->first_payment_verified_by_cfo == 0)
                                                            <button class="btn btn-secondary toastrDefaultError"
                                                            onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                            Now</button>
                                                        @else
                                                            <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                                <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($pays->submission_payment_sub_total > 0)
                                                        @if($paid->second_payment_status != "PAID" && $paid->second_payment_verified_by_cfo == 0 && ($paid->second_payment_txn_mode == 'TRANSFER' || $paid->submission_payment_txn_mode == 'BALANCE_ON_TRANSFER'))
                                                            <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                        @elseif($paid->submission_payment_status != "PAID" && $paid->submission_payment_verified_by_cfo == 0)
                                                            <button class="btn btn-secondary toastrDefaultError"
                                                            onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                            Now</button>
                                                        @else
                                                            <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                                <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        @if($paid->second_payment_status != "PAID" && $paid->second_payment_verified_by_cfo == 0 && ($paid->second_payment_txn_mode == 'TRANSFER' || $paid->second_payment_txn_mode == 'BALANCE_ON_TRANSFER'))
                                                            <button class="btn btn-secondary" style="font-size:18px;color:#7f8187;font-weight:700" disabled>Being Verified..</button>
                                                        @elseif($paid->first_payment_status != "PAID" && $paid->first_payment_verified_by_cfo == 0)
                                                            <button class="btn btn-secondary toastrDefaultError"
                                                            onclick="toastr.error('Your previous payment is being verified!')" style="font-weight:700">Pay
                                                            Now</button>
                                                        @else
                                                            <form action="{{ route('payment',$prod->id) }}" method="GET">
                                                                <button class="btn btn-secondary" style="font-weight:700">Pay Now</button>
                                                            </form>
                                                        @endif
                                                    @endif
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
                    {{-- <div class="row" style="font-size:18px">
                        <div style="align-items: left; align:left; float: left; padding-left:40px;padding-right:40px" class="col-12">Your next payment is <b>

                          @if($paid->submission_payment_status =='PAID' && $paid->submission_payment_remaining = 0)                    
                            {{ $pays->second_payment_sub_total }} AED
                            </b>, to be charged for Third Payment.

                          @elseif($paid->first_payment_status =='PAID' && $paid->first_payment_remaining == 0)
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
                    </div> --}}
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