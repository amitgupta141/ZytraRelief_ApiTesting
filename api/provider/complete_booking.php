<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$id = $_GET['params'][0] ?? null;

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("UPDATE bookings SET status = 'completed' WHERE id = ?");
$stmt->execute([$id]);

sendResponse([], "Booking marked completed");
