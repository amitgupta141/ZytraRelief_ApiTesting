<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || empty($data['userName']) || empty($data['userEmail']) || empty($data['userPassword'])) {
    sendError("Required fields missing", 400);
}

$required = ['userName', 'userEmail', 'userPassword', 'userCategory', 'userAddress', 'userPhone'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        sendError("Missing or empty field: $field", 422);
    }
}

try {

    $stmt = $pdo->prepare("select userID from users where userEmail = :email");
    $stmt->execute(['email' => $data['userEmail']]);
    if ($stmt->rowCount() > 0) {
        sendError("Email already registered", 409);
    }

    $hashedPassword = password_hash($data['userPassword'], PASSWORD_BCRYPT);
    $insert = $pdo->prepare("insert into users (userName, userEmail, userPassword,category,address,userPhone) VALUES (:name, :email, :password, :category, :address, :phone)");
    $insert->execute([
        'name' => $data['userName'],
        'email' => $data['userEmail'],
        'password' => $hashedPassword,
        'category' => $data['userCategory'],
        'address' => $data['userAddress'],
        'phone' => $data['userPhone']

    ]);
    sendResponse([], "User registered successfully");
} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}


?>