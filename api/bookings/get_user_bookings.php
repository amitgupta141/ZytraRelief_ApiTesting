<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful


$user_id = $_GET['user_id'] ?? null;
if (!$user_id) sendError("User ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("select * from bookings where user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);

sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
?>