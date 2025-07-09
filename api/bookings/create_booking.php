<?php

error_log("✅ create_booking.php loaded");


require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful

// Parse input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    sendError("Invalid JSON body", 400);
}

$required = ['user_id', 'provider_id', 'service_id', 'booking_date', 'address'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        sendError("Missing or empty field: $field", 422);
    }
}

try {
    $pdo = (new Database())->connect();

    $stmt = $pdo->prepare("
        INSERT INTO bookings 
            (user_id, provider_id, service_id, booking_date, address, status, payment_status) 
        VALUES 
            (:user_id, :provider_id, :service_id, :booking_date, :address, 'pending', 'pending')
    ");

    $stmt->execute([
        'user_id' => $data['user_id'],
        'provider_id' => $data['provider_id'],
        'service_id' => $data['service_id'],
        'booking_date' => $data['booking_date'],
        'address' => $data['address']
    ]);

    sendResponse(['booking_id' => $pdo->lastInsertId()], "Booking created successfully");

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}
