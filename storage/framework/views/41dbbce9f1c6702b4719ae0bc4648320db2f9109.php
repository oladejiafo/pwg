<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>PWG Group</title>	
    </head>
    <body>
        <table role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;background-color:#edf2f7;margin:0;padding:0;width:100%" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
            <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif" align="center">
                <table role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;margin:0;padding:0;width:100%" width="100%" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td>
                            <div style="box-sizing:border-box;font-family:Yantramanav,sans-serif;margin-bottom:30px"></div>
                        </td>
                    </tr>
                    <tr>
                        <td cellpadding="0" cellspacing="0" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%" width="100%">
                            <table class="m_7403659591128230136inner-body" role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px;font-weight:300" width="570" cellspacing="0" cellpadding="0" align="center">
        
                            <tbody><tr>
                                <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif;max-width:100vw;padding:32px">
                                    <div style="box-sizing:border-box;font-family:Yantramanav,sans-serif;width:400px;height:250px;display:block;margin:30px auto">
                                        <img src="<?php echo e(asset('images/paymentsuccesmail.png')); ?>" alt="PWG Group" width="100%" height="100%">
                                    </div>
                                    <h1 style="box-sizing:border-box;font-family:Yantramanav,sans-serif;color:#3d4852;font-size:24px;font-weight:bold;margin-top:0;text-align:center">PAYMENT SUBMITTED <br>
                                        SUCCESSFULLY!</h1>
                                    <p style="box-sizing:border-box;font-family:Yantramanav,sans-serif;font-size:15px;line-height:1.5em;margin-top:0;text-align:center">Thank you,</p>
                                    <p style="box-sizing:border-box;font-family:Yantramanav,sans-serif;font-size:15px;line-height:1.5em;margin-top:0;text-align:center">
                                            You have successfully made your <b style="font-weight: bold"><?php echo e(ucwords($data['paymentType'])); ?></b> payment<br>
                                            and you can view & download your invoice under <br>
                                            <b>My Applications</b> on our portal. If you are not completed with application details the work permit will be delay. 
                                            <?php if(ucwords($data['paymentType']) != 'SECOND'): ?> You will be notified when your <br>
                                            <?php if(ucwords($data['paymentType']) == 'FIRST'): ?> work permit is ready. <?php elseif(ucwords($data['paymentType']) == 'SUBMISSION'): ?> embassy appointment is set. <?php elseif(ucwords($data['paymentType']) == 'Full-Outstanding Payment'): ?> work permit & embassy appointment is set. <?php endif; ?> <?php endif; ?>
                                    </p>
                                    <table role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;margin:auto;padding:0;text-align:center;float:center;width:100%;margin-bottom:1.5em" width="100%" cellspacing="0" cellpadding="0" align="center">
                                        <tbody><tr>
                                            <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif" align="center">
                                                <table role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody><tr>
                                                        <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif" align="center">
                                                            <table role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif" cellspacing="0" cellpadding="0" border="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif">
                                                                            <a href="<?php echo e(env('APP_URL')); ?>/myapplication" class="m_6264836849513322656button" rel="noopener" style="font-size: 20px;font-weight:500;box-sizing:border-box;float:center;border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;padding:12px;width:200px;text-align:center;background-color:#2ead0c!important;border:1px solid #c4c6cd" target="_blank" >GET INVOICE</a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <div style="display: block; margin-top:40px; text-align:center">
                                        <div style="width:40%; display:inline-block;">
                                            <div style="text-align: center;
                                            height: 51px;
                                            width: 23%;
                                            float: right;margin-right:25px;">
                                                <img src="<?php echo e(asset('images/logoo.png')); ?>" alt="PWG Group" width="100%" height="100%">
                                            </div>
                                        </div>
                        
                                        <div style="display: inline-block;border: 1px solid #383838;height: 45px;"></div>
                                        <div style="width:50%; display:inline-block;">
                                            <p style="font-family: Yantramanav, sans-serif;
                                                font-style: normal;
                                                font-weight: 300;
                                                font-size: 9px;
                                                line-height: 14px;
                                                color: #383838;
                                                text-align: left;
                                                margin-left:25px">
                                                ©<?php echo e(now()->year); ?> PWG Group <br>
                                                The Oberoi Centre, Office - 20th Floor<br>
                                                Business Bay, Dubai, United Arab Emirates<br>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            <tr>
            <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif">
            <table class="m_7403659591128230136footer" role="presentation" style="box-sizing:border-box;font-family:Yantramanav,sans-serif;margin:0 auto;padding:0;text-align:center;width:570px" width="570" cellspacing="0" cellpadding="0" align="center">
                <tbody><tr>
                    <td style="box-sizing:border-box;font-family:Yantramanav,sans-serif;max-width:100vw;padding:32px" align="center">
                    </td>
                </tr>
            </tbody></table>
        </td>
        </tr>
        </tbody></table>
        </td>
        </tr>
        </tbody></table>
    </body>
</html>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/emails/payment-success.blade.php ENDPATH**/ ?>