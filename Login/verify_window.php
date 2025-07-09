<?php
session_start();
require_once '../config/database.php';
require_once '../utils/response.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'] ?? '';
    $email = $_SESSION['userEmail'] ?? '';

    if (empty($email)) {
        $error = "Session expired or email not found.";
    } elseif (empty($otp)) {
        $error = "Please enter the OTP.";
    } else {
        $pdo = (new Database())->connect();

        // Check OTP
        if($_SESSION['userType'] == 'user'){
          $stmt = $pdo->prepare("select * from users where userEmail = :email AND otp_code = :otp AND otp_expiry > NOW()");
        }
        else{
          $stmt = $pdo->prepare("select * from providers where email = :email AND otp_code = :otp AND otp_expiry > NOW()");

        }

        $stmt->execute([
            'email' => $email,
            'otp' => $otp
        ]);

        if ($stmt->rowCount() > 0) {
            $success = "OTP verified successfully!";

            // Clear OTP
            if($_SESSION['userType'] == 'user'){
              
              $st = $pdo->prepare("update users SET otp_code = NULL, otp_expiry = NULL WHERE userEmail = :email");
            }
            else{
              $st = $pdo->prepare("update providers SET otp_code = NULL, otp_expiry = NULL WHERE email = :email");

            }
            
               $st->execute(['email' => $email]);

            // Optionally redirect or show login link
            header("Location: /../homepage-main.php");
            exit;
        } else {
            $error = "Invalid or expired OTP.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .otp-container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .otp-container h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input[type="text"] {
      width: 100%;
      padding: 12px;
      font-size: 18px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      box-sizing: border-box;
    }

    button {
      background: #2563eb;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background: #1e40af;
    }

    .info {
      margin-top: 10px;
      font-size: 14px;
      color: #555;
    }

    .error {
      color: red;
      margin-bottom: 10px;
    }

    .success {
      color: green;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="otp-container">
    <h2>Enter OTP</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="otp" placeholder="Enter 6-digit OTP" maxlength="6" required>
      <button type="submit">Verify</button>
    </form>

    <div class="info">Check your email for the OTP.</div>
  </div>
</body>
</html>
