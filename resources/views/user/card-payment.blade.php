<form method="POST" action="{{ url('add_payment') }}">
    @csrf

  

    <div class="row payament-sec">
        <div class="col-lg-6 col-md-12" style="padding-right:20px">
            <div class="total">
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">

                        @if ($whichPayment == 'FIRST')
                            <b>First Payment</b>
                        @else
                            First Payment
                        @endif
                        <span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                (+ 5% VAT)
                            @endif
                        </span>
                        @if ($pends > 1)
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }} </font>
                        @endif
                    </div>
                    <div class="right-section col-6" align="right">
                        @if ($whichPayment == 'FIRST')
                            <b>{{ number_format($first_pay, 2) }}</b>
                        @else
                            {{ number_format($first_pay, 2) }}
                        @endif
                        <span style="font-size:11px">AED</span>
                    </div>
                </div>
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">

                        @if ($whichPayment == 'SUBMISSION')
                            <b>Submission Payment</b>
                        @else
                            Submission Payment
                        @endif
                        <span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                (+ 5% VAT)
                            @endif
                        </span>
                        @if ($outsub > 1)
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }} </font>
                        @endif
                    </div>
                    <div class="right-section col-6" align="right">

                        @if ($whichPayment == 'SUBMISSION')
                            <b>{{ number_format($second_pay, 2) }}</b>
                        @else
                            {{ number_format($second_pay, 2) }}
                        @endif
                        <span style="font-size:11px">AED</span>

                    </div>
                </div>
                <div class="total-sec row mt-3">
                    <div class="left-section col-6">
                        @if ($whichPayment == 'SECOND')

                            <b>Second Payment</b>
                            @if (strlen($pendMsg) > 1)
                                <br>

                                <font style='font-size:11px;color:red'><i fa fa-arrow-up></i>{{-- {{ $pendMsg }} --}}
                                </font>
                            @endif
                        @else
                            Second Payment
                        @endif
                        <span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                (+ 5% VAT)
                            @endif
                        </span>
                        @if ($outsec > 1)
                            <br>
                            <font style='font-size:10px;color:red'><i fa fa-arrow-up></i> {{ $pendMsg }} </font>
                        @endif
                    </div>
                    <div class="right-section col-6" align="right">
                        @if ($whichPayment == 'SECOND')
                            <b>{{ number_format($third_pay, 2) }}</b>
                        @else
                            {{ number_format($third_pay, 2) }}
                        @endif
                        <span style="font-size:11px">AED</span>
                    </div>
                </div>
                <hr>

                <div class="total-sec row mt-3">
                    <div class="left-section col-6">
                        Total Payment
                    </div>
                    <div class="right-section col-6 " align="right">
                        <?php
                        
                        //    $totalCost = Session::get('totalCost');
                        if (isset($tot_pay)) {
                            if (is_numeric($tot_pay)) {
                                $ttot = number_format($tot_pay, 2);
                            } else {
                                $ttot = $tot_pay; //$totalCost;
                            }
                        } else {
                            $ttot = Session::get('totalCost');
                        }
                        ?>


                        @if (isset($ttot) && $ttot > 0)
                            {{ $ttot }}
                        @else
                            {{ isset($tot_pay) ? number_format($tot_pay, 2) : '' }}
                            {{-- {{number_format($data->unit_price,2)}} --}}
                        @endif
                        <span style="font-size:11px">AED</span>
                    </div>
                </div>

                @if ($payall == 1 && isset($discount) && $discount > 0)
                    <div class="total-sec row mt-3 showDiscount">
                        <div class="left-section col-6">
                            Full Payment Discount (<span
                                id="discountPercent">-{{ $discountPercent ? $discountPercent : '' }}</span>)
                        </div>
                        <div class="right-section col-6" align="right">

                            <span id="discountValue">{{ number_format($discount, 2) }} </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="discount" id="myDiscount" value="{{ $discount }}">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">

                        </div>

                    </div>
                @else
                    <div class="total-sec row mt-3 showDiscount" id="showDiscount">
                        <div class="left-section col-6">

                            Discount (<span
                                id="discountPercent">{{ isset($discountPercent) ? $discountPercent : '' }} </span>)

                        </div>
                        <div class="right-section col-6" align="right">

                            <span id="discountValue">{{ number_format($discount, 2) }} </span>
                            <span style="font-size:11px" id="discountVal">AED</span>
                            <input type="hidden" name="discount" id="myDiscount" value="{{ $discount }}">
                            <input type="hidden" name="discountCode" id="myDiscountCode" value="">

                        </div>

                    </div>
                @endif
                @if (isset($vat) && $vat > 0)
                    <div class="total-sec row mt-3 showVat" id="showVat">
                        <div class="left-section col-6">
                            VAT (+ 5% of {{ $whichPayment }})
                        </div>
                        <div class="right-section col-6" align="right">
                            <span id="vatt">{{ number_format($vat, 2) }} </span>
                            <span style="font-size:11px">AED</span>
                        </div>
                    </div>
                @endif
                <input type="hidden" name="vats" id="vats" value="{{ $vat }}">
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            @if ($whichPayment == 'FIRST' && (!isset($pays) || $pays->first_payment_paid == 0))
                <div class="partial" style="height: 100%;">
                    <p>Pay {{ strtolower($whichPayment) }} installment in partial</p>
                    <input type="text" class="form-control" name="amount" id="amount"
                        placeholder="Enter partial payment" style="text-align:left !important"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                    {{-- @if ($errors->has('totalpay'))
                              <div class="error">{{ $errors->first('totalpay') }}</div>
                            @endif  --}}
                    @if ($errors->has('amount'))
                        <div class="error">{{ $errors->first('amount') }}</div>
                    @endif
                    <p>Minimum amount of <b> 1,000 AED</b><span style="font-size:11px" class="vtt">
                            @if ($vat > 0)
                                (+ 5% VAT)
                            @endif
                        </span></p>

                    <p><b>Remaining amount to be paid in 30 days</b></p>
                </div>
            @endif
        </div>
        <div class="partial-total-sec">

            @if(isset($pays) && $pays->first_payment_paid > 0 && $pays->first_payment_remaining > 0 && $payall ==0 ) 
                <h2 style="font-size: 1em;">Now you will pay the balance on first installment only
                    <b>{{ number_format((floor($pends * 100)/100),2) }}</b> AED 
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if($vat>0) (VAT inclusive @if($discount>0) ,less Discount  @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{  round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round(($payNow + $vat),2) }}">
                <input type="hidden" name="totalremaining" value="{{round($pends,2)}}">
            @elseif(isset($pays) && $pays->submission_payment_paid > 0 && $pays->submission_payment_remaining > 0 && $payall ==0 && (strtolower($whichPayment) == "submission" || strtolower($whichPayment) == "balance_on_submission"))
                <h2 style="font-size: 1em;">Now you will pay the balance on submission installment only
                    <b>{{ number_format((floor($payNoww * 100)/100),2) }}</b> AED 
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if($vat>0) (VAT inclusive @if($discount>0) ,less Discount  @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{  round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round(($payNow + $vat),2) }}">
                <input type="hidden" name="totalremaining" value="{{round($pends,2)}}">
            @elseif(isset($pays) && $pays->second_payment_paid > 0 && $pays->second_payment_remaining > 0 && $payall ==0 && (strtolower($whichPayment) == "second" || strtolower($whichPayment) == "balance_on_second"))
                <h2 style="font-size: 1em;">Now you will pay the balance on second installment only
                    <b>{{ number_format((floor($payNoww * 100)/100),2) }}</b> AED 
                    <span style="font-size:11px;opacity:0.6" id="amountText">
                        @if($vat>0) (VAT inclusive @if($discount>0) ,less Discount  @endif) @endif
                    </span>
                </h2>
                <input type="hidden" id="amountLink2" name="totalpay" value="{{  round($payNoww, 2) }}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{ round(($payNow + $vat),2) }}">
                <input type="hidden" name="totalremaining" value="{{round($pends,2)}}">
            @else
                <h2 style="font-size: 1em;">Now you will pay {{strtolower($whichPayment)}} installment only
                    <span id="amountLink">
                    
                        {{-- <b>{{(($pays->first_payment_status !="PAID") ? (($diff > 0) ? number_format((floor(((($payNoww - $discount)+ $vat)+$pays->first_payment_remaining)*100)/100),2) : (number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))):number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))}}</b> --}}
                        <b><span id="amountLink"> {{((!isset($pays) || $pays->first_payment_status !="PAID") ? (($diff > 0) ? number_format((floor(((($payNoww - $discount)+ $vat))*100)/100),2) : (number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))):number_format((floor((($payNoww - $discount)+ $vat)*100)/100),2))}} </span></b>
                    </span> AED 
                    <span style="font-size:11px;opacity:0.6"  id="amountText">
                        @if($vat>0) 
                        (<span id="vt">VAT inclusive</span> @if($discount>0) ,less Discount  @endif) 
                        @else 
                        @if($discount>0) 
                        (less Discount)  
                        @endif 
                        @endif
                    </span>
                </h2>
                {{-- <input type="hidden" id="amountLink2" name="totalpay" value="{{ round((($payNoww - $discount)+ $vat),2) }}"> --}}
                <input type="hidden" id="amountLink2" name="totalpay" value="{{ (( !isset($pays) || $pays->first_payment_status !="PAID" ) ? (($diff > 0) ? (round(((($payNoww - $discount)+ $vat)),2)) : round((($payNoww - $discount)+ $vat),2)):round((($payNoww - $discount)+ $vat),2))}}">
                <input type="hidden" id="totaldue" name="totaldue" value="{{round((($payNoww - $discount) + $vat),2) }}">
            @endif
        </div>
    </div>


    <input type="hidden" name="pid" value="{{ $data->id }}">
    <input type="hidden" name="ppid" value="{{ isset($pdet->id) ? $pdet->id : '' }}">
    <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
    <input type="hidden" name="packageType" value="{{$pdet->pricing_plan_type}}">
    <input type="hidden" name="whichpayment" value="{{ $whichPayment ? $whichPayment : 'FIRST' }}">
    <input type="hidden" name="first_p" value="{{ $pdet->first_payment_sub_total }}">
    <input type="hidden" name="second_p" value="{{ $pdet->submission_payment_sub_total }}">
    <input type="hidden" name="third_p" value="{{ $pdet->second_payment_sub_total }}">

    <div class="row mt4">
        <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px">
            <span>By continuing you agree to the <a href="{{route('terms')}}"  style="color:#000;margin:30px 0;font-size: 15px" target="_blank"><u>Terms & Conditions</u></a></span>
        </div>
        <div class="col-lg-2 col-md-1 col-sm-12"></div>
        <div class="col-lg-4 col-md-5 col-sm-12">
            <button type="submit" class="btn btn-primary submitBtn" style="border-radius: 0px">Pay Now</button>
        </div>

    </div>
</form>
