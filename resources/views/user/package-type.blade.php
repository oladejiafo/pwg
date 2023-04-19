@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">

<style>
    .package-type ul {
      list-style: none;
    }
    
    .package-type ul li {
       font-size: 14px;
       /* align-items: left; */
       position: relative;

    }
   
    .package-type ul li::marker {
      content: "";
      display: inline-block; 
    }
    .package-type .indpackage ul li::before {
        position: absolute;
        content: "✓";
        display: block;
        width: 25px;
        height: 25px;
        top: 5px;
        left: 5px;
        background: #FACB08;
        margin-bottom: 0 !important;
        font-weight: bold;
        color: #000;
    }

    .package-type .fampackage ul li::before {
        position: absolute;
        content: "✓";
        display: block;
        width: 25px;
        height: 25px;
        top: 5px;
        left: 5px;
        background: #E10930;
        margin-bottom: 0 !important;
        font-weight: bold;
        color: #000;
    }
    
    .selected path {
        fill: #000;
    }

    .package-type .price
    {
        padding:0 5%;
    }
    .package-type .saved {
        padding:0 5%; 
        margin:3px 0 10px 0;
    }
   
    @media (max-width: 1100px)
    {
        .package-type .price
        {
            padding:0;
        }   
        .package-type .promo {
            padding: 0px
        }
        .package-type .line {
            padding: 0px
        }
        .package-type .regular {
            padding: 0px
        }
        .package-type .saved {
            padding:0; 
            margin:3px 0 10px 0;
        }
    }


    @media (max-width:800px)
    {
        .package {
            padding: 20px 5% !important;
        }
        h3 {
            font-size: 25px !important;
            text-align: center !important;
        }
        p {
            text-align: center;
            font-size: 20px;
        }
        .package-type{
            margin: 0px 0px 50px 0px;
            /* width: 100%; */
            padding: 0px !important;
            /* height: 350px; */
        }
        .package-type img {
        width:100px; 
        /* height:120px; */
        }
    }
    @media (max-width: 600px)
    {
        .package-type .line {
            width: 2%;
        }
        .package-type .promo {
            width: 47%;
        }
        .package-type .regular {
            width: 47%;
        }                            
    }

    @media (max-width:360px) {
        .fampackage ul,
        .indpackage ul {
            padding: 0px;
        }
        .fampackage .bonus,
        .indpackage .bonus {
            padding: 0px;
            margin-left: 0px !important;
        }

        .package-type .saved .col-5,
        .package-type .saved .col-7 {
            font-size: 12px !important;            
        }
        .package {
            padding: 20px 0% !important;
            width: 100% !important;
        }

        .package .switch {
            width: 60px !important;
        }
        .children label {
            width: 40px !important;
        }

        #familymodal .price {
            padding: 10px 0px !important
        }

        #familymodal .separator {
            width: 1%;
        }
        #familymodal .promos {
            width: 47%;
        }
        #familymodal .actual {
            width: 47%;
            padding-right: 0px !important;
        }    
    }

    @media (max-width:280px) {
        .fampackage ul,
        .indpackage ul {
            padding: 0px;
        }
        .fampackage .bonus,
        .indpackage .bonus {
            padding: 0px;
            margin-left: 0px !important;
        }

        .package-type .saved .col-5,
        .package-type .saved .col-7 {
            font-size: 12px !important;            
        }
        .package {
            padding: 20px 0% !important;
            width: 100% !important;
        }
        .package-type .price {
            font-size: 12px !important;
        }
        .package .header h2 {
            font-size: 35px;
        }
        .package .header p{
            font-size: 15px !important;
        }
        .package-type {
            height: 800px !important;
            max-height: 800px !important;
            margin-bottom: 50px !important;
        }
        .btn.btn-secondary {
            width: 90% !important;
            font-size: 10px !important;
        }
        .familymodal .saved {
            padding: 0px !important; 
        }
    }

</style>


@section('content')

