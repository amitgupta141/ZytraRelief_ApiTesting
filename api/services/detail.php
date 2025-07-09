<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$id = $_GET['params'][0] ?? null;
if (!$id) sendError("Service ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("select * from services where service_id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if ($service) {
    sendResponse($service, "Service details");
} else {
    sendError("Service not found", 404);
}
