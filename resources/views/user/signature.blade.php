@extends('layouts.master')

<html>

<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f1f1f1;
    }

    a.darken {
        background: #e0d8d881;

    }

    a.darken img {
        display: block;

        -webkit-transition: all 0.5s linear;
        -moz-transition: all 0.5s linear;
        -ms-transition: all 0.5s linear;
        -o-transition: all 0.5s linear;
        transition: all 0.5s linear;
    }

    a.darken:hover img {
        opacity: 0.5;

    }

    label {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 70%;
    }
</style>

@section('content')
    <div class="loginx">

        <div class="container-fluid">
            <div class="signature" style="box-shadow: 0 0 0 0.5px #ccc;">
                <div class="append">
                    <div class="append-title">
                        <h1>Append Your Signature</h1>
                        <p>To proceed to payment, please upload your signature</p>
                        <form action="{{ url('upload_signature') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="pid" value="{{$data->id}}">

                            <label>
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="file" name="image" style="display: none;" required="">
                                <img class="darken" style="cursor: pointer;" src="{{asset('user/images/upload.svg')}}" alt="signature" title="Click to upload file" class="upload">
                            </label>
                            <button class="btn btn-primary submitBtn">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection