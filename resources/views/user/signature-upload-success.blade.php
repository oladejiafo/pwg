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
        <div class="container" style="margin-top: 130px;">
            <div class="forgot-password" style="padding-top: 30px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/Approved.svg')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Awesome !
                    </div>
                    <div class="subConfirm">Your signature has been uploaded successfully</div>
                    <div class="sig">
                        <form action="{{ route('payment') }}" method="GET">
                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <button  style="font-size:20px;" class="btn btn-primary ose">Proceed To Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection