<?php
// Manual PHPMailer includes
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';
require_once __DIR__ . '/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Returns a fully configured PHPMailer instance
 */
function getMailer()
{
    $mail = new PHPMailer(true);

    try {
        // ----------------------------
        // SMTP CONFIGURATION
        // ----------------------------

        // Mailgun
        // $mail->isSMTP();
        // $mail->Host       = 'smtp.mailgun.org';
        // $mail->SMTPAuth   = true;
        // $mail->Username   = 'postmaster@YOUR_DOMAIN.mailgun.org';
        // $mail->Password   = 'YOUR_MAILGUN_SMTP_PASSWORD';         
        // $mail->Port       = 587;
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // Mailhog for local testing

        $mail->isSMTP();
        $mail->Host = 'mailhog';
        $mail->Port = 1025;
        $mail->SMTPAuth = false;  // No username/password
        $mail->SMTPSecure = false;

        $mail->isHTML(true);

        return $mail;
    } catch (Exception $e) {
        die("Mailer could not be created. Error: " . $e->getMessage());
    }
}
