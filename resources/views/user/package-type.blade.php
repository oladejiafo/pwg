@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">
<style>

</style>
@section('content')


@foreach($famdet as $fam)
@if($loop->first)

@php 
$fam_cost = $fam->cost
@endphp
@endif
@endforeach
    <div class="container">
        <div class="col-12">
            <div class="package">
                <div class="header">
                    <h3>Package Type</h3>
                    <div class="bottoom-title">
                        <p>We’ve got you covered</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="package-type blue-collar">
                            <div class="content">
                                <img src="{{asset('images/yellowWhiteCollar.svg')}}">
                                <h6>Blue Collar Package</h6>
                                <p class="amountSection"><span class="amount">{{number_format($data->unit_price,0)}}</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type  white-collar">
                            <div class="content">
                                <img src="{{asset('images/yellowBlueCollar.svg')}}">
                                @foreach($whiteJobs as $whiteJob)
                                @if ($loop->first)
                                 @php                                   
                                   $whiteJob_cost = $whiteJob->cost + $data->unit_price
                                 @endphp 
                                 @endif
                                @endforeach
                                <h6>White Collar Package</h6>
                                <p class="amountSection"><span class="amount">{{number_format($whiteJob_cost,0)}}</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type family-package">
                            <div class="content">
                                <img src="{{asset('images/yellowFamily.svg')}}">
                                <h6>Family Package</h6>
                                <p class="amountSection"><span class="amount">{{ number_format($fam_cost) }}</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="package-desc">
                        <div class="blue-desc">
                        @if(session()->has('packageType')) 
                           @php 
                            session()->forget('packageType');
                          @endphp
                        @endif
                        @php                            
                         session(['packageType' => 'BLUE COLLAR JOBS']);
                        @endphp

                            @include('user.package-jobs')
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <a class="btn btn-primary" href="{{ url('product', $productId) }}" style="width: 100%;font-size: 24px;">Continue</a>
                                </div>
                            </div>
                        </div>
                        <div class="white-desc">
                        @if(session()->has('packageType')) 
                           @php 
                            session()->forget('packageType');
                          @endphp
                        @endif
                        @php                            
                         session(['packageType' => 'WHITE COLLAR JOBS']);
                        @endphp

                            @include('user.white-collar-packge')
                        
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <a class="btn btn-primary" href="{{ url('product', $productId) }}" style="width: 100%;font-size: 24px;">Continue</a>
                                </div>
                            </div>
                        </div>

                        <div class="family-desc">

                        @if(session()->has('packageType')) 
                           @php 
                            session()->forget('packageType');
                          @endphp
                        @endif
                        @php                            
                         session(['packageType' => 'FAMILY PACKAGE']);
                        @endphp

                            <div class="header">
                                <h4>Dependants Details</h4>
                                <div class="bottoom-title">
                                    <p>Please add details about your dependants here</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ url('product') }}">
                            <!-- <form method="POST" action="{{url('family/details/submit')}}"> -->
                          
                                @csrf
                              
                                <input type="hidden" name="productId" value="{{$productId}}">
                                <input type="hidden" name="cost" value="{{$fam_cost}}">
                                <div class="partner-sec">
                                <?php $XYZ = Session::get('mySpouse'); ?>
                                    <p style="height: 13px"><span class="header"> Partner/Spouse</span>
                                        Yes
                                        <label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'yes' ) checked="checked" @endif  onclick="handleClick(this);" value="yes">
                                            <span class="slider round"></span>
                                        </label>
                                        
                                        No<label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'no' ) checked="checked" @endif onclick="handleClick(this);" value="no">
                                            <span class="slider round"></span>
                                        </label>
                                    </p>

                                    <p>Is your spouse/partner accompanying you?</p>
                                </div>

                                <?php $ABC = Session::get('myKids'); ?>

                                <div class="children-sec">
                                    <p style="height: 13px">
                                        <span class="header"> Children</span>
                                        <ul class="children">
                                            <li>
                                                <input type="radio" id="none" name="children" @if($ABC == 0 || $ABC==null ) checked="checked" @endif value="0"/>
                                                <label for="none">None</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="one" name="children" @if($ABC == 1 ) checked="checked" @endif onclick="handleKids(this);" value="1"/>
                                                <label for="one">One</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="two" name="children" @if($ABC == 2 ) checked="checked" @endif onclick="handleKids(this);" value="2" />
                                                <label for="two">Two</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="three" name="children" @if($ABC == 3 ) checked="checked" @endif onclick="handleKids(this);" value="3" />
                                                <label for="three">Three</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="four" name="children" @if($ABC == 4 ) checked="checked" @endif onclick="handleKids(this);" value="4" />
                                                <label for="four">Four</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="five" name="children" @if($ABC == 5 ) checked="checked" @endif  onclick="handleKids(this);" value="5" />
                                                <label for="five">Five</label>
                                            </li>
                                        </ul>
                                    </p>
                                </div>

                                <div class="form-group row" style="margin-top: 140px"> 
                                    <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
            $('.blue-collar').click(function(){
                $('.blue-desc').show();
                $('.white-desc').hide();
                $('.family-desc').hide();
            });
            $('.white-collar').click(function(){
                $('.blue-desc').hide();
                $('.white-desc').show();
                $('.family-desc').hide();
            });
            $('.family-package').click(function(){
                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').show();
            });
        });


// $('a[data-booked]').click(function($e){
//     $e.preventDefault();
//      $.post("/ajax/add-book", {
//         "packageType": $(this).data('book')
//       });
// });
</script>
@endpush

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<!-- https://www.jsdelivr.com/package/npm/jquery.session -->

<script src="Scripts/jquery.session.js"></script>
<script type="text/javascript">

function handleClick(spouse) {
 
    parents = spouse.value;

    // document.cookie = 'parents='+parents ;        
    // window.location.href = "{{ route('packageType',$productId) }}";
}

function handleKids(children) {
let kidd = children.value;

 document.cookie = 'parents='+parents ;
 document.cookie = 'pers='+kidd ; 


 window.location.href = "{{ route('packageType',$productId) }}";
}

</script>