<?php
session_start();
require_once __DIR__. '/../config/database.php';
require_once __DIR__. '/../config/mailer1.php'; // where sendOTPEmail() is defined
require_once __DIR__. '/../utils/response.php';

if (!isset($_SESSION['userEmail'])) {
    sendError("Session expired or email not set", 400);
}

$email = $_SESSION['userEmail'];
$pdo = (new Database())->connect();

if($_SESSION['userType'] == 'user'){
    $stmt = $pdo->prepare("select userID FROM users where userEmail = :email");
}
else{
    $stmt = $pdo->prepare("select provider_id FROM providers where email = :email");
}
// Check if user exists
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() === 0) {
    sendError($_SESSION['userType'] +" not found", 404);
}


// Generate OTP
$otp = rand(100000, 999999);
$otps = [];
while(in_array($otp,$otps)){
    $otp = rand(100000, 999999);
}
array_push($otps,strval($otp));




// Save OTP to DB
if($_SESSION['userType'] == 'user'){

    $update = $pdo->prepare("update users set otp_code = :otp, otp_expiry = NOW() + INTERVAL 5 MINUTE where userEmail = :email");
}
else{
    $update = $pdo->prepare("update providers set otp_code = :otp, otp_expiry = NOW() + INTERVAL 5 MINUTE where email = :email");

}

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