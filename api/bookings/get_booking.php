<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful


$bookingId = $_GET['id'] ?? null;

if (!$bookingId) {
    sendError("Booking ID not provided", 400);
}

try {
    $pdo = (new Database())->connect();

    $stmt = $pdo->prepare("select * from bookings where booking_id = :id");
    $stmt->execute(['id' => $bookingId]);

    if ($stmt->rowCount() === 0) {
        sendError("Booking not found", 404);
    }

    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    sendResponse(['booking' => $booking]);

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}

?>
