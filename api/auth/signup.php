<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$data = json_decode(file_get_contents("php://input"), true);

$name     = $data['name'] ?? '';
$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';
$phone    = $data['phone'] ?? '';
$partner_name = $data['partner_name'] ?? '';
$category = $data['category'] ?? '';
$address  = $data['address'] ?? '';

if (!$email || !$password || !$name || !$phone) {
    sendError("All fields are required", 400);
}

$pdo = (new Database())->connect();

// Check if user already exists
$check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$check->execute(['email' => $email]);
if ($check->rowCount()) {
    sendError("Email already registered", 409);
}

// Insert user
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, partner_name, category, address, is_verified) 
                       VALUES (:name, :email, :password, :phone, :partner_name, :category, :address, 0)");

$success = $stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' => $hashedPassword,
    'phone' => $phone,
    'partner_name' => $partner_name,
    'category' => $category,
    'address' => $address
]);

if ($success) {
    sendResponse([], "Signup successful. Please verify OTP sent to your email.", 201);
} else {
    sendError("Signup failed", 500);
}
