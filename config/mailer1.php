<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// session_start();
require __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


function sendOTPEmail($to, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_EMAIL']; 
        $mail->Password = $_ENV['SMTP_PASS'];   
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('info@zytrarelief.com', 'Zytra Relief');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Login OTP';
        $mail->Body    = "<h3>Your OTP is: <strong>$otp</strong></h3>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
