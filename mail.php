<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$mail = new PHPMailer(true);

    try {
        #========== SMTP DETAILS ==========#
        $mail->SMTPDebug    =  2;
        $mail->isSMTP();
        $mail->Host         = 'mail.shamsnatural.com';
        $mail->SMTPAuth     =  true;
        $mail->Username     = 'noreply@shamsnatural.com';
        $mail->Password     = '@^,ey&[5V%i-RQS0-I';
        $mail->SMTPSecure   = 'ssl';
        $mail->Port         =  465;

        #========== SENDER & RECIPIENT DETAILS ==========#
        $mail->setFrom('noreply@shamsnatural.com', 'Test');
        $mail->addAddress('milan.mithal@mrm.com');

        #========== EMAIL CONTENT ==========#
        $mail->isHTML(true);
        $mail->Subject      = "Test email";
        $mail->Body         = "Testing";
        $mail->AltBody      = "Testing";
        
        $mail->send();

        echo "Email Sent Successfully";

    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>