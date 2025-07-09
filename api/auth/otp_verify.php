<?php
session_start();
require_once '../../config/database.php';
require_once '../../utils/response.php';

if (!isset($_SESSION['userEmail'])) {
    sendError("Session expired or email not set", 400);
}

$email = $_SESSION['userEmail'];
$pdo = (new Database())->connect();

// Check if user exists
$stmt = $pdo->prepare("select userID, otp_code, otp_expiry from users where email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() === 0) {
    sendError("User not found", 404);
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get OTP from request (can be from form or JS fetch)
$otpInput = $_POST['otp'] ?? json_decode(file_get_contents("php://input"), true)['otp'] ?? '';

if (empty($otpInput)) {
    sendError("OTP is required", 422);
}

// Verify OTP
if ($otpInput != $user['otp_code']) {
    sendError("Invalid OTP", 401);
}

// Check if OTP expired
if (strtotime($user['otp_expiry']) < time()) {
    sendError("OTP has expired", 410);
}

// Update user as verified
$update = $pdo->prepare("update users set is_verified = 1, otp_code = NULL, otp_expiry = NULL where email = :email");
$update->execute(['email' => $email]);

sendResponse([], "OTP verified successfully");

?>
<script>
    alert("OTP verified successfully!");
</script>
<?php

header('Location: ../Login/login.php');
exit;
