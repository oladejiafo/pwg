@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">
<style>

</style>
@section('content')
    <div class="container">
        <div class="col-12">
            <div class="package">
                <div class="header">
                    <h3>Package type</h3>
                    <div class="bottoom-title">
                        <p>we’ve got you covered</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="package-type blue-collar">
                            <div class="content">
                                <img src="{{asset('images/yellowWhiteCollar.svg')}}">
                                <h6>Blue Collar Package</h6>
                                <p class="amountSection"><span class="amount">4,789</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type  white-collar">
                            <div class="content">
                                <img src="{{asset('images/yellowBlueCollar.svg')}}">
                                <h6>White Collar Package</h6>
                                <p class="amountSection"><span class="amount">6,789</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="package-type family-package">
                            <div class="content">
                                <img src="{{asset('images/yellowFamily.svg')}}">
                                <h6>Family Package</h6>
                                <p class="amountSection"><span class="amount">8,789</span><b>AED</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="package-desc">
                        <div class="blue-desc">
                            @include('user.package-jobs')
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <a class="btn btn-primary" href="{{ url('product', $productId) }}" style="width: 100%;font-size: 24px;">Continue</a>
                                </div>
                            </div>
                        </div>
                        <div class="white-desc">
                            @include('user.white-collar-packge')
                            <div class="form-group row" style="margin-top: 70px"> 
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <a class="btn btn-primary" href="{{ url('product', $productId) }}" style="width: 100%;font-size: 24px;">Continue</a>
                                </div>
                            </div>
                        </div>

                        <div class="family-desc">
                            <div class="header">
                                <h4>Dependants Details</h4>
                                <div class="bottoom-title">
                                    <p>Please add details aabout your dependants here</p>
                                </div>
                            </div>
                            <form method="POST" action="{{url('family/details/submit')}}">
                                @csrf
                                @method('PUT') 
                                <input type="hidden" name="productId" value="{{$productId}}">
                                <div class="partner-sec">
                                    <p style="height: 13px"><span class="header"> Partner/Spouse</span>
                                        Yes
                                        <label class="switch">
                                            <input type="radio" name="spouse" value="yes">
                                            <span class="slider round"></span>
                                        </label>
                                        
                                        No<label class="switch">
                                            <input type="radio" name="spouse" value="no">
                                            <span class="slider round"></span>
                                        </label>
                                        </p>
                                    <p>Is your spouse/partner accompanying you?</p>
                                </div>

                                <div class="children-sec">
                                    <p style="height: 13px">
                                        <span class="header"> Children</span>
                                        <ul class="children">
                                            <li>
                                                <input type="radio" id="none" name="children" checked="checked" value="0"/>
                                                <label for="none">None</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="one" name="children" value="1"/>
                                                <label for="one">One</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="two" name="children"value="2" />
                                                <label for="two">Two</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="three" name="children"value="3" />
                                                <label for="three">Three</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="four" name="children"value="4" />
                                                <label for="four">Four</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="five" name="children"value="5" />
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
</script>
@endpush