<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once '../utils/response.php';
require_once '../config/jwt.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data
    $user_name = $_POST['userName'] ?? '';
    $user_email = $_POST['userEmail'] ?? '';
    $user_phone = $_POST['userPhone'] ?? '';
    $user_password = $_POST['userPassword'] ?? '';
    $user_category = $_POST['userCategory'] ?? '';
    $user_address = $_POST['userAddress'] ?? '';

    // Validate basic fields
    if (empty($user_name) || empty($user_email) || empty($user_phone)) {
        die("All fields are required.");
    }

    // Connect to DB
    $pdo = (new Database())->connect();

    // Insert user
    $stmt = $pdo->prepare("insert into users (userName, userEmail, userPhone, userPassword, category, address) values (:name, :email, :phone, :password, :category, :address)");
    $stmt->execute([
        'name'  => $user_name,
        'email' => $user_email,
        'phone' => $user_phone,
        'password' => $user_password,
        'category' => $user_category,
        'address' => $user_address
    ]);

    // Store email in session
    $_SESSION["userEmail"] = $user_email;
    $_SESSION["userName"] = $user_name;
    $_SESSION["userPhone"] = $user_phone;

    // Redirect to send OTP
    header("Location: ./otp_send.php");
    exit;
} else {
    die("Invalid request method");
}
?>
