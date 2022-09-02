
@include('user/header')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="../user/extra/css/signature-pad.css">

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body>

<div class="login">

  <div class="container">
    <div class="col-12">
        <div class="signature tt">
            <div class="append">
                <div class="append-title">
                    <div class="col-4 offset-4 signatureLogo">
                        <img src="{{asset('images/signature.svg')}}" width="100%" height="100%">
                    </div>
                    <h1>Append Your Signature</h1>
                    <p>To proceed to payment, please upload your signature</p>
                    <div class="col-8 offset-2">
                        <form action="{{ url('upload_signature') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="pid" value="{{$data->id}}">
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">


                            <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                  <canvas id="sig"></canvas>
                                </div>
                                <div class="signature-pad--footer">
                                <div class="description">Sign above</div>

                                <div class="signature-pad--actions">
                                    <textarea name="signed" id="signature64" ></textarea>
                                    <div>
                                    <button type="button" class="btn btn-primary clear" id="clear" data-action="clear">CLEAR</button>
                                    <!-- <button type="button" class="button" data-action="change-color">Change color</button>
                                    <button type="button" class="button" data-action="undo">Undo</button> -->

                                    </div>
                                    <div>
                                    <button type="button" class="btn btn-primary">SUBMIT</button>
                                     <!-- <button type="button" class="button save" data-action="save-png">Save as PNG</button>  -->
                                    <!-- <button type="button" class="button save" data-action="save-jpg">Save as JPG</button> -->
                                    <!-- <button type="button" class="button save" data-action="save-svg">Save as SVG</button> -->
                                    </div>
                                </div>
                                </div>
                            </div>
                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
 </div>
</div>

  <script src="../user/extra/js/signature_pad.umd.js"></script>
  <script src="../user/extra/js/app.js"></script>

  <script type="text/javascript">

    $("#sig").mouseout(function(event) {
        var canvass = document.getElementById('sig');
        var src  = canvass.toDataURL("image/png");
        // alert(src);
        // $("#signature64").val('');
        $("#signature64").val(src);
    });

    $('#clear').click(function(e) {
            
        $("#signature64").val('');
    });

// $(document).ready(function() {

//         var sig = $('#sig').saveSignature({
//             syncField: '#signature64',
//             syncFormat: 'PNG'
//         });

//         $('#clear').click(function(e) {
//             e.preventDefault();
//             sig.signaturePad('clear');
//             $("#signature64").val('');
//         });

// });

  </script>
</body>
</html>
