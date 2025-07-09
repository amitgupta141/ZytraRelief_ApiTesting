<?php
require_once __DIR__ . '/../config/jwt.php';
require_once __DIR__ . '/response.php';

function authenticate() {
    $headers = apache_request_headers();

    if (!isset($headers['Authorization'])) {
        sendError("Missing Authorization Header", 401);
    }

    $authHeader = $headers['Authorization'];
    if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        sendError("Invalid Authorization format", 401);
    }

    $token = $matches[1];
    $userId = Token::verify($token);

    if (!$userId) {
        sendError("Unauthorized or expired token", 401);
    }

    return $userId;
}
