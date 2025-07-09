<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';
require_once '../../utils/auth_middleware.php';

$user_id = authenticate();
$pdo = (new Database())->connect();

$stmt = $pdo->prepare("select * from users WHERE userID = ?");
$stmt->execute([$user_id]);
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($addresses, "User addresses");
