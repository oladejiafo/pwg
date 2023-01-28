@extends('layouts.master')

<head>
    
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    .forgot-password .btn {
        margin-top: 25px;
        margin-left: auto !important;
        margin-right: auto !important;
        display: block;
        width: 100% !important;
    }

    .invoice p {
        margin-left: 83px;
        margin-top: -39px;
        font-size: 19px;
    }

    .invoice:hover {
        transform: scale(1.15);
        transition: 0.9s ease-in-out;
    }

    .invoice {
        transition: transform 0.9s ease;
        margin-top: -8%;
    }



    .invoice-image:hover {
        background-image: url("{{asset('images/invoice-download-White.svg')}}") !important;
        background: #0f8c13;
    }

    .invoice-image {
        border-radius: 10px;
        width: 45px;
        height: 35px;
        margin-left: 24px;
        margin-top: 20px;
        background-image: url("{{asset('images/invoice-download.svg')}}") !important;
        background-position: 47% 51% !important;
        background-repeat: no-repeat !important;
    }

    .ose {
        font-size: 18px
    }

    @media only screen and (max-width: 768px) and (min-width: 230px)
    {
        .ose {
            font-size: 14px
        }
    }

</style>
</head>
<?php
 $applicant = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                ->where('destination_id', $id)
                ->first();
?>

@section('content')
    <div class="container">
        <div class="col-12">
            <div class="forgot-password">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/CheckMark.png')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment successful !
                    </div>
                    <div class="subConfirm"> Your journey just began!</div>
                    <div class="sig">
                        <div class="invoice-now">
                            <div class="invoice">
                            <a href="{{url('/get/invoice')}}">
                                <div class="invoice-image">
                                </div>
                                    <p><a href="{{url('/get/invoice')}}"> Get the invoice now </a></p>
                            </div></a>
                        </div>
                        <div class="invoice-later">
                            <label class="switch">
                                <input type="checkbox" name="invoicelater" value="1">
                                <span class="slider round"></span>
                            </label>
                            <p> Get the invoice later </p>
                        </div>
                        @if($applicant->application_stage_status == 5)
                          <form action="{{ url('myapplication') }}" method="GET">
                        @else
                            <form action="{{ url('applicant/details',$id) }}" method="GET">
                        @endif
                            <input type="hidden" name="pid" value="{{$id}}">
                            <button class="btn btn-primary ose">APPLICATION DETAILS</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
