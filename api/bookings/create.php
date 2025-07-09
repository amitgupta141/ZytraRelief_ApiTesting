<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';
require_once '../../utils/auth_middleware.php';

$user_id = authenticate();
$data = json_decode(file_get_contents("php://input"), true);

$service_id = $data['service_id'] ?? null;
$address_id = $data['address_id'] ?? null;
$scheduled_time = $data['scheduled_time'] ?? null;

if (!$service_id || !$address_id || !$scheduled_time) {
    sendError("Missing booking details", 400);
}

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("INSERT INTO bookings (user_id, service_id, address_id, scheduled_time, status) VALUES (?, ?, ?, ?, 'pending')");
$stmt->execute([$user_id, $service_id, $address_id, $scheduled_time]);

sendResponse([], "Booking created", 201);
