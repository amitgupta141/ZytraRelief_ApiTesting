<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$id = $_GET['params'][0] ?? null;
if (!$id) sendError("Category ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("SELECT * FROM services WHERE category_id = ?");
$stmt->execute([$id]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($services, "Services in category");
