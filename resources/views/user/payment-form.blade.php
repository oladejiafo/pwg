@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('css/payment-form.css')}}" rel="stylesheet">
<link href="{{asset('css/alert.css')}}" rel="stylesheet">
<link rel="stylesheet" href="../user/extra/css/signature-pad.css">

@php 
    $completed = DB::table('applications')
        ->where('client_id', '=', Auth::user()->id)
        ->orderBy('id','desc')
        ->first();
    if(Session::has('myproduct_id'))
    {
        $pid = Session::get('myproduct_id');
    } else {
        $pid = $app_id;
    }
    $vals=array(0,1,2);
@endphp

@if($completed)
    @php
        $levels = $completed->application_stage_status;
        $app_id= $completed->id;
    @endphp
@else
    <script>window.location = "/home";</script>
@endif

<div class="container">
    <div class="col-12">        
        @if($levels == '5')
          <!-- Show Nothing -->
        @else
            <div class="wizard">
                <div class="row">
                    <div class="tabs d-flex justify-content-center">
                        <div class="wrapper">
                            <a href="{{ url('payment_form', $pid)}}" class="wrapper-link">
                                <div class="round-active round2 m-2">1</div>
                            </a>
                            <div class="col-2 round-title">Payment <br> Details</div>
                        </div>
                        <div class="linear"></div>
                        
                        @if ($levels == '5' || $levels == '4' || $levels == '3' || $levels == '2')
	                        <div class="wrapper">
	                            <a href="{{route('applicant.details', $pid)}}" class="wrapper-link">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="{{url('applicant/review', $pid)}}" class="wrapper-link">
	                                <div class="round5 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @else
	                        <div class="wrapper">
	                            <a href="#" onclick="toastr.error('You have to complete Payment first');" class="wrapper-link toastrDefaultError">
	                                <div class="round4 m-2">2</div>
	                            </a>
	                            <div class="col-2 round-title">Applicant <br> Details</div>
	                        </div>
	                        <div class="linear"></div>
	                        <div class="wrapper">
	                            <a href="#" onclick="toastr.error('You have to complete Payment first');"  class="wrapper-link toastrDefaultError">
	                                <div class="round5 m-2">3</div>
	                            </a>
	                            <div class="col-2 round-title">Application <br> Review</div>
	                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="payment-form">
            <div class="contract-signature">
                <div class="row">
                    <div class="col-6">
                        <div class="contract">
                            <div class="contractImg">
                                <img src="{{asset('images/contract.png')}}" width="100%" height="100%">
                                <h6>CONTRACT</h6>
                                <p>Please review the contract carefully</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <form enctype="multipart/form-data" id="signatureSubmit">
                                @csrf
                                <input type="hidden" name="pid" value="{{$data->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="payall" value="{{$payall}}">
                                <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <canvas id="sig"></canvas>
                                </div>
            
                                <div class="signature-pad--footer">                              
                                    <div class="signature-pad--actions">
                                    </div>
                                </div>
                                
                                <div class="toast-container"><div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>