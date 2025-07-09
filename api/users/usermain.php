<?php
// File: /api/users/index.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';
session_start();



$pdo = (new Database())->connect();

if ($method === 'POST' && strpos($uri, '/api/users/register') !== false) {
    // Register User
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || empty($data['userName']) || empty($data['userEmail']) || empty($data['userPassword'])) {
        sendError("Required fields missing", 400);
    }

    $stmt = $pdo->prepare("SELECT userID FROM users WHERE userEmail = :email");
    $stmt->execute(['email' => $data['userEmail']]);
    if ($stmt->rowCount() > 0) {
        sendError("Email already registered", 409);
    }

    $hashedPassword = password_hash($data['userPassword'], PASSWORD_BCRYPT);
    $insert = $pdo->prepare("INSERT INTO users (userName, userEmail, userPassword) VALUES (:name, :email, :password)");
    $insert->execute([
        'name' => $data['userName'],
        'email' => $data['userEmail'],
        'password' => $hashedPassword
    ]);
    sendResponse([], "User registered successfully");

} elseif ($method === 'POST' && strpos($uri, '/api/users/login') !== false) {
    // Login User
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || empty($data['email']) || empty($data['password'])) {
        sendError("Email and password required", 400);
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE userEmail = :email");
    $stmt->execute(['email' => $data['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data['password'], $user['userPassword'])) {
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['userEmail'] = $user['userEmail'];
        sendResponse(['user' => [
            'userID' => $user['userID'],
            'userName' => $user['userName'],
            'userEmail' => $user['userEmail']
        ]], "Login successful");
    } else {
        sendError("Invalid credentials", 401);
    }

} elseif ($method === 'GET' && strpos($uri, '/api/users/profile') !== false) {
    // Get User Profile
    if (!isset($_SESSION['userID'])) sendError("Not authenticated", 401);

    $stmt = $pdo->prepare("SELECT userID, userName, userEmail, userPhone FROM users WHERE userID = :id");
    $stmt->execute(['id' => $_SESSION['userID']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    sendResponse(['user' => $user]);

} elseif ($method === 'PUT' && strpos($uri, '/api/users/profile') !== false) {
    // Update Profile
    if (!isset($_SESSION['userID'])) sendError("Not authenticated", 401);

    $data = json_decode(file_get_contents('php://input'), true);
    $fields = [];
    $params = [ 'id' => $_SESSION['userID'] ];

    if (!empty($data['userName'])) {
        $fields[] = "userName = :name";
        $params['name'] = $data['userName'];
    }
    if (!empty($data['userPhone'])) {
        $fields[] = "userPhone = :phone";
        $params['phone'] = $data['userPhone'];
    }

    if (empty($fields)) sendError("No fields to update", 400);

    $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE userID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    sendResponse([], "Profile updated successfully");

} else {
    sendError("Invalid endpoint or method", 404);
}
