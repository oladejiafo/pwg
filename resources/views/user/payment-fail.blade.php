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
                        <img src="{{asset('images/Failed_Mark.svg')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Payment unsuccessful !
                    </div>
                    <div class="subConfirm">We are unable to complete the transaction</div>
                    <div class="sig">
                        <form action="{{ route('payment',$id) }}" method="GET">
                            <input type="hidden" name="pid" value="{{$id}}">
                            <button  style="font-size:20px;" class="btn btn-primary ose">TRY AGAIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection