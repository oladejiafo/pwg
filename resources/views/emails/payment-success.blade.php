<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>PWG Notification</title>	
    {{-- <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/mail.css')}}'> --}}
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
					<table border="0" cellpadding="0" cellspacing="0" class="mail" style="width: 80%;max-width: 100%;margin-left: auto;margin-right: auto;margin: 0 auto;padding: 80px 80px 40px 80px;background-color: #ffffff;margin-bottom: 150px;margin-top: 150px;text-align: center; ">
                        <tbody style="border-bottom:1px solid #383838 ">
                            <tr style="border-bottom:1px solid #383838 ">
                                <td>
                                    <div class="mailHeadImage" style="width: 400px;height: 250px;display: block;margin: auto;">
                                        <img src="{{asset('images/paymentsuccesmail.png')}}" alt="" width="100%" height="100%">
                                    </div>
                                    <div class="content-block">
                                        <div class="mailHead" style="font-family: Yantramanav, sans-serif;font-size: 30px;font-weight: 900;line-height: 48px;letter-spacing: 0em;text-align: center;color: #383838; margin-top: 30px;">PAYMENT SUBMITTED <br>
                                            SUCCESSFULLY!</div>
                                                                                    
                                        <p class="mailContent" style="font-family: Yantramanav, sans-serif;font-size: 18px;font-weight: lighter;line-height: 27px;letter-spacing: 0em;text-align: center;color: #383838;margin-top: 20px;">Thank you. <br>
                                            You have successfully made your <b style="font-weight: bold">{{ucwords($data['paymentType'])}}</b><br>
                                            and you can view & download your invoice under <br>
                                            <b>My Applications</b> on our portal.@if(ucwords($data['paymentType']) != 'Third Payment') You will be notified when your <br>
                                            @if(ucwords($data['paymentType']) == 'First Payment') work permit is ready. @elseif(ucwords($data['paymentType']) == 'Second Payment') embassy appointment is set. @elseif(ucwords($data['paymentType']) == 'Full-Outstanding Payment') work permit & embassy appointment is set. @endif @endif</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td min-width ="100%;">
                                    <a class="btn" style="color: #fff;
                                    background: #6dcb16;
                                    text-decoration: none;
                                    padding: 12px 58px;
                                    margin: 20px auto;
                                    font-family: 'Montserrat';
                                    font-style: normal;
                                    font-weight: 700;
                                    font-size: 24px;
                                    line-height: 125px;" href="{{env('APP_URL')}}">GET-INVOICE</a>
                                </td>
                            </tr>
                            <tr>
                                <td min-width ="100%;">
                                    <a class="btn" style="color: #fff;
                                    background: #6dcb16;
                                    text-decoration: none;
                                    padding: 12px 58px;
                                    margin: 20px auto;
                                    font-family: 'Montserrat';
                                    font-style: normal;
                                    font-weight: 700;
                                    font-size: 24px;
                                    line-height: 125px;" href="{{env('APP_URL')}}">INVOICE</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" min-width ="100%;">
                                    <hr style="margin-left: -80px; margin-right:-80px !important;color:#383838;height:0.25px">
                                    <div style="display: block; margin-top:50px">
                                        <div style="width:35%; display:inline-block;">
                                            <div style="float:right; height: 51px">
                                                <img src="{{asset('images/logoo.png')}}" alt="" width="100%" height="100%">
                                            </div>
                                        </div>
                                
                                        <div style="display: inline-block;border: 1.5px solid #383838;height: 56px;"></div>
                                        <div style="width:35%; display:inline-block;">
                                            <p style="font-family: Yantramanav, sans-serif;
                                                font-style: normal;
                                                font-weight: 300;
                                                font-size: 10px;
                                                line-height: 16px;
                                                color: #383838;
                                                text-align: left;">
                                                ©{{ now()->year }} PWG Group <br>
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
