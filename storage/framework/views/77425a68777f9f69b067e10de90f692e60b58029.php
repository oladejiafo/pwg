<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        </head>
        <!-- <title>Botchatbox Chat Application</title>
        
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
        
        <style>
            html, body {
                background-color: #fff;
                /* color: #636b6h; */
                font-weight: 100;
                height: 100px;
                margin: 10px;
            }
        </style>
        
        <body>
            <script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/chat.js'></script>
        </body>

        <script type="text/javascript">
            var botmanWidget = {
                frameEndpoint:'https://www.youtube.com/',
                aboutText: 'Hello there',
                introMessage: "I am Botman, Happy to talk with you!",
                title: 'ChatBot'
            };
        </script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    </head> -->

    <body>
      <div class="fb-customerchat" page_id="YOUR_PAGE_ID" theme_color="#whatever"></div>
    </body>

<script>
    window.fbAsyncInit = function() {
    FB.init({
      autoLogAppEvents : true,
      xfbml : true,
      version : 'v2.11'
    });
  };
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
</html><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views\user\chatbox.blade.php ENDPATH**/ ?>