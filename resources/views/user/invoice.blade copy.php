<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PWG Client Receipt</title>
<style>
    body {
        font-size: 13px;;
    }
</style>
  </head>
    @php
        if($user->payment_type =="First Payment")
        {
            $discounted = $apply->first_payment_discount;
        } elseif($user->payment_type =="Second Payment") {
            $discounted = $apply->submission_payment_discount;
        } elseif($user->payment_type =="Third Payment") {
            $discounted = $apply->second_payment_discount;  
        } else {
            $discounted =0;
        }
    @endphp
  <body>
        <div class="row" style="margin-bottom:30px;display: block;text-align: center;">
            <div class="col-lg-2 pull-left" valign="top" style="display: inline-block; float:left; height:auto">
                <img src="{{public_path('images/logo2.png')}}" alt="logo">
            </div>
            <div class="col-lg-8" align="left" style="display: inline-block; text-align:left !important; margin:0px;width:60%">
                <b>PWG VISA SERVICES LLC</b> <br>
                OBEROI CENTER 20th FLOOR, 2001-2004,<br>
                DUBAI, DUBAI 00000 <br>
                +971 45686033 || sales@pwggroup.pl
            </div>
            <div class="col-lg-2 pull-right" align="right" valign="top" style="color:#ccc; display: inline-block;float:right">
               Invoice No.: <b>{{$user->invoice_no}}</b>
            </div>
        </div><hr style="height:0.7px; opacity:0.5;color:#ccc;">

        <div class="row" style="display: block;text-align: center;padding-top:5px;padding-bottom:10px; @if($discounted > 0) height:135px; @else height:90px; @endif ">
            <div class="col-lg-4" valign="top" style="display: inline-block; float:left; text-align:left;line-height:130%">
                <b>BILL TO:</b> <br>
                {{Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name}}<br>
                {{Auth::user()->address_line_1}},<br>
                {{Auth::user()->phone_number}},<br>
                {{Auth::user()->email}}
            </div>
            <div class="col-lg-8" align="center" style="display: inline-block;float:right;width:62%;margin:0px">
                <div class="row" style="display: block">
                   <b>
                    <div class="col-lg-3" style="width:25%;display: inline-block; background-color:#eee;height:40px; opacity: 0.7">Payment Date <br>{{date("d-m-Y", strtotime($user->payment_date))}}</div>
                    <div class="col-lg-3" style="width:24%;display: inline-block; background-color:#eee;height:40px; opacity: 0.7">Payable Amount <br>{{number_format($user->payable_amount,2)}}</div>
                    <div class="col-lg-3" style="width:24%;display: inline-block; background-color:#eee;height:40px; opacity: 0.7">Paid Amount <br>{{number_format($user->paid_amount,2)}}</div>
                    <div class="col-lg-3" style="width:24%;display: inline-block; background-color:#eee;height:40px; opacity: 0.7">Amount Due <br>{{number_format($user->payable_amount-$user->paid_amount,2)}}</div>
                   </b>
                </div>
                @if(Auth::user()->country_of_residence == "United Arab Emirates")
                    <div class="row">
                        <div class="col-12" align="center" style="border-bottom:1px solid #ccc;margin:20px;margin-top:5px;margin-bottom:5px;padding-bottom:-15px; height:12px;width:90%;font-size:9px !important;">
                            <b>VAT SUMMARY</b>
                        </div>
                    </div>
                    <!-- ($user->payable_amount*(100/105)) -->
                    @php $thisAmt = ($user->payable_amount*(100/105)); $thisVat = $user->payable_amount - $thisAmt; @endphp
                    <div class="row" style="display: block;">
                    <b>
                        <div class="col" style="width:30%;display: inline-block;height:12px; opacity: 0.7;font-size:9px">RATE</div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">VAT AMOUNT</div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">NET AMOUNT</div>
                    </b>
                    </div>
                    <div class="row" style="display: block">
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">5%</div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">{{number_format($thisVat,2)}}</div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">{{number_format($thisAmt,2)}}</div>
                    </div>
                @endif
  

                @if($discounted > 0)
                    <div class="row">
                        <div class="col-12" align="center" style="border-bottom:1px solid #ccc;margin:20px;margin-top:5px;margin-bottom:5px;padding-bottom:-15px; height:12px;width:90%;font-size:9px !important;">
                            <b>DISCOUNT SUMMARY</b>
                        </div>
                    </div>
                    @php $netAmt = $user->paid_amount - $discounted; @endphp
                    <div class="row" style="display: block;">
                    <b>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px"></div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">DISCOUNT AMOUNT</div>
                        <div class="col" style="width:30%;display: inline-block; height:12px; opacity: 0.7;font-size:9px">UNDISCOUNTED AMOUNT</div>
                    </b>
                    </div>
                    <div class="row" style="display: block">
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px"></div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">{{number_format($discounted,2)}}</div>
                    <div class="col" style="width:30%;display: inline-block;height:15px; opacity: 0.7;font-size:11px">{{number_format($netAmt,2)}}</div>
                    </div>
                @endif
            </div>
        </div>
       
        <hr style="height:0.7px; opacity:0.5;color:#ccc;"><br>
