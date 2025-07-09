<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$pdo = (new Database())->connect();
$stmt = $pdo->query("SELECT * FROM bookings WHERE status = 'pending'");
$assigned = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($assigned, "Assigned bookings");
