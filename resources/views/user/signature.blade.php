@include('user/header')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="../user/extra/css/signature-pad.css">
  <style>
    .toast-container {
      position:absolute;
      top:12%;
      width:100%;
      /* margin: auto; */
      left:43%;
      height:auto;
    }
    @media (min-width:260px) and (max-width:768px) {
        .toast-container {
        top:20%;
        width:100%;
        margin: auto; 
        left:2%;
      }
    }
  </style>
</head>

<body>
  @if(session()->has('failed'))
  <div class="alert alert-danger" style="margin-left:auto;margin-right:auto; width:40%; text-align:center;margin-bottom:20px">
    <button type="button" class="close" data-dismiss="alert" style="float:right;border-style:none;background-color: transparent"><i class="fa fa-times-circle" aria-hidden="true" style="color:#000; font-size:25px" ;></i>

    </button>
    <strong>{{ session()->get('failed') }}</strong>
  </div>
  @endif
  <div class="login">
  @php
  $payall = $_REQUEST['payall'];
@endphp
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
              <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                <form enctype="multipart/form-data" id="signatureSubmit">
                  @csrf
                  <input type="hidden" name="pid" value="{{$data->id}}">
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                  <!-- <textarea name="signed" id="signature64" required></textarea> -->
                  <input type="hidden" name="payall" value="{{$payall}}">
                  <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                      <canvas id="sig"></canvas>
                    </div>

                    <div class="signature-pad--footer">
                      <div class="description">Sign above</div>
                    
                      <div class="signature-pad--actions">

                        <div class="col-6">

                          <button type="button" class="btn btn-primary clear" id="clear" data-action="clear">CLEAR</button>
                        </div>
                        <div class="col-6">
                          <!-- <button type="submit" id="sigBtn" data-action="savePNG" class="btn btn-primary">SUBMIT</button> -->
                          <button type="button" id="sigBtn" data-action="save-png" class="btn btn-primary button save">SUBMIT</button>
                        </div>
                      </div>
                    </div>
                    
                    <div class="toast-container"><div>
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
  <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
  <script src="{{asset('js/alert.js')}}"></script>

  <script type="text/javascript">

    $(document).ready(function() {

        
    savePNGButton.addEventListener("click", () => {
      if (signaturePad.isEmpty()) {
        toastr.error("Please provide a signature.");
      } else {
        const dataURL = signaturePad.toDataURL();

        $.ajax({
          type: 'POST',
          url: "{{ url('upload_signature') }}",
          data: {
            "_token": "{{ csrf_token() }}",
            signed: dataURL,
            payall: '{{$payall}}',
            response: 1
          },
          success: function(data) {
            console.log(data);
            if (data) {
              location.href = "{{url('payment_form')}}/" + '{{$data->id}}';

            } else {
              alert('Something went wrong');
            }

          },
          error: function(error) {}
        });
      }
    });

      // ############////////
      // $("#signatureSubmit").submit(function(e) {
      //   e.preventDefault();
      //   html2canvas([document.getElementById('sig')], {
      //     onrendered: function(canvas) {
      //       var canvas_img_data = canvas.toDataURL('image/png');
      //       var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
      //       // document.getElementById("canvasImage").src="data:image/gif;base64,"+img_data;
     
      //       $.ajax({
      //         type: 'POST',
      //         url: "{{ url('upload_signature') }}",
      //         data: {
      //           "_token": "{{ csrf_token() }}",
      //           signed: canvas_img_data,
      //           payall: '{{$payall}}',
      //           response: 1
      //         },
      //         success: function(data) {
      //           if (data) {
      //             location.href = "{{url('payment_form')}}/" + '{{$data->id}}';

      //           } else {
      //             alert('Something went wrong');
      //           }

      //         },
      //         error: function(error) {}
      //       });

      //     }
      //   });
      // });
      
    });



    // $("#sig").mouseout(function(event) {
    //     var canvass = document.getElementById('sig');
    //     var src  = canvass.toDataURL("image/png");
    //     // $("#signature64").val('');
    //     $("#signature64").val(src);
    // });

    // $('#clear').click(function(e) {

    //     $("#signature64").val('');
    // });

    toastr.options = { 
      "closeButton": false,
      "debug": false,
      "newestOnTop": false, 
      "progressBar": false, 
      "positionClass": "toast-container",
      "preventDuplicates": false, 
      "onclick": null,
      "showDuration": "300", 
      "hideDuration": "1000", 
      "timeOut": "5000", 
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
    };

  </script>

@include('user/footer')
</body>

</html>