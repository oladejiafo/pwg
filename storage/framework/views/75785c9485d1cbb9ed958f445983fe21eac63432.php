<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>PWG Group</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' media='screen' href='<?php echo e(asset('css/login.css')); ?>'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="login">
            <div class="container">
                <div class="forgot-password">
                    <div class="reset">
                        <div class="resetImage">
                            
                        </div>
                        <div class="reset-heading">
                            Reset Password
                        </div>
                        <div class="reset-title">
                            <p>You are receiving this email because we received a password reset request for your account.</p>
                            <p>Here is your OTP <?php echo e($token); ?></p>
                            <p>This password reset will expire in 60 minutes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
    
<?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/emails/resetpassword-template.blade.php ENDPATH**/ ?>