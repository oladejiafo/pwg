<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>EMAS Notification</title>	
    
</head>
<style>
    body{
    background: #E9EBF4;
}

.mail {
    width: 60%;max-width: 100%;margin-left: auto;margin-right: auto;margin: 0 auto;padding: 100px;background-color: #ffffff;margin-bottom: 150px;margin-top: 150px;text-align: center
}

.mailHead {
    font-family: Yantramanav, sans-serif;font-size: 30px;font-weight: 900;line-height: 48px;letter-spacing: 0em;text-align: center;color: #383838; margin-top: 30px;
}

.mailContent {
    font-family: Yantramanav, sans-serif;font-size: 18px;font-weight: lighter;line-height: 27px;letter-spacing: 0em;text-align: center;color: #383838;margin-top: 20px;
}

.mailHeadImage {
    width: 500px;height: 300px;display: block;margin: auto;
}
</style>
<body style="background: #E9EBF4;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
                <td>
					<table border="0" cellpadding="0" cellspacing="0" class="mail" style="width: 60%;max-width: 100%;margin-left: auto;margin-right: auto;margin: 0 auto;padding: 100px;background-color: #ffffff;margin-bottom: 150px;margin-top: 150px;text-align: center; ">
                        <tbody style="border-bottom:1px solid #383838 ">
                            <tr style="border-bottom:1px solid #383838 ">
                                <td>
                                    <div class="mailHeadImage" style="width: 500px;height: 300px;display: block;margin: auto;">
                                        <img src="<?php echo e(asset('images/paymentsuccesmail.png')); ?>" alt="" width="100%" height="100%">
                                    </div>
                                    <div class="content-block">
                                        <div class="mailHead" style="font-family: Yantramanav, sans-serif;font-size: 30px;font-weight: 900;line-height: 48px;letter-spacing: 0em;text-align: center;color: #383838; margin-top: 30px;">PAYMENT SUBMITTED <br>
                                            SUCCESSFULLY!</div>
                                                                                    
                                        <p class="mailContent" style="font-family: Yantramanav, sans-serif;font-size: 18px;font-weight: lighter;line-height: 27px;letter-spacing: 0em;text-align: center;color: #383838;margin-top: 20px;">Thank you. <br>
                                            You have successfully made your <b style="font-weight: bold"><?php echo e(ucwords($data['paymentType'])); ?></b><br>
                                            and you can view & download your invoice under <br>
                                            <b>My Applications</b> on our portal. You will be notified when your <br>
                                            embassy appointment is set. </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn" style="color:#fff;background: #6DCB16;  text-decoration: none;padding: 17px 97px;margin: 20px auto;font-family: 'Montserrat';font-style: normal;font-weight: 700;font-size: 28px;line-height: 125px;" href="http://eportal.emasimmigration.in//myapplication">GET INVOICE</a>
                                </td>
                            </tr>
                            <tr style="width:100%">
                                <td>
                                    <hr style="margin-left: -100px; margin-right:-100px !important;color:#383838;height:0.25px">
                                    <div style="display: block">
                                        <div style="width:49%; display:inline-block">
                                            <div style="width:73%;float:right; height: 51px">
                                                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="" width="100%" height="100%">
                                            </div>
                                        </div>
                                        <div style="display: inline-block;border: 1.5px solid #383838;height: 47px;"></div>
                                        <div style="width:49%; display:inline-block">
                                            <p style="font-family: 'Yantramanav';
                                            font-style: normal;
                                            font-weight: 300;
                                            font-size: 10px;
                                            line-height: 20px;
                                            color: #383838;
                                            text-align: left;">
                                                ©<?php echo e(now()->year); ?> EMAS INTERNATIONAL <br>
                                                B505, G Block Rd, G Block BKC, Bandra Kurla Complex, <br>
                                                Bandra East, Mumbai, Maharashtra 400098, India <br>
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
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/emails/payment-success.blade.php ENDPATH**/ ?>