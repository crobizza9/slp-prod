<?php
require_once __DIR__ . '/mailer.php';

class EmailService
{

    public static function sendShippingRequest($recipientEmail, $senderEmail, $senderName, $emailBody, $subject = null)
    {
        $mail = getMailer();

        try {
            // Default subject if none provided
            if (!$subject) {
                $subject = "Shipping Request From: " . $senderName . " " . date("m-d-Y");
            }

            // Set FROM and TO
            $mail->setFrom($senderEmail, $senderName);
            $mail->addAddress($recipientEmail);

            // Email body
            $mail->Subject = $subject;
            $mail->Body    = $emailBody;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
