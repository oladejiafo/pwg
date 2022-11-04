<?php echo $__env->make('user/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
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
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>

<body>
  <?php if(session()->has('failed')): ?>
  <div class="alert alert-danger" style="margin-left:auto;margin-right:auto; width:40%; text-align:center;margin-bottom:20px">
    <button type="button" class="close" data-dismiss="alert" style="float:right;border-style:none;background-color: transparent"><i class="fa fa-times-circle" aria-hidden="true" style="color:#000; font-size:25px" ;></i>

    </button>
    <strong><?php echo e(session()->get('failed')); ?></strong>
  </div>
  <?php endif; ?>
  <div class="login">
  <?php
  $payall = $_REQUEST['payall'];
?>
    <div class="container">
      <div class="col-12">
        <div class="signature tt">
          <div class="append">
            <div class="append-title">
              <div class="col-4 offset-4 signatureLogo">
                <img src="<?php echo e(asset('images/signature.svg')); ?>" width="100%" height="100%">
              </div>
              <h1>Append Your Signature</h1>
              <p>To proceed to payment, please upload your signature</p>
              <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                <form enctype="multipart/form-data" id="signatureSubmit">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="pid" value="<?php echo e($data->id); ?>">
                  <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                  <!-- <textarea name="signed" id="signature64" required></textarea> -->
                  <input type="hidden" name="payall" value="<?php echo e($payall); ?>">
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
                          <button type="submit" id="sigBtn"  class="btn btn-primary">SUBMIT</button>
                          
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
  <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
  <script src="<?php echo e(asset('js/alert.js')); ?>"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#signatureSubmit").submit(function(e) {
        e.preventDefault();

        html2canvas([document.getElementById('sig')], {
          onrendered: function(canvas) {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            // document.getElementById("canvasImage").src="data:image/gif;base64,"+img_data;

            $.ajax({
              type: 'POST',
              url: "<?php echo e(url('upload_signature')); ?>",
              data: {
                "_token": "<?php echo e(csrf_token()); ?>",
                signed: canvas_img_data,
                payall: '<?php echo e($payall); ?>',
                response: 1
              },
              success: function(data) {
                if (data) {
                  location.href = "<?php echo e(url('payment_form')); ?>/" + '<?php echo e($data->id); ?>';

                } else {
                  alert('Something went wrong');
                }

              },
              error: function(error) {}
            });

          }
        });
      });
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


  </script>
</body>

</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/signature.blade.php ENDPATH**/ ?>