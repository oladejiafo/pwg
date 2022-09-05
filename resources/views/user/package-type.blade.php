@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">

<style>
  .selected path {
    fill: #000;
  }
</style>


@section('content')



    <div class="container" style="margin-top: 150px;">
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
                            <div class="dataCompleted" id="blueSelect" style="margin-top:-35px !important; margin-left:99% !important">
                                <img class="selected" src="{{asset('images/Affiliate_Program_Section_Completed.svg')}}" alt="approved">
                            </div>
                                <img src="{{asset('images/yellowWhiteCollar.svg')}}">
                                <h6>Blue Collar Package</h6>
                                <p class="amountSection"><span class="amount">{{number_format($data->unit_price,0)}}</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type  white-collar">
                            
                            <div class="content">
                            <div class="dataCompleted" id="whiteSelect" style="margin-top:-35px !important; margin-left:99% !important">
                                <img src="{{asset('images/Affiliate_Program_Section_Completed.svg')}}" alt="approved">
                            </div>
                                <img src="{{asset('images/yellowBlueCollar.svg')}}">
                                @if($whiteJobs->first())
                                @foreach($whiteJobs as $whiteJob)
                                @if ($loop->first)
                                
                                 @php                                   
                                   $whiteJob_cost = $whiteJob->cost + $data->unit_price
                                 @endphp 

                                 @endif
                                @endforeach
                                @else 
                                @php                                   
                                   $whiteJob_cost = 0
                                 @endphp
                                @endif
                                <h6>White Collar Package</h6>
                                <p class="amountSection"><span class="amount">{{($whiteJob_cost > 0) ? number_format($whiteJob_cost,0) : 0}}</span><b>AED</b></p>
                                                      
                                   @if($whiteJob_cost == 0)
                                   <p style="font-size: 14px">
                                     Package Not Available 
                                   </p> 
                                   @endif
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type family-package">
                            <div class="content">
                            <div class="dataCompleted" id="familySelect" style="margin-top:-35px !important; margin-left:99% !important">
                                <img src="{{asset('images/Affiliate_Program_Section_Completed.svg')}}" alt="approved">
                            </div>
                                <img src="{{asset('images/yellowFamily.svg')}}">
                                <h6>Family Package</h6>
                                <p class="amountSection"><span class="Famamount">{{($famdet) ?  number_format($famdet['cost'],0) : 0 }}</span><b>AED</b></p>
                                   @if(!$famdet)
                                   <p style="font-size: 14px">
                                     Package Not Available 
                                   </p> 
                                   @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="package-desc">
                        <div class="blue-desc">
                            
                           {{-- @include('user.package-jobs') --}}
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <form method="POST" action="{{ url('product') }}">
                                    @csrf
                                    <input type="hidden" name="cost" value="{{$data->unit_price}}">
                                   
                                     <input type="hidden" value="Blue Collar Jobs" name="myPack">
                                    <!-- <a class="btn btn-primary" href="{{ url('product') }}" style="width: 100%;font-size: 24px;">Continue</a> -->
                                    <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                </form>
                                </div>
                            </div>
                        </div>
                        <div class="white-desc">
                  
                             {{-- @include('user.white-collar-packge') --}}
                        
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                <form method="POST" action="{{ url('product') }}">
                                    @csrf
                                    <input type="hidden" name="cost" value="{{$whiteJob_cost}}">
                                    <input type="hidden" value="White Collar Jobs" name="myPack">
                                    <!-- <a class="btn btn-primary" href="{{ url('product') }}" style="width: 100%;font-size: 24px;">Continue</a> -->
                                    <button type="submit" class="btn btn-primary" style="width: 100%;font-size: 24px;">Continue</button>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="family-desc">

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
                                <input type="hidden" class="hiddenFamAmount" name="cost" value="{{($famdet) ?  number_format($famdet['cost']) : 0 }}">
                                <input type="hidden" value="FAMILY PACKAGE" name="myPack">
                                <input type="hidden" value="{{($famdet) ? $famdet->id : 0 }}" name="fam_id">

                                <div class="partner-sec">
                                <?php $XYZ = Session::get('mySpouse'); ?>
                                    <p style="height: 13px"><span class="header"> Partner/Spouse</span>
                                        Yes
                                        <label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'yes' ) checked="checked" @endif  onclick="handleClick(this);" value="yes">
                                            <span class="slider round"></span>
                                        </label>
                                        
                                        No<label class="switch">
                                            <input type="radio" id="mySpouse" name="spouse" @if($XYZ == 'no' || $XYZ == null) checked="checked" @endif onclick="handleClick(this);" value="no">
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
                                                <input type="radio" id="none" name="children" @if($ABC == 0 || $ABC==null ) checked="checked" @endif  onclick="handleKids(this);" value="0"/>
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
                                                <input type="radio" id="five" disabled="disabled" name="children" @if($ABC == 5 ) checked="checked" @endif  onclick="handleKids(this);" value="5" />
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
            
            $('#blueSelect').hide()
            $('#whiteSelect').hide()
            $('#familySelect').hide()

            $('.blue-collar').click(function(){
                let bluej = "Blue Collar Jobs"
                document.cookie = 'packageType='+bluej ;
               
                $('.blue-desc').show();
                $('.white-desc').hide();
                $('.family-desc').hide();

                $('#blueSelect').show()
                $('#whiteSelect').hide()
                $('#familySelect').hide()
            });
            $('.white-collar').click(function(){
                let whitej = "White Collar Jobs"
                document.cookie = 'packageType='+whitej ;

                $('.blue-desc').hide();
                $('.white-desc').show();
                $('.family-desc').hide();

                $('#blueSelect').hide()
                $('#whiteSelect').show()
                $('#familySelect').hide()
            });
            $('.family-package').click(function(){
                let famj = "FAMILY PACKAGE"
                document.cookie = 'packageType='+famj ;

                $('.blue-desc').hide();
                $('.white-desc').hide();
                $('.family-desc').show();

                $('#blueSelect').hide()
                $('#whiteSelect').hide()
                $('#familySelect').show()
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
    // document.cookie = 'parents='+parents ;        
}

function handleKids(children) {
let kidd = children.value;
parent = $("input[name=spouse]:checked").val();

getCost(kidd,parent);

//  document.cookie = 'pers='+kidd ; 
//  window.location.href = "{{ route('packageType',$productId) }}";
}

function getCost(kidd, parents)
{
    $.ajax({
        type: 'GET',
        url: "{{ route('packageType',$productId)  }}",
        data: {kid : kidd, parents: parents , response : 1}, 
        success: function (data) {
            console.log(data)

            $('.Famamount').text(parseFloat(data.cost).toLocaleString());
            $('.hiddenFamAmount').val(data.cost);
        },
        errror: function (error) {
        }
    });
}

</script>