{{-- @if($canadaOthers->first())

@php 
$cSamount=0;
$cXamount=0;
@endphp
@foreach($canadaOthers as $canada)

@if($canada->pricing_plan_type == "STUDY_PERMIT")
@php  
  $cSname = $canada->pricing_plan_type;
  $cSamount =$cSamount + $canada->sub_total - $canada->third_payment_sub_total;
@endphp
@endif

@if($canada->pricing_plan_type == "EXPRESS_ENTRY")
@php  
  $cXname = $canada->pricing_plan_type;
  $cXamount = $cXamount + $canada->sub_total - $canada->third_payment_sub_total;
@endphp
@endif

@endforeach

@endif --}}
@if($proddet->first())
@foreach($proddet as $prdet)
    @if ($loop->first)

        @php 
        // $blue_cost = $prdet->total_price
        // $blue_cost = $prdet->sub_total - $prdet->third_payment_sub_total
        $blue_cost = $prdet->first_payment_sub_total
        @endphp 

    @endif
@endforeach
@else 
@php                                   
    $blue_cost = 0
@endphp
@endif
    <div class="container" style="margin-top: 100px;">
        <div class="col-12">
            <div align="center" class="package">
                <div class="header">
                    {{-- FOR {{strtoupper($data->name)}} --}}
                    <h2>CHOOSE YOUR PACKAGE</h2>
                    <div class="bottoom-title">
                        <p>To start your journey to {{$data->name}}, please select the package that best suits you</p>
                    </div>
                </div>
                <br>
                <div class="row" style="margin-left:auto; margin-right:auto; text-align:center;justify-content: center; display: flex;">
                

                       
                    <div class="col-sm-10 col-md-6 col-lg-5" style="display:inline-block;">
                        <img src="{{asset('user/images/individual.png')}}" width="100%" alt="PWG Group">
                        <div class="package-type blue-collar" data-bs-toggle="modalXX" data-bs-target="#individualModalXX">
                            <div class="content">
                                <div>
                                    <div class="row price">
                                        @php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;@endphp
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 promo" align="right"><b>PROMO PRICE</b> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:18px">{{number_format($blue_cost,0)}}</span></b></div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del>{{number_format($blue_cost_old,0)}}</del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED {{number_format($blue_save,0)}}</div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row" style="border-block: 1px solid #000;padding:5px; margin:15px">
                                        <div class="col"><b>INDIVIDUAL PACKAGE</b></div>
                                    </div>
                                    <div class="indpackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free accomodation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Passport after 5 years</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Attractive job market</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Your right is protected</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">No company ban</div></li>
                                        </ul>
                                        {{-- <div class="bonus" style="text-align: left;margin-block:15px; margin-left: 35px"><i class="fa fa-star" style="color:#FACB08;font-size: 25px;"></i><b style="font-size: 18px;margin-left: 15px;">BONUS:</b> Salary deduction on the last payment of selected package.</div> --}}
                                    </div>
                                    <div>
                                        @if(Route::has('login'))
                                            @auth
                                            <form action="{{ url('payment_form', $data->id) }}" method="GET">
                                        @else
                                            <form action="{{ url('register') }}">
                                                @php Session::put('prod_id', $data->id); @endphp
                                            @endauth
                                        @endif
                                        @csrf
                                            <input type="hidden" name="cost" value="{{$blue_cost}}">
                                            <input type="hidden" name="blue_id" value="{{$prdet->id}}">
                                            <input type="hidden" name="pr_id" value="{{$data->id}}">
                                        
                                            <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                            <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;background: #FACB08">APPLY NOW</button>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    
                    @if($famdet)

                    <div class="col-sm-10 col-md-6 col-lg-5" style="display:inline-block;">
                        <img src="{{asset('user/images/family.png')}}" width="100%" alt="PWG Group">
                        <div class="package-type family-package" data-bs-toggle="modalXX" data-bs-target="#familyModalXX">

                            <div class="content">
                                <div>
                                    <div class="row price" style="padding:0 5%">
                                        @if(isset($famdet)) 
                                            @php 
                                                $famdet_cost_old = $famdet['first_payment_sub_total']*1.2995; 
                                                $famdet_save= $famdet_cost_old - $famdet['first_payment_sub_total'];
                                            @endphp
                                        @endif
                                        <div class="col-lg-5 col-md-5 col-sm-5 promo" align="right"><b>PROMO PRICE</b> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:18px">{{number_format($famdet['first_payment_sub_total'],0)}}</span></b></div>
                                        <div class="col-lg-2 col-md-2 col-sm-1 line" align="center" style="padding:0 5px; border-left: 2px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-lg-5 col-md-5 col-sm-6 regular" align="left"><b>REGULAR PRICE</b> <br> <span style="font-size:12px">AED</span> <span style="font-size:18px"><del>{{number_format($famdet_cost_old,0)}}</del></span></div>
                                    </div>
                                    <div class="row saved">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED {{number_format($famdet_save,0)}}</div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">SALES ENDS 7 DAYS</div>
                                    </div>
                                    <div class="row" style="border-block: 1px solid #000;padding:5px; margin:15px">
                                        <div class="col"><b>FAMILY PACKAGE</b></div>
                                    </div>
                                    <div class="fampackage">
                                        <ul>
                                            <li><div style="text-align: left;margin-left: 35px">Free accomodation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free transportation</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free health insurance</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Free regeneration meal</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Flexible working hours</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Permanent residency</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Passport after 5 years</div></li>

                                            <li><div style="text-align: left;margin-left: 35px">Salary on time</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Family benefits</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Access to Free Education</div></li>
                                            <li><div style="text-align: left;margin-left: 35px">Low cost of living</div></li>
                                            {{-- <li><div style="text-align: left;margin-left: 35px">Legal employment</div></li> --}}
                                            <li><div style="text-align: left;margin-left: 35px">Respect of your rights</div></li>
                                            {{-- <li><div style="text-align: left;margin-left: 35px">No company ban</div></li> --}}
                                            <li><div style="text-align: left;margin-left: 35px">Right to family reunification</div></li>

                                        </ul>
                                        {{-- <div class="bonus" style="text-align: left;margin-block:15px; margin-left: 35px"><i class="fa fa-star" style="color:#E10930;font-size: 25px;"></i><b style="font-size: 18px;margin-left: 15px;">BONUS:</b> Salary deduction on the last payment of selected package.</div> --}}
                                    </div>
                                    <div>
                                        @if(Route::has('login'))
                                            @auth
                                            <form action="{{ url('payment_form', $data->id) }}" method="GET">
                                        @else
                                            <form action="{{ url('register') }}">
                                                @php Session::put('prod_id', $data->id); @endphp
                                            @endauth
                                        @endif
                                            <input type="hidden" name="pr_id" value="{{$data->id}}">
                                            @csrf
        
                                            <input type="hidden" name="productId" value="{{$productId}}">
                                            <input type="hidden" class="hiddenFamAmount" name="cost" value="{{($famdet) ?  number_format($famdet['first_payment_sub_total']) : 0 }}">
                                            <input type="hidden" value="FAMILY_PACKAGE" name="myPack">
                                            <input type="hidden" value="{{($famdet) ? $famdet->id : 0 }}" name="fam_id" class="fam_id">
                                            
                                            <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;background: #E10930">APPLY NOW</button>
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    @endif
               
                    </div>
                                
                    <!-- Individual Modal -->
                    <div class="modal fade" id="individualModal" tabindex="-1" aria-labelledby="individualModalLabel" aria-hidden="true">
                        <div class="modal-dialog row">
                            <div class="modal-content col-4" style="border-radius: 15px">
                                <div class="modal-headerx" align="center">
                                    <div><img src="{{asset('user/images/individual_icon.png')}}" width="30%" style="margin-top:25px;margin-bottom:5px" alt="PWG Group"></div>
                                    <h5 class="modal-title" id="individualModalLabel">INDIVIDUAL PACKAGE</h5>
                                    {{-- <button type="button" style="float:right; font-size:11px; width:20px;height:20px" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                </div>
                                <div class="modal-body" style="height:auto">
                                    
                                    <div class="row" style="padding:5px 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px">SAVE AED {{number_format($blue_save,0)}}</div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px">WHEN YOU PAY IN FULL</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="border-top:0px solid rgb(57, 127, 184)"></div>
                                    </div>
                                    <div class="row" style="padding:10px 5%">
                                        
                                        @php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;@endphp
                                        <div class="col-5" align="right"><span style="font-size:10px;;color:#000"><b>PROMO PRICE</b></span> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:22px;color:#000">{{number_format($blue_cost,0)}}</span></b></div>
                                        <div class="col-1" align="center" style="padding:0 3px; border-left: 0px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-6" align="right" style="padding-right:15%"><span style="font-size:10px;color:#000"><b>REGULAR PRICE</b></span> <br> <span style="font-size:12px;color:#E10930">AED</span> <span style="font-size:22px;color:#E10930"><del>{{number_format($blue_cost_old,0)}}</del></span></div>
                                    </div>
                                    @if(Route::has('login'))
                                        @auth
                                        <form action="{{ url('payment_form', $data->id) }}" method="GET">
                                    @else
                                        <form action="{{ url('register') }}">
                                            @php Session::put('prod_id', $data->id); @endphp
                                        @endauth
                                    @endif
                                            
                                    @csrf
                                    <input type="hidden" name="cost" value="{{$blue_cost}}">
                                    <input type="hidden" name="blue_id" value="{{$prdet->id}}">
                                    <input type="hidden" name="pr_id" value="{{$data->id}}">
                                
                                    <input type="hidden" value="BLUE_COLLAR" name="myPack">
                                    <div class="form-groupx row" style=" margin:0 auto;"> 
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary se2" id="buy" value="1" name="payall"  style="width:80%;border-radius:5px; margin-block:3px; border: 0px solid #fff; background:#FACB08">FULL PAYMENT</button>
                                            <?php
                                            if($data->full_payment_discount > 0) {
                                            ?>
                                            {{-- <p style="margin-left:2px;font-weight:bold;font-size: 13px; margin-right:10px">Get <i>{{number_format(($data->full_payment_discount * $blue_cost/100))}} AED</i> discount on Full Payment</p> --}}
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:80%; border-radius:5px;margin-block:3px">PAY INSTALLMENTS</button>
                                        </div>

                                            <p align="center" style="font-size: 11px">
                                                <i>By continuing, you have accepted our <a target="_blank" href="{{route('terms')}}"  style="color:#000;margin:0;font-size: 15px"><u>Terms & Conditions</u></a></i>
                                            </p>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Individual Modal Ends -->
                    @if($famdet)
                    <!-- Family Modal -->
                    <div class="modal fade" id="familyModal" tabindex="-1" aria-labelledby="familyModalLabel" aria-hidden="true">
                        <div class="modal-dialog row">
                            <div class="modal-content col-4" style="border-radius: 15px">
                                <div class="modal-headerx" align="center">
                                    <div><img src="{{asset('user/images/family_icon.png')}}" width="30%" style="margin-top:25px;margin-bottom:5px" alt="PWG Group"></div>
                                    <h5 class="modal-title" id="familyModalLabel">FAMILY PACKAGE</h5>
                                    {{-- <button type="button" style="float:right; font-size:11px; width:20px;height:20px" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                </div>
                                <div class="modal-body" style="height:auto">
                                    <p style="font-size: 18px">Dependants Details </p>
                                    <p style="font-size: 12px;margin-top:-10px">Please add details about your Dependants</p>
                                    @if(Route::has('login'))
                                    @auth
                                    <form action="{{ url('payment_form', $data->id) }}" method="GET">
                                    @else
                                    <form action="{{ url('register') }}">
                                        @php Session::put('prod_id', $data->id); @endphp
                                    @endauth
                                    @endif

                                    {{-- <input type="hidden" value="{{$data->id}}"> --}}
                                    <input type="hidden" name="pr_id" value="{{$data->id}}">
                                    @csrf

                                    <input type="hidden" name="productId" value="{{$productId}}">
                                    <input type="hidden" class="hiddenFamAmount" name="cost" value="{{($famdet) ?  number_format($famdet['first_payment_sub_total']) : 0 }}">
                                    <input type="hidden" value="FAMILY_PACKAGE" name="myPack">
                                    <input type="hidden" value="{{($famdet) ? $famdet->id : 0 }}" name="fam_id" class="fam_id">

                                    <div class="partner-sec">
                                        <?php $XYZ = Session::get('mySpouse'); ?>
                                        <p style="font-size: 12px">Is your spouse/partner accompanying you?</p>
                                        <p style="height: 13px; padding: 15px 30px;font-size: 12px;margin-top:-25px; margin-bottom:25px">
                                            Yes
                                            <label class="switch">
                                                <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'yes' ) checked="checked" @endif  onclick="handleClick(this);" value="yes">
                                                <span class="slider round"></span>
                                            </label>
                                            
                                            No
                                            <label class="switch">
                                                <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'no' || $XYZ == null) checked="checked" @endif onclick="handleClick(this);" value="no">
                                                <span class="slider round"></span>
                                            </label>
                                        </p>
                                    </div>

                                    <?php $ABC = Session::get('myKids'); ?>

                                    <div class="children-sec">
                                        <p style="height: 13px">
                                            <p style="font-size: 12px;margin-bottom:-15px;margin-top:-10px">How many children will be accompanying you?</p>
                                            <div class=" row children">
                                                <div class="col-2">
                                                    <input type="radio" id="none" name="children" @if($ABC == 0 || $ABC==null ) checked="checked" @endif  onclick="handleKids(this);" value="0"/>
                                                    <label for="none">None</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="one" name="children" @if($ABC == 1 || $ABC==null ) checked="checked" @endif onclick="handleKids(this);" value="1"/>
                                                    <label for="one">One</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="two" name="children" @if($ABC == 2 ) checked="checked" @endif onclick="handleKids(this);" value="2" />
                                                    <label for="two">Two</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="three" name="children" @if($ABC == 3 ) checked="checked" @endif onclick="handleKids(this);" value="3" />
                                                    <label for="three">Three</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="four" name="children" @if($ABC == 4 ) checked="checked" @endif onclick="handleKids(this);" value="4" />
                                                    <label for="four">Four</label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>

                                    <div class="row saved" style="padding:15px 5%; margin:3px 0 10px 0">
                                        <div class="col-5" style="background: #000; border-radius:30px 0 0 30px;color:#fff; font-size:10px;font-weight:600; padding-block: 5px;">SAVE AED <span class="Famamount_save">{{number_format($famdet_save,0)}}</span></div>
                                        <div class="col-7" style="background: #FACB08; border-radius:0 30px 30px 0;color:#000; font-size:10px; font-weight:600; padding-block: 5px;">WHEN YOU PAY IN FULL</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="border-top:0px solid rgb(57, 127, 184)"></div>
                                    </div>
                                    <div class="row price" style="padding:10px 5%">
                                        
                                        @php $blue_cost_old = $blue_cost*1.2995; $blue_save= $blue_cost_old - $blue_cost;@endphp
                                        <div class="col-5 promos" align="right"><span style="font-size:10px;;color:#000"><b>PROMO PRICE</b></span> <br> <b><span style="font-size:12px">AED</span> <span style="font-size:22px;color:#000" class="Famamount">{{number_format($famdet['first_payment_sub_total'],0)}}</span></b></div>
                                        <div class="col-1 separator" align="center" style="padding:0 3px; border-left: 0px solid rgb(57, 127, 184); height: 52px;transform: translateX(50%);"><b></b></div>
                                        <div class="col-6 actual" align="right" style="padding-right:15%"><span style="font-size:10px;color:#000"><b>REGULAR PRICE</b></span> <br> <span style="font-size:12px;color:#E10930">AED</span> <del style="font-size:22px;color:#E10930"><span style="font-size:22px;color:#E10930" class="Famamount_old">{{number_format($famdet_cost_old,0)}}</span></del></div>
                                    </div>

                                    <div class="form-groupx row" style=" margin:0 auto;"> 
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary se2" id="buy" value="1" name="payall"  style="width:80%;border-radius:5px; margin-block:3px; border: 0px solid #fff; background:#FACB08">FULL PAYMENT</button>
                                            <?php
                                            if($data->full_payment_discount > 0) {
                                            ?>
                                            {{-- <p style="margin-left:2px;font-weight:bold;font-size: 13px; margin-right:10px">Get <i>{{number_format(($data->full_payment_discount * $blue_cost/100))}} AED</i> discount on Full Payment</p> --}}
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="display:inline-block;">
                                            <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:80%; border-radius:5px;margin-block:3px">PAY INSTALLMENTS</button>
                                        </div>

                                            <p align="center" style="font-size: 11px">
                                                <i>By continuing, you have accepted our <a target="_blank" href="{{route('terms')}}"  style="color:#000;margin:0;font-size: 15px"><u>Terms & Conditions</u></a></i>
                                            </p>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Family Modal Ends -->
                    @endif
            </div>
        </div>

    </div>



@endSection
@push('custom-scripts')
<script>
    $(document).ready(function(){
            $('.blue-desc').hide();
            $('.white-desc').hide();
            $('.family-desc').hide();
            $('.study-desc').hide();
            $('.express-desc').hide();
            
            $('#blueSelect').hide()
            $('#whiteSelect').hide()
            $('#familySelect').hide()
            $('#studySelect').hide()
            $('#expressSelect').hide()

            $('.blue-collar').click(function(){
                let bluej = "BLUE_COLLAR"
                document.cookie = 'packageType='+bluej ;

                if($('.blue-desc').is(":visible"))
                {
                    $('.blue-desc').hide();
                } else {
                    $('.blue-desc').show(); 
                }
                $('.white-desc').hide();
                $('.family-desc').hide();
                $('.study-desc').hide();
                $('.express-desc').hide();

                $('#studySelect').hide()
                $('#expressSelect').hide()
                if($('#blueSelect').is(":visible"))
                {
                    $('#blueSelect').hide()
                } else {
                    $('#blueSelect').show()
                }
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.white-collar').click(function(){
                let whitej = "WHITE_COLLAR"
                document.cookie = 'packageType='+whitej ;

                $('.blue-desc').hide();
                if($('.white-desc').is(":visible"))
                {
                    $('.white-desc').hide();
                } else {
                    $('.white-desc').show();
                }
                $('.family-desc').hide();

                $('#blueSelect').hide()
                if($('#whiteSelect').is(":visible"))
                {
                    $('#whiteSelect').hide()
                } else {
                    $('#whiteSelect').show()
                }                 
                $('#familySelect').hide()
            });
            $('.family-package').click(function(){
                let famj = "FAMILY_PACKAGE"
                document.cookie = 'packageType='+famj ;

                $('.blue-desc').hide();
                $('.white-desc').hide();
                if($('.family-desc').is(":visible"))
                {
                    $('.family-desc').hide();
                } else {
                    $('.family-desc').show();
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                if($('#familySelect').is(":visible"))
                {
                    $('#familySelect').hide()
                } else {
                    $('#familySelect').show()
                }
            });

            $('.study-permit').click(function(){
                let studyj = "STUDY_PERMIT"
                document.cookie = 'packageType='+studyj ;

                if($('.study-desc').is(":visible"))
                {
                   $('.study-desc').hide();
                } else {
                    $('.study-desc').show();
                }
                $('.express-desc').hide();
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                if($('#studySelect').is(":visible"))
                {
                    $('#studySelect').hide()
                } else {
                    $('#studySelect').show()
                }
                $('#expressSelect').hide()
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.express-entry').click(function(){
                let expressj = "EXPRESS_ENTRY"
                document.cookie = 'packageType='+expressj ;
               
                $('.study-desc').hide();
                if($('.express-desc').is(":visible"))
                {
                    $('.express-desc').hide();
                } else {
                    $('.express-desc').show();
                }
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').hide();

                $('#studySelect').hide()
                if($('#expressSelect').is(":visible"))
                {
                    $('#expressSelect').hide()
                } else {
                    $('#expressSelect').show()
                }
                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
        });

</script>
@endpush

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

<script src="Scripts/jquery.session.js"></script>
<script type="text/javascript">

function handleClick(spouse) {
    parents = spouse.value;
    kidd = $('input[name="children"]:checked').val();

    getCost(kidd,parents);      
}

function handleKids(children) {
    let kidd = children.value;
    parents = $("input[name=spouse]:checked").val();

    getCost(kidd,parents);
}

function getCost(kidd, parents)
{
    $.ajax({
        type: 'GET',
        url: "{{ route('packageType',$productId)  }}",
        data: {kid : kidd, parents: parents , response : 1}, 
        success: function (data) {
            let vallu = (data.first_payment_sub_total*1.2995)-(data.first_payment_sub_total);
            
            $('.Famamount').text(parseFloat(data.first_payment_sub_total).toLocaleString());
            $('.Famamount_old').text(parseFloat(data.first_payment_sub_total*1.2995).toLocaleString());
            $('.Famamount_save').text(parseFloat(vallu).toLocaleString());
            $('.hiddenFamAmount').val(data.first_payment_sub_total);
            $('.fam_id').val(data.id);
        },
        error: function (error) {
        }
    });
}

</script>