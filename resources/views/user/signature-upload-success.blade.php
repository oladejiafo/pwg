@extends('layouts.master')

<head>
    
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

@section('content')
    <div class="loginx">
        <div class="container">
            <div class="forgot-password">
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
                        <button class="btn btn-primary">Proceed To Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection