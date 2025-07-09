<?php
require_once '../../config/database.php';
require_once '../../utils/response.php';

$pdo = (new Database())->connect();
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

sendResponse($categories, "Categories fetched");
