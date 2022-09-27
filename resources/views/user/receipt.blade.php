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
  <?php $paid=0; ?>

  @foreach($user as $user)
  
  @if($user->paid_amount)
  @php
  $paid =$paid+$user->paid_amount
  @endphp
  @else
  @php 
    $paid=0;
    @endphp
  @endif
  @endforeach

 @if(isset($user->payable_amount))
    @php
        $thisAmt = $user->payable_amount 
    @endphp
@else  
@php
        $thisAmt = 0 
    @endphp   
 @endif 
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
               Receipt No.: <b>@if(isset($user->invoice_no)) {{ $user->invoice_no}} @endif</b>
            </div>
        </div><hr style="height:0.7px; opacity:0.5;color:#ccc;">

        <div class="row" style="display: block;text-align: center;padding-top:5px;padding-bottom:10px; height:90px;">
            <div class="col-lg-9" valign="top" style="display: inline-block; float:left; text-align:left;line-height:130%">
                <b>BILL TO:</b> <br>
                {{Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name}}<br>
                {{Auth::user()->address_line_1}},<br>
                {{Auth::user()->phone_number}},<br>
                {{Auth::user()->email}}
            </div>
            <div class="col-lg-3 pull-right" align="right" style="display: inline-block;float:right;width:20%;padding:10px;background-color:#eee;height:50px; opacity: 0.7;border-radius:5px">
                Payment Date <br>@if(isset($user->payment_date)){{date("d-m-Y", strtotime($user->payment_date))}}@endif
            </div>
        </div>
       
        <hr style="height:0.7px; opacity:0.5;color:#ccc;"><br>
    
        <div class="row" style="display: block;width:100%">
            <div align="left" class="col-3" style="width:40%;display: inline-block; height:20px"><b>DESCRIPTION</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>QTY</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>RATE</b></div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"><b>AMOUNT</b></div>
        </div><hr style="height:0.7px; opacity:0.2;color:#ccc;">

        <div class="row" style="display: block;height:40px">
            <div align="left" class="col-3" style="width:40%;display: inline-block; height:20px"> @if(isset($pricing->plan_name)) {{$pricing->plan_name}} @endif VISA Application @if(isset($user->payment_type)) {{$user->payment_type}} @endif</div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> 1 </div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> {{number_format($thisAmt,2)}}</div>
            <div align="right" class="col-3" style="width:19%;display: inline-block; height:20px"> {{number_format($thisAmt,2)}}</div>
        </div>               

        <div class="row" style="display: block">
            <div class="col-12">
                <div class="row" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block;height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block;height:25px; opacity: 0.7"><b>TOTAL</b></div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1p"><b>{{number_format(($thisAmt),2)}}</b></div>
                </div>

                <div class="row" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7">PAID</div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1px">{{number_format($paid,2)}}</div>
                </div>

                <div class="row" style="display: block">
                    <div class="col-lg-4" style="width:70%;display: inline-block; height:25px; opacity: 0.7"></div>
                    <div class="col-lg-4" align="right" style="width:15%;display: inline-block; height:25px; opacity: 0.7"><b>TOTAL DUE</b></div>
                    <div class="col-lg-4" align="right" style="width:12.5%;display: inline-block; background-color:#eee;height:25px; opacity: 0.7;border-bottom:#fff solid 1p"><b>{{number_format((($thisAmt) - $paid),2)}}</b></div>
                </div>
            </div>
        </div>
  </body>
</html>
