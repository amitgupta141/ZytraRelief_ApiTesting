<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful


$provider_id = $_GET['provider_id'] ?? null;
if (!$provider_id) sendError("Provider ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("select * from bookings where provider_id = :provider_id");
$stmt->execute(['provider_id' => $provider_id]);

sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));

?>