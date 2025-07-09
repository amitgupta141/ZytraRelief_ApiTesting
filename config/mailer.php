<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendOTPEmail($to, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_EMAIL'];
        $mail->Password = $_ENV['SMTP_PASS'];  // 12-char app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('info@zytrarelief.com', 'Zytra Relief');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Registration OTP';
        $mail->Body    = "<h3>Your OTP is: <strong>$otp</strong></h3>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
