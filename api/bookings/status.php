<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';
require_once '../../utils/auth_middleware.php';

authenticate();
$id = $_GET['params'][0] ?? null;
if (!$id) sendError("Booking ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

sendResponse($booking, "Booking status");