@php
if(Auth::user()->country_of_residence == "United Arab Emirates")
{
    $vatP = $pricing->total_price * 5/100;
} else {
    $vatP = 0;
}
$totalP = $pricing->total_price;
$total = $totalP + $vatP;
@endphp

<div align="center" style="height:35px;opacity:0.4"><u>FULL BILLING SUMMARY</u></div>
        <div class="row" style="display: block">
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"><b>Type of Visa Application</b></div>
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"><b>Payment Type</b></div>
            <div align="right" class="col-4" style="width:30%;display: inline-block; height:20px"><b>Payment Amount @if(Auth::user()->country_of_residence == "United Arab Emirates") (+VAT) @endif</b></div>
        </div><hr style="height:0.7px; opacity:0.2;color:#ccc;">
        <div class="row" style="display: block">
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> {{$pricing->plan_name}}</div>
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> First Payment @if($apply->first_payment_status =='PAID' || $apply->first_payment_status =='PARTIAL') <span style="font-weigth:bold;color:#ccc">[{{$apply->first_payment_status}}]</span> @endif</div>
            <div align="right" class="col-4" style="width:30%;display: inline-block; height:20px"> @if(Auth::user()->country_of_residence == "United Arab Emirates")  {{number_format($pricing->first_payment_price + ($pricing->first_payment_price*5/100),2)}} @else {{number_format($pricing->first_payment_price,2) }} @endif</div>
        </div>
        <div class="row" style="display: block">
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> </div>
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> Second Payment @if($apply->submission_payment_status =='PAID') <span style="font-weigth:bold;color:#ccc">[PAID]</span> @endif</div>
            <div align="right" class="col-4" style="width:30%;display: inline-block; height:20px"> @if(Auth::user()->country_of_residence == "United Arab Emirates")  {{number_format($pricing->submission_payment_price + ($pricing->submission_payment_price*5/100),2)}} @else {{number_format($pricing->submission_payment_price,2) }} @endif</div>
        </div>
        <div class="row" style="display: block">
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> </div>
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> Third Payment @if($apply->second_payment_status =='PAID') <span style="font-weigth:bold;color:#ccc">[PAID]</span> @endif</div>
            <div align="right" class="col-4" style="width:30%;display: inline-block; height:20px"> @if(Auth::user()->country_of_residence == "United Arab Emirates")  {{number_format($pricing->second_payment_price + ($pricing->second_payment_price*5/100),2)}} @else {{number_format($pricing->second_payment_price,2) }} @endif</div>
        </div><hr style="height:0.7px; opacity:0.2;color:#ccc;">
        <div class="row" style="display: block">
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> </div>
            <div align="left" class="col-4" style="width:30%;display: inline-block; height:20px"> <b>Total Payment</b></div>
            <div align="right" class="col-4" style="width:30%;display: inline-block; height:20px"> <b>{{number_format($total,2)}}</b></div>
        </div>
  </body>
</html>
