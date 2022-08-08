@extends('layouts.master')

<head>
    <style>
        .succ {
            width: 60%;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin: 0 auto;
            padding: 70px 203px 70px 203px;
            box-shadow: 0 0 0 0.4px #ccc;
            background-color: #ffffff;
            margin-bottom: 420px;
            margin-top: 150px;
            color: #636466;
            align-content: center;
            max-height: 700px;
        }

        .sig button {
            display: flex;
        justify-content: center;
        align-items: center;
            width: 350px;
            height: 50px;
            background-color: none;
            border-color: #000;
            color: #000;
            font-family: "TTNormsPro-Regular";
            font-size: 25px;
            font-weight: bold;
            padding: 2px;
            box-shadow: 0 0 0 0.7px #ccc;

        }

        .sig button:hover {
            background-color: #f9bf29;
            border-color: #f9bf29;
        }
    </style>
</head>

@section('content')
    <div class="loginx">
        <div class="container">
            <div class="succ" style="margin-top:70px;">
                <div class="reset">
                    <div class="resetImage">
                        <img src="{{asset('images/Approved.svg')}}" alt="approved">
                    </div>
                    <div class="reset-heading">
                        Awesome !
                    </div>
                    <div class="subConfirm">Your signature has been uploaded successfully</div>
                    <div class="sig">
                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <button class="sig" style="border-color: #000;">Proceed To Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection