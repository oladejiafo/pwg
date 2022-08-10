@extends('layouts.master')

<head>
</head>

@section('content')
    <div class="loginx">
        <div class="container">
            <div class="forgot-password" style="height: 700px;">
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