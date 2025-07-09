<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$id = $_GET['params'][0] ?? null;
if (!$id) sendError("Address ID required", 400);

$pdo = (new Database())->connect();
$stmt = $pdo->prepare("delete FROM users WHERE userID = ?");
$stmt->execute([$id]);

sendResponse([], "Address deleted");
