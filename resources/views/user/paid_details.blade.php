
<!-- Theme style  -->
<link rel="stylesheet" href="{{asset('user/extra/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">

<style>
    .card {
        /* style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" */
        margin-top: 20px;
        border-color: none;
        border-radius: 10px;
        border-style:hidden;
    }

    .btn {
        height: 60px;
        padding-top: 15px;
        padding-bottom: 15px;
        font-size: 30px;
    }

   @media (min-width:375px){
    .btn {
        height: 60px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-size: 20px;
    }
   } 
</style>
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
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @foreach($pays as $pay)
                                <div class="row">
                                    <div class="col-md-3" align="left">
                                        <p>
                                            {{$pay->payment}}
                                        </p>
                                    </div>
                                    <div class="col-md-3" align="left">
                                        <p>
                                            @foreach($paid as $pd)

                                            @if( $pd->product_payment_id == $pay->id)
                                            Status PAID
                                            @else
                                            Status PENDING
                                            @endif

                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                            @foreach($paid as $pd)

                                            @if( $pd->product_payment_id == $pay->id)

                                            <a class="btn btn-secondary" style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" href="#">Get Reciept</a>
                                            @else
                                            <a class="btn btn-secondary" style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" href="{{ url('payment') }}">Pay Now</a>
                                            @endif

                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row" style="font-size:18px">
                        <div style="align-items: left; align:left; float: left; magin-left:0px" class="col-12">Your next payment is <b>
                                @foreach($prod as $pp)
                                @foreach($pays as $pay)
                                @if( $pd->product_payment_id == $pay->id)
                                <?php $tt = $pay->id;
                                $ttt = $pay->id + 1; ?>

                                <?php $count = 0; ?>
                                @foreach($pays as $pay => $review)
                                <?php

                                $count++; // Note that first iteration is $count = 1 not 0 here.
                                if ($count <= $tt or $count > $ttt) continue; // Skip the iteration unless 4th or above.
                                ?>
                                {{ number_format($review->amount) }}


                                @endforeach

                                @endif
                                @endforeach
                                @endforeach


                                AED
                            </b>, to be charged for second payment.</div>
                        
                    </div>
                    <!-- <a class="btn btn-secondary" href="{{ url('payment') }}">Pay Now</a> -->

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
