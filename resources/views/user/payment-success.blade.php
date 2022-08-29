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
        width: 68% !important;
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
    }

    .invoice-image:hover {
        background-image: url("{{asset('images/invoice-download-White.svg')}}") !important;
        background: #0f8c13;
    }

    .invoice-image {
        border-radius: 10px;
        width: 45px;
        height: 45px;
        margin-left: 24px;
        margin-top: 20px;
        background-image: url(http://127.0.0.1:8000/images/invoice-download.svg) !important;
        background-position: 47% 51% !important;
        background-repeat: no-repeat !important;
    }

</style>
</head>

@section('content')
    <div class="container" style="margin-top: 130px;">
        <div class="col-12">
            <div class="forgot-password" style="padding-top: 30px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/CheckMark.svg')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment successful !
                    </div>
                    <div class="subConfirm"> Your journey to Poland just began!</div>
                    <div class="sig">
                        <div class="invoice-now">
                            <div class="invoice">
                                <div class="invoice-image">

                                </div>
                                <p> Get the invoice now </p>
                            </div>
                        </div>
                        <div class="invoice-later">
                            <label class="switch">
                                <input type="checkbox" name="invoicelater" value="1">
                                <span class="slider round"></span>
                            </label>
                            <p> Get the invoice Later </p>
                        </div>
                        <form action="{{ route('applicant',$id) }}" method="GET">
                            <input type="hidden" name="pid" value="{{$id}}">
                            <button  style="font-size:20px" class="btn btn-primary ose">APPLICATION DETAILS</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection