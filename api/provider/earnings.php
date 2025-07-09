<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$partner_id = 1; // Replace with JWT authentication

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("SELECT SUM(amount) as total_earned FROM payments WHERE provider_id = ?");
$stmt->execute([$partner_id]);
$earnings = $stmt->fetch(PDO::FETCH_ASSOC);

sendResponse($earnings, "Earnings fetched");
