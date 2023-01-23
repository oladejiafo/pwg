<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>PWG Notification</title>	
    
</head>
<body style="background: #E9EBF4;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
                <td>
					<table border="0" cellpadding="0" cellspacing="0" class="mail" style="width: 60%;max-width: 100%;margin-left: auto;margin-right: auto;margin: 0 auto;padding: 80px;background-color: #ffffff;margin-bottom: 150px;margin-top: 150px;text-align: center; ">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="width: 400px;height: 300px;display: block;margin: auto;">
                                        <img src="<?php echo e(asset('images/congratulationsicon.png')); ?>" alt="" width="100%" height="100%">
                                    </div>
                                    <div class="content-block">
                                        <div class="mailHead" style="font-family: Yantramanav, sans-serif;font-size: 30px;font-weight: 900;line-height: 48px;letter-spacing: 0em;text-align: center;color: #383838; margin-top: 30px;">APPLICATION SUBMITTED 
                                            <br> SUCCESSFULLY!</div>
                                                                                    
                                        <p class="mailContent" style="font-family: Yantramanav, sans-serif;font-size: 16px;font-weight: lighter;line-height: 27px;letter-spacing: 0em;text-align: center;color: #383838;margin-top: 20px;">
                                            Thank you for starting your journey with PWG Group <br>
                                            you can view your application under <b style="font-weight: bold">My Applications</b> on our portal. 
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn" style="color:#fff;background: #6DCB16;  text-decoration: none;padding: 17px 97px;margin: 20px auto;font-family: 'Montserrat';font-style: normal;font-weight: 700;font-size: 28px;line-height: 125px;" href="<?php echo e(env('APP_URL')); ?>">GET INVOICE</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <div style="display: block; margin-top:50px">
                                        <div style="width:35%; display:inline-block;padding-bottom:5px">
                                            <div style="float:right; height: 51px">
                                                <img src="<?php echo e(asset('images/logoo.png')); ?>" alt="" width="100%" height="100%">
                                            </div>
                                        </div>
                                
                                        <div style="display: inline-block;border: 1.5px solid #383838;height: 56px;"></div>
                                        <div style="width:35%; display:inline-block;padding-bottom:5px">
                                            <p style="font-family: Yantramanav, sans-serif;
                                                font-style: normal;
                                                font-weight: 300;
                                                font-size: 10px;
                                                line-height: 16px;
                                                color: #383838;
                                                text-align: left;">
                                                ©<?php echo e(now()->year); ?> PWG Group <br>
                                                The Oberoi Centre, Office - 20th Floor<br>
                                                Business Bay, Dubai<br>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/emails/application-submitted.blade.php ENDPATH**/ ?>