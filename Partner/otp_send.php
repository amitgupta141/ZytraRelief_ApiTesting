<?php
require_once '../config/database.php';
require_once '../config/mailer.php'; // where sendOTPEmail() is defined
require_once '../utils/response.php';
session_start();

if (!isset($_SESSION['providerEmail'])) {
    sendError("Session expired or email not set", 400);
}

$email = $_SESSION['providerEmail'];
$pdo = (new Database())->connect();

// Check if user exists
$stmt = $pdo->prepare("select provider_id FROM providers where email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() === 0) {
    sendError("User not found", 404);
}


// Generate OTP
$otp = rand(100000, 999999);
$otps = [];
while(in_array($otp,$otps)){
    $otp = rand(100000, 999999);
}
array_push($otps,strval($otp));




// Save OTP to DB
$update = $pdo->prepare("update providers set otp_code = :otp, otp_expiry = NOW() + interval 5 minute where email = :email");
$update->execute(['otp' => $otp, 'email' => $email]);

// Send Email
if (sendOTPEmail($email, $otp)) {
    // sendResponse([], "OTP sent successfully to $email");
    ?>
    <script>
    alert("OTP sent successfully");
    </script>
    <?php
} else {
    sendError("Failed to send OTP", 500);
}

header('Location:./verify_window.php');
?>