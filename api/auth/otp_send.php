<?php
require_once '../../config/database.php';
require_once '../../config/mailer.php';
require_once '../../utils/response.php';

$data  = $conn->query('Select * from ')
$email = $data['userEmail'] ?? '';

if (!$email) {
    sendError("Email is required", 400);
}

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);

if ($stmt->rowCount() === 0) {
    sendError("User not found", 404);
}

// Generate 6-digit OTP
$otp = rand(100000, 999999);

// Save OTP in DB
$update = $pdo->prepare("UPDATE users SET otp_code = :otp, otp_expiry = NOW() + INTERVAL 5 MINUTE WHERE email = :email");
$update->execute(['otp' => $otp, 'email' => $email]);

// Send Email
$sent = sendOTPEmail($email, $otp);

if ($sent) {
    sendResponse([], "OTP sent to $email", 200);
} else {
    sendError("Failed to send OTP", 500);
}
