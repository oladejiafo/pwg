<!DOCTYPE html>

<html>

@include('user/header');

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
        display: block;
        width: auto;
    }
</style>

<body>
    <div class="login">
        <div class="container-fluid">
            @if(session()->has('message'))

                <div class="alert alert-success" style="margin: 0 auto;;font-size:15px; width:35%; padding:0; height:28px;">
                    <button type="button" class="close" data-dismiss="alert" style="float:right">
                        
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="signature">
                <div class="append">
                    <div class="append-title">
                        <h1>Append Your Signature</h1>
                        <p>To proceed to payment, please upload your signature</p>
                        <form action="{{ url('upload_signature') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="p_id" value="{{$data->id}}">

                            <label>
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="file" name="image" style="display: none;" required="">
                                <img class="darken" src="{{asset('user/images/upload.svg')}}" alt="signature" title="Click to upload file" class="upload">
                            </label>
                            <button class="btn btn-primary submitBtn">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>