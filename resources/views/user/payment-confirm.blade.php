@extends('layouts.master')

<head>
    
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
  .btn {
    height: 60px;
    color: #000;
    font-size: 20px;
    width:80%;
  }
</style>
</head>

@section('content')
    <div class="login">
        <div class="container">
            <div class="forgot-password" >
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/reminder.png')}}" width="100% " alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment need to be confirmed!
                    </div>
                    <div class="subConfirm">Our Finance department will verify your payment and once done you will be able to download your invoice</div>
                    <div class="subConfirm">You can continue with application submission</div>
                    <div class="sig">
                        <form action="{{ url('applicant/details',$id) }}" method="GET">
                                <input type="hidden" name="pid" value="{{$id}}">
                                <button class="btn btn-primary ose">APPLICATION DETAILS</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection