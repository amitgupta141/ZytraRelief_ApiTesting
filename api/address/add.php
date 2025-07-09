<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';
require_once '../../utils/auth_middleware.php';

$user_id = authenticate();
$data = json_decode(file_get_contents("php://input"), true);
$address = $data['address'] ?? '';

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("INSERT INTO addresses (user_id, address) VALUES (?, ?)");
$stmt->execute([$user_id, $address]);

sendResponse([], "Address added");
