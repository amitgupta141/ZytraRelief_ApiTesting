<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$id = $_GET['params'][0] ?? null;
$partner_id = 1; // replace with auth system

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("UPDATE bookings SET provider_id = ?, status = 'accepted' WHERE id = ?");
$stmt->execute([$partner_id, $id]);

sendResponse([], "Booking accepted");
