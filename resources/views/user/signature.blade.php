@extends('layouts.master')

<html>

<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<link type="text/css" href="{{asset('user/css/jquery.signature.css')}}" rel="stylesheet">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!--[if IE]> 
<script type="text/javascript" src="js/excanvas.js"></script> 
<![endif]-->
<!-- <script type="text/javascript" src="..user/js/jquery.ui.touch-punch.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript" src="{{asset('user/js/jquery.signature.min.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('user/js/jquery.signature.js')}}"></script> -->
<style>
    .kbw-signature {
        width: 100%; height: 350px;

        align-content: center;
        border-radius: 10px;
        border-style: solid;
        border-color: #ccc; /*#f0f3f4*/;
        border-width: 1px;
    }

    #sig canvas {
        width: 100% !important;
        height: auto;
        z-index: 9099;
    }
    [contentEditable=true]:empty:not(:focus):before{
    content:attr(data-text);
    font-size: 30px;
    color:#ccc;
   
}
</style>
@section('content')
<div class="loginx">

    <div class="container-fluid">
        <div class="signature tt">
            <div class="append">
                <div class="append-title">
                    <h1>Append Your Signature</h1>
                    <p>To proceed to payment, please upload your signature</p>
                    <form action="{{ url('upload_signature') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pid" value="{{$data->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                        <div><br>
                            <p>Signature Here:</p>
                            <div id="sig" class="kbw-signature" contentEditable=true data-text="Sign Here">
                                
                            </div>
                            <p style="clear: both;">
                                <button id="clear" class="btn btn-primary">Clear</button>
                                <textarea name="signed" id="signature64" style="display:none"></textarea>
                            </p>

                        </div>
                        <button class="btn btn-primary" style="height:60px">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    $(function() {
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });

    });
</script>