
@include('user/header')

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

                                    <div><br>
                                        <p>Signature Here:</p>
                                        <div id="sig" class="kbw-signature">
                                        
                                        </div>
                                        <p style="clear: both;">
                                            <button id="clear" class="btn btn-primary" style="height: 55px; width:100%">CLEAR</button>
                                            <textarea name="signed" id="signature64" style="display:none; " required></textarea>
                                        </p>

                                    </div>
                                    <button class="btn btn-primary" style="height:60px;width:100%">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    function resizeCanvas() {
  var ratio =  Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
  signaturePad.clear(); // otherwise isEmpty() might return incorrect value
}
window.addEventListener("resize", resizeCanvas);
resizeCanvas();
    var canvas = document.querySelector('canvas');
fitToContainer(canvas);
function fitToContainer(canvas){
  // Make it visually fill the positioned parent
  canvas.style.width ='100%';
  canvas.style.height='100%';
  // ...then set the internal size to match
  canvas.width  = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
}
</script>
