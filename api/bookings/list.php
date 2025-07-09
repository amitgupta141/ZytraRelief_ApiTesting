<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';
require_once '../../utils/auth_middleware.php';

$user_id = authenticate();
$pdo = (new Database())->connect();
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($bookings, "Your bookings");
