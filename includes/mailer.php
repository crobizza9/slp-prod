<?php
// Manual PHPMailer includes
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';
require_once __DIR__ . '/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getMailer()
{
    $mail = new PHPMailer(true);

    try {


        // SMTP goes here. I am not going to put the actual smtp here. It is in production version

        // $mail->isSMTP();
        // $mail->Host = 'mailhog';
        // $mail->Port = 1025;
        // $mail->SMTPAuth = false;  // No username/password
        // $mail->SMTPSecure = false;

        // $mail->isHTML(true);

        return $mail;
    } catch (Exception $e) {
        die("Mailer could not be created. Error: " . $e->getMessage());
    }
}
