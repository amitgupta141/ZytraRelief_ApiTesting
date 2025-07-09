<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once '../utils/response.php';
require_once '../config/jwt.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data
    $user_name = $_POST['providerName'] ?? '';
    $user_email = $_POST['providerEmail'] ?? '';
    $user_phone = $_POST['providerPhone'] ?? '';
    $user_password = $_POST['providerPassword'] ?? '';
    $user_category = $_POST['providerCategory'] ?? '';
    $user_address = $_POST['providerAddress'] ?? '';

    // Validate basic fields
    if (empty($user_name) || empty($user_email) || empty($user_phone) || empty($user_category) || empty($user_password)) {
        die("All fields are required.");
    }

    // Connect to DB
    $pdo = (new Database())->connect();

    // Insert user
    $stmt = $pdo->prepare("insert into providers (name, email, phone, password, profession, address) values (:name, :email, :phone, :password, :category, :address)");
    $stmt->execute([
        'name'  => $user_name,
        'email' => $user_email,
        'phone' => $user_phone,
        'password' => $user_password,
        'category' => $user_category,
        'address' => $user_address
    ]);

    // Store email in session
    $_SESSION["providerEmail"] = $user_email;
    $_SESSION["providerName"] = $user_name;
    $_SESSION["providerPhone"] = $user_phone;

    // Redirect to send OTP
    header("Location: ./otp_send.php");
    exit;
} else {
    die("Invalid request method");
}
?>
