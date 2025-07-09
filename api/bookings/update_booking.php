<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful


$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$id) sendError("Booking ID required", 400);

$pdo = (new Database())->connect();

// Get current booking
$stmt = $pdo->prepare("select * from bookings where booking_id = :id");
$stmt->execute(['id' => $id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) sendError("Booking not found", 404);

// Merge updates with existing data
$updated = [
    'user_id'        => $data['user_id']        ?? $booking['user_id'],
    'provider_id'    => $data['provider_id']    ?? $booking['provider_id'],
    'service_id'     => $data['service_id']     ?? $booking['service_id'],
    'booking_date'   => $data['booking_date']   ?? $booking['booking_date'],
    'address'        => $data['address']        ?? $booking['address'],
    'status'         => $data['status']         ?? $booking['status'],
    'payment_status' => $data['payment_status'] ?? $booking['payment_status'],
    'id'             => $id
];

// Update booking
$update = $pdo->prepare("update bookings set
    user_id = :user_id,
    provider_id = :provider_id,
    service_id = :service_id,
    booking_date = :booking_date,
    address = :address,
    status = :status,
    payment_status = :payment_status
    where booking_id = :id");

$update->execute($updated);

sendResponse([], "Booking updated successfully");


?>