<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include the PHPMailer library
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Step 1: Send a test email

$mail = new PHPMailer(true); // Set true for exceptions

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server details (replace with your provider's settings)
    $mail->SMTPAuth = true;
    $mail->Username = 'kishnuyadav783@gmail.com'; // Your email address
    $mail->Password = 'qxpllbzodkfgwgiy'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
    $mail->Port = 587; // Port for STARTTLS

    // Recipients
    $mail->setFrom('from@example.com', 'Your Name');
    $mail->addAddress('21bcar0376@jainuniversity.ac.in', 'krishna'); // Replace with the recipient's email address
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email sent using PHPMailer.';

    $mail->send();
    echo "Test email sent successfully.";
} catch (Exception $e) {
    echo "Error: Test email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
