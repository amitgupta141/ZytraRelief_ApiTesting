<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$service_id = $_GET['params'][0] ?? null;
$pdo = (new Database())->connect();

$stmt = $pdo->prepare("select * FROM reviews WHERE service_id = ?");
$stmt->execute([$service_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($reviews, "Service reviews");